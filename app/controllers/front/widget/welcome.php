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

namespace App\Controllers\Front\Widget;

use App\Controllers\Controller;

class Welcome extends Controller {
    
    public function index($setting) {
        $data = Theme::language('widget/welcome');
        
        $data['heading_title'] = sprintf(Lang::get('lang_heading_title'), Config::get('config_name'));
        
        $data['message'] = html_entity_decode($setting['description'][Config::get('config_language_id') ], ENT_QUOTES, 'UTF-8');
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        return View::render('widget/welcome', $data);
    }
}
