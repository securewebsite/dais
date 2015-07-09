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
		$data = Theme::language('setting/help');

		Theme::setTitle($this->language->get('lang_heading_title'));

		$this->breadcrumb->add('lang_heading_title', 'setting/help');

		$data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::render_controllers($data);
        
        Response::setOutput(Theme::view('setting/help', $data));
	}
}
