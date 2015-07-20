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

namespace App\Controllers\Admin\Tool;

use App\Controllers\Controller;

class Test extends Controller {
    
    public function index() {
        $data = Theme::language('tool/test');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        if (isset(Session::p()->data['success'])):
            $data['success'] = Session::p()->data['success'];
            
            unset(Session::p()->data['success']);
        else:
            $data['success'] = '';
        endif;
        
        Breadcrumb::add('lang_heading_title', 'tool/test');

        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('tool/test', $data));
    }
}
