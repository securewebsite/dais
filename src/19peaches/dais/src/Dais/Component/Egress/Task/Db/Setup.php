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

class Setup extends TaskBase implements TaskInterface {
    
    private $_adapter = null;

    public function __construct($adapter) {
        parent::__construct($adapter);
        $this->_adapter = $adapter;
    }

    public function execute($args) {
        $output  = "Started: " . date('Y-m-d g:ia T') . "\n\n";
        $output .= "[db:setup]: \n";
        
        //it doesnt exist, create it
        if (!$this->_adapter->table_exists(EGRESS_TS_SCHEMA_TBL_NAME)):
            $output .= sprintf("\tCreating table: %s", EGRESS_TS_SCHEMA_TBL_NAME);
            $this->_adapter->create_schema_version_table();
            $output .= "\n\tDone.\n";
        else:
            $output .= sprintf("\tNOTICE: table '%s' already exists. Nothing to do.", EGRESS_TS_SCHEMA_TBL_NAME);
        endif;

        $output .= "\n\nFinished: " . date('Y-m-d g:ia T') . "\n\n";

        return $output;
    }

    public function help() {
        $output =<<<USAGE

\tTask: db:setup

\tA basic task to initialize your DB for migrations is available. One should
\talways run this task when first starting out.

\tThis task does not take arguments.

USAGE;

        return $output;
    }
}
