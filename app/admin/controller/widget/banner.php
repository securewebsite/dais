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
use Dais\Base\Controller;

class Banner extends Controller {
    private $error = array();
    
    public function index() {
        $data = Theme::language('widget/banner');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('setting/setting');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('banner', $this->request->post);
            $this->session->data['success'] = Lang::get('lang_text_success');
            
            Response::redirect(Url::link('module/widget', 'token=' . $this->session->data['token'], 'SSL'));
        }
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        if (isset($this->error['dimension'])) {
            $data['error_dimension'] = $this->error['dimension'];
        } else {
            $data['error_dimension'] = array();
        }
        
        Breadcrumb::add('lang_text_widget', 'module/widget');
        Breadcrumb::add('lang_heading_title', 'widget/banner');
        
        $data['action'] = Url::link('widget/banner', 'token=' . $this->session->data['token'], 'SSL');
        $data['cancel'] = Url::link('module/widget', 'token=' . $this->session->data['token'], 'SSL');
        
        $data['widgets'] = array();
        
        if (isset($this->request->post['banner_widget'])) {
            $data['widgets'] = $this->request->post['banner_widget'];
        } elseif (Config::get('banner_widget')) {
            $data['widgets'] = Config::get('banner_widget');
        }
        
        Theme::model('design/layout');
        
        $data['layouts'] = $this->model_design_layout->getLayouts();
        
        Theme::model('design/banner');
        
        $data['banners'] = $this->model_design_banner->getBanners();
        
        Theme::loadjs('javascript/widget/banner', $data);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::render_controllers($data);
        
        Response::setOutput(Theme::view('widget/banner', $data));
    }
    
    protected function validate() {
        if (!User::hasPermission('modify', 'widget/banner')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        if (isset($this->request->post['banner_widget'])) {
            foreach ($this->request->post['banner_widget'] as $key => $value) {
                if (!$value['width'] || !$value['height']) {
                    $this->error['dimension'][$key] = Lang::get('lang_error_dimension');
                }
            }
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
