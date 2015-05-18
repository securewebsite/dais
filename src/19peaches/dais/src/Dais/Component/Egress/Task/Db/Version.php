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

class Version extends TaskBase implements TaskInterface {
    
    private $_adapter = null;

    public function __construct($adapter) {
        parent::__construct($adapter);
        $this->_adapter = $adapter;
    }

    public function execute($args) {
        $output  = "Started: " . date('Y-m-d g:ia T') . "\n\n";
        $output .= "[db:version]: \n";
        
        if (!$this->_adapter->table_exists(EGRESS_TS_SCHEMA_TBL_NAME)):
            //it doesnt exist, create it
            $output .= "\tSchema version table (" . EGRESS_TS_SCHEMA_TBL_NAME . ") does not exist. Do you need to run 'db:setup'?";
        else:
            //it exists, read the version from it
            // We only want one row but we cannot assume that we are using MySQL and use a LIMIT statement
            // as it is not part of the SQL standard. Thus we have to select all rows and use PHP to return
            // the record we need
            $versions_nested = $this->_adapter->select_all(sprintf("SELECT version FROM %s", EGRESS_TS_SCHEMA_TBL_NAME));
            $versions        = array();
            
            foreach ($versions_nested as $v):
                $versions[] = $v['version'];
            endforeach;

            $num_versions = count($versions);
            
            if ($num_versions > 0):
                sort($versions); //sorts lowest-to-highest (ascending)
                $version = (string) $versions[$num_versions-1];
                $output .= sprintf("\tCurrent version: %s", $version);
            else:
                $output .= sprintf("\tNo migrations have been executed.");
            endif;
        endif;

        $output .= "\n\nFinished: " . date('Y-m-d g:ia T') . "\n\n";

        return $output;
    }

    public function help() {
        $output =<<<USAGE

\tTask: db:version

\tIt is always possible to ask the framework (really the DB) what version it is
\tcurrently at.

\tThis task does not take arguments.

USAGE;

        return $output;
    }
}
