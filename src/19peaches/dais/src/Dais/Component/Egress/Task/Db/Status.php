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

namespace Egress\Task\Db;
use Egress\Library\Task\TaskBase;
use Egress\Library\Task\TaskInterface;
use Egress\Library\Utility\Migrator;

class Status extends TaskBase implements TaskInterface {
    
    private $_adapter = null;

    public function __construct($adapter) {
        parent::__construct($adapter);
        $this->_adapter = $adapter;
    }

    public function execute($args) {
        $output  = "Started: " . date('Y-m-d g:ia T') . "\n\n";
        $output .= "[db:status]: \n";
        
        $util        = new Migrator($this->_adapter);
        $migrations  = $util->get_executed_migrations();
        $files       = $util->get_migration_files($this->get_framework()->migrations_directories(), 'up');
        $applied     = array();
        $not_applied = array();
        
        foreach ($files as $file):
            if (in_array($file['version'], $migrations)):
                $applied[] = $file['class'] . ' [ ' . $file['version'] . ' ]';
            else:
                $not_applied[] = $file['class'] . ' [ ' . $file['version'] . ' ]';
            endif;
        endforeach;

        if (count($applied) > 0):
            $output .= $this->_displayMigrations($applied, 'APPLIED');
        endif;
        
        if (count($not_applied) > 0):
            $output .= $this->_displayMigrations($not_applied, 'NOT APPLIED');
        endif;

        $output .= "\n\nFinished: " . date('Y-m-d g:ia T') . "\n\n";

        return $output;
    }

    private function _displayMigrations($migrations, $title) {
        $output = "\n\n===================== {$title} =======================\n";

        foreach ($migrations as $a):
            $output .= "\t" . $a . "\n";
        endforeach;

        return $output;
    }

    public function help() {
        $output =<<<USAGE

\tTask: db:status

\tWith this task you'll get an overview of the already executed migrations and
\twhich will be executed when running db:migrate.

\tThis task does not take arguments.

USAGE;

        return $output;
    }
}
