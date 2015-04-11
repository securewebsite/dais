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

namespace Admin\Controller\Setting;
use Dais\Engine\Controller;

class Help extends Controller {

	public function index() {
		$data = $this->theme->language('setting/help');

		$this->theme->setTitle($this->language->get('lang_heading_title'));

		$this->breadcrumb->add('lang_heading_title', 'setting/help');

		$data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('setting/help', $data));
	}
}
