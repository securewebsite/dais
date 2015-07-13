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

namespace App\Controllers\Admin\Common;

use App\Controllers\Controller;

class Javascript extends Controller {
    
    public function index() {
        $scripts         = JS::fetch();
        $data            = $scripts['data'];
        $data['scripts'] = $scripts['files'];
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        return Theme::view('common/javascript', $data);
    }
    
    public function runner() {
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
        
        Theme::listen(__CLASS__, __FUNCTION__);
    }
}
