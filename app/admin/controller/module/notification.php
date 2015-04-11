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

namespace Admin\Controller\Module;
use Dais\Engine\Controller;

class Notification extends Controller {
	private $error;

	public function index() {
		$this->language->load('module/notification');
		$this->theme->setTitle($this->language->get('lang_heading_title'));

		$this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
	}

	public function insert() {
		$this->language->load('module/notification');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('module/notification');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()):
            $this->model_module_notification->addNotification($this->request->post);
            $this->session->data['success'] = $this->language->get('lang_text_success');
            
            $url = '';
            
            if (isset($this->request->get['page'])):
                $url.= '&page=' . $this->request->get['page'];
            endif;
            
            $this->response->redirect($this->url->link('module/notification', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        endif;
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
	}

	public function update() {
		$this->language->load('module/notification');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('module/notification');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()):
            $this->model_module_notification->editNotification($this->request->get['notification_id'], $this->request->post);
            $this->session->data['success'] = $this->language->get('lang_text_success');
            
            $url = '';

            if (isset($this->request->get['page'])):
                $url.= '&page=' . $this->request->get['page'];
            endif;
            
            $this->response->redirect($this->url->link('module/notification', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        endif;
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
	}

	public function delete() {
		$this->language->load('module/notification');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('module/notification');
        
        if (isset($this->request->post['selected']) && $this->validateDelete()):
            foreach ($this->request->post['selected'] as $notification_id):
                $this->model_module_notification->deleteNotification($notification_id);
            endforeach;
            
            $this->session->data['success'] = $this->language->get('lang_text_success');
            
            $url = '';
            
            if (isset($this->request->get['page'])):
                $url.= '&page=' . $this->request->get['page'];
            endif;
            
            $this->response->redirect($this->url->link('module/notification', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        endif;
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
	}

	public function getList() {
		$data = $this->theme->language('module/notification');
		$this->theme->model('module/notification');

		$url = '';

		if (isset($this->request->get['page'])):
            $page = $this->request->get['page'];
        	$url .= '&page=' . $this->request->get['page'];
        else:
            $page = 1;
        endif;
        
        $this->breadcrumb->add('lang_heading_title', 'module/notification', $url);
        
        $data['insert'] = $this->url->link('module/notification/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['delete'] = $this->url->link('module/notification/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

        $data['notifications'] = array();
        
        $filter = array( 
            'start' => ($page - 1) * $this->config->get('config_admin_limit'), 
            'limit' => $this->config->get('config_admin_limit')
        );
        
		$total   = $this->model_module_notification->getTotalNotifications();
		$results = $this->model_module_notification->getNotifications($filter);

		foreach ($results as $result):
            $action = array();
            
            $action[] = array(
            	'text' => $this->language->get('lang_text_edit'), 
            	'href' => $this->url->link('module/notification/update', 'token=' . $this->session->data['token'] . '&notification_id=' . $result['email_id'] . $url, 'SSL')
            );

            // Let's display a nice name
			$split = explode('_', $result['email_slug']);

			foreach($split as $key => $value):
				$split[$key] =  ucfirst($value);
			endforeach;

			$name = implode(' ', $split);

            $type     = ($result['is_system']) ? $this->language->get('lang_text_system') : $this->language->get('lang_text_user');
            $priority = ($result['priority'] == 1) ? $this->language->get('lang_text_immediate') : $this->language->get('lang_text_queue');
            
            $data['notifications'][] = array(
                'notification_id' => $result['email_id'],
                'name'            => $name, 
                'email_slug'      => $result['email_slug'],
                'priority'        => $priority,
                'type'            => $type,
                'is_system'       => $result['is_system'],
                'selected'        => isset($this->request->post['selected']) && in_array($result['email_id'], $this->request->post['selected']), 
                'action'          => $action
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

        $data['pagination'] = $this->theme->paginate(
        	$total, 
        	$page, 
        	$this->config->get('config_admin_limit'), 
        	$this->language->get('lang_text_pagination'), 
        	$this->url->link('module/notification', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL')
        );

        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('module/notification_list', $data));
	}

	public function getForm() {
		$data = $this->theme->language('module/notification');
		$this->theme->model('module/notification');

		if (isset($this->error['warning'])):
            $data['error_warning'] = $this->error['warning'];
        else:
            $data['error_warning'] = '';
        endif;

        if (isset($this->error['subject'])):
            $data['error_subject'] = $this->error['subject'];
        else:
            $data['error_subject'] = '';
        endif;

        if (isset($this->error['email_slug'])):
            $data['error_email_slug'] = $this->error['email_slug'];
        else:
            $data['error_email_slug'] = '';
        endif;
        
        if (isset($this->error['error_text'])):
            $data['error_text'] = $this->error['text'];
        else:
            $data['error_text'] = array();
        endif;
        
        if (isset($this->error['html'])):
            $data['error_html'] = $this->error['html'];
        else:
            $data['error_html'] = array();
        endif;

        if (isset($this->error['description'])):
            $data['error_description'] = $this->error['description'];
        else:
            $data['error_description'] = '';
        endif;

        $url = '';
        
        if (isset($this->request->get['page'])):
            $url.= '&page=' . $this->request->get['page'];
        endif;
        
        $this->breadcrumb->add('lang_heading_title', 'module/notification', $url);

        if (!isset($this->request->get['notification_id'])):
            $data['action'] = $this->url->link('module/notification/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        else:
            $data['action'] = $this->url->link('module/notification/update', 'token=' . $this->session->data['token'] . '&notification_id=' . $this->request->get['notification_id'] . $url, 'SSL');
        endif;
        
        $data['cancel'] = $this->url->link('module/notification', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        if (isset($this->request->get['notification_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')):
            $notification_info = $this->model_module_notification->getNotification($this->request->get['notification_id']);
        endif;
        
        $data['token'] = $this->session->data['token'];
        
        $this->theme->model('localization/language');
        
        $data['languages'] = $this->model_localization_language->getLanguages();
        
        if (isset($this->request->post['email_content'])):
            $data['email_content'] = $this->request->post['email_content'];
        elseif (isset($this->request->get['notification_id'])):
            $data['email_content'] = $this->model_module_notification->getNotificationContent($this->request->get['notification_id']);
        else:
            $data['email_content'] = array();
        endif;

        if (isset($this->request->post['email_slug'])):
            $data['email_slug'] = $this->request->post['email_slug'];
        elseif (!empty($notification_info)):
            $data['email_slug'] = $notification_info['email_slug'];
        else:
            $data['email_slug'] = '';
        endif;

        if (isset($this->request->post['is_system'])):
        	$data['is_system'] = $this->request->post['is_system'];
        elseif (!empty($notification_info)):
            $data['is_system'] = $notification_info['is_system'];
        else:
            $data['is_system'] = 0;
        endif;

        if (isset($this->request->post['configurable'])):
            $data['configurable'] = $this->request->post['configurable'];
        elseif (!empty($notification_info)):
            $data['configurable'] = $notification_info['configurable'];
        else:
            $data['configurable'] = 0;
        endif;

        if (isset($this->request->post['config_description'])):
            $data['config_description'] = $this->request->post['config_description'];
        elseif (!empty($notification_info)):
            $data['config_description'] = $notification_info['config_description'];
        else:
            $data['config_description'] = '';
        endif;

        // Customer: 1  Admin: 2
        if (isset($this->request->post['recipient'])):
            $data['recipient'] = $this->request->post['recipient'];
        elseif (!empty($notification_info)):
            $data['recipient'] = $notification_info['recipient'];
        else:
            $data['recipient'] = 1;
        endif;

        if (isset($this->request->post['priority'])):
            $data['priority'] = $this->request->post['priority'];
        elseif (!empty($notification_info)):
            $data['priority'] = $notification_info['priority'];
        else:
            $data['priority'] = 2;
        endif;

        $this->theme->loadjs('javascript/module/notification_form', $data);

        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('module/notification_form', $data));

	}

	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'module/notification')):
            $this->error['warning'] = $this->language->get('lang_error_permission');
        endif;
        
        foreach ($this->request->post['email_content'] as $language_id => $value):
            if ($this->encode->strlen($value['text']) < 1):
                $this->error['text'][$language_id] = $this->language->get('lang_error_text');
            endif;
            
            if ($this->encode->strlen($value['html']) < 1):
                $this->error['html'][$language_id] = $this->language->get('lang_error_html');
            endif;

            if ($this->encode->strlen($value['subject']) < 1):
                $this->error['subject'][$language_id] = $this->language->get('lang_error_subject');
            endif;
        endforeach;
        
        if (isset($this->request->post['email_slug']) && $this->encode->strlen($this->request->post['email_slug']) < 1):
            $this->error['email_slug'] = $this->language->get('lang_error_email_slug');
        endif;

        if ($this->request->post['configurable'] === true && $this->encode->strlen($this->request->post['config_description']) < 3):
            $this->error['description'] = $this->language->get('lang_error_description');
        endif;
        
        if ($this->error && !isset($this->error['warning'])):
            $this->error['warning'] = $this->language->get('lang_error_warning');
        endif;
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
	}

	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'module/notification')):
            $this->error['warning'] = $this->language->get('lang_error_permission');
        endif;

        $count = 0;

        foreach ($this->request->post['selected'] as $email_id):
        	$check = $this->model_module_notification->checkSystem($email_id);
        	if ($check):
        		$count++;
        	endif;
        endforeach;

        if ($count > 0):
        	$this->error['warning'] = $this->language->get('lang_error_system');
        endif;

        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
	}
}
