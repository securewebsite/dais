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

class Featured extends Controller {
    private $error = array();
    
    public function index() {
        $data = Theme::language('widget/featured');
        Theme::setTitle($this->language->get('lang_heading_title'));
        Theme::model('setting/setting');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('featured', $this->request->post);
            $this->session->data['success'] = $this->language->get('lang_text_success');
            
            Response::redirect($this->url->link('module/widget', 'token=' . $this->session->data['token'], 'SSL'));
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
        
        $this->breadcrumb->add('lang_text_widget', 'module/widget');
        $this->breadcrumb->add('lang_heading_title', 'widget/featured');
        
        $data['action'] = $this->url->link('widget/featured', 'token=' . $this->session->data['token'], 'SSL');
        $data['cancel'] = $this->url->link('module/widget', 'token=' . $this->session->data['token'], 'SSL');
        
        $data['token'] = $this->session->data['token'];
        
        if (isset($this->request->post['featured_product'])) {
            $data['featured_product'] = $this->request->post['featured_product'];
        } else {
            $data['featured_product'] = Config::get('featured_product');
        }
        
        Theme::model('catalog/product');
        
        if (isset($this->request->post['featured_product'])) {
            $products = explode(',', $this->request->post['featured_product']);
        } else {
            $products = explode(',', Config::get('featured_product'));
        }
        
        $data['products'] = array();
        
        foreach ($products as $product_id) {
            $product_info = $this->model_catalog_product->getProduct($product_id);
            
            if ($product_info) {
                $data['products'][] = array('product_id' => $product_info['product_id'], 'name' => $product_info['name']);
            }
        }
        
        $data['widgets'] = array();
        
        if (isset($this->request->post['featured_widget'])) {
            $data['widgets'] = $this->request->post['featured_widget'];
        } elseif (Config::get('featured_widget')) {
            $data['widgets'] = Config::get('featured_widget');
        }
        
        Theme::model('design/layout');
        
        $data['layouts'] = $this->model_design_layout->getLayouts();
        
        Theme::loadjs('javascript/widget/featured', $data);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::render_controllers($data);
        
        Response::setOutput(Theme::view('widget/featured', $data));
    }
    
    protected function validate() {
        if (!User::hasPermission('modify', 'widget/featured')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        if (isset($this->request->post['featured_widget'])) {
            foreach ($this->request->post['featured_widget'] as $key => $value) {
                if (!$value['image_width'] || !$value['image_height']) {
                    $this->error['image'][$key] = $this->language->get('lang_error_image');
                }
            }
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
