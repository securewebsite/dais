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

namespace App\Controllers\Admin\Design;

use App\Controllers\Controller;

class Route extends Controller {
	
	private $error = array();

	public function index() {
		Lang::load('design/route');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Theme::model('design/route');
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
	}

	public function edit() {
		Lang::load('design/route');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Theme::model('design/route');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()):
            $this->model_design_route->editRoutes($this->request->post);
            
            $this->session->data['success'] = Lang::get('lang_text_success');
            
            $url = '';
            
            if (isset($this->request->get['page'])):
                $url .= '&page=' . $this->request->get['page'];
            endif;
            
            Response::redirect(Url::link('design/route', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        endif;
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
	}

	protected function getList() {
		$data = Theme::language('design/route');
        
        if (isset($this->request->get['page'])):
            $page = $this->request->get['page'];
        else:
            $page = 1;
        endif;
        
        $url = '';
        
        if (isset($this->request->get['page'])):
            $url.= '&page=' . $this->request->get['page'];
        endif;
        
        Breadcrumb::add('lang_heading_title', 'design/route', $url);
        
        $data['edit'] = Url::link('design/route/edit', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        $data['routes'] = array();
        
        $filter = array(
			'start' => ($page - 1) * Config::get('config_admin_limit'), 
			'limit' => Config::get('config_admin_limit')
        );
        
        $route_total = $this->model_design_route->getTotalRoutes();
        
        $results = $this->model_design_route->getCustomRoutes($filter);
        
        foreach ($results as $result):
            $data['routes'][] = array(
				'route_id' => $result['route_id'], 
				'route'    => $result['route'],
				'slug'     => $result['slug']
            );
        endforeach;
        
        if (isset($this->error['warning'])):
            $data['error_warning'] = $this->error['warning'];
        else:
            $data['error_warning'] = '';
        endif;
        
        if (isset($this->session->data['success'])):
            $data['success'] = $this->session->data['success'];
            unset($this->session->data['success']);
        else:
            $data['success'] = '';
        endif;
        
        $url = '';
        
        if (isset($this->request->get['page'])):
            $url.= '&page=' . $this->request->get['page'];
        endif;
        
        $data['pagination'] = Theme::paginate(
        	$route_total, 
        	$page, 
        	Config::get('config_admin_limit'), 
        	Lang::get('lang_text_pagination'), 
        	Url::link('design/route', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL')
        );
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(Theme::view('design/route_list', $data));
	}

	protected function getForm() {
		$data = Theme::language('design/route');
        
        if (isset($this->error['warning'])):
            $data['error_warning'] = $this->error['warning'];
        else:
            $data['error_warning'] = '';
        endif;
        
        $url = '';
        
        if (isset($this->request->get['page'])):
            $url.= '&page=' . $this->request->get['page'];
        endif;
        
        Breadcrumb::add('lang_heading_title', 'design/route', $url);
        
        $data['action'] = Url::link('design/route/edit', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['cancel'] = Url::link('design/route', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        if (isset($this->request->post['custom_route'])):
            $data['custom_routes'] = $this->request->post['custom_route'];
        else:
            $data['custom_routes'] = $this->model_design_route->getCustomRoutes();
        endif;
        
        Theme::loadjs('javascript/design/route_form', $data);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(Theme::view('design/route_form', $data));
	}

	protected function validateForm() {
		if (!User::hasPermission('modify', 'design/route')):
            $this->error['warning'] = Lang::get('lang_error_permission');
        endif;

        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
	}
}
