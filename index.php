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

header('HTTP/1.1 302 Found');

if (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on' || $_SERVER['SERVER_PORT'] == 443):
	header('Location: https://' . $_SERVER['HTTP_HOST'] . rtrim(str_replace('\\', '/', dirname($_SERVER['PHP_SELF'])), '/') . '/public/index.php' . (isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] ? "?$_SERVER[QUERY_STRING]" : ''));
else:
	header('Location: http://' . $_SERVER['HTTP_HOST'] . rtrim(str_replace('\\', '/', dirname($_SERVER['PHP_SELF'])), '/') . '/public/index.php' . (isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] ? "?$_SERVER[QUERY_STRING]" : ''));
endif;
