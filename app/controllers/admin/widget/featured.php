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

namespace App\Controllers\Admin\Widget;

use App\Controllers\Controller;

class Featured extends Controller {
    
    private $error = array();
    
    public function index() {
        $data = Theme::language('widget/featured');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('setting/setting');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            SettingSetting::editSetting('featured', Request::post());
            Session::p()->data['success'] = Lang::get('lang_text_success');
            
            Response::redirect(Url::link('module/widget', '', 'SSL'));
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
        Breadcrumb::add('lang_heading_title', 'widget/featured');
        
        $data['action'] = Url::link('widget/featured', '', 'SSL');
        $data['cancel'] = Url::link('module/widget', '', 'SSL');
        
        if (isset(Request::p()->post['featured_product'])) {
            $data['featured_product'] = Request::p()->post['featured_product'];
        } else {
            $data['featured_product'] = Config::get('featured_product');
        }
        
        Theme::model('catalog/product');
        
        if (isset(Request::p()->post['featured_product'])) {
            $products = explode(',', Request::p()->post['featured_product']);
        } else {
            $products = explode(',', Config::get('featured_product'));
        }
        
        $data['products'] = array();
        
        foreach ($products as $product_id) {
            $product_info = CatalogProduct::getProduct($product_id);
            
            if ($product_info) {
                $data['products'][] = array('product_id' => $product_info['product_id'], 'name' => $product_info['name']);
            }
        }
        
        $data['widgets'] = array();
        
        if (isset(Request::p()->post['featured_widget'])) {
            $data['widgets'] = Request::p()->post['featured_widget'];
        } elseif (Config::get('featured_widget')) {
            $data['widgets'] = Config::get('featured_widget');
        }
        
        Theme::model('design/layout');
        
        $data['layouts'] = DesignLayout::getLayouts();
        
        Theme::loadjs('javascript/widget/featured', $data);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('widget/featured', $data));
    }
    
    protected function validate() {
        if (!User::hasPermission('modify', 'widget/featured')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        if (isset(Request::p()->post['featured_widget'])) {
            foreach (Request::p()->post['featured_widget'] as $key => $value) {
                if (!$value['image_width'] || !$value['image_height']) {
                    $this->error['image'][$key] = Lang::get('lang_error_image');
                }
            }
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
