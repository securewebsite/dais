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

interface DBContract {

	public function query($sql, array $params);

	public function escape($value);

	public function countAffected();

	public function getLastId();

	public function prefix();
}