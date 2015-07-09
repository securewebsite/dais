<?php

/*
|--------------------------------------------------------------------------
|   Dais
|--------------------------------------------------------------------------
|
|   This file is part of the Dais Framework package.
|    
|    (c) Vince Kronlein <vince@dais.io>
|    
|    For the full copyright and license information, please view the LICENSE
|    file that was distributed with this source code.
|    
*/

namespace Dais\Services\Providers;

use Dais\Contracts\EncodeContract;

final class Mbstring implements EncodeContract {

	public static function utf8Strlen($string) {
        return mb_strlen($string);
    }
    
    public static function utf8Strpos($string, $needle, $offset = 0) {
        return mb_strpos($string, $needle, $offset);
    }
    
    public static function utf8Strrpos($string, $needle, $offset = 0) {
        return mb_strrpos($string, $needle, $offset);
    }
    
    public static function utf8Substr($string, $offset, $length = null) {
        if ($length === null):
            return mb_substr($string, $offset, self::utf8_strlen($string));
        else:
            return mb_substr($string, $offset, $length);
        endif;
    }
    
    public static function utf8Strtoupper($string) {
        return mb_strtoupper($string);
    }
    
    public static function utf8Strtolower($string) {
        return mb_strtolower($string);
    }
}
