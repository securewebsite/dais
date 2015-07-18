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

namespace App\Theme\Admin\Bs3;

use Dais\Contracts\ThemeContract;
use Dais\Base\Theme as BaseTheme;

class Bs3 extends BaseTheme implements ThemeContract {

	protected $assetPath;

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
		// site style not needed for admin themes
		$this->build();
	}

	public function build() {
		$this->buildControllers();
	}

	protected function asset() {
		$this->setAssetPath($this->getPath() . 'asset' . SEP);
	}

	protected function setCss() {
		CSS::register('dais.min')
            ->register('editor.min', 'dais.min');
	}

	protected function setJavascript() {
		JS::register('jquery.min', null)
            ->register('migrate.min', 'jquery.min')
            ->register('bootstrap.min', 'migrate.min')
            ->register('datetimepicker.min', 'bootstrap.min')
            ->register('typeahead.min', 'bootstrap.min')
            ->register('editor/codemirror.min', 'bootstrap.min')
            ->register('editor/xml-fold.min', 'codemirror.min')
            ->register('editor/active-line.min', 'xml-fold.min')
            ->register('editor/matchbrackets.min', 'active-line.min')
            ->register('editor/closebrackets.min', 'matchbrackets.min')
            ->register('editor/matchtags.min', 'closebrackets.min')
            ->register('editor/closetag.min', 'matchtags.min')
            ->register('editor/xml.min', 'closetag.min')
            ->register('editor/javascript.min', 'xml.min')
            ->register('editor/css.min', 'javascript.min')
            ->register('editor/php.min', 'css.min')
            ->register('editor/format.min', 'php.min')
            ->register('editor/summernote.min', 'format.min')
            ->register('common.min', null, true);
	}
}
