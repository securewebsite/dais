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
use Exception;

class EgressException extends Exception {

    const MISSING_SCHEMA_INFO_TABLE = 100;
    const INVALID_INDEX_NAME        = 101;
    const MISSING_TABLE             = 102;
    const INVALID_ADAPTER           = 103;
    const INVALID_ARGUMENT          = 104;
    const INVALID_TABLE_DEFINITION  = 105;
    const INVALID_TASK              = 106;
    const INVALID_LOG               = 107;
    const INVALID_CONFIG            = 108;
    const INVALID_TARGET_MIGRATION  = 109;
    const INVALID_MIGRATION_DIR     = 110;
    const INVALID_FRAMEWORK         = 111;
    const QUERY_ERROR               = 112;
    const INVALID_MIGRATION_METHOD  = 113;
    const MIGRATION_FAILED          = 114;
    const MIGRATION_NOT_SUPPORTED   = 115;
    const INVALID_DB_DIR            = 116;

    public function __construct($message, $code = 0, Exception $previous = null) {
        // make sure everything is assigned properly
        if (version_compare(PHP_VERSION, '5.3.0', '>=')):
            parent::__construct($message, $code, $previous);
        else:
            parent::__construct($message, $code);
        endif;
    }

    public function __toString() {
        return "\n" . basename($this->file) . "({$this->line}) : {$this->message}\n";
    }

    public static function errorHandler($code, $message, $file, $line) {
        file_put_contents('php://stderr', "\n" . basename($file) . "({$line}) : {$message}\n\n");

        if ($code != E_WARNING && $code != E_NOTICE):
            exit(1);
        endif;
    }

    public static function exceptionHandler($exception) {
        file_put_contents('php://stderr', "\n" . basename($exception->getFile()) . "({$exception->getLine()}) : {$exception->getMessage()}\n\n");
        exit(1);
    }
}
