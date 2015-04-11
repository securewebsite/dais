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

class Slideshow extends Controller {
    private $error = array();
    
    public function index() {
        $data = $this->theme->language('widget/slideshow');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('setting/setting');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('slideshow', $this->request->post);
            $this->session->data['success'] = $this->language->get('lang_text_success');
            
            $this->response->redirect($this->url->link('module/widget', 'token=' . $this->session->data['token'], 'SSL'));
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
        
        $this->breadcrumb->add('lang_text_widget', 'module/widget');
        $this->breadcrumb->add('lang_heading_title', 'widget/slideshow');
        
        $data['action'] = $this->url->link('widget/slideshow', 'token=' . $this->session->data['token'], 'SSL');
        $data['cancel'] = $this->url->link('module/widget', 'token=' . $this->session->data['token'], 'SSL');
        
        $data['widgets'] = array();
        
        if (isset($this->request->post['slideshow_widget'])) {
            $data['widgets'] = $this->request->post['slideshow_widget'];
        } elseif ($this->config->get('slideshow_widget')) {
            $data['widgets'] = $this->config->get('slideshow_widget');
        }
        
        $this->theme->model('design/layout');
        
        $data['layouts'] = $this->model_design_layout->getLayouts();
        
        $this->theme->model('design/banner');
        
        $data['banners'] = $this->model_design_banner->getBanners();
        
        $this->theme->loadjs('javascript/widget/slideshow', $data);
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('widget/slideshow', $data));
    }
    
    protected function validate() {
        if (!$this->user->hasPermission('modify', 'widget/slideshow')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        if (isset($this->request->post['slideshow_widget'])) {
            foreach ($this->request->post['slideshow_widget'] as $key => $value) {
                if (!$value['width'] || !$value['height']) {
                    $this->error['dimension'][$key] = $this->language->get('lang_error_dimension');
                }
            }
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
