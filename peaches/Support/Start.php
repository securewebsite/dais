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
*/

namespace Dais\Support;

class Start {

    public static function detect() {
        // Error Reporting
        error_reporting(E_ALL);

        // Check Version
        if (version_compare(phpversion() , '5.5.0', '<') === true):
            trigger_error('PHP5.5+ Required');
        endif;

        if (!ini_get('date.timezone')):
            date_default_timezone_set(env('APP_TIMEZONE', 'America/Phoenix'));
        endif;

        // Windows IIS Compatibility
        if (!isset($_SERVER['DOCUMENT_ROOT'])):
            if (isset($_SERVER['SCRIPT_FILENAME'])):
                $_SERVER['DOCUMENT_ROOT'] = str_replace('\\', '/', substr($_SERVER['SCRIPT_FILENAME'], 0, 0 - strlen($_SERVER['PHP_SELF'])));
            endif;
        endif;

        if (!isset($_SERVER['DOCUMENT_ROOT'])):
            if (isset($_SERVER['PATH_TRANSLATED'])):
                $_SERVER['DOCUMENT_ROOT'] = str_replace('\\', '/', substr(str_replace('\\\\', '\\', $_SERVER['PATH_TRANSLATED']) , 0, 0 - strlen($_SERVER['PHP_SELF'])));
            endif;
        endif;

        if (!isset($_SERVER['REQUEST_URI'])):
            $_SERVER['REQUEST_URI'] = substr($_SERVER['PHP_SELF'], 1);
            
            if (isset($_SERVER['QUERY_STRING'])):
                $_SERVER['REQUEST_URI'].= '?' . $_SERVER['QUERY_STRING'];
            endif;
        endif;

        if (!isset($_SERVER['HTTP_HOST'])):
            $_SERVER['HTTP_HOST'] = getenv('HTTP_HOST');
        endif;

        // Check if SSL
        if (isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1'))):
            $_SERVER['HTTPS'] = true;
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' || !empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on'):
            $_SERVER['HTTPS'] = true;
        else:
            $_SERVER['HTTPS'] = false;
        endif;
    }
}
