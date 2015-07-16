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


namespace App\Controllers\Front\Account;

use App\Controllers\Controller;

class Wishlist extends Controller {
    
    public function index() {
        if (!Customer::isLogged()) {
            $this->session->data['redirect'] = Url::link('account/wishlist', '', 'SSL');
            
            Response::redirect(Url::link('account/login', '', 'SSL'));
        }
        
        $data = Theme::language('account/wishlist');
        Theme::model('catalog/product');
        Theme::model('tool/image');
        
        if (!isset($this->session->data['wishlist'])) {
            $this->session->data['wishlist'] = array();
        }
        
        if (isset($this->request->get['remove'])) {
            $key = array_search($this->request->get['remove'], $this->session->data['wishlist']);
            
            if ($key !== false) {
                unset($this->session->data['wishlist'][$key]);
            }
            
            $this->session->data['success'] = Lang::get('lang_text_remove');
            
            Response::redirect(Url::link('account/wishlist'));
        }
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Breadcrumb::add('lang_text_account', 'account/dashboard', null, true, 'SSL');
        Breadcrumb::add('lang_heading_title', 'account/wishlist', null, true, 'SSL');
        
        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];
            
            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }
        
        $data['products'] = array();
        
        foreach ($this->session->data['wishlist'] as $key => $product_id) {
            $product_info = CatalogProduct::getProduct($product_id);
            
            if ($product_info) {
                if ($product_info['image']) {
                    $image = ToolImage::resize($product_info['image'], Config::get('config_image_wishlist_width'), Config::get('config_image_wishlist_height'));
                } else {
                    $image = false;
                }
                
                if ($product_info['quantity'] <= 0) {
                    $stock = $product_info['stock_status'];
                } elseif (Config::get('config_stock_display')) {
                    $stock = $product_info['quantity'];
                } else {
                    $stock = Lang::get('lang_text_instock');
                }
                
                if ((Config::get('config_customer_price') && Customer::isLogged()) || !Config::get('config_customer_price')) {
                    $price = Currency::format(Tax::calculate($product_info['price'], $product_info['tax_class_id'], Config::get('config_tax')));
                } else {
                    $price = false;
                }
                
                if ((float)$product_info['special']) {
                    $special = Currency::format(Tax::calculate($product_info['special'], $product_info['tax_class_id'], Config::get('config_tax')));
                } else {
                    $special = false;
                }
                
                $data['products'][] = array('product_id' => $product_info['product_id'], 'event_id' => $product_info['event_id'], 'thumb' => $image, 'name' => $product_info['name'], 'model' => $product_info['model'], 'stock' => $stock, 'price' => $price, 'special' => $special, 'href' => Url::link('catalog/product', 'product_id=' . $product_info['product_id']), 'remove' => Url::link('account/wishlist', 'remove=' . $product_info['product_id']));
            } else {
                unset($this->session->data['wishlist'][$key]);
            }
        }
        
        $data['continue'] = Url::link('account/dashboard', '', 'SSL');
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        Theme::setController('header', 'shop/header');
        Theme::setController('footer', 'shop/footer');
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::render('account/wishlist', $data));
    }
    
    public function add() {
        Theme::language('account/wishlist');
        
        $json = array();
        
        if (!isset($this->session->data['wishlist'])) {
            $this->session->data['wishlist'] = array();
        }
        
        if (isset($this->request->post['product_id'])) {
            $product_id = $this->request->post['product_id'];
        } else {
            $product_id = 0;
        }
        
        Theme::model('catalog/product');
        
        $product_info = CatalogProduct::getProduct($product_id);
        
        if ($product_info) {
            if (!in_array($this->request->post['product_id'], $this->session->data['wishlist'])) {
                $this->session->data['wishlist'][] = $this->request->post['product_id'];
            }
            
            if (Customer::isLogged()) {
                $json['success'] = sprintf(Lang::get('lang_text_success'), Url::link('catalog/product', 'product_id=' . $this->request->post['product_id']), $product_info['name'], Url::link('account/wishlist'));
            } else {
                $json['success'] = sprintf(Lang::get('lang_text_login'), Url::link('account/login', '', 'SSL'), Url::link('account/register', '', 'SSL'), Url::link('catalog/product', 'product_id=' . $this->request->post['product_id']), $product_info['name'], Url::link('account/wishlist'));
            }
            
            $json['total'] = sprintf(Lang::get('lang_text_wishlist'), (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0));
        }
        
        $json = Theme::listen(__CLASS__, __FUNCTION__, $json);
        
        Response::setOutput(json_encode($json));
    }
}
