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

class Share extends Controller {
	private $error = array();

	public function index() {
		$data = Theme::language('module/share');
        Theme::setTitle($this->language->get('lang_heading_title'));

        $this->breadcrumb->add('lang_heading_title', 'module/share');

        if (isset($this->session->data['success'])):
            $data['success'] = $this->session->data['success'];
            unset($this->session->data['success']);
        else:
            $data['success'] = '';
        endif;
        
        Theme::model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()):
            $this->model_setting_setting->editSetting('share_bar', $this->request->post);
            $this->session->data['success'] = $this->language->get('lang_text_success');
            
            Response::redirect($this->url->link('module/share', 'token=' . $this->session->data['token'], 'SSL'));
        endif;

        if (isset($this->error['warning'])):
            $data['error_warning'] = $this->error['warning'];
        else:
            $data['error_warning'] = '';
        endif;

        $settings = $this->model_setting_setting->getSetting('share_bar');

        if (isset($this->request->post['facebook_enabled'])):
        	$data['facebook_enabled'] = $this->request->post['facebook_enabled'];
        elseif(!empty($settings['facebook_enabled'])):
        	$data['facebook_enabled'] = $settings['facebook_enabled'];
        else:
        	$data['facebook_enabled'] = false;
        endif;

        if (isset($this->request->post['twitter_enabled'])):
        	$data['twitter_enabled'] = $this->request->post['twitter_enabled'];
        elseif(!empty($settings['twitter_enabled'])):
        	$data['twitter_enabled'] = $settings['twitter_enabled'];
        else:
        	$data['twitter_enabled'] = false;
        endif;

        if (isset($this->request->post['google_enabled'])):
        	$data['google_enabled'] = $this->request->post['google_enabled'];
        elseif(!empty($settings['google_enabled'])):
        	$data['google_enabled'] = $settings['google_enabled'];
        else:
        	$data['google_enabled'] = false;
        endif;

        if (isset($this->request->post['linkedin_enabled'])):
        	$data['linkedin_enabled'] = $this->request->post['linkedin_enabled'];
        elseif(!empty($settings['linkedin_enabled'])):
        	$data['linkedin_enabled'] = $settings['linkedin_enabled'];
        else:
        	$data['linkedin_enabled'] = false;
        endif;

        if (isset($this->request->post['pinterest_enabled'])):
        	$data['pinterest_enabled'] = $this->request->post['pinterest_enabled'];
        elseif(!empty($settings['pinterest_enabled'])):
        	$data['pinterest_enabled'] = $settings['pinterest_enabled'];
        else:
        	$data['pinterest_enabled'] = false;
        endif;

        if (isset($this->request->post['tumblr_enabled'])):
        	$data['tumblr_enabled'] = $this->request->post['tumblr_enabled'];
        elseif(!empty($settings['tumblr_enabled'])):
        	$data['tumblr_enabled'] = $settings['tumblr_enabled'];
        else:
        	$data['tumblr_enabled'] = false;
        endif;

        if (isset($this->request->post['digg_enabled'])):
        	$data['digg_enabled'] = $this->request->post['digg_enabled'];
        elseif(!empty($settings['digg_enabled'])):
        	$data['digg_enabled'] = $settings['digg_enabled'];
        else:
        	$data['digg_enabled'] = false;
        endif;

        if (isset($this->request->post['stumbleupon_enabled'])):
        	$data['stumbleupon_enabled'] = $this->request->post['stumbleupon_enabled'];
        elseif(!empty($settings['stumbleupon_enabled'])):
        	$data['stumbleupon_enabled'] = $settings['stumbleupon_enabled'];
        else:
        	$data['stumbleupon_enabled'] = false;
        endif;

        if (isset($this->request->post['delicious_enabled'])):
        	$data['delicious_enabled'] = $this->request->post['delicious_enabled'];
        elseif(!empty($settings['delicious_enabled'])):
        	$data['delicious_enabled'] = $settings['delicious_enabled'];
        else:
        	$data['delicious_enabled'] = false;
        endif;

        $data['action'] = $this->url->link('module/share', 'token=' . $this->session->data['token'], 'SSL');
        $data['cancel'] = $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL');

        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        $data = Theme::render_controllers($data);
        
        Response::setOutput(Theme::view('module/share', $data));
	}

	protected function validate() {
		if (!User::hasPermission('modify', 'module/share')):
            $this->error['warning'] = $this->language->get('lang_error_permission');
        endif;
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
	}
}
