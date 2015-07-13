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


namespace Front\Controller\Account;
use Dais\Base\Controller;

class Wishlist extends Controller {
    public function index() {
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('account/wishlist', '', 'SSL');
            
            $this->response->redirect($this->url->link('account/login', '', 'SSL'));
        }
        
        $data = $this->theme->language('account/wishlist');
        $this->theme->model('catalog/product');
        $this->theme->model('tool/image');
        
        if (!isset($this->session->data['wishlist'])) {
            $this->session->data['wishlist'] = array();
        }
        
        if (isset($this->request->get['remove'])) {
            $key = array_search($this->request->get['remove'], $this->session->data['wishlist']);
            
            if ($key !== false) {
                unset($this->session->data['wishlist'][$key]);
            }
            
            $this->session->data['success'] = $this->language->get('lang_text_remove');
            
            $this->response->redirect($this->url->link('account/wishlist'));
        }
        
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        
        $this->breadcrumb->add('lang_text_account', 'account/dashboard', null, true, 'SSL');
        $this->breadcrumb->add('lang_heading_title', 'account/wishlist', null, true, 'SSL');
        
        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];
            
            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }
        
        $data['products'] = array();
        
        foreach ($this->session->data['wishlist'] as $key => $product_id) {
            $product_info = $this->model_catalog_product->getProduct($product_id);
            
            if ($product_info) {
                if ($product_info['image']) {
                    $image = $this->model_tool_image->resize($product_info['image'], $this->config->get('config_image_wishlist_width'), $this->config->get('config_image_wishlist_height'));
                } else {
                    $image = false;
                }
                
                if ($product_info['quantity'] <= 0) {
                    $stock = $product_info['stock_status'];
                } elseif ($this->config->get('config_stock_display')) {
                    $stock = $product_info['quantity'];
                } else {
                    $stock = $this->language->get('lang_text_instock');
                }
                
                if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
                    $price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));
                } else {
                    $price = false;
                }
                
                if ((float)$product_info['special']) {
                    $special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')));
                } else {
                    $special = false;
                }
                
                $data['products'][] = array('product_id' => $product_info['product_id'], 'event_id' => $product_info['event_id'], 'thumb' => $image, 'name' => $product_info['name'], 'model' => $product_info['model'], 'stock' => $stock, 'price' => $price, 'special' => $special, 'href' => $this->url->link('catalog/product', 'product_id=' . $product_info['product_id']), 'remove' => $this->url->link('account/wishlist', 'remove=' . $product_info['product_id']));
            } else {
                unset($this->session->data['wishlist'][$key]);
            }
        }
        
        $data['continue'] = $this->url->link('account/dashboard', '', 'SSL');
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $this->theme->set_controller('header', 'shop/header');
        $this->theme->set_controller('footer', 'shop/footer');
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('account/wishlist', $data));
    }
    
    public function add() {
        $this->theme->language('account/wishlist');
        
        $json = array();
        
        if (!isset($this->session->data['wishlist'])) {
            $this->session->data['wishlist'] = array();
        }
        
        if (isset($this->request->post['product_id'])) {
            $product_id = $this->request->post['product_id'];
        } else {
            $product_id = 0;
        }
        
        $this->theme->model('catalog/product');
        
        $product_info = $this->model_catalog_product->getProduct($product_id);
        
        if ($product_info) {
            if (!in_array($this->request->post['product_id'], $this->session->data['wishlist'])) {
                $this->session->data['wishlist'][] = $this->request->post['product_id'];
            }
            
            if ($this->customer->isLogged()) {
                $json['success'] = sprintf($this->language->get('lang_text_success'), $this->url->link('catalog/product', 'product_id=' . $this->request->post['product_id']), $product_info['name'], $this->url->link('account/wishlist'));
            } else {
                $json['success'] = sprintf($this->language->get('lang_text_login'), $this->url->link('account/login', '', 'SSL'), $this->url->link('account/register', '', 'SSL'), $this->url->link('catalog/product', 'product_id=' . $this->request->post['product_id']), $product_info['name'], $this->url->link('account/wishlist'));
            }
            
            $json['total'] = sprintf($this->language->get('lang_text_wishlist'), (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0));
        }
        
        $json = $this->theme->listen(__CLASS__, __FUNCTION__, $json);
        
        $this->response->setOutput(json_encode($json));
    }
}
