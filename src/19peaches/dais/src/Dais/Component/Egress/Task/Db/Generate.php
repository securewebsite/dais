<?php

/*
|--------------------------------------------------------------------------
|   Egress
|--------------------------------------------------------------------------
|
|    This file is part of the Dais Framework package.
|    
|    Egress is a recoded version of Ruckusing Migrations for full
|    integration into the Dais Framework. For the original version and
|    details on Ruckusing Migrations see:
|    
|    https://github.com/ruckus/ruckusing-migrations
|    
|    All thanks to Cody Caughlan for the great work he did on this.
|    
|    (c) Vince Kronlein <vince@dais.io>
|    
|    For the full copyright and license information, please view the LICENSE
|    file that was distributed with this source code.
|    
*/

namespace Egress\Library\Task\Db;
use Egress\Library\Task\TaskBase;
use Egress\Library\Task\TaskInterface;
use Egress\Library\Utility\Migrator;
use Egress\Library\Utility\Naming;
use Egress\Library\EgressException;

class Generate extends TaskBase implements TaskInterface {
    
    private $_adapter = null;

    public function __construct($adapter) {
        parent::__construct($adapter);
        $this->_adapter = $adapter;
    }

    public function execute($args) {
        $output = '';
        
        // Add support for old migration style
        if (!is_array($args) || !array_key_exists('name', $args)):
            $cargs = $this->parse_args($_SERVER['argv']);
            
            //input sanity check
            if (!is_array($cargs) || !array_key_exists('name', $cargs)):
                $output .= $this->help();

                return $output;
            endif;
            
            $migration_name = $cargs['name'];
        else:
            $migration_name = $args['name'];
        endif;

        if (!array_key_exists('module', $args)):
            $args['module'] = '';
        endif;

        //clear any filesystem stats cache
        clearstatcache();

        $framework      = $this->get_framework();
        $migrations_dir = $framework->migrations_directory($args['module']);

        //generate a complete migration file
        $next_version = Migrator::generate_timestamp();
        $class        = Naming::camelcase($migration_name);
        
        if (!self::classNameIsCorrect($class)):
            throw new EgressException("Bad migration name,PHP class can't be named as $class.Please, choose another name.", EgressException::INVALID_ARGUMENT);
        endif;

        $all_dirs = $framework->migrations_directories();

        if ($re = self::classNameIsDuplicated($class, $all_dirs)):
            throw new EgressException("This migration name is already used in the \"$re\" directory. Please, choose another name.", EgressException::INVALID_ARGUMENT);
        endif;

        $file_name = $next_version . '_' . $class . '.php';
        
        //check to make sure our destination directory is writable
        if (!is_writable($migrations_dir)):
            throw new EgressException("ERROR: migration directory '" . $migrations_dir . "' is not writable by the current user. Check permissions and try again.", EgressException::INVALID_MIGRATION_DIR);
        endif;

        //write it out!
        $full_path    = $migrations_dir . $file_name;
        $template_str = self::get_template($class);
        $file_result  = file_put_contents($full_path, $template_str);
        
        if ($file_result === FALSE):
            throw new EgressException("Error writing to migrations directory/file. Do you have sufficient privileges?", EgressException::INVALID_MIGRATION_DIR);
        else:
            $output .= "\n\tCreated migration: {$file_name}\n\n";
        endif;

        return $output;
    }

    public function parse_args($argv) {
        foreach ($argv as $i => $arg):
            if (strpos($arg, '=') !== FALSE):
                unset($argv[$i]);
            endif;
        endforeach;
        
        $num_args = count($argv);
        
        if ($num_args < 3):
            return array();
        endif;
        
        $migration_name = $argv[2];

        return array('name' => $migration_name);
    }

    public static function classNameIsDuplicated($classname, $migrationsDirs) {
        $migrationFiles = Migrator::get_migration_files($migrationsDirs, 'up');
        $classname      = strtolower($classname);
        
        foreach ($migrationFiles as $file):
            if (strtolower($file['class']) == $classname):
                return $file['module'];
            endif;
        endforeach;

        return false;
    }

    public static function classNameIsCorrect($classname){
        $correct_class_name_regex = '/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/';
        
        if (preg_match($correct_class_name_regex, $classname)):
            return true;
        endif;
        
        return false;
    }

    public static function get_template($klass) {
        $namespace = MIGRATION_NAMESPACE;
        $prefix    = PREFIX;
        
        $template = <<<TPL
<?php

/*
|--------------------------------------------------------------------------
|   Dais
|--------------------------------------------------------------------------
|
|   This file is part of the Dais Framework package.
|    
|   (c) Vince Kronlein <vince@dais.io>
|    
|   For the full copyright and license information, please view the LICENSE
|   file that was distributed with this source code.
|   
|   Your table prefix has been included so that you can easily write your 
|   migrations to include the proper prefix.
|   
|   \$users = \$this->create_table("{\$this->prefix}users");
|
|   Obviously if you have no table prefix, this variable will be empty.
|   
*/

namespace $namespace;
use Egress\Library\Migration\MigrationBase;

class $klass extends MigrationBase {

    private \$prefix = '$prefix';

    public function up() {

    }

    public function down() {

    }
}

TPL;

        return $template;
    }

    public function help() {
        $output =<<<USAGE

\tTask: db:generate <migration name>

\tGenerator for migrations.

\t<migration name> is a descriptive name of the migration,
\tjoined with underscores. e.g.: add_index_to_users | create_users_table

\tExample :

\t\tphp {$_SERVER['argv'][0]} db:generate add_index_to_users

USAGE;

        return $output;
    }
}
