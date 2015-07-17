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
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()):
            DesignRoute::editRoutes(Request::post());
            
            Session::p()->data['success'] = Lang::get('lang_text_success');
            
            $url = '';
            
            if (isset(Request::p()->get['page'])):
                $url .= '&page=' . Request::p()->get['page'];
            endif;
            
            Response::redirect(Url::link('design/route', '' . $url, 'SSL'));
        endif;
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
	}

	protected function getList() {
		$data = Theme::language('design/route');
        
        if (isset(Request::p()->get['page'])):
            $page = Request::p()->get['page'];
        else:
            $page = 1;
        endif;
        
        $url = '';
        
        if (isset(Request::p()->get['page'])):
            $url.= '&page=' . Request::p()->get['page'];
        endif;
        
        Breadcrumb::add('lang_heading_title', 'design/route', $url);
        
        $data['edit'] = Url::link('design/route/edit', '' . $url, 'SSL');
        
        $data['routes'] = array();
        
        $filter = array(
			'start' => ($page - 1) * Config::get('config_admin_limit'), 
			'limit' => Config::get('config_admin_limit')
        );
        
        $route_total = DesignRoute::getTotalRoutes();
        
        $results = DesignRoute::getCustomRoutes($filter);
        
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
        
        if (isset(Session::p()->data['success'])):
            $data['success'] = Session::p()->data['success'];
            unset(Session::p()->data['success']);
        else:
            $data['success'] = '';
        endif;
        
        $url = '';
        
        if (isset(Request::p()->get['page'])):
            $url.= '&page=' . Request::p()->get['page'];
        endif;
        
        $data['pagination'] = Theme::paginate(
        	$route_total, 
        	$page, 
        	Config::get('config_admin_limit'), 
        	Lang::get('lang_text_pagination'), 
        	Url::link('design/route', '' . $url . '&page={page}', 'SSL')
        );
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::render('design/route_list', $data));
	}

	protected function getForm() {
		$data = Theme::language('design/route');
        
        if (isset($this->error['warning'])):
            $data['error_warning'] = $this->error['warning'];
        else:
            $data['error_warning'] = '';
        endif;
        
        $url = '';
        
        if (isset(Request::p()->get['page'])):
            $url.= '&page=' . Request::p()->get['page'];
        endif;
        
        Breadcrumb::add('lang_heading_title', 'design/route', $url);
        
        $data['action'] = Url::link('design/route/edit', '' . $url, 'SSL');
        $data['cancel'] = Url::link('design/route', '' . $url, 'SSL');
        
        if (isset(Request::p()->post['custom_route'])):
            $data['custom_routes'] = Request::p()->post['custom_route'];
        else:
            $data['custom_routes'] = DesignRoute::getCustomRoutes();
        endif;
        
        Theme::loadjs('javascript/design/route_form', $data);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::render('design/route_form', $data));
	}

	protected function validateForm() {
		if (!User::hasPermission('modify', 'design/route')):
            $this->error['warning'] = Lang::get('lang_error_permission');
        endif;

        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
	}
}
