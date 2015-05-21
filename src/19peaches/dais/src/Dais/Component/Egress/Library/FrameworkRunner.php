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

namespace Egress\Library;
use Egress\Library\Task\Manager;
use Egress\Library\Utility\Logger;
use Egress\Library\Utility\Naming;
use Egress\Library\EgressException;

class FrameworkRunner {
    
    private $_active_db_config;
    private $_config        = array();
    private $_task_mgr      = null;
    private $_adapter       = null;
    private $_cur_task_name = "";
    private $_task_options  = "";
    private $_env           = "";
    private $_showhelp      = false;

    public function __construct($config, $argv, Logger $log = null) {
        set_error_handler(array('\Egress\Library\EgressException', 'errorHandler'), E_ALL);
        set_exception_handler(array('\Egress\Library\EgressException', 'exceptionHandler'));

        // set environment
        $this->_env = ENVIRONMENT;

        //parse arguments
        $this->parse_args($argv);

        //set config variables
        $this->_config = $config;

        //verify config array
        $this->verify_db_config();

        //initialize logger
        $this->logger = $log;
        $this->initialize_logger();

        //include all adapters
        $this->load_all_adapters(EGRESS_BASE . SEP . 'Library' . SEP . 'Adapter');

        //initialize logger
        $this->initialize_db();

        //initialize tasks
        $this->init_tasks();

    }

    public function execute() {
        $output = '';

        if (empty($this->_cur_task_name)):
            if (isset($_SERVER["argv"][1]) && stripos($_SERVER["argv"][1], '=') === false):
                $output .= sprintf("\n\tWrong Task format: %s\n", $_SERVER["argv"][1]);
            endif;
            $output .= $this->help();
        else:
            if ($this->_task_mgr->has_task($this->_cur_task_name)):
                if ($this->_showhelp):
                    $output .= $this->_task_mgr->help($this->_cur_task_name);
                else:
                    $output .= $this->_task_mgr->execute($this, $this->_cur_task_name, $this->_task_options);
                endif;
            else:
                $output .= sprintf("\n\tTask not found: %s\n", $this->_cur_task_name);
                $output .= $this->help();
            endif;
        endif;

        if ($this->logger):
            $this->logger->close();
        endif;

        return $output;
    }

    public function get_adapter() {
        return $this->_adapter;
    }

    public function init_tasks() {
        $this->_task_mgr = new Manager($this->_adapter, $this->_config);
    }

    public function migrations_directory($key = '') {
        $migration_dir = '';

        if ($key):
            if (!isset($this->_config['migrations_dir'][$key])):
                throw new EgressException(sprintf("No module %s migration_dir set in config", $key), EgressException::INVALID_CONFIG);
            endif;

            $migration_dir = $this->_config['migrations_dir'][$key] . SEP;
        elseif (is_array($this->_config['migrations_dir'])):
            $migration_dir = $this->_config['migrations_dir']['default'] . SEP;
        else:
            $migration_dir = $this->_config['migrations_dir'] . SEP;
        endif;

        if (array_key_exists('directory', $this->_config['db'][$this->_env])):
            return $migration_dir . Naming::camelcase($this->_config['db'][$this->_env]['directory']);
        endif;

        return $migration_dir;
    }

    public function migrations_directories() {

        return $this->_config['migrations_dir'];
    }

    public function db_directory() {
        $path = $this->_config['db_dir'];

        return $path;
    }

    public function initialize_db() {
        $db      = $this->_config['db'][$this->_env];
        $adapter = $this->get_adapter_class($db['type']);

        if (empty($adapter)):
            throw new EgressException(sprintf("No adapter available for DB type: %s", $db['type']), EgressException::INVALID_ADAPTER
            );
        endif;

        $this->_adapter = new $adapter($db, $this->logger);

    }

    public function initialize_logger() {
        if (!$this->logger):
            if (is_dir($this->_config['log_dir']) && !is_writable($this->_config['log_dir'])):
                throw new EgressException("\n\nCannot write to log directory: " . $this->_config['log_dir'] . "\n\nCheck permissions.\n\n", EgressException::INVALID_LOG
                );
            elseif (!is_dir($this->_config['log_dir'])):
                //try and create the log directory
                mkdir($this->_config['log_dir'], 0755, true);
            endif;

            $log_name     = sprintf("%s.log", $this->_env);
            $this->logger = Logger::instance($this->_config['log_dir'] . SEP . $log_name);
        endif;
    }

    private function parse_args($argv) {
        $num_args = count($argv);

        $options = array();
        for ($i = 0; $i < $num_args; $i++):
            $arg = $argv[$i];
            if (stripos($arg, ':') !== false):
                $this->_cur_task_name = $arg;
            elseif ($arg == 'help'):
                $this->_showhelp = true;
                continue;
            elseif (stripos($arg, '=') !== false):
                list($key, $value) = explode('=', $arg);
                $key               = strtolower($key); // Allow both upper and lower case parameters
                $options[$key]     = $value;

                if ($key == 'env'):
                    $this->_env = $value;
                endif;
            endif;
        endfor;

        $this->_task_options = $options;
    }

    private function verify_db_config() {
        if ( !array_key_exists($this->_env, $this->_config['db'])):
            throw new EgressException(sprintf("Error: '%s' DB is not configured", $this->_env), EgressException::INVALID_CONFIG);
        endif;

        $this->_active_db_config = $this->_config['db'][$this->_env];
        
        if (!array_key_exists("type", $this->_active_db_config)):
            throw new EgressException(sprintf("Error: 'type' is not set for '%s' DB", $this->_env), EgressException::INVALID_CONFIG);
        endif;

        if (!array_key_exists("host", $this->_active_db_config)):
            throw new EgressException(sprintf("Error: 'host' is not set for '%s' DB", $this->_env), EgressException::INVALID_CONFIG);
        endif;

        if (!array_key_exists("database", $this->_active_db_config)):
            throw new EgressException(sprintf("Error: 'database' is not set for '%s' DB", $this->_env), EgressException::INVALID_CONFIG);
        endif;

        if (!array_key_exists("user", $this->_active_db_config)):
            throw new EgressException(sprintf("Error: 'user' is not set for '%s' DB", $this->_env), EgressException::INVALID_CONFIG);
        endif;

        if (!array_key_exists("password", $this->_active_db_config)):
            throw new EgressException(sprintf("Error: 'password' is not set for '%s' DB", $this->_env), EgressException::INVALID_CONFIG);
        endif;

        if (empty($this->_config['migrations_dir'])):
            throw new EgressException("Error: 'migrations_dir' is not set in config.", EgressException::INVALID_CONFIG);
        endif;

        if (is_array($this->_config['migrations_dir'])):
            if (!isset($this->_config['migrations_dir']['default'])):
                throw new EgressException("Error: 'migrations_dir' 'default' key is not set in config.", EgressException::INVALID_CONFIG);
            elseif (empty($this->_config['migrations_dir']['default'])):
                throw new EgressException("Error: 'migrations_dir' 'default' key is empty in config.", EgressException::INVALID_CONFIG);
            else:
                $names = $paths = array();
                foreach ($this->_config['migrations_dir'] as $name => $path):
                    if (isset($names[$name])):
                        throw new EgressException("Error: 'migrations_dir' '$name' key is defined multiples times in config.", EgressException::INVALID_CONFIG);
                    endif;

                    if (isset($paths[$path])):
                        throw new EgressException("Error: 'migrations_dir' '{$paths[$path]}' and '$name' keys defined the same path in config.", EgressException::INVALID_CONFIG);
                    endif;

                    $names[$name] = $path;
                    $paths[$path] = $name;
                endforeach;
            endif;
        endif;

        if (isset($this->_task_options['module']) && !isset($this->_config['migrations_dir'][$this->_task_options['module']])):
            throw new EgressException(sprintf("Error: module name %s is not set in 'migrations_dir' option in config.", $this->_task_options['module']), EgressException::INVALID_CONFIG);
        endif;

        if (empty($this->_config['db_dir'])):
            throw new EgressException("Error: 'db_dir' is not set in config.", EgressException::INVALID_CONFIG);
        endif;

        if (empty($this->_config['log_dir'])):
            throw new EgressException("Error: 'log_dir' is not set in config.", EgressException::INVALID_CONFIG);
        endif;
    }

    private function get_adapter_class($db_type) {
        $adapter_class = null;
        
        switch ($db_type):
            case 'mysql':
                $adapter_class = "\Egress\Library\Adapter\MySQL\MySQLBase";
                break;
        endswitch;

        return $adapter_class;
    }

    private function load_all_adapters($adapter_dir) {
        if (!is_dir($adapter_dir)):
            throw new EgressException(sprintf("Adapter dir: %s does not exist", $adapter_dir), EgressException::INVALID_ADAPTER);
        endif;

        $files = scandir($adapter_dir);
        
        foreach ($files as $f):
            //skip over invalid files
            if ($f == '.' || $f == ".." || !is_dir($adapter_dir . SEP . $f)):
                continue;
            endif;

            $adapter_class_path = $adapter_dir . SEP . $f . SEP . $f . 'Base.php';
            
            if (file_exists($adapter_class_path)):
              require_once $adapter_class_path;
            endif;
        endforeach;
    }

    public function help() {
        $output =<<<USAGE

\tUsage: php {$_SERVER['argv'][0]} <task> [help] [task parameters] [env=environment]

\thelp: Display this message

\tenv: The env command line parameter can be used to specify a different
\tdatabase to run against, as specific in the configuration file
\t(config/database.inc.php).
\tBy default, env is "development"

\ttask: In a nutshell, task names are pseudo-namespaced. The tasks that come
\twith the framework are namespaced to "db" (e.g. the tasks are "db:migrate",
\t"db:setup", etc).
\tAll tasks available actually :

\t- db:setup : A basic task to initialize your DB for migrations is
\tavailable. One should always run this task when first starting out.

\t- db:generate : A generic task which acts as a Generator for migrations.

\t- db:migrate : The primary purpose of the framework is to run migrations,
\tand the execution of migrations is all handled by just a regular ol' task.

\t- db:version : It is always possible to ask the framework (really the DB)
\twhat version it is currently at.

\t- db:status : With this taks you'll get an overview of the already
\texecuted migrations and which will be executed when running db:migrate

\t- db:schema : It can be beneficial to get a dump of the DB in raw SQL
\tformat which represents the current version.

USAGE;

        return $output;
    }
}
