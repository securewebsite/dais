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

namespace Front\Controller\Widget;
use Dais\Base\Controller;

class Page extends Controller {
    public function index() {
        $data = $this->theme->language('widget/page');
        
        $this->theme->model('content/page');
        
        $data['pages'] = array();
        
        foreach ($this->model_content_page->getPages() as $result) {
            $data['pages'][] = array('title' => $result['title'], 'href' => $this->url->link('content/page', 'page_id=' . $result['page_id']));
        }
        
        $data['contact'] = $this->url->link('content/contact');
        $data['site_map'] = $this->url->link('content/site_map');
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        return $this->theme->view('widget/page', $data);
    }
}
