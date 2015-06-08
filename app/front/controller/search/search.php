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

namespace Front\Controller\Search;
use Dais\Engine\Controller;

class Search extends Controller {

	public function index() {
		$data = $this->theme->language('search/search');

		$this->javascript->register('storage.min', 'jquery.min');

		$this->breadcrumb->add('lang_heading_title', 'search/search');

		if (isset($this->request->post['search'])):
			$search = $this->request->post['search'];
		else:
			$search = false;
		endif;

		if (isset($this->request->get['page'])):
            $page = $this->request->get['page'];
        else:
            $page = 1;
        endif;

        if ($search):
            $this->theme->setTitle($this->language->get('lang_heading_title') . ' - ' . $search);
            $data['heading_title'] = $this->language->get('lang_heading_title') . ' - ' . $search;
        else:
        	$this->theme->setTitle($this->language->get('lang_heading_title'));
            $data['heading_title'] = $this->language->get('lang_heading_title');
        endif;

        if ($search):
        	$result = $this->search->execute($search);
        endif;

        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('search/search', $data));
	}
}
