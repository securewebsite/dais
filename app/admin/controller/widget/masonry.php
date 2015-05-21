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

class Masonry extends Controller {
    private $error = array();
    
    public function index() {
        $data = $this->theme->language('widget/masonry');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('setting/setting');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('masonry_widget', $this->request->post);
            $this->cache->delete('products.masonry');
            $this->session->data['success'] = $this->language->get('lang_text_success');
            
            if (!empty($this->request->get['continue'])) {
                $this->response->redirect($this->url->link('widget/masonry', 'token=' . $this->session->data['token'], 'SSL'));
            } else {
                $this->response->redirect($this->url->link('module/widget', 'token=' . $this->session->data['token'], 'SSL'));
            }
        }
        
        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];
            
            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        if (isset($this->error['asterisk'])) {
            $data['error_asterisk'] = $this->error['asterisk'];
        } else {
            $data['error_asterisk'] = array();
        }
        
        $data['breadcrumbs'] = array();
        
        $this->breadcrumb->add('lang_text_widget', 'module/widget');
        $this->breadcrumb->add('lang_heading_title', 'widget/masonry');
        
        $data['action'] = $this->url->link('widget/masonry', 'token=' . $this->session->data['token'], 'SSL');
        $data['cancel'] = $this->url->link('module/widget', 'token=' . $this->session->data['token'], 'SSL');
        
        if (isset($this->request->post['masonry_cart'])) {
            $data['masonry_cart'] = $this->request->post['masonry_cart'];
        } else {
            $data['masonry_cart'] = $this->config->get('masonry_cart');
        }
        
        $data['widgets'] = array();
        
        if (isset($this->request->post['masonry_widget'])) {
            $data['widgets'] = $this->request->post['masonry_widget'];
        } elseif ($this->config->get('masonry_widget')) {
            $data['widgets'] = $this->config->get('masonry_widget');
        }
        
        $data['product_types'] = array('latest' => $this->language->get('lang_text_latest'), 'featured' => $this->language->get('lang_text_featured'), 'special' => $this->language->get('lang_text_special'), 'best_seller' => $this->language->get('lang_text_best_seller'));
        
        $this->theme->model('design/layout');
        
        $data['layouts'] = $this->model_design_layout->getLayouts();
        
        $this->theme->loadjs('javascript/widget/masonry', $data);
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('widget/masonry', $data));
    }
    
    private function validate() {
        if (!$this->user->hasPermission('modify', 'widget/masonry')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        if (isset($this->request->post['masonry_widget'])) {
            foreach ($this->request->post['masonry_widget'] as $key => $value) {
                if ($value['span'] == 1 && $value['description']) {
                    $this->error['asterisk'][$key]['description'] = $this->language->get('lang_error_asterisk');
                }
                
                if ($value['span'] == 1 && $value['button']) {
                    $this->error['asterisk'][$key]['button'] = $this->language->get('lang_error_asterisk');
                }
            }
        }
        
        if ($this->error && !isset($this->error['warning'])) {
            $this->error['warning'] = $this->language->get('lang_error_span');
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
