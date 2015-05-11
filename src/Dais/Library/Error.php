<?php

/*
|--------------------------------------------------------------------------
|   Dais
|--------------------------------------------------------------------------
|
|   This file is part of the Dais Framework package.
|	
|	(c) Vince Kronlein <vince@dais.io>
|	
|	For the full copyright and license information, please view the LICENSE
|	file that was distributed with this source code.
|	
*/

namespace Dais\Library;
use Dais\Engine\Container;
use Dais\Service\LibraryService;

class Error extends LibraryService {
    
    public function __construct(Container $app) {
        parent::__construct($app);
    }
    
    public function error_handler($errno, $errstr, $errfile, $errline) {
        $log    = parent::$app['log'];
        $config = parent::$app['config'];
        
        // Error supression via @ symbol
        if (0 == error_reporting()):
            return;
        endif;
        
        switch ($errno):
        case E_NOTICE:
        case E_USER_NOTICE:
            $error = 'Notice';
            break;

        case E_WARNING:
        case E_USER_WARNING:
            $error = 'Warning';
            break;

        case E_ERROR:
        case E_USER_ERROR:
            $error = 'Fatal Error';
            break;

        default:
            $error = 'Unknown';
            break;
        endswitch;
        
        if ($config->get('config_error_display')):
            echo '<b>' . $error . '</b>: ' . $errstr . ' in <b>' . $errfile . '</b> on line <b>' . $errline . '</b>';
        endif;
        
        if ($config->get('config_error_log')):
            $log->write('PHP ' . $error . ':  ' . $errstr . ' in ' . $errfile . ' on line ' . $errline);
        endif;
        
        return true;
    }
}
