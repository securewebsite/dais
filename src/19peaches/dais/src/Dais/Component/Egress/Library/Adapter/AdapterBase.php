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

namespace Egress\Library\Adapter;
use Egress\Library\Utility\Logger;
use Egress\Library\EgressException;

define('SQL_UNKNOWN_QUERY_TYPE', 1);
define('SQL_SELECT', 2);
define('SQL_INSERT', 4);
define('SQL_UPDATE', 8);
define('SQL_DELETE', 16);
define('SQL_ALTER', 32);
define('SQL_DROP', 64);
define('SQL_CREATE', 128);
define('SQL_SHOW', 256);
define('SQL_RENAME', 512);
define('SQL_SET', 1024);

class AdapterBase {

    private   $_dsn;
    private   $_db;
    protected $_conn;
    public    $logger;

    public function __construct($dsn) {
        $this->set_dsn($dsn);
    }

    public function set_dsn($dsn) {
        $this->_dsn = $dsn;
    }

    public function get_dsn() {
        return $this->_dsn;
    }

    public function set_db($db) {
        $this->_db = $db;
    }

    public function get_db() {
        return $this->_db;
    }

    public function set_logger($logger) {
        if (!($logger instanceof Logger)):
            throw new EgressException('Logger parameter must be instance of Egress_Util_Logger', EgressException::INVALID_ARGUMENT);
        endif;

        $this->logger = $logger;
    }

    public function get_logger($logger) {
        return $this->logger;
    }

    public function has_table($tbl) {
        return $this->table_exists($tbl);
    }
}
