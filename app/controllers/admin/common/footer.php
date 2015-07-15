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

class Footer extends Controller {
    
    public function index() {
        $data = Theme::language('common/footer');
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data['javascript']  = Theme::controller('common/javascript');
        $data['text_footer'] = sprintf(Lang::get('lang_text_footer'), App::version());

		$key             = JS::compile();
		$data['js_link'] = Config::get('https.public') . 'asset/js/' . Filecache::get_key($key, 'js');
        
        return Theme::view('common/footer', $data);
    }
}
