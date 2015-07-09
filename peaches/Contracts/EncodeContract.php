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

namespace Dais\Contracts;

interface EncodeContract {

	public static function utf8Strlen($string);

	public static function utf8Strpos($string, $needle, $offset = 0);

	public static function utf8Strrpos($string, $needle);

	public static function utf8Substr($string, $offset, $length = null);

	public static function utf8Strtoupper($string);

	public static function utf8Strtolower($string);
}
