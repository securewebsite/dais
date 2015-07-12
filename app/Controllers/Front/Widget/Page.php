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

class Page extends Controller {
    public function index() {
        $data = Theme::language('widget/page');
        
        Theme::model('content/page');
        
        $data['pages'] = array();
        
        foreach ($this->model_content_page->getPages() as $result) {
            $data['pages'][] = array('title' => $result['title'], 'href' => Url::link('content/page', 'page_id=' . $result['page_id']));
        }
        
        $data['contact'] = Url::link('content/contact');
        $data['site_map'] = Url::link('content/site_map');
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        return Theme::view('widget/page', $data);
    }
}
