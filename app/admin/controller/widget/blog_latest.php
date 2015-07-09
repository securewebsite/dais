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

namespace Admin\Controller\Widget;
use Dais\Engine\Controller;

class BlogLatest extends Controller {
    private $error = array();
    
    public function index() {
        $data = Theme::language('widget/blog_latest');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('setting/setting');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('blog_latest', $this->request->post);
            
            $this->cache->delete('posts.latest');
            $this->session->data['success'] = Lang::get('lang_text_success');
            
            Response::redirect(Url::link('module/widget', 'token=' . $this->session->data['token'], 'SSL'));
        }
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        if (isset($this->error['image'])) {
            $data['error_image'] = $this->error['image'];
        } else {
            $data['error_image'] = array();
        }
        
        Breadcrumb::add('lang_text_widget', 'module/widget');
        Breadcrumb::add('lang_heading_title', 'widget/blog_latest');
        
        $data['action'] = Url::link('widget/blog_latest', 'token=' . $this->session->data['token'], 'SSL');
        $data['cancel'] = Url::link('module/widget', 'token=' . $this->session->data['token'], 'SSL');
        
        $data['widgets'] = array();
        
        if (isset($this->request->post['blog_latest_widget'])) {
            $data['widgets'] = $this->request->post['blog_latest_widget'];
        } elseif (Config::get('blog_latest_widget')) {
            $data['widgets'] = Config::get('blog_latest_widget');
        }
        
        Theme::model('design/layout');
        
        $data['layouts'] = $this->model_design_layout->getLayouts();
        
        Theme::loadjs('javascript/widget/blog_latest', $data);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::render_controllers($data);
        
        Response::setOutput(Theme::view('widget/blog_latest', $data));
    }
    
    private function validate() {
        if (!User::hasPermission('modify', 'widget/blog_latest')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        if (isset($this->request->post['blog_latest_widget'])) {
            foreach ($this->request->post['blog_latest_widget'] as $key => $value) {
                if (!$value['image_width'] || !$value['image_height']) {
                    $this->error['image'][$key] = Lang::get('lang_error_image');
                }
            }
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
