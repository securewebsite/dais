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

namespace App\Controllers\Front\Common;

use App\Controllers\Controller;

class Javascript extends Controller {
    
    public function index() {
        $scripts         = JS::fetch();
        $data            = $scripts['data'];
        $data['scripts'] = $scripts['files'];
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        return View::make('common/javascript', $data);
    }
}
