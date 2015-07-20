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

namespace App\Controllers\Admin\Catalog;

use App\Controllers\Controller;

class Product extends Controller {
    
    private $error = array();
    
    public function index() {
        Lang::load('catalog/product');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Theme::model('catalog/product');
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    public function insert() {
        Lang::load('catalog/product');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Theme::model('catalog/product');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            CatalogProduct::addProduct(Request::post());
            
            Session::p()->data['success'] = Lang::get('lang_text_success');
            
            $url = '';
            
            if (isset(Request::p()->get['filter_name'])) {
                $url.= '&filter_name=' . urlencode(html_entity_decode(Request::p()->get['filter_name'], ENT_QUOTES, 'UTF-8'));
            }
            
            if (isset(Request::p()->get['filter_model'])) {
                $url.= '&filter_model=' . urlencode(html_entity_decode(Request::p()->get['filter_model'], ENT_QUOTES, 'UTF-8'));
            }
            
            if (isset(Request::p()->get['filter_price'])) {
                $url.= '&filter_price=' . Request::p()->get['filter_price'];
            }
            
            if (isset(Request::p()->get['filter_quantity'])) {
                $url.= '&filter_quantity=' . Request::p()->get['filter_quantity'];
            }
            
            if (isset(Request::p()->get['filter_status'])) {
                $url.= '&filter_status=' . Request::p()->get['filter_status'];
            }
            
            if (isset(Request::p()->get['sort'])) {
                $url.= '&sort=' . Request::p()->get['sort'];
            }
            
            if (isset(Request::p()->get['order'])) {
                $url.= '&order=' . Request::p()->get['order'];
            }
            
            if (isset(Request::p()->get['page'])) {
                $url.= '&page=' . Request::p()->get['page'];
            }
            
            Response::redirect(Url::link('catalog/product', '' . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function update() {
        Lang::load('catalog/product');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Theme::model('catalog/product');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            CatalogProduct::editProduct(Request::p()->get['product_id'], Request::post());
            
            Session::p()->data['success'] = Lang::get('lang_text_success');
            
            $url = '';
            
            if (isset(Request::p()->get['filter_name'])) {
                $url.= '&filter_name=' . urlencode(html_entity_decode(Request::p()->get['filter_name'], ENT_QUOTES, 'UTF-8'));
            }
            
            if (isset(Request::p()->get['filter_model'])) {
                $url.= '&filter_model=' . urlencode(html_entity_decode(Request::p()->get['filter_model'], ENT_QUOTES, 'UTF-8'));
            }
            
            if (isset(Request::p()->get['filter_price'])) {
                $url.= '&filter_price=' . Request::p()->get['filter_price'];
            }
            
            if (isset(Request::p()->get['filter_quantity'])) {
                $url.= '&filter_quantity=' . Request::p()->get['filter_quantity'];
            }
            
            if (isset(Request::p()->get['filter_status'])) {
                $url.= '&filter_status=' . Request::p()->get['filter_status'];
            }
            
            if (isset(Request::p()->get['sort'])) {
                $url.= '&sort=' . Request::p()->get['sort'];
            }
            
            if (isset(Request::p()->get['order'])) {
                $url.= '&order=' . Request::p()->get['order'];
            }
            
            if (isset(Request::p()->get['page'])) {
                $url.= '&page=' . Request::p()->get['page'];
            }
            
            Response::redirect(Url::link('catalog/product', '' . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function delete() {
        Lang::load('catalog/product');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Theme::model('catalog/product');
        
        if (isset(Request::p()->post['selected']) && $this->validateDelete()) {
            foreach (Request::p()->post['selected'] as $product_id) {
                CatalogProduct::deleteProduct($product_id);
            }
            
            Session::p()->data['success'] = Lang::get('lang_text_success');
            
            $url = '';
            
            if (isset(Request::p()->get['filter_name'])) {
                $url.= '&filter_name=' . urlencode(html_entity_decode(Request::p()->get['filter_name'], ENT_QUOTES, 'UTF-8'));
            }
            
            if (isset(Request::p()->get['filter_model'])) {
                $url.= '&filter_model=' . urlencode(html_entity_decode(Request::p()->get['filter_model'], ENT_QUOTES, 'UTF-8'));
            }
            
            if (isset(Request::p()->get['filter_price'])) {
                $url.= '&filter_price=' . Request::p()->get['filter_price'];
            }
            
            if (isset(Request::p()->get['filter_quantity'])) {
                $url.= '&filter_quantity=' . Request::p()->get['filter_quantity'];
            }
            
            if (isset(Request::p()->get['filter_status'])) {
                $url.= '&filter_status=' . Request::p()->get['filter_status'];
            }
            
            if (isset(Request::p()->get['sort'])) {
                $url.= '&sort=' . Request::p()->get['sort'];
            }
            
            if (isset(Request::p()->get['order'])) {
                $url.= '&order=' . Request::p()->get['order'];
            }
            
            if (isset(Request::p()->get['page'])) {
                $url.= '&page=' . Request::p()->get['page'];
            }
            
            Response::redirect(Url::link('catalog/product', '' . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    public function copy() {
        Lang::load('catalog/product');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Theme::model('catalog/product');
        
        if (isset(Request::p()->post['selected']) && $this->validateCopy()) {
            foreach (Request::p()->post['selected'] as $product_id) {
                CatalogProduct::copyProduct($product_id);
            }
            
            Session::p()->data['success'] = Lang::get('lang_text_success');
            
            $url = '';
            
            if (isset(Request::p()->get['filter_name'])) {
                $url.= '&filter_name=' . urlencode(html_entity_decode(Request::p()->get['filter_name'], ENT_QUOTES, 'UTF-8'));
            }
            
            if (isset(Request::p()->get['filter_model'])) {
                $url.= '&filter_model=' . urlencode(html_entity_decode(Request::p()->get['filter_model'], ENT_QUOTES, 'UTF-8'));
            }
            
            if (isset(Request::p()->get['filter_price'])) {
                $url.= '&filter_price=' . Request::p()->get['filter_price'];
            }
            
            if (isset(Request::p()->get['filter_quantity'])) {
                $url.= '&filter_quantity=' . Request::p()->get['filter_quantity'];
            }
            
            if (isset(Request::p()->get['filter_status'])) {
                $url.= '&filter_status=' . Request::p()->get['filter_status'];
            }
            
            if (isset(Request::p()->get['sort'])) {
                $url.= '&sort=' . Request::p()->get['sort'];
            }
            
            if (isset(Request::p()->get['order'])) {
                $url.= '&order=' . Request::p()->get['order'];
            }
            
            if (isset(Request::p()->get['page'])) {
                $url.= '&page=' . Request::p()->get['page'];
            }
            
            Response::redirect(Url::link('catalog/product', '' . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    protected function getList() {
        $data = Theme::language('catalog/product');
        
        if (isset(Request::p()->get['filter_name'])) {
            $filter_name = Request::p()->get['filter_name'];
        } else {
            $filter_name = null;
        }
        
        if (isset(Request::p()->get['filter_model'])) {
            $filter_model = Request::p()->get['filter_model'];
        } else {
            $filter_model = null;
        }
        
        if (isset(Request::p()->get['filter_price'])) {
            $filter_price = Request::p()->get['filter_price'];
        } else {
            $filter_price = null;
        }
        
        if (isset(Request::p()->get['filter_quantity'])) {
            $filter_quantity = Request::p()->get['filter_quantity'];
        } else {
            $filter_quantity = null;
        }
        
        if (isset(Request::p()->get['filter_status'])) {
            $filter_status = Request::p()->get['filter_status'];
        } else {
            $filter_status = null;
        }
        
        if (isset(Request::p()->get['sort'])) {
            $sort = Request::p()->get['sort'];
        } else {
            $sort = 'pd.name';
        }
        
        if (isset(Request::p()->get['order'])) {
            $order = Request::p()->get['order'];
        } else {
            $order = 'asc';
        }
        
        if (isset(Request::p()->get['page'])) {
            $page = Request::p()->get['page'];
        } else {
            $page = 1;
        }
        
        $url = '';
        
        if (isset(Request::p()->get['filter_name'])) {
            $url.= '&filter_name=' . urlencode(html_entity_decode(Request::p()->get['filter_name'], ENT_QUOTES, 'UTF-8'));
        }
        
        if (isset(Request::p()->get['filter_model'])) {
            $url.= '&filter_model=' . urlencode(html_entity_decode(Request::p()->get['filter_model'], ENT_QUOTES, 'UTF-8'));
        }
        
        if (isset(Request::p()->get['filter_price'])) {
            $url.= '&filter_price=' . Request::p()->get['filter_price'];
        }
        
        if (isset(Request::p()->get['filter_quantity'])) {
            $url.= '&filter_quantity=' . Request::p()->get['filter_quantity'];
        }
        
        if (isset(Request::p()->get['filter_status'])) {
            $url.= '&filter_status=' . Request::p()->get['filter_status'];
        }
        
        if (isset(Request::p()->get['sort'])) {
            $url.= '&sort=' . Request::p()->get['sort'];
        }
        
        if (isset(Request::p()->get['order'])) {
            $url.= '&order=' . Request::p()->get['order'];
        }
        
        if (isset(Request::p()->get['page'])) {
            $url.= '&page=' . Request::p()->get['page'];
        }
        
        Breadcrumb::add('lang_heading_title', 'catalog/product', $url);
        
        $data['insert'] = Url::link('catalog/product/insert', '' . $url, 'SSL');
        $data['copy']   = Url::link('catalog/product/copy', '' . $url, 'SSL');
        $data['delete'] = Url::link('catalog/product/delete', '' . $url, 'SSL');
        
        $data['products'] = array();
        
        $filter = array(
            'filter_name'     => $filter_name, 
            'filter_model'    => $filter_model, 
            'filter_price'    => $filter_price, 
            'filter_quantity' => $filter_quantity, 
            'filter_status'   => $filter_status, 
            'sort'            => $sort, 
            'order'           => $order, 
            'start'           => ($page - 1) * Config::get('config_admin_limit'), 
            'limit'           => Config::get('config_admin_limit')
        );
        
        Theme::model('tool/image');
        
        $product_total = CatalogProduct::getTotalProducts($filter);
        
        $results = CatalogProduct::getProducts($filter);
        
        foreach ($results as $result) {
            $action = array();
            
            $action[] = array(
                'text' => Lang::get('lang_text_edit'), 
                'href' => Url::link('catalog/product/update', '' . 'product_id=' . $result['product_id'] . $url, 'SSL')
            );
            
            if ($result['image'] && file_exists(Config::get('path.image') . $result['image'])) {
                $image = ToolImage::resize($result['image'], 40, 40);
            } else {
                $image = ToolImage::resize('placeholder.png', 40, 40);
            }
            
            $special = false;
            
            $product_specials = CatalogProduct::getProductSpecials($result['product_id']);
            
            foreach ($product_specials as $product_special) {
                if (($product_special['date_start'] == '0000-00-00' || $product_special['date_start'] < date('Y-m-d')) && ($product_special['date_end'] == '0000-00-00' || $product_special['date_end'] > date('Y-m-d'))) {
                    $special = $product_special['price'];
                    
                    break;
                }
            }
            
            $data['products'][] = array('product_id' => $result['product_id'], 'name' => $result['name'], 'model' => $result['model'], 'price' => $result['price'], 'special' => $special, 'image' => $image, 'quantity' => $result['quantity'], 'status' => ($result['status'] ? Lang::get('lang_text_enabled') : Lang::get('lang_text_disabled')), 'selected' => isset(Request::p()->post['selected']) && in_array($result['product_id'], Request::p()->post['selected']), 'action' => $action);
        }
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        if (isset(Session::p()->data['success'])) {
            $data['success'] = Session::p()->data['success'];
            
            unset(Session::p()->data['success']);
        } else {
            $data['success'] = '';
        }
        
        $url = '';
        
        if (isset(Request::p()->get['filter_name'])) {
            $url.= '&filter_name=' . urlencode(html_entity_decode(Request::p()->get['filter_name'], ENT_QUOTES, 'UTF-8'));
        }
        
        if (isset(Request::p()->get['filter_model'])) {
            $url.= '&filter_model=' . urlencode(html_entity_decode(Request::p()->get['filter_model'], ENT_QUOTES, 'UTF-8'));
        }
        
        if (isset(Request::p()->get['filter_price'])) {
            $url.= '&filter_price=' . Request::p()->get['filter_price'];
        }
        
        if (isset(Request::p()->get['filter_quantity'])) {
            $url.= '&filter_quantity=' . Request::p()->get['filter_quantity'];
        }
        
        if (isset(Request::p()->get['filter_status'])) {
            $url.= '&filter_status=' . Request::p()->get['filter_status'];
        }
        
        if ($order == 'asc') {
            $url.= '&order=desc';
        } else {
            $url.= '&order=asc';
        }
        
        if (isset(Request::p()->get['page'])) {
            $url.= '&page=' . Request::p()->get['page'];
        }
        
        $data['sort_name']     = Url::link('catalog/product', '' . 'sort=pd.name' . $url, 'SSL');
        $data['sort_model']    = Url::link('catalog/product', '' . 'sort=p.model' . $url, 'SSL');
        $data['sort_price']    = Url::link('catalog/product', '' . 'sort=p.price' . $url, 'SSL');
        $data['sort_quantity'] = Url::link('catalog/product', '' . 'sort=p.quantity' . $url, 'SSL');
        $data['sort_status']   = Url::link('catalog/product', '' . 'sort=p.status' . $url, 'SSL');
        $data['sort_order']    = Url::link('catalog/product', '' . 'sort=p.sort_order' . $url, 'SSL');
        
        $url = '';
        
        if (isset(Request::p()->get['filter_name'])) {
            $url.= '&filter_name=' . urlencode(html_entity_decode(Request::p()->get['filter_name'], ENT_QUOTES, 'UTF-8'));
        }
        
        if (isset(Request::p()->get['filter_model'])) {
            $url.= '&filter_model=' . urlencode(html_entity_decode(Request::p()->get['filter_model'], ENT_QUOTES, 'UTF-8'));
        }
        
        if (isset(Request::p()->get['filter_price'])) {
            $url.= '&filter_price=' . Request::p()->get['filter_price'];
        }
        
        if (isset(Request::p()->get['filter_quantity'])) {
            $url.= '&filter_quantity=' . Request::p()->get['filter_quantity'];
        }
        
        if (isset(Request::p()->get['filter_status'])) {
            $url.= '&filter_status=' . Request::p()->get['filter_status'];
        }
        
        if (isset(Request::p()->get['sort'])) {
            $url.= '&sort=' . Request::p()->get['sort'];
        }
        
        if (isset(Request::p()->get['order'])) {
            $url.= '&order=' . Request::p()->get['order'];
        }
        
        $data['pagination'] = Theme::paginate(
            $product_total, $page, 
            Config::get('config_admin_limit'), 
            Lang::get('lang_text_pagination'), 
            Url::link('catalog/product', '' . $url . '&page={page}', 'SSL')
        );
        
        $data['filter_name']     = $filter_name;
        $data['filter_model']    = $filter_model;
        $data['filter_price']    = $filter_price;
        $data['filter_quantity'] = $filter_quantity;
        $data['filter_status']   = $filter_status;
        
        $data['sort']  = $sort;
        $data['order'] = $order;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('catalog/product_list', $data));
    }
    
    protected function getForm() {
        $data = Theme::language('catalog/product');
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        if (isset($this->error['name'])) {
            $data['error_name'] = $this->error['name'];
        } else {
            $data['error_name'] = array();
        }
        
        if (isset($this->error['meta_description'])) {
            $data['error_meta_description'] = $this->error['meta_description'];
        } else {
            $data['error_meta_description'] = array();
        }
        
        if (isset($this->error['description'])) {
            $data['error_description'] = $this->error['description'];
        } else {
            $data['error_description'] = array();
        }
        
        if (isset($this->error['model'])) {
            $data['error_model'] = $this->error['model'];
        } else {
            $data['error_model'] = '';
        }
        
        if (isset($this->error['slug'])) {
            $data['error_slug'] = $this->error['slug'];
        } else {
            $data['error_slug'] = '';
        }
        
        if (isset($this->error['date_available'])) {
            $data['error_date_available'] = $this->error['date_available'];
        } else {
            $data['error_date_available'] = '';
        }
        
        $url = '';
        
        if (isset(Request::p()->get['filter_name'])) {
            $url.= '&filter_name=' . urlencode(html_entity_decode(Request::p()->get['filter_name'], ENT_QUOTES, 'UTF-8'));
        }
        
        if (isset(Request::p()->get['filter_model'])) {
            $url.= '&filter_model=' . urlencode(html_entity_decode(Request::p()->get['filter_model'], ENT_QUOTES, 'UTF-8'));
        }
        
        if (isset(Request::p()->get['filter_price'])) {
            $url.= '&filter_price=' . Request::p()->get['filter_price'];
        }
        
        if (isset(Request::p()->get['filter_quantity'])) {
            $url.= '&filter_quantity=' . Request::p()->get['filter_quantity'];
        }
        
        if (isset(Request::p()->get['filter_status'])) {
            $url.= '&filter_status=' . Request::p()->get['filter_status'];
        }
        
        if (isset(Request::p()->get['sort'])) {
            $url.= '&sort=' . Request::p()->get['sort'];
        }
        
        if (isset(Request::p()->get['order'])) {
            $url.= '&order=' . Request::p()->get['order'];
        }
        
        if (isset(Request::p()->get['page'])) {
            $url.= '&page=' . Request::p()->get['page'];
        }
        
        Breadcrumb::add('lang_heading_title', 'catalog/product', $url);
        
        if (!isset(Request::p()->get['product_id'])) {
            $data['action'] = Url::link('catalog/product/insert', '' . $url, 'SSL');
        } else {
            $data['action'] = Url::link('catalog/product/update', '' . 'product_id=' . Request::p()->get['product_id'] . $url, 'SSL');
        }
        
        $data['cancel'] = Url::link('catalog/product', '' . $url, 'SSL');
        
        if (isset(Request::p()->get['product_id']) && (Request::p()->server['REQUEST_METHOD'] != 'POST')) {
            $product_info = CatalogProduct::getProduct(Request::p()->get['product_id']);
        }
        
        Theme::model('locale/language');
        
        $data['languages'] = LocaleLanguage::getLanguages();
        
        if (isset(Request::p()->post['product_description'])) {
            $data['product_description'] = Request::p()->post['product_description'];
        } elseif (isset(Request::p()->get['product_id'])) {
            $data['product_description'] = CatalogProduct::getProductDescriptions(Request::p()->get['product_id']);
        } else {
            $data['product_description'] = array();
        }
        
        if (isset(Request::p()->post['model'])) {
            $data['model'] = Request::p()->post['model'];
        } elseif (!empty($product_info)) {
            $data['model'] = $product_info['model'];
        } else {
            $data['model'] = '';
        }
        
        if (isset(Request::p()->post['sku'])) {
            $data['sku'] = Request::p()->post['sku'];
        } elseif (!empty($product_info)) {
            $data['sku'] = $product_info['sku'];
        } else {
            $data['sku'] = '';
        }
        
        if (isset(Request::p()->post['upc'])) {
            $data['upc'] = Request::p()->post['upc'];
        } elseif (!empty($product_info)) {
            $data['upc'] = $product_info['upc'];
        } else {
            $data['upc'] = '';
        }
        
        if (isset(Request::p()->post['ean'])) {
            $data['ean'] = Request::p()->post['ean'];
        } elseif (!empty($product_info)) {
            $data['ean'] = $product_info['ean'];
        } else {
            $data['ean'] = '';
        }
        
        if (isset(Request::p()->post['jan'])) {
            $data['jan'] = Request::p()->post['jan'];
        } elseif (!empty($product_info)) {
            $data['jan'] = $product_info['jan'];
        } else {
            $data['jan'] = '';
        }
        
        if (isset(Request::p()->post['isbn'])) {
            $data['isbn'] = Request::p()->post['isbn'];
        } elseif (!empty($product_info)) {
            $data['isbn'] = $product_info['isbn'];
        } else {
            $data['isbn'] = '';
        }
        
        if (isset(Request::p()->post['mpn'])) {
            $data['mpn'] = Request::p()->post['mpn'];
        } elseif (!empty($product_info)) {
            $data['mpn'] = $product_info['mpn'];
        } else {
            $data['mpn'] = '';
        }
        
        if (isset(Request::p()->post['location'])) {
            $data['location'] = Request::p()->post['location'];
        } elseif (!empty($product_info)) {
            $data['location'] = $product_info['location'];
        } else {
            $data['location'] = '';
        }
        
        Theme::model('setting/store');
        
        $data['stores'] = SettingStore::getStores();
        
        if (isset(Request::p()->post['product_store'])) {
            $data['product_store'] = Request::p()->post['product_store'];
        } elseif (isset(Request::p()->get['product_id'])) {
            $data['product_store'] = CatalogProduct::getProductStores(Request::p()->get['product_id']);
        } else {
            $data['product_store'] = array(0);
        }
        
        if (isset(Request::p()->post['slug'])) {
            $data['slug'] = Request::p()->post['slug'];
        } elseif (!empty($product_info)) {
            $data['slug'] = $product_info['slug'];
        } else {
            $data['slug'] = '';
        }
        
        if (isset(Request::p()->post['image'])) {
            $data['image'] = Request::p()->post['image'];
        } elseif (!empty($product_info)) {
            $data['image'] = $product_info['image'];
        } else {
            $data['image'] = '';
        }
        
        Theme::model('tool/image');
        
        if (isset(Request::p()->post['image']) && file_exists(Config::get('path.image') . Request::p()->post['image'])) {
            $data['thumb'] = ToolImage::resize(Request::p()->post['image'], 100, 100);
        } elseif (!empty($product_info) && $product_info['image'] && file_exists(Config::get('path.image') . $product_info['image'])) {
            $data['thumb'] = ToolImage::resize($product_info['image'], 100, 100);
        } else {
            $data['thumb'] = ToolImage::resize('placeholder.png', 100, 100);
        }
        
        if (isset(Request::p()->post['shipping'])) {
            $data['shipping'] = Request::p()->post['shipping'];
        } elseif (!empty($product_info)) {
            $data['shipping'] = $product_info['shipping'];
        } else {
            $data['shipping'] = 1;
        }
        
        if (isset(Request::p()->post['price'])) {
            $data['price'] = Request::p()->post['price'];
        } elseif (!empty($product_info)) {
            $data['price'] = $product_info['price'];
        } else {
            $data['price'] = '';
        }
        
        Theme::model('catalog/recurring');
        
        $data['recurrings'] = CatalogRecurring::getRecurrings();
        
        if (isset(Request::p()->post['product_recurrings'])) {
            $data['product_recurrings'] = Request::p()->post['product_recurrings'];
        } elseif (!empty($product_info)) {
            $data['product_recurrings'] = CatalogProduct::getRecurrings($product_info['product_id']);
        } else {
            $data['product_recurrings'] = array();
        }
        
        Theme::model('locale/tax_class');
        
        $data['tax_classes'] = LocaleTaxClass::getTaxClasses();
        
        if (isset(Request::p()->post['tax_class_id'])) {
            $data['tax_class_id'] = Request::p()->post['tax_class_id'];
        } elseif (!empty($product_info)) {
            $data['tax_class_id'] = $product_info['tax_class_id'];
        } else {
            $data['tax_class_id'] = 0;
        }
        
        if (isset(Request::p()->post['date_available'])) {
            $data['date_available'] = Request::p()->post['date_available'];
        } elseif (!empty($product_info)) {
            $data['date_available'] = date('Y-m-d', strtotime($product_info['date_available']));
        } else {
            $data['date_available'] = date('Y-m-d', time() - 86400);
        }
        
        if (isset(Request::p()->post['quantity'])) {
            $data['quantity'] = Request::p()->post['quantity'];
        } elseif (!empty($product_info)) {
            $data['quantity'] = $product_info['quantity'];
        } else {
            $data['quantity'] = 1;
        }
        
        if (isset(Request::p()->post['minimum'])) {
            $data['minimum'] = Request::p()->post['minimum'];
        } elseif (!empty($product_info)) {
            $data['minimum'] = $product_info['minimum'];
        } else {
            $data['minimum'] = 1;
        }
        
        if (isset(Request::p()->post['subtract'])) {
            $data['subtract'] = Request::p()->post['subtract'];
        } elseif (!empty($product_info)) {
            $data['subtract'] = $product_info['subtract'];
        } else {
            $data['subtract'] = 1;
        }
        
        if (isset(Request::p()->post['sort_order'])) {
            $data['sort_order'] = Request::p()->post['sort_order'];
        } elseif (!empty($product_info)) {
            $data['sort_order'] = $product_info['sort_order'];
        } else {
            $data['sort_order'] = 1;
        }
        
        Theme::model('locale/stock_status');
        
        $data['stock_statuses'] = LocaleStockStatus::getStockStatuses();
        
        if (isset(Request::p()->post['stock_status_id'])) {
            $data['stock_status_id'] = Request::p()->post['stock_status_id'];
        } elseif (!empty($product_info)) {
            $data['stock_status_id'] = $product_info['stock_status_id'];
        } else {
            $data['stock_status_id'] = Config::get('config_stock_status_id');
        }
        
        if (isset(Request::p()->post['status'])) {
            $data['status'] = Request::p()->post['status'];
        } elseif (!empty($product_info)) {
            $data['status'] = $product_info['status'];
        } else {
            $data['status'] = 1;
        }
        
        if (isset(Request::p()->post['visibility'])) {
            $data['visibility'] = Request::p()->post['visibility'];
        } elseif (!empty($product_info)) {
            $data['visibility'] = $product_info['visibility'];
        } else {
            $data['visibility'] = Config::get('config_default_visibility');
        }
        
        if (isset(Request::p()->post['weight'])) {
            $data['weight'] = Request::p()->post['weight'];
        } elseif (!empty($product_info)) {
            $data['weight'] = $product_info['weight'];
        } else {
            $data['weight'] = '';
        }
        
        Theme::model('locale/weight_class');
        
        $data['weight_classes'] = LocaleWeightClass::getWeightClasses();
        
        if (isset(Request::p()->post['weight_class_id'])) {
            $data['weight_class_id'] = Request::p()->post['weight_class_id'];
        } elseif (!empty($product_info)) {
            $data['weight_class_id'] = $product_info['weight_class_id'];
        } else {
            $data['weight_class_id'] = Config::get('config_weight_class_id');
        }
        
        if (isset(Request::p()->post['length'])) {
            $data['length'] = Request::p()->post['length'];
        } elseif (!empty($product_info)) {
            $data['length'] = $product_info['length'];
        } else {
            $data['length'] = '';
        }
        
        if (isset(Request::p()->post['width'])) {
            $data['width'] = Request::p()->post['width'];
        } elseif (!empty($product_info)) {
            $data['width'] = $product_info['width'];
        } else {
            $data['width'] = '';
        }
        
        if (isset(Request::p()->post['height'])) {
            $data['height'] = Request::p()->post['height'];
        } elseif (!empty($product_info)) {
            $data['height'] = $product_info['height'];
        } else {
            $data['height'] = '';
        }
        
        Theme::model('locale/length_class');
        
        $data['length_classes'] = LocaleLengthClass::getLengthClasses();
        
        if (isset(Request::p()->post['length_class_id'])) {
            $data['length_class_id'] = Request::p()->post['length_class_id'];
        } elseif (!empty($product_info)) {
            $data['length_class_id'] = $product_info['length_class_id'];
        } else {
            $data['length_class_id'] = Config::get('config_length_class_id');
        }
        
        Theme::model('catalog/manufacturer');
        
        if (isset(Request::p()->post['manufacturer_id'])) {
            $data['manufacturer_id'] = Request::p()->post['manufacturer_id'];
        } elseif (!empty($product_info)) {
            $data['manufacturer_id'] = $product_info['manufacturer_id'];
        } else {
            $data['manufacturer_id'] = 0;
        }
        
        if (isset(Request::p()->post['manufacturer'])) {
            $data['manufacturer'] = Request::p()->post['manufacturer'];
        } elseif (!empty($product_info)) {
            $manufacturer_info = CatalogManufacturer::getManufacturer($product_info['manufacturer_id']);
            
            if ($manufacturer_info) {
                $data['manufacturer'] = $manufacturer_info['name'];
            } else {
                $data['manufacturer'] = '';
            }
        } else {
            $data['manufacturer'] = '';
        }
        
        // Categories
        Theme::model('catalog/category');
        
        if (isset(Request::p()->post['product_category'])) {
            $categories = Request::p()->post['product_category'];
        } elseif (isset(Request::p()->get['product_id'])) {
            $categories = CatalogProduct::getProductCategories(Request::p()->get['product_id']);
        } else {
            $categories = array();
        }
        
        $data['product_categories'] = array();
        
        foreach ($categories as $category_id) {
            $category_info = CatalogCategory::getCategory($category_id);
            
            if ($category_info) {
                $data['product_categories'][] = array('category_id' => $category_info['category_id'], 'name' => ($category_info['path'] ? $category_info['path'] . ' &gt; ' : '') . $category_info['name']);
            }
        }
        
        // Filters
        Theme::model('catalog/filter');
        
        if (isset(Request::p()->post['product_filter'])) {
            $filters = Request::p()->post['product_filter'];
        } elseif (isset(Request::p()->get['product_id'])) {
            $filters = CatalogProduct::getProductFilters(Request::p()->get['product_id']);
        } else {
            $filters = array();
        }
        
        $data['product_filters'] = array();
        
        foreach ($filters as $filter_id) {
            $filter_info = CatalogFilter::getFilter($filter_id);
            
            if ($filter_info) {
                $data['product_filters'][] = array('filter_id' => $filter_info['filter_id'], 'name' => $filter_info['group'] . ' &gt; ' . $filter_info['name']);
            }
        }
        
        // Attributes
        Theme::model('catalog/attribute');
        
        if (isset(Request::p()->post['product_attribute'])) {
            $product_attributes = Request::p()->post['product_attribute'];
        } elseif (isset(Request::p()->get['product_id'])) {
            $product_attributes = CatalogProduct::getProductAttributes(Request::p()->get['product_id']);
        } else {
            $product_attributes = array();
        }
        
        $data['product_attributes'] = array();
        
        foreach ($product_attributes as $product_attribute) {
            $attribute_info = CatalogAttribute::getAttribute($product_attribute['attribute_id']);
            
            if ($attribute_info) {
                $data['product_attributes'][] = array('attribute_id' => $product_attribute['attribute_id'], 'name' => $attribute_info['name'], 'product_attribute_description' => $product_attribute['product_attribute_description']);
            }
        }
        
        // Options
        Theme::model('catalog/option');
        
        if (isset(Request::p()->post['product_option'])) {
            $product_options = Request::p()->post['product_option'];
        } elseif (isset(Request::p()->get['product_id'])) {
            $product_options = CatalogProduct::getProductOptions(Request::p()->get['product_id']);
        } else {
            $product_options = array();
        }
        
        $data['product_options'] = array();
        
        foreach ($product_options as $product_option) {
            if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
                $product_option_value_data = array();
                
                foreach ($product_option['product_option_value'] as $product_option_value) {
                    $product_option_value_data[] = array('product_option_value_id' => $product_option_value['product_option_value_id'], 'option_value_id' => $product_option_value['option_value_id'], 'quantity' => $product_option_value['quantity'], 'subtract' => $product_option_value['subtract'], 'price' => $product_option_value['price'], 'price_prefix' => $product_option_value['price_prefix'], 'points' => $product_option_value['points'], 'points_prefix' => $product_option_value['points_prefix'], 'weight' => $product_option_value['weight'], 'weight_prefix' => $product_option_value['weight_prefix']);
                }
                
                $data['product_options'][] = array('product_option_id' => $product_option['product_option_id'], 'product_option_value' => $product_option_value_data, 'option_id' => $product_option['option_id'], 'name' => $product_option['name'], 'type' => $product_option['type'], 'required' => $product_option['required']);
            } else {
                $data['product_options'][] = array('product_option_id' => $product_option['product_option_id'], 'option_id' => $product_option['option_id'], 'name' => $product_option['name'], 'type' => $product_option['type'], 'option_value' => $product_option['option_value'], 'required' => $product_option['required']);
            }
        }
        
        $data['option_values'] = array();
        
        foreach ($data['product_options'] as $product_option) {
            if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
                if (!isset($data['option_values'][$product_option['option_id']])) {
                    $data['option_values'][$product_option['option_id']] = CatalogOption::getOptionValues($product_option['option_id']);
                }
            }
        }
        
        Theme::model('people/customer_group');
        
        $data['customer_groups'] = PeopleCustomerGroup::getCustomerGroups();
        
        if (isset(Request::p()->post['product_discount'])) {
            $data['product_discounts'] = Request::p()->post['product_discount'];
        } elseif (isset(Request::p()->get['product_id'])) {
            $data['product_discounts'] = CatalogProduct::getProductDiscounts(Request::p()->get['product_id']);
        } else {
            $data['product_discounts'] = array();
        }
        
        if (isset(Request::p()->post['product_special'])) {
            $data['product_specials'] = Request::p()->post['product_special'];
        } elseif (isset(Request::p()->get['product_id'])) {
            $data['product_specials'] = CatalogProduct::getProductSpecials(Request::p()->get['product_id']);
        } else {
            $data['product_specials'] = array();
        }
        
        // Images
        if (isset(Request::p()->post['product_image'])) {
            $product_images = Request::p()->post['product_image'];
        } elseif (isset(Request::p()->get['product_id'])) {
            $product_images = CatalogProduct::getProductImages(Request::p()->get['product_id']);
        } else {
            $product_images = array();
        }
        
        $data['product_images'] = array();
        
        foreach ($product_images as $product_image) {
            if ($product_image['image'] && file_exists(Config::get('path.image') . $product_image['image'])) {
                $image = $product_image['image'];
            } else {
                $image = 'placeholder.png';
            }
            
            $data['product_images'][] = array('image' => $image, 'thumb' => ToolImage::resize($image, 100, 100), 'sort_order' => $product_image['sort_order']);
        }
        
        $data['no_image'] = ToolImage::resize('placeholder.png', 100, 100);
        
        // Downloads
        Theme::model('catalog/download');
        
        if (isset(Request::p()->post['product_download'])) {
            $product_downloads = Request::p()->post['product_download'];
        } elseif (isset(Request::p()->get['product_id'])) {
            $product_downloads = CatalogProduct::getProductDownloads(Request::p()->get['product_id']);
        } else {
            $product_downloads = array();
        }
        
        $data['product_downloads'] = array();
        
        foreach ($product_downloads as $download_id) {
            $download_info = CatalogDownload::getDownload($download_id);
            
            if ($download_info) {
                $data['product_downloads'][] = array('download_id' => $download_info['download_id'], 'name' => $download_info['name']);
            }
        }
        
        if (isset(Request::p()->post['product_related'])) {
            $products = Request::p()->post['product_related'];
        } elseif (isset(Request::p()->get['product_id'])) {
            $products = CatalogProduct::getProductRelated(Request::p()->get['product_id']);
        } else {
            $products = array();
        }
        
        $data['product_related'] = array();
        
        foreach ($products as $product_id) {
            $related_info = CatalogProduct::getProduct($product_id);
            
            if ($related_info) {
                $data['product_related'][] = array('product_id' => $related_info['product_id'], 'name' => $related_info['name']);
            }
        }
        
        // adding support for a single customer product
        Theme::model('people/customer');
        
        if (isset(Request::p()->post['customer_id'])):
            $data['customer_id'] = Request::p()->post['customer_id'];
        elseif (!empty($product_info)):
            $data['customer_id'] = $product_info['customer_id'];
        else:
            $data['customer_id'] = 0;
        endif;
        
        if ($data['customer_id']):
            $data['customer'] = PeopleCustomer::getUsernameByCustomerId($data['customer_id']);
        else:
            $data['customer'] = '';
        endif;
        
        if (isset(Request::p()->post['points'])) {
            $data['points'] = Request::p()->post['points'];
        } elseif (!empty($product_info)) {
            $data['points'] = $product_info['points'];
        } else {
            $data['points'] = '';
        }
        
        if (isset(Request::p()->post['product_reward'])) {
            $data['product_reward'] = Request::p()->post['product_reward'];
        } elseif (isset(Request::p()->get['product_id'])) {
            $data['product_reward'] = CatalogProduct::getProductRewards(Request::p()->get['product_id']);
        } else {
            $data['product_reward'] = array();
        }
        
        if (isset(Request::p()->post['product_layout'])) {
            $data['product_layout'] = Request::p()->post['product_layout'];
        } elseif (isset(Request::p()->get['product_id'])) {
            $data['product_layout'] = CatalogProduct::getProductLayouts(Request::p()->get['product_id']);
        } else {
            $data['product_layout'] = array();
        }
        
        Theme::model('design/layout');
        
        $data['layouts'] = DesignLayout::getLayouts();
        
        Theme::loadjs('javascript/catalog/product_form', $data);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('catalog/product_form', $data));
    }
    
    protected function validateForm() {
        if (!User::hasPermission('modify', 'catalog/product')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        foreach (Request::p()->post['product_description'] as $language_id => $value) {
            if ((Encode::strlen($value['name']) < 1) || (Encode::strlen($value['name']) > 255)) {
                $this->error['name'][$language_id] = Lang::get('lang_error_name');
            }
        }
        
        if (isset(Request::p()->post['slug']) && Encode::strlen(Request::p()->post['slug']) > 0):
            Theme::model('tool/utility');
            $query = ToolUtility::findSlugByName(Request::p()->post['slug']);
            
            if (isset(Request::p()->get['product_id'])):
                if ($query):
                    if ($query != 'product_id:' . Request::p()->get['product_id']):
                        $this->error['slug'] = sprintf(Lang::get('lang_error_slug_found'), Request::p()->post['slug']);
                    endif;
                endif;
            else:
                if ($query):
                    $this->error['slug'] = sprintf(Lang::get('lang_error_slug_found'), Request::p()->post['slug']);
                endif;
            endif;
        else:
            $this->error['slug'] = Lang::get('lang_error_slug');
        endif;
        
        if ((Encode::strlen(Request::p()->post['model']) < 1) || (Encode::strlen(Request::p()->post['model']) > 64)) {
            $this->error['model'] = Lang::get('lang_error_model');
        }
        
        if ($this->error && !isset($this->error['warning'])) {
            $this->error['warning'] = Lang::get('lang_error_warning');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    protected function validateDelete() {
        if (!User::hasPermission('modify', 'catalog/product')):
            $this->error['warning'] = Lang::get('lang_error_permission');
        endif;

        Theme::model('calendar/event');

        foreach (Request::p()->post['selected'] as $product_id):
            $event_total = CalendarEvent::getTotalEventsByProductId($product_id);

            if ($event_total):
                $this->error['warning'] = sprintf(Lang::get('lang_error_event'), $event_total);
            endif;
        endforeach;
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    protected function validateCopy() {
        if (!User::hasPermission('modify', 'catalog/product')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    public function autouser() {
        $json = array();
        
        if (isset(Request::p()->get['name'])) {
            Theme::model('people/customer');
            
            $filter = array('filter_username' => Request::p()->get['name'], 'start' => 0, 'limit' => 20);
            
            $results = PeopleCustomer::getCustomers($filter);
            
            foreach ($results as $result) {
                $json[] = array('customer_id' => $result['customer_id'], 'name' => strip_tags(html_entity_decode($result['username'], ENT_QUOTES, 'UTF-8')));
            }
        }
        
        $sort_order = array();
        
        foreach ($json as $key => $value) {
            $sort_order[$key] = $value['name'];
        }
        
        array_multisort($sort_order, SORT_ASC, $json);
        
        Response::setOutput(json_encode($json));
    }
    
    public function autocomplete() {
        $json = array();
        
        if (isset(Request::p()->get['filter_name']) || isset(Request::p()->get['filter_model']) || isset(Request::p()->get['filter_category_id'])) {
            Theme::model('catalog/product');
            Theme::model('catalog/option');
            
            if (isset(Request::p()->get['filter_name'])) {
                $filter_name = Request::p()->get['filter_name'];
            } else {
                $filter_name = '';
            }
            
            if (isset(Request::p()->get['filter_model'])) {
                $filter_model = Request::p()->get['filter_model'];
            } else {
                $filter_model = '';
            }
            
            if (isset(Request::p()->get['limit'])) {
                $limit = Request::p()->get['limit'];
            } else {
                $limit = 20;
            }
            
            $filter = array('filter_name' => $filter_name, 'filter_model' => $filter_model, 'start' => 0, 'limit' => $limit);
            
            $results = CatalogProduct::getProducts($filter);
            
            foreach ($results as $result) {
                $option_data = array();
                
                $product_options = CatalogProduct::getProductOptions($result['product_id']);
                
                foreach ($product_options as $product_option) {
                    $option_info = CatalogOption::getOption($product_option['option_id']);
                    
                    if ($option_info) {
                        if ($option_info['type'] == 'select' || $option_info['type'] == 'radio' || $option_info['type'] == 'checkbox' || $option_info['type'] == 'image') {
                            $option_value_data = array();
                            
                            foreach ($product_option['product_option_value'] as $product_option_value) {
                                $option_value_info = CatalogOption::getOptionValue($product_option_value['option_value_id']);
                                
                                if ($option_value_info) {
                                    $option_value_data[] = array('product_option_value_id' => $product_option_value['product_option_value_id'], 'option_value_id' => $product_option_value['option_value_id'], 'name' => $option_value_info['name'], 'price' => (float)$product_option_value['price'] ? Currency::format($product_option_value['price'], Config::get('config_currency')) : false, 'price_prefix' => $product_option_value['price_prefix']);
                                }
                            }
                            
                            $option_data[] = array('product_option_id' => $product_option['product_option_id'], 'option_id' => $product_option['option_id'], 'name' => $option_info['name'], 'type' => $option_info['type'], 'option_value' => $option_value_data, 'required' => $product_option['required']);
                        } else {
                            $option_data[] = array('product_option_id' => $product_option['product_option_id'], 'option_id' => $product_option['option_id'], 'name' => $option_info['name'], 'type' => $option_info['type'], 'option_value' => $product_option['option_value'], 'required' => $product_option['required']);
                        }
                    }
                }
                
                $json[] = array('product_id' => $result['product_id'], 'name' => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')), 'model' => $result['model'], 'option' => $option_data, 'price' => $result['price']);
            }
        }
        
        $json = Theme::listen(__CLASS__, __FUNCTION__, $json);
        
        Response::setOutput(json_encode($json));
    }
    
    public function slug() {
        Lang::load('catalog/product');
        Theme::model('tool/utility');
        
        $json = array();
        
        if (!isset(Request::p()->get['name']) || Encode::strlen(Request::p()->get['name']) < 1):
            $json['error'] = Lang::get('lang_error_name_first');
        else:
            
            // build slug
            $slug = Naming::build_slug(Request::p()->get['name']);
            
            // check that the slug is globally unique
            $query = ToolUtility::findSlugByName($slug);
            
            if ($query):
                if (isset(Request::p()->get['product_id'])):
                    if ($query != 'product_id:' . Request::p()->get['product_id']):
                        $json['error'] = sprintf(Lang::get('lang_error_slug_found'), $slug);
                    else:
                        $json['slug'] = $slug;
                    endif;
                else:
                    $json['error'] = sprintf(Lang::get('lang_error_slug_found'), $slug);
                endif;
            else:
                $json['slug'] = $slug;
            endif;
        endif;
        
        $json = Theme::listen(__CLASS__, __FUNCTION__, $json);
        
        Response::setOutput(json_encode($json));
    }

    public function description() {
        $json = array();

        if (isset(Request::p()->post['description']))
            $json['success'] = $this->keyword->getDescription(Request::p()->post['description']);

        Response::setOutput(json_encode($json));
    }

    public function keyword() {
        $json = array();

        if (isset(Request::p()->post['keywords'])):
            // let's clean up the data first
            $keywords        = $this->keyword->getDescription(Request::p()->post['keywords']);
            $json['success'] = $this->keyword->getKeywords($keywords);
        endif;

        Response::setOutput(json_encode($json));
    }
}
