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

namespace App\Controllers\Admin\Module;

use App\Controllers\Controller;

class Share extends Controller {
	
    private $error = array();

	public function index() {
		$data = Theme::language('module/share');
        Theme::setTitle(Lang::get('lang_heading_title'));

        Breadcrumb::add('lang_heading_title', 'module/share');

        if (isset(Session::p()->data['success'])):
            $data['success'] = Session::p()->data['success'];
            unset(Session::p()->data['success']);
        else:
            $data['success'] = '';
        endif;
        
        Theme::model('setting/setting');

        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validate()):
            SettingSetting::editSetting('share_bar', Request::post());
            Session::p()->data['success'] = Lang::get('lang_text_success');
            
            Response::redirect(Url::link('module/share', '', 'SSL'));
        endif;

        if (isset($this->error['warning'])):
            $data['error_warning'] = $this->error['warning'];
        else:
            $data['error_warning'] = '';
        endif;

        $settings = SettingSetting::getSetting('share_bar');

        if (isset(Request::p()->post['facebook_enabled'])):
        	$data['facebook_enabled'] = Request::p()->post['facebook_enabled'];
        elseif(!empty($settings['facebook_enabled'])):
        	$data['facebook_enabled'] = $settings['facebook_enabled'];
        else:
        	$data['facebook_enabled'] = false;
        endif;

        if (isset(Request::p()->post['twitter_enabled'])):
        	$data['twitter_enabled'] = Request::p()->post['twitter_enabled'];
        elseif(!empty($settings['twitter_enabled'])):
        	$data['twitter_enabled'] = $settings['twitter_enabled'];
        else:
        	$data['twitter_enabled'] = false;
        endif;

        if (isset(Request::p()->post['google_enabled'])):
        	$data['google_enabled'] = Request::p()->post['google_enabled'];
        elseif(!empty($settings['google_enabled'])):
        	$data['google_enabled'] = $settings['google_enabled'];
        else:
        	$data['google_enabled'] = false;
        endif;

        if (isset(Request::p()->post['linkedin_enabled'])):
        	$data['linkedin_enabled'] = Request::p()->post['linkedin_enabled'];
        elseif(!empty($settings['linkedin_enabled'])):
        	$data['linkedin_enabled'] = $settings['linkedin_enabled'];
        else:
        	$data['linkedin_enabled'] = false;
        endif;

        if (isset(Request::p()->post['pinterest_enabled'])):
        	$data['pinterest_enabled'] = Request::p()->post['pinterest_enabled'];
        elseif(!empty($settings['pinterest_enabled'])):
        	$data['pinterest_enabled'] = $settings['pinterest_enabled'];
        else:
        	$data['pinterest_enabled'] = false;
        endif;

        if (isset(Request::p()->post['tumblr_enabled'])):
        	$data['tumblr_enabled'] = Request::p()->post['tumblr_enabled'];
        elseif(!empty($settings['tumblr_enabled'])):
        	$data['tumblr_enabled'] = $settings['tumblr_enabled'];
        else:
        	$data['tumblr_enabled'] = false;
        endif;

        if (isset(Request::p()->post['digg_enabled'])):
        	$data['digg_enabled'] = Request::p()->post['digg_enabled'];
        elseif(!empty($settings['digg_enabled'])):
        	$data['digg_enabled'] = $settings['digg_enabled'];
        else:
        	$data['digg_enabled'] = false;
        endif;

        if (isset(Request::p()->post['stumbleupon_enabled'])):
        	$data['stumbleupon_enabled'] = Request::p()->post['stumbleupon_enabled'];
        elseif(!empty($settings['stumbleupon_enabled'])):
        	$data['stumbleupon_enabled'] = $settings['stumbleupon_enabled'];
        else:
        	$data['stumbleupon_enabled'] = false;
        endif;

        if (isset(Request::p()->post['delicious_enabled'])):
        	$data['delicious_enabled'] = Request::p()->post['delicious_enabled'];
        elseif(!empty($settings['delicious_enabled'])):
        	$data['delicious_enabled'] = $settings['delicious_enabled'];
        else:
        	$data['delicious_enabled'] = false;
        endif;

        $data['action'] = Url::link('module/share', '', 'SSL');
        $data['cancel'] = Url::link('common/dashboard', '', 'SSL');

        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('module/share', $data));
	}

	protected function validate() {
		if (!User::hasPermission('modify', 'module/share')):
            $this->error['warning'] = Lang::get('lang_error_permission');
        endif;
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
	}
}
