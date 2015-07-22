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

namespace App\Controllers\Admin\Feed;

use App\Controllers\Controller;

class GoogleSiteMap extends Controller {
    
    private $error = array();
    
    public function index() {
        $data = Theme::language('feed/google_site_map');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Theme::model('setting/setting');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            SettingSetting::editSetting('google_site_map', Request::post());
            
            Session::p()->data['success'] = Lang::get('lang_text_success');
            
            Response::redirect(Url::link('module/feed', '', 'SSL'));
        }
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        Breadcrumb::add('lang_text_feed', 'module/feed');
        Breadcrumb::add('lang_heading_title', 'feed/google_site_map');
        
        $data['action'] = Url::link('feed/google_site_map', '', 'SSL');
        
        $data['cancel'] = Url::link('module/feed', '', 'SSL');
        
        if (isset(Request::p()->post['google_site_map_status'])) {
            $data['google_site_map_status'] = Request::p()->post['google_site_map_status'];
        } else {
            $data['google_site_map_status'] = Config::get('google_site_map_status');
        }
        
        $data['data_feed'] = Config::get('http.public') . 'feed/google-site-map';
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('feed/google_site_map', $data));
    }
    
    protected function validate() {
        if (!User::hasPermission('modify', 'feed/google_site_map')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
