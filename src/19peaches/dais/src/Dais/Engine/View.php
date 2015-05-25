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

namespace Dais\Engine;
use Foil\Template\Template;

class View extends Template {
	
	protected function collect($path) {
		ob_start();
		extract($this->data());
		require $path;
		$this->last_buffer = $this->buffer;
		$this->buffer = trim(ob_get_clean());

		return $this->buffer;
	}
}
