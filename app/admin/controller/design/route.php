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

namespace Admin\Controller\Design;
use Dais\Engine\Controller;

class Route extends Controller {
	
	private $error = array();

	public function index() {
		$this->language->load('design/route');
        
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        
        $this->theme->model('design/route');
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
	}

	public function insert() {
		
	}

	public function update() {
		
	}

	public function delete() {
		
	}

	protected function getList() {
		$data = $this->theme->language('design/route');
        
        if (isset($this->request->get['page'])):
            $page = $this->request->get['page'];
        else:
            $page = 1;
        endif;
        
        $url = '';
        
        if (isset($this->request->get['page'])):
            $url.= '&page=' . $this->request->get['page'];
        endif;
        
        $this->breadcrumb->add('lang_heading_title', 'design/route', $url);
        
        $data['insert'] = $this->url->link('design/route/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['delete'] = $this->url->link('design/route/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        $data['routes'] = array();
        
        $filter = array(
			'start' => ($page - 1) * $this->config->get('config_admin_limit'), 
			'limit' => $this->config->get('config_admin_limit')
        );
        
        $route_total = $this->model_design_route->getTotalRoutes();
        
        $results = $this->model_design_route->getRoutes($filter);
        
        foreach ($results as $result) {
            $action = array();
            
            $action[] = array(
            	'text' => $this->language->get('lang_text_edit'), 
            	'href' => $this->url->link('design/route/update', 'token=' . $this->session->data['token'] . '&route_id=' . $result['route_id'] . $url, 'SSL')
            );
            
            $data['routes'][] = array(
				'route_id' => $result['route_id'], 
				'route'    => $result['route'],
				'slug'     => $result['slug'], 
				'selected' => isset($this->request->post['selected']) && in_array($result['route_id'], $this->request->post['selected']), 
				'action'   => $action
            );
        }
        
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
        
        $data['pagination'] = $this->theme->paginate(
        	$route_total, 
        	$page, 
        	$this->config->get('config_admin_limit'), 
        	$this->language->get('lang_text_pagination'), 
        	$this->url->link('design/route', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL')
        );
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('design/route_list', $data));
	}

	protected function getForm() {
		$data = $this->theme->language('design/route');
        
        if (isset($this->error['warning'])):
            $data['error_warning'] = $this->error['warning'];
        else:
            $data['error_warning'] = '';
        endif;
        
        $url = '';
        
        if (isset($this->request->get['page'])):
            $url.= '&page=' . $this->request->get['page'];
        endif;
        
        $this->breadcrumb->add('lang_heading_title', 'design/route', $url);
        
        if (!isset($this->request->get['route_id'])):
            $data['action'] = $this->url->link('design/route/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        else:
            $data['action'] = $this->url->link('design/route/update', 'token=' . $this->session->data['token'] . '&route_id=' . $this->request->get['route_id'] . $url, 'SSL');
        endif;
        
        $data['cancel'] = $this->url->link('design/route', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        if (isset($this->request->get['route_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')):
            $route_info = $this->model_design_route->getRoute($this->request->get['route_id']);
        endif;
        
        $this->theme->model('setting/store');
        
        $data['stores'] = $this->model_setting_store->getStores();
        
        if (isset($this->request->post['custom_route'])):
            $data['custom_routes'] = $this->request->post['custom_route'];
        elseif (isset($this->request->get['route_id'])):
            $data['custom_routes'] = $this->model_design_route->getCustomRoutes($this->request->get['route_id']);
        else:
            $data['custom_routes'] = array();
        endif;
        
        $this->theme->loadjs('javascript/design/route_form', $data);
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('design/route_form', $data));
	}

	protected function validateForm() {
		
	}

	protected function validateDelete() {
		
	}
}
