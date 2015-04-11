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
use Dais\Engine\Controller;

class Blogsearch extends Controller {
    public function index($setting) {
        $data = $this->theme->language('widget/blogsearch');
        
        // Search
        if (isset($this->request->get['filter_name'])) {
            $data['filter_name'] = $this->request->get['filter_name'];
        } else {
            $data['filter_name'] = '';
        }
        
        $this->theme->loadjs('javascript/widget/blogsearch', $data);
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        return $this->theme->view('widget/blogsearch', $data);
    }
}
