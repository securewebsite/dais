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
use Egress\Library\EgressException;

class Schema extends TaskBase implements TaskInterface {
    
    private $_adapter = null;
    private $_return  = '';

    public function __construct($adapter) {
        parent::__construct($adapter);
        $this->_adapter = $adapter;
    }

    public function execute($args) {
        $this->_return .= "Started: " . date('Y-m-d g:ia T') . "\n\n";
        $this->_return .= "[db:schema]: \n";

        //write to disk
        $schema_file = $this->db_dir() . '/schema.txt';
        $schema      = $this->_adapter->schema($schema_file);
        
        $this->_return .= "\tSchema written to: $schema_file\n\n";
        $this->_return .= "\n\nFinished: " . date('Y-m-d g:ia T') . "\n\n";

        return $this->_return;
    }

    private function db_dir() {
        // create the db directory if it doesnt exist
        $db_directory = $this->get_framework()->db_directory();

        //check to make sure our destination directory is writable
        if (!is_writable($db_directory)):
            throw new EgressException("ERROR: DB Schema directory '" . $db_directory . "' is not writable by the current user. Check permissions and try again.\n", EgressException::INVALID_DB_DIR
            );
        endif;

        return $db_directory;
    }

    public function help() {
        $output =<<<USAGE

\tTask: db:schema

\tIt can be beneficial to get a dump of the DB in raw SQL format which represents
\tthe current version.

\tNote: This dump only contains the actual schema (e.g. the DML needed to
\treconstruct the DB), but not any actual data.

\tIn MySQL terms, this task would not be the same as running the mysqldump command
\t(which by defaults does include any data in the tables).

USAGE;

        return $output;
    }
}
