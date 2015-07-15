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

namespace App\Theme\Front\Ghost;

use Dais\Contracts\ThemeContract;
use Dais\Base\Theme as BaseTheme;

class Theme extends BaseTheme implements ThemeContract {

	public function __construct() {
		$this->path();
		$this->asset();
		$this->setCss();
		$this->setJavascript();
	}

	public function path() {
		$this->setPath(__DIR__ . SEP);
		$this->style();
	}

	public function style() {
		$this->setStyle('content');
		$this->build();
	}

	public function build() {
		$this->buildControllers();
	}

	protected function asset() {
		$this->setAssetPath($this->getPath() . 'asset' . SEP);
	}

	public function setCss() {
		CSS::register('dais')
            ->register('plugin', 'dais')
            ->register('blog', 'plugin')
            ->register('calendar', 'blog')
            ->register('video', 'calendar', true);
	}

	public function setJavascript() {
		JS::register('jquery.min')
            ->register('migrate.min', 'jquery.min')
            ->register('underscore.min', 'migrate.min')
            ->register('cookie.min', 'underscore.min')
            ->register('touchswipe.min', 'cookie.min')
            ->register('bootstrap.min', 'cookie.min')
            ->register('typeahead.min', 'bootstrap.min')
            ->register('jstz.min', 'bootstrap.min')
            ->register('plugin.min', 'jstz.min')
            ->register('video.min', 'plugin.min')
            ->register('youtube', 'video.min')
            ->register('calendar', 'plugin.min')
            ->register('common.min', null, true);
	}
}
