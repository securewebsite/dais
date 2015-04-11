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

namespace Admin\Controller\Feed;
use Dais\Engine\Controller;

class Googlesitemap extends Controller {
    private $error = array();
    
    public function index() {
        $data = $this->theme->language('feed/googlesitemap');
        
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        
        $this->theme->model('setting/setting');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('googlesitemap', $this->request->post);
            
            $this->session->data['success'] = $this->language->get('lang_text_success');
            
            $this->response->redirect($this->url->link('module/feed', 'token=' . $this->session->data['token'], 'SSL'));
        }
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        $this->breadcrumb->add('lang_text_feed', 'module/feed');
        $this->breadcrumb->add('lang_heading_title', 'feed/googlesitemap');
        
        $data['action'] = $this->url->link('feed/googlesitemap', 'token=' . $this->session->data['token'], 'SSL');
        
        $data['cancel'] = $this->url->link('module/feed', 'token=' . $this->session->data['token'], 'SSL');
        
        if (isset($this->request->post['googlesitemap_status'])) {
            $data['googlesitemap_status'] = $this->request->post['googlesitemap_status'];
        } else {
            $data['googlesitemap_status'] = $this->config->get('googlesitemap_status');
        }
        
        $data['data_feed'] = $this->app['http.public'] . 'feed/googlesitemap';
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('feed/googlesitemap', $data));
    }
    
    protected function validate() {
        if (!$this->user->hasPermission('modify', 'feed/googlesitemap')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
