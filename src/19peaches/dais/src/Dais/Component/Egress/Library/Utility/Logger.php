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

namespace Egress\Library\Utility;
use Egress\Library\EgressException;

class Logger {
    
    private static $_instance;
    private        $_file = '';
    private        $_fp;

    public function __construct($file) {
        $this->_file = $file;
        $this->_fp = fopen($this->_file, "a+");
    }

    public function __destruct() {
        $this->close();
    }

    public static function instance($logfile) {
        if (self::$_instance !== NULL):
            return $instance;
        endif;

        $instance = new Logger($logfile);

        return $instance;
    }

    public function log($msg) {
        if ($this->_fp):
            $ts = date('M d H:i:s', time());
            $line = sprintf("%s [info] %s\n", $ts, $msg);
            fwrite($this->_fp, $line);
        else:
            throw new EgressException(sprintf("Error: logfile '%s' not open for writing!", $this->_file), EgressException::INVALID_LOG);
        endif;
    }

    public function close() {
        if ($this->_fp):
            $closed = fclose($this->_fp);
        
            if ($closed):
                $this->_fp = null;
                self::$_instance = null;
            else:
                throw new EgressException('Error closing the log file', EgressException::INVALID_LOG);
            endif;
        endif;
    }
}
