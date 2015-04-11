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

class Welcome extends Controller {
    public function index($setting) {
        $data = $this->theme->language('widget/welcome');
        
        $data['heading_title'] = sprintf($this->language->get('lang_heading_title'), $this->config->get('config_name'));
        
        $data['message'] = html_entity_decode($setting['description'][$this->config->get('config_language_id') ], ENT_QUOTES, 'UTF-8');
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        return $this->theme->view('widget/welcome', $data);
    }
}
