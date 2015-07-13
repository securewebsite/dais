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

namespace Front\Controller\Account;
use Dais\Base\Controller;

class Notification extends Controller {

	private $error = array();

	public function index() {
		if (!$this->customer->isLogged()):
            $this->session->data['redirect'] = $this->url->link('account/notification', '', 'SSL');
            $this->response->redirect($this->url->link('account/login', '', 'SSL'));
        endif;

		$data = $this->theme->language('account/notification');

		$this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('account/notification');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()):
            $this->model_account_notification->editNotification($this->request->post);
            $this->session->data['success'] = $this->language->get('lang_text_success');
        endif;

        $this->breadcrumb->add('lang_text_account', 'account/dashboard', null, true, 'SSL');
        $this->breadcrumb->add('lang_heading_title', 'account/notification', null, true, 'SSL');

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

        $customer_notifications = $this->model_account_notification->getCustomerNotifications();
        $emails = $this->model_account_notification->getConfigurableNotifications();

        $data['notifications'] = array();

        foreach($emails as $email):
            $mail     = array();
            $internal = array();

            $mail['title']     = $this->language->get('lang_text_email');
            $internal['title'] = $this->language->get('lang_text_internal');

            if (array_key_exists($email['email_id'], $customer_notifications)):
                $mail['value']     = $customer_notifications[$email['email_id']]['email'];
                $internal['value'] = $customer_notifications[$email['email_id']]['internal'];
            else:
                $mail['value']     = 0;
                $internal['value'] = 0;
            endif;

            $notify = array(
                'email'    => $mail,
                'internal' => $internal
            );

            $data['notifications'][] = array(
                'id'          => $email['email_id'],
                'slug'        => $email['email_slug'],
                'description' => $email['config_description'],
                'content'     => $notify
            );
        endforeach;

		$data['action'] = $this->url->link('account/notification', '', 'SSL');
		$data['back']   = $this->url->link('account/dashboard', '', 'SSL');

        $this->theme->loadjs('javascript/account/notification', $data);

        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $this->theme->set_controller('header', 'shop/header');
        $this->theme->set_controller('footer', 'shop/footer');
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('account/notification', $data));
	}

    public function inbox() {
        $data = $this->theme->language('account/notification');
        $this->theme->model('account/notification');
        
        if (isset($this->request->get['page'])):
            $page = $this->request->get['page'];
        else:
            $page = 1;
        endif;
        
        $data['inbox'] = array();
        
        $total   = $this->model_account_notification->getTotalNotifications();
        $results = $this->model_account_notification->getAllNotifications(($page - 1) * 10, 10);

        $data['back'] = $this->url->link('account/dashboard', '', 'SSL');
        
        foreach ($results as $result):
           $data['inbox'][] = array(
                'notification_id' => $result['notification_id'],
                'href'            => $this->url->link('account/notification/read', 'notification_id=' . $result['notification_id'], 'SSL'),
                'subject'         => $result['subject'],
                'read'            => $result['is_read'],
                'delete'          => $this->url->link('account/notification/delete', 'notification_id=' . $result['notification_id'], 'SSL'),
            ); 
        endforeach;
        
        $data['pagination'] = $this->theme->paginate(
            $total, 
            $page, 
            10, 
            $this->language->get('lang_text_pagination'), 
            $this->url->link('account/notification/inbox', 'page={page}', 'SSL')
        );
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $this->response->setOutput($this->theme->view('account/inbox', $data));
    }

    public function read() {
        $this->theme->model('account/notification');

        $json = array();

        $id = $this->request->get['notification_id'];

        $json['message'] = html_entity_decode($this->model_account_notification->getInboxNotification($id), ENT_QUOTES, 'UTF-8');

        $json = $this->theme->listen(__CLASS__, __FUNCTION__, $json);
        
        $this->response->setOutput(json_encode($json));
    }

    public function delete() {
        $this->theme->language('account/notification');
        $this->theme->model('account/notification');

        $json = array();

        $notification_id = $this->request->get['notification_id'];

        if ($this->model_account_notification->deleteInboxNotification($notification_id)):
            $json['success'] = $this->language->get('lang_text_success');
        endif;

        $json = $this->theme->listen(__CLASS__, __FUNCTION__, $json);
        
        $this->response->setOutput(json_encode($json));
    }

    public function unsubscribe() {
        if ($this->customer->isLogged()):
            $this->response->redirect($this->url->link('account/notification/#tab-settings', '', 'SSL'));
        endif;

        $this->theme->language('account/notification');
    }

    public function webversion() {
        $data = $this->theme->language('account/notification');

        $data['webversion'] = false;

        if (isset($this->request->get['id'])):
            $this->theme->model('account/notification');
            $data['webversion'] = $this->model_account_notification->getWebversion($this->request->get['id']);
        endif;

        $this->response->setOutput($this->theme->view('account/webversion', $data));
    }

    public function preferences() {

    }

	private function validate() {
		// just return true as we have nothing to validate here
        return true;
	}
}
