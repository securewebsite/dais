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

namespace App\Plugin\Example\Admin\Controller;

use App\Controllers\Controller;

class Example extends Controller {
    
    public function __construct() {
        Plugin::setPlugin('Example');
    }
    
    public function index() {
        $data = Plugin::language('example');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Breadcrumb::add('lang_text_plugin', 'module/plugin');
        Breadcrumb::add('lang_heading_title', 'plugin/example');
        
        $data['header']     = Theme::controller('common/header');
        $data['breadcrumb'] = Theme::controller('common/bread_crumb');
        $data['footer']     = Theme::controller('common/footer');
        
        Response::setOutput(Plugin::view('example', $data));
    }
}
