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

namespace Admin\Controller\Common;
use Dais\Engine\Controller;

class Footer extends Controller {
    public function index() {
        $data = $this->theme->language('common/footer');
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data['javascript']  = $this->theme->controller('common/javascript');
        $data['text_footer'] = sprintf($this->language->get('lang_text_footer'), VERSION);

		$key             = $this->javascript->compile();
		$data['js_link'] = $this->app['https.public'] . 'asset/' . $this->app['theme.name'] . '/compiled/' . $this->app['filecache']->get_key($key, 'js');
        
        return $this->theme->view('common/footer', $data);
    }
}
