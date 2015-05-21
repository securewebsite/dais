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

class Naming {
    
    const CLASS_NS_PREFIX = '\Egress\Task\\';

    public static function task_from_class_name($klass) {
        if (! preg_match('/' . str_replace('\\', '\\\\', self::CLASS_NS_PREFIX) . '/', $klass)):
            throw new EgressException('The class name must start with ' . self::CLASS_NS_PREFIX, EgressException::INVALID_ARGUMENT);
        endif;

        $klass = str_replace(self::CLASS_NS_PREFIX, '', $klass);
        $klass = strtolower($klass);
        $klass = str_replace("\\", ":", $klass);

        return $klass;
    }

    public static function task_to_class_name($task) {
        if (false === stripos($task, ':')):
            throw new EgressException('Task name (' . $task . ') must be contains ":"', EgressException::INVALID_ARGUMENT);
        endif;

        $parts = explode(":", $task);

        return self::CLASS_NS_PREFIX . ucfirst($parts[0]) . '\\' . ucfirst($parts[1]);
    }

    public static function class_from_file_name($file_name) {
        //we could be given either a string or an absolute path
        //deal with it appropriately

        // normalize directory separators first
        $file_name = str_replace(array('/', '\\'), SEP, $file_name);

        $parts     = explode(SEP, $file_name);
        $namespace = $parts[count($parts)-2];
        $file_name = substr($parts[count($parts)-1], 0, -4);

        return self::CLASS_NS_PREFIX . ucfirst($namespace) . '\\' . ucfirst($file_name);
    }

    public static function class_from_migration_file($file_name) {
        $className = false;
        
        if (preg_match('/^(.*)_(\d+)\.php$/', $file_name, $matches)):
            if (count($matches) == 3):
                $className = $matches[1] . '_' . $matches[2];
            endif;
        endif;
        
        return $className;
    }

    public static function camelcase($str) {
        $str   = preg_replace('/\s+/', '_', $str);
        $parts = explode("_", $str);

        //if there were no spaces in the input string
        //then assume its already camel-cased
        if (count($parts) == 0):
            return $str;
        endif;

        $cleaned = "";
        
        foreach ($parts as $word):
            $cleaned .= ucfirst($word);
        endforeach;

        return $cleaned;
    }

    public static function index_name($table_name, $column_name) {
        $name = sprintf("idx_%s", self::underscore($table_name));
        //if the column parameter is an array then the user wants to create a multi-column
        
        //index
        if (is_array($column_name)):
            $column_str = join("_and_", $column_name);
        else:
            $column_str = $column_name;
        endif;

        $name .= sprintf("_%s", $column_str);

        return $name;
    }

    public static function underscore($str) {
        $underscored = preg_replace('/\W/', '_', $str);

        return preg_replace('/\_{2,}/', '_', $underscored);
    }
}
