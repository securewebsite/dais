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

namespace Admin\Controller\Catalog;
use Dais\Engine\Controller;

class Product extends Controller {
    private $error = array();
    
    public function index() {
        $this->language->load('catalog/product');
        
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        
        $this->theme->model('catalog/product');
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    public function insert() {
        $this->language->load('catalog/product');
        
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        
        $this->theme->model('catalog/product');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_catalog_product->addProduct($this->request->post);
            
            $this->session->data['success'] = $this->language->get('lang_text_success');
            
            $url = '';
            
            if (isset($this->request->get['filter_name'])) {
                $url.= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
            }
            
            if (isset($this->request->get['filter_model'])) {
                $url.= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
            }
            
            if (isset($this->request->get['filter_price'])) {
                $url.= '&filter_price=' . $this->request->get['filter_price'];
            }
            
            if (isset($this->request->get['filter_quantity'])) {
                $url.= '&filter_quantity=' . $this->request->get['filter_quantity'];
            }
            
            if (isset($this->request->get['filter_status'])) {
                $url.= '&filter_status=' . $this->request->get['filter_status'];
            }
            
            if (isset($this->request->get['sort'])) {
                $url.= '&sort=' . $this->request->get['sort'];
            }
            
            if (isset($this->request->get['order'])) {
                $url.= '&order=' . $this->request->get['order'];
            }
            
            if (isset($this->request->get['page'])) {
                $url.= '&page=' . $this->request->get['page'];
            }
            
            $this->response->redirect($this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function update() {
        $this->language->load('catalog/product');
        
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        
        $this->theme->model('catalog/product');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_catalog_product->editProduct($this->request->get['product_id'], $this->request->post);
            
            $this->session->data['success'] = $this->language->get('lang_text_success');
            
            $url = '';
            
            if (isset($this->request->get['filter_name'])) {
                $url.= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
            }
            
            if (isset($this->request->get['filter_model'])) {
                $url.= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
            }
            
            if (isset($this->request->get['filter_price'])) {
                $url.= '&filter_price=' . $this->request->get['filter_price'];
            }
            
            if (isset($this->request->get['filter_quantity'])) {
                $url.= '&filter_quantity=' . $this->request->get['filter_quantity'];
            }
            
            if (isset($this->request->get['filter_status'])) {
                $url.= '&filter_status=' . $this->request->get['filter_status'];
            }
            
            if (isset($this->request->get['sort'])) {
                $url.= '&sort=' . $this->request->get['sort'];
            }
            
            if (isset($this->request->get['order'])) {
                $url.= '&order=' . $this->request->get['order'];
            }
            
            if (isset($this->request->get['page'])) {
                $url.= '&page=' . $this->request->get['page'];
            }
            
            $this->response->redirect($this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function delete() {
        $this->language->load('catalog/product');
        
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        
        $this->theme->model('catalog/product');
        
        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $product_id) {
                $this->model_catalog_product->deleteProduct($product_id);
            }
            
            $this->session->data['success'] = $this->language->get('lang_text_success');
            
            $url = '';
            
            if (isset($this->request->get['filter_name'])) {
                $url.= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
            }
            
            if (isset($this->request->get['filter_model'])) {
                $url.= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
            }
            
            if (isset($this->request->get['filter_price'])) {
                $url.= '&filter_price=' . $this->request->get['filter_price'];
            }
            
            if (isset($this->request->get['filter_quantity'])) {
                $url.= '&filter_quantity=' . $this->request->get['filter_quantity'];
            }
            
            if (isset($this->request->get['filter_status'])) {
                $url.= '&filter_status=' . $this->request->get['filter_status'];
            }
            
            if (isset($this->request->get['sort'])) {
                $url.= '&sort=' . $this->request->get['sort'];
            }
            
            if (isset($this->request->get['order'])) {
                $url.= '&order=' . $this->request->get['order'];
            }
            
            if (isset($this->request->get['page'])) {
                $url.= '&page=' . $this->request->get['page'];
            }
            
            $this->response->redirect($this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    public function copy() {
        $this->language->load('catalog/product');
        
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        
        $this->theme->model('catalog/product');
        
        if (isset($this->request->post['selected']) && $this->validateCopy()) {
            foreach ($this->request->post['selected'] as $product_id) {
                $this->model_catalog_product->copyProduct($product_id);
            }
            
            $this->session->data['success'] = $this->language->get('lang_text_success');
            
            $url = '';
            
            if (isset($this->request->get['filter_name'])) {
                $url.= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
            }
            
            if (isset($this->request->get['filter_model'])) {
                $url.= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
            }
            
            if (isset($this->request->get['filter_price'])) {
                $url.= '&filter_price=' . $this->request->get['filter_price'];
            }
            
            if (isset($this->request->get['filter_quantity'])) {
                $url.= '&filter_quantity=' . $this->request->get['filter_quantity'];
            }
            
            if (isset($this->request->get['filter_status'])) {
                $url.= '&filter_status=' . $this->request->get['filter_status'];
            }
            
            if (isset($this->request->get['sort'])) {
                $url.= '&sort=' . $this->request->get['sort'];
            }
            
            if (isset($this->request->get['order'])) {
                $url.= '&order=' . $this->request->get['order'];
            }
            
            if (isset($this->request->get['page'])) {
                $url.= '&page=' . $this->request->get['page'];
            }
            
            $this->response->redirect($this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    protected function getList() {
        $data = $this->theme->language('catalog/product');
        
        if (isset($this->request->get['filter_name'])) {
            $filter_name = $this->request->get['filter_name'];
        } else {
            $filter_name = null;
        }
        
        if (isset($this->request->get['filter_model'])) {
            $filter_model = $this->request->get['filter_model'];
        } else {
            $filter_model = null;
        }
        
        if (isset($this->request->get['filter_price'])) {
            $filter_price = $this->request->get['filter_price'];
        } else {
            $filter_price = null;
        }
        
        if (isset($this->request->get['filter_quantity'])) {
            $filter_quantity = $this->request->get['filter_quantity'];
        } else {
            $filter_quantity = null;
        }
        
        if (isset($this->request->get['filter_status'])) {
            $filter_status = $this->request->get['filter_status'];
        } else {
            $filter_status = null;
        }
        
        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'pd.name';
        }
        
        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            $order = 'ASC';
        }
        
        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }
        
        $url = '';
        
        if (isset($this->request->get['filter_name'])) {
            $url.= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
        }
        
        if (isset($this->request->get['filter_model'])) {
            $url.= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
        }
        
        if (isset($this->request->get['filter_price'])) {
            $url.= '&filter_price=' . $this->request->get['filter_price'];
        }
        
        if (isset($this->request->get['filter_quantity'])) {
            $url.= '&filter_quantity=' . $this->request->get['filter_quantity'];
        }
        
        if (isset($this->request->get['filter_status'])) {
            $url.= '&filter_status=' . $this->request->get['filter_status'];
        }
        
        if (isset($this->request->get['sort'])) {
            $url.= '&sort=' . $this->request->get['sort'];
        }
        
        if (isset($this->request->get['order'])) {
            $url.= '&order=' . $this->request->get['order'];
        }
        
        if (isset($this->request->get['page'])) {
            $url.= '&page=' . $this->request->get['page'];
        }
        
        $this->breadcrumb->add('lang_heading_title', 'catalog/product', $url);
        
        $data['insert'] = $this->url->link('catalog/product/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['copy'] = $this->url->link('catalog/product/copy', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['delete'] = $this->url->link('catalog/product/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        $data['products'] = array();
        
        $filter = array('filter_name' => $filter_name, 'filter_model' => $filter_model, 'filter_price' => $filter_price, 'filter_quantity' => $filter_quantity, 'filter_status' => $filter_status, 'sort' => $sort, 'order' => $order, 'start' => ($page - 1) * $this->config->get('config_admin_limit'), 'limit' => $this->config->get('config_admin_limit'));
        
        $this->theme->model('tool/image');
        
        $product_total = $this->model_catalog_product->getTotalProducts($filter);
        
        $results = $this->model_catalog_product->getProducts($filter);
        
        foreach ($results as $result) {
            $action = array();
            
            $action[] = array('text' => $this->language->get('lang_text_edit'), 'href' => $this->url->link('catalog/product/update', 'token=' . $this->session->data['token'] . '&product_id=' . $result['product_id'] . $url, 'SSL'));
            
            if ($result['image'] && file_exists($this->app['path.image'] . $result['image'])) {
                $image = $this->model_tool_image->resize($result['image'], 40, 40);
            } else {
                $image = $this->model_tool_image->resize('placeholder.png', 40, 40);
            }
            
            $special = false;
            
            $product_specials = $this->model_catalog_product->getProductSpecials($result['product_id']);
            
            foreach ($product_specials as $product_special) {
                if (($product_special['date_start'] == '0000-00-00' || $product_special['date_start'] < date('Y-m-d')) && ($product_special['date_end'] == '0000-00-00' || $product_special['date_end'] > date('Y-m-d'))) {
                    $special = $product_special['price'];
                    
                    break;
                }
            }
            
            $data['products'][] = array('product_id' => $result['product_id'], 'name' => $result['name'], 'model' => $result['model'], 'price' => $result['price'], 'special' => $special, 'image' => $image, 'quantity' => $result['quantity'], 'status' => ($result['status'] ? $this->language->get('lang_text_enabled') : $this->language->get('lang_text_disabled')), 'selected' => isset($this->request->post['selected']) && in_array($result['product_id'], $this->request->post['selected']), 'action' => $action);
        }
        
        $data['token'] = $this->session->data['token'];
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];
            
            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }
        
        $url = '';
        
        if (isset($this->request->get['filter_name'])) {
            $url.= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
        }
        
        if (isset($this->request->get['filter_model'])) {
            $url.= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
        }
        
        if (isset($this->request->get['filter_price'])) {
            $url.= '&filter_price=' . $this->request->get['filter_price'];
        }
        
        if (isset($this->request->get['filter_quantity'])) {
            $url.= '&filter_quantity=' . $this->request->get['filter_quantity'];
        }
        
        if (isset($this->request->get['filter_status'])) {
            $url.= '&filter_status=' . $this->request->get['filter_status'];
        }
        
        if ($order == 'ASC') {
            $url.= '&order=DESC';
        } else {
            $url.= '&order=ASC';
        }
        
        if (isset($this->request->get['page'])) {
            $url.= '&page=' . $this->request->get['page'];
        }
        
        $data['sort_name'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=pd.name' . $url, 'SSL');
        $data['sort_model'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=p.model' . $url, 'SSL');
        $data['sort_price'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=p.price' . $url, 'SSL');
        $data['sort_quantity'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=p.quantity' . $url, 'SSL');
        $data['sort_status'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=p.status' . $url, 'SSL');
        $data['sort_order'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=p.sort_order' . $url, 'SSL');
        
        $url = '';
        
        if (isset($this->request->get['filter_name'])) {
            $url.= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
        }
        
        if (isset($this->request->get['filter_model'])) {
            $url.= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
        }
        
        if (isset($this->request->get['filter_price'])) {
            $url.= '&filter_price=' . $this->request->get['filter_price'];
        }
        
        if (isset($this->request->get['filter_quantity'])) {
            $url.= '&filter_quantity=' . $this->request->get['filter_quantity'];
        }
        
        if (isset($this->request->get['filter_status'])) {
            $url.= '&filter_status=' . $this->request->get['filter_status'];
        }
        
        if (isset($this->request->get['sort'])) {
            $url.= '&sort=' . $this->request->get['sort'];
        }
        
        if (isset($this->request->get['order'])) {
            $url.= '&order=' . $this->request->get['order'];
        }
        
        $data['pagination'] = $this->theme->paginate($product_total, $page, $this->config->get('config_admin_limit'), $this->language->get('lang_text_pagination'), $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL'));
        
        $data['filter_name'] = $filter_name;
        $data['filter_model'] = $filter_model;
        $data['filter_price'] = $filter_price;
        $data['filter_quantity'] = $filter_quantity;
        $data['filter_status'] = $filter_status;
        
        $data['sort'] = $sort;
        $data['order'] = $order;
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('catalog/product_list', $data));
    }
    
    protected function getForm() {
        $data = $this->theme->language('catalog/product');
        
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
        
        if (isset($this->request->get['filter_name'])) {
            $url.= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
        }
        
        if (isset($this->request->get['filter_model'])) {
            $url.= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
        }
        
        if (isset($this->request->get['filter_price'])) {
            $url.= '&filter_price=' . $this->request->get['filter_price'];
        }
        
        if (isset($this->request->get['filter_quantity'])) {
            $url.= '&filter_quantity=' . $this->request->get['filter_quantity'];
        }
        
        if (isset($this->request->get['filter_status'])) {
            $url.= '&filter_status=' . $this->request->get['filter_status'];
        }
        
        if (isset($this->request->get['sort'])) {
            $url.= '&sort=' . $this->request->get['sort'];
        }
        
        if (isset($this->request->get['order'])) {
            $url.= '&order=' . $this->request->get['order'];
        }
        
        if (isset($this->request->get['page'])) {
            $url.= '&page=' . $this->request->get['page'];
        }
        
        $this->breadcrumb->add('lang_heading_title', 'catalog/product', $url);
        
        if (!isset($this->request->get['product_id'])) {
            $data['action'] = $this->url->link('catalog/product/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        } else {
            $data['action'] = $this->url->link('catalog/product/update', 'token=' . $this->session->data['token'] . '&product_id=' . $this->request->get['product_id'] . $url, 'SSL');
        }
        
        $data['cancel'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        if (isset($this->request->get['product_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $product_info = $this->model_catalog_product->getProduct($this->request->get['product_id']);
        }
        
        $data['token'] = $this->session->data['token'];
        
        $this->theme->model('localization/language');
        
        $data['languages'] = $this->model_localization_language->getLanguages();
        
        if (isset($this->request->post['product_description'])) {
            $data['product_description'] = $this->request->post['product_description'];
        } elseif (isset($this->request->get['product_id'])) {
            $data['product_description'] = $this->model_catalog_product->getProductDescriptions($this->request->get['product_id']);
        } else {
            $data['product_description'] = array();
        }
        
        if (isset($this->request->post['model'])) {
            $data['model'] = $this->request->post['model'];
        } elseif (!empty($product_info)) {
            $data['model'] = $product_info['model'];
        } else {
            $data['model'] = '';
        }
        
        if (isset($this->request->post['sku'])) {
            $data['sku'] = $this->request->post['sku'];
        } elseif (!empty($product_info)) {
            $data['sku'] = $product_info['sku'];
        } else {
            $data['sku'] = '';
        }
        
        if (isset($this->request->post['upc'])) {
            $data['upc'] = $this->request->post['upc'];
        } elseif (!empty($product_info)) {
            $data['upc'] = $product_info['upc'];
        } else {
            $data['upc'] = '';
        }
        
        if (isset($this->request->post['ean'])) {
            $data['ean'] = $this->request->post['ean'];
        } elseif (!empty($product_info)) {
            $data['ean'] = $product_info['ean'];
        } else {
            $data['ean'] = '';
        }
        
        if (isset($this->request->post['jan'])) {
            $data['jan'] = $this->request->post['jan'];
        } elseif (!empty($product_info)) {
            $data['jan'] = $product_info['jan'];
        } else {
            $data['jan'] = '';
        }
        
        if (isset($this->request->post['isbn'])) {
            $data['isbn'] = $this->request->post['isbn'];
        } elseif (!empty($product_info)) {
            $data['isbn'] = $product_info['isbn'];
        } else {
            $data['isbn'] = '';
        }
        
        if (isset($this->request->post['mpn'])) {
            $data['mpn'] = $this->request->post['mpn'];
        } elseif (!empty($product_info)) {
            $data['mpn'] = $product_info['mpn'];
        } else {
            $data['mpn'] = '';
        }
        
        if (isset($this->request->post['location'])) {
            $data['location'] = $this->request->post['location'];
        } elseif (!empty($product_info)) {
            $data['location'] = $product_info['location'];
        } else {
            $data['location'] = '';
        }
        
        $this->theme->model('setting/store');
        
        $data['stores'] = $this->model_setting_store->getStores();
        
        if (isset($this->request->post['product_store'])) {
            $data['product_store'] = $this->request->post['product_store'];
        } elseif (isset($this->request->get['product_id'])) {
            $data['product_store'] = $this->model_catalog_product->getProductStores($this->request->get['product_id']);
        } else {
            $data['product_store'] = array(0);
        }
        
        if (isset($this->request->post['slug'])) {
            $data['slug'] = $this->request->post['slug'];
        } elseif (!empty($product_info)) {
            $data['slug'] = $product_info['slug'];
        } else {
            $data['slug'] = '';
        }
        
        if (isset($this->request->post['image'])) {
            $data['image'] = $this->request->post['image'];
        } elseif (!empty($product_info)) {
            $data['image'] = $product_info['image'];
        } else {
            $data['image'] = '';
        }
        
        $this->theme->model('tool/image');
        
        if (isset($this->request->post['image']) && file_exists($this->app['path.image'] . $this->request->post['image'])) {
            $data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
        } elseif (!empty($product_info) && $product_info['image'] && file_exists($this->app['path.image'] . $product_info['image'])) {
            $data['thumb'] = $this->model_tool_image->resize($product_info['image'], 100, 100);
        } else {
            $data['thumb'] = $this->model_tool_image->resize('placeholder.png', 100, 100);
        }
        
        if (isset($this->request->post['shipping'])) {
            $data['shipping'] = $this->request->post['shipping'];
        } elseif (!empty($product_info)) {
            $data['shipping'] = $product_info['shipping'];
        } else {
            $data['shipping'] = 1;
        }
        
        if (isset($this->request->post['price'])) {
            $data['price'] = $this->request->post['price'];
        } elseif (!empty($product_info)) {
            $data['price'] = $product_info['price'];
        } else {
            $data['price'] = '';
        }
        
        $this->theme->model('catalog/recurring');
        
        $data['recurrings'] = $this->model_catalog_recurring->getRecurrings();
        
        if (isset($this->request->post['product_recurrings'])) {
            $data['product_recurrings'] = $this->request->post['product_recurrings'];
        } elseif (!empty($product_info)) {
            $data['product_recurrings'] = $this->model_catalog_product->getRecurrings($product_info['product_id']);
        } else {
            $data['product_recurrings'] = array();
        }
        
        $this->theme->model('localization/taxclass');
        
        $data['tax_classes'] = $this->model_localization_taxclass->getTaxClasses();
        
        if (isset($this->request->post['tax_class_id'])) {
            $data['tax_class_id'] = $this->request->post['tax_class_id'];
        } elseif (!empty($product_info)) {
            $data['tax_class_id'] = $product_info['tax_class_id'];
        } else {
            $data['tax_class_id'] = 0;
        }
        
        if (isset($this->request->post['date_available'])) {
            $data['date_available'] = $this->request->post['date_available'];
        } elseif (!empty($product_info)) {
            $data['date_available'] = date('Y-m-d', strtotime($product_info['date_available']));
        } else {
            $data['date_available'] = date('Y-m-d', time() - 86400);
        }
        
        if (isset($this->request->post['quantity'])) {
            $data['quantity'] = $this->request->post['quantity'];
        } elseif (!empty($product_info)) {
            $data['quantity'] = $product_info['quantity'];
        } else {
            $data['quantity'] = 1;
        }
        
        if (isset($this->request->post['minimum'])) {
            $data['minimum'] = $this->request->post['minimum'];
        } elseif (!empty($product_info)) {
            $data['minimum'] = $product_info['minimum'];
        } else {
            $data['minimum'] = 1;
        }
        
        if (isset($this->request->post['subtract'])) {
            $data['subtract'] = $this->request->post['subtract'];
        } elseif (!empty($product_info)) {
            $data['subtract'] = $product_info['subtract'];
        } else {
            $data['subtract'] = 1;
        }
        
        if (isset($this->request->post['sort_order'])) {
            $data['sort_order'] = $this->request->post['sort_order'];
        } elseif (!empty($product_info)) {
            $data['sort_order'] = $product_info['sort_order'];
        } else {
            $data['sort_order'] = 1;
        }
        
        $this->theme->model('localization/stockstatus');
        
        $data['stock_statuses'] = $this->model_localization_stockstatus->getStockStatuses();
        
        if (isset($this->request->post['stock_status_id'])) {
            $data['stock_status_id'] = $this->request->post['stock_status_id'];
        } elseif (!empty($product_info)) {
            $data['stock_status_id'] = $product_info['stock_status_id'];
        } else {
            $data['stock_status_id'] = $this->config->get('config_stock_status_id');
        }
        
        if (isset($this->request->post['status'])) {
            $data['status'] = $this->request->post['status'];
        } elseif (!empty($product_info)) {
            $data['status'] = $product_info['status'];
        } else {
            $data['status'] = 1;
        }
        
        if (isset($this->request->post['visibility'])) {
            $data['visibility'] = $this->request->post['visibility'];
        } elseif (!empty($product_info)) {
            $data['visibility'] = $product_info['visibility'];
        } else {
            $data['visibility'] = $this->config->get('config_default_visibility');
        }
        
        if (isset($this->request->post['weight'])) {
            $data['weight'] = $this->request->post['weight'];
        } elseif (!empty($product_info)) {
            $data['weight'] = $product_info['weight'];
        } else {
            $data['weight'] = '';
        }
        
        $this->theme->model('localization/weightclass');
        
        $data['weight_classes'] = $this->model_localization_weightclass->getWeightClasses();
        
        if (isset($this->request->post['weight_class_id'])) {
            $data['weight_class_id'] = $this->request->post['weight_class_id'];
        } elseif (!empty($product_info)) {
            $data['weight_class_id'] = $product_info['weight_class_id'];
        } else {
            $data['weight_class_id'] = $this->config->get('config_weight_class_id');
        }
        
        if (isset($this->request->post['length'])) {
            $data['length'] = $this->request->post['length'];
        } elseif (!empty($product_info)) {
            $data['length'] = $product_info['length'];
        } else {
            $data['length'] = '';
        }
        
        if (isset($this->request->post['width'])) {
            $data['width'] = $this->request->post['width'];
        } elseif (!empty($product_info)) {
            $data['width'] = $product_info['width'];
        } else {
            $data['width'] = '';
        }
        
        if (isset($this->request->post['height'])) {
            $data['height'] = $this->request->post['height'];
        } elseif (!empty($product_info)) {
            $data['height'] = $product_info['height'];
        } else {
            $data['height'] = '';
        }
        
        $this->theme->model('localization/lengthclass');
        
        $data['length_classes'] = $this->model_localization_lengthclass->getLengthClasses();
        
        if (isset($this->request->post['length_class_id'])) {
            $data['length_class_id'] = $this->request->post['length_class_id'];
        } elseif (!empty($product_info)) {
            $data['length_class_id'] = $product_info['length_class_id'];
        } else {
            $data['length_class_id'] = $this->config->get('config_length_class_id');
        }
        
        $this->theme->model('catalog/manufacturer');
        
        if (isset($this->request->post['manufacturer_id'])) {
            $data['manufacturer_id'] = $this->request->post['manufacturer_id'];
        } elseif (!empty($product_info)) {
            $data['manufacturer_id'] = $product_info['manufacturer_id'];
        } else {
            $data['manufacturer_id'] = 0;
        }
        
        if (isset($this->request->post['manufacturer'])) {
            $data['manufacturer'] = $this->request->post['manufacturer'];
        } elseif (!empty($product_info)) {
            $manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($product_info['manufacturer_id']);
            
            if ($manufacturer_info) {
                $data['manufacturer'] = $manufacturer_info['name'];
            } else {
                $data['manufacturer'] = '';
            }
        } else {
            $data['manufacturer'] = '';
        }
        
        // Categories
        $this->theme->model('catalog/category');
        
        if (isset($this->request->post['product_category'])) {
            $categories = $this->request->post['product_category'];
        } elseif (isset($this->request->get['product_id'])) {
            $categories = $this->model_catalog_product->getProductCategories($this->request->get['product_id']);
        } else {
            $categories = array();
        }
        
        $data['product_categories'] = array();
        
        foreach ($categories as $category_id) {
            $category_info = $this->model_catalog_category->getCategory($category_id);
            
            if ($category_info) {
                $data['product_categories'][] = array('category_id' => $category_info['category_id'], 'name' => ($category_info['path'] ? $category_info['path'] . ' &gt; ' : '') . $category_info['name']);
            }
        }
        
        // Filters
        $this->theme->model('catalog/filter');
        
        if (isset($this->request->post['product_filter'])) {
            $filters = $this->request->post['product_filter'];
        } elseif (isset($this->request->get['product_id'])) {
            $filters = $this->model_catalog_product->getProductFilters($this->request->get['product_id']);
        } else {
            $filters = array();
        }
        
        $data['product_filters'] = array();
        
        foreach ($filters as $filter_id) {
            $filter_info = $this->model_catalog_filter->getFilter($filter_id);
            
            if ($filter_info) {
                $data['product_filters'][] = array('filter_id' => $filter_info['filter_id'], 'name' => $filter_info['group'] . ' &gt; ' . $filter_info['name']);
            }
        }
        
        // Attributes
        $this->theme->model('catalog/attribute');
        
        if (isset($this->request->post['product_attribute'])) {
            $product_attributes = $this->request->post['product_attribute'];
        } elseif (isset($this->request->get['product_id'])) {
            $product_attributes = $this->model_catalog_product->getProductAttributes($this->request->get['product_id']);
        } else {
            $product_attributes = array();
        }
        
        $data['product_attributes'] = array();
        
        foreach ($product_attributes as $product_attribute) {
            $attribute_info = $this->model_catalog_attribute->getAttribute($product_attribute['attribute_id']);
            
            if ($attribute_info) {
                $data['product_attributes'][] = array('attribute_id' => $product_attribute['attribute_id'], 'name' => $attribute_info['name'], 'product_attribute_description' => $product_attribute['product_attribute_description']);
            }
        }
        
        // Options
        $this->theme->model('catalog/option');
        
        if (isset($this->request->post['product_option'])) {
            $product_options = $this->request->post['product_option'];
        } elseif (isset($this->request->get['product_id'])) {
            $product_options = $this->model_catalog_product->getProductOptions($this->request->get['product_id']);
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
                    $data['option_values'][$product_option['option_id']] = $this->model_catalog_option->getOptionValues($product_option['option_id']);
                }
            }
        }
        
        $this->theme->model('people/customergroup');
        
        $data['customer_groups'] = $this->model_people_customergroup->getCustomerGroups();
        
        if (isset($this->request->post['product_discount'])) {
            $data['product_discounts'] = $this->request->post['product_discount'];
        } elseif (isset($this->request->get['product_id'])) {
            $data['product_discounts'] = $this->model_catalog_product->getProductDiscounts($this->request->get['product_id']);
        } else {
            $data['product_discounts'] = array();
        }
        
        if (isset($this->request->post['product_special'])) {
            $data['product_specials'] = $this->request->post['product_special'];
        } elseif (isset($this->request->get['product_id'])) {
            $data['product_specials'] = $this->model_catalog_product->getProductSpecials($this->request->get['product_id']);
        } else {
            $data['product_specials'] = array();
        }
        
        // Images
        if (isset($this->request->post['product_image'])) {
            $product_images = $this->request->post['product_image'];
        } elseif (isset($this->request->get['product_id'])) {
            $product_images = $this->model_catalog_product->getProductImages($this->request->get['product_id']);
        } else {
            $product_images = array();
        }
        
        $data['product_images'] = array();
        
        foreach ($product_images as $product_image) {
            if ($product_image['image'] && file_exists($this->app['path.image'] . $product_image['image'])) {
                $image = $product_image['image'];
            } else {
                $image = 'placeholder.png';
            }
            
            $data['product_images'][] = array('image' => $image, 'thumb' => $this->model_tool_image->resize($image, 100, 100), 'sort_order' => $product_image['sort_order']);
        }
        
        $data['no_image'] = $this->model_tool_image->resize('placeholder.png', 100, 100);
        
        // Downloads
        $this->theme->model('catalog/download');
        
        if (isset($this->request->post['product_download'])) {
            $product_downloads = $this->request->post['product_download'];
        } elseif (isset($this->request->get['product_id'])) {
            $product_downloads = $this->model_catalog_product->getProductDownloads($this->request->get['product_id']);
        } else {
            $product_downloads = array();
        }
        
        $data['product_downloads'] = array();
        
        foreach ($product_downloads as $download_id) {
            $download_info = $this->model_catalog_download->getDownload($download_id);
            
            if ($download_info) {
                $data['product_downloads'][] = array('download_id' => $download_info['download_id'], 'name' => $download_info['name']);
            }
        }
        
        if (isset($this->request->post['product_related'])) {
            $products = $this->request->post['product_related'];
        } elseif (isset($this->request->get['product_id'])) {
            $products = $this->model_catalog_product->getProductRelated($this->request->get['product_id']);
        } else {
            $products = array();
        }
        
        $data['product_related'] = array();
        
        foreach ($products as $product_id) {
            $related_info = $this->model_catalog_product->getProduct($product_id);
            
            if ($related_info) {
                $data['product_related'][] = array('product_id' => $related_info['product_id'], 'name' => $related_info['name']);
            }
        }
        
        // adding support for a single customer product
        $this->theme->model('people/customer');
        
        if (isset($this->request->post['customer_id'])):
            $data['customer_id'] = $this->request->post['customer_id'];
        elseif (!empty($product_info)):
            $data['customer_id'] = $product_info['customer_id'];
        else:
            $data['customer_id'] = 0;
        endif;
        
        if ($data['customer_id']):
            $data['customer'] = $this->model_people_customer->getUsernameByCustomerId($data['customer_id']);
        else:
            $data['customer'] = '';
        endif;
        
        if (isset($this->request->post['points'])) {
            $data['points'] = $this->request->post['points'];
        } elseif (!empty($product_info)) {
            $data['points'] = $product_info['points'];
        } else {
            $data['points'] = '';
        }
        
        if (isset($this->request->post['product_reward'])) {
            $data['product_reward'] = $this->request->post['product_reward'];
        } elseif (isset($this->request->get['product_id'])) {
            $data['product_reward'] = $this->model_catalog_product->getProductRewards($this->request->get['product_id']);
        } else {
            $data['product_reward'] = array();
        }
        
        if (isset($this->request->post['product_layout'])) {
            $data['product_layout'] = $this->request->post['product_layout'];
        } elseif (isset($this->request->get['product_id'])) {
            $data['product_layout'] = $this->model_catalog_product->getProductLayouts($this->request->get['product_id']);
        } else {
            $data['product_layout'] = array();
        }
        
        $this->theme->model('design/layout');
        
        $data['layouts'] = $this->model_design_layout->getLayouts();
        
        $this->theme->loadjs('javascript/catalog/product_form', $data);
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('catalog/product_form', $data));
    }
    
    protected function validateForm() {
        if (!$this->user->hasPermission('modify', 'catalog/product')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        foreach ($this->request->post['product_description'] as $language_id => $value) {
            if (($this->encode->strlen($value['name']) < 1) || ($this->encode->strlen($value['name']) > 255)) {
                $this->error['name'][$language_id] = $this->language->get('lang_error_name');
            }
        }
        
        if (isset($this->request->post['slug']) && $this->encode->strlen($this->request->post['slug']) > 0):
            $this->theme->model('tool/utility');
            $query = $this->model_tool_utility->findSlugByName($this->request->post['slug']);
            
            if (isset($this->request->get['product_id'])):
                if (isset($query)):
                    if ($query != 'product_id:' . $this->request->get['product_id']):
                        $this->error['slug'] = sprintf($this->language->get('lang_error_slug_found'), $this->request->post['slug']);
                    endif;
                endif;
            else:
                if (isset($query)):
                    $this->error['slug'] = sprintf($this->language->get('lang_error_slug_found'), $this->request->post['slug']);
                endif;
            endif;
        else:
            $this->error['slug'] = $this->language->get('lang_error_slug');
        endif;
        
        if (($this->encode->strlen($this->request->post['model']) < 1) || ($this->encode->strlen($this->request->post['model']) > 64)) {
            $this->error['model'] = $this->language->get('lang_error_model');
        }
        
        if ($this->error && !isset($this->error['warning'])) {
            $this->error['warning'] = $this->language->get('lang_error_warning');
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    protected function validateDelete() {
        if (!$this->user->hasPermission('modify', 'catalog/product')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    protected function validateCopy() {
        if (!$this->user->hasPermission('modify', 'catalog/product')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    public function autouser() {
        $json = array();
        
        if (isset($this->request->get['name'])) {
            $this->theme->model('people/customer');
            
            $filter = array('filter_username' => $this->request->get['name'], 'start' => 0, 'limit' => 20);
            
            $results = $this->model_people_customer->getCustomers($filter);
            
            foreach ($results as $result) {
                $json[] = array('customer_id' => $result['customer_id'], 'name' => strip_tags(html_entity_decode($result['username'], ENT_QUOTES, 'UTF-8')));
            }
        }
        
        $sort_order = array();
        
        foreach ($json as $key => $value) {
            $sort_order[$key] = $value['name'];
        }
        
        array_multisort($sort_order, SORT_ASC, $json);
        
        $this->response->setOutput(json_encode($json));
    }
    
    public function autocomplete() {
        $json = array();
        
        if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_model']) || isset($this->request->get['filter_category_id'])) {
            $this->theme->model('catalog/product');
            $this->theme->model('catalog/option');
            
            if (isset($this->request->get['filter_name'])) {
                $filter_name = $this->request->get['filter_name'];
            } else {
                $filter_name = '';
            }
            
            if (isset($this->request->get['filter_model'])) {
                $filter_model = $this->request->get['filter_model'];
            } else {
                $filter_model = '';
            }
            
            if (isset($this->request->get['limit'])) {
                $limit = $this->request->get['limit'];
            } else {
                $limit = 20;
            }
            
            $filter = array('filter_name' => $filter_name, 'filter_model' => $filter_model, 'start' => 0, 'limit' => $limit);
            
            $results = $this->model_catalog_product->getProducts($filter);
            
            foreach ($results as $result) {
                $option_data = array();
                
                $product_options = $this->model_catalog_product->getProductOptions($result['product_id']);
                
                foreach ($product_options as $product_option) {
                    $option_info = $this->model_catalog_option->getOption($product_option['option_id']);
                    
                    if ($option_info) {
                        if ($option_info['type'] == 'select' || $option_info['type'] == 'radio' || $option_info['type'] == 'checkbox' || $option_info['type'] == 'image') {
                            $option_value_data = array();
                            
                            foreach ($product_option['product_option_value'] as $product_option_value) {
                                $option_value_info = $this->model_catalog_option->getOptionValue($product_option_value['option_value_id']);
                                
                                if ($option_value_info) {
                                    $option_value_data[] = array('product_option_value_id' => $product_option_value['product_option_value_id'], 'option_value_id' => $product_option_value['option_value_id'], 'name' => $option_value_info['name'], 'price' => (float)$product_option_value['price'] ? $this->currency->format($product_option_value['price'], $this->config->get('config_currency')) : false, 'price_prefix' => $product_option_value['price_prefix']);
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
        
        $json = $this->theme->listen(__CLASS__, __FUNCTION__, $json);
        
        $this->response->setOutput(json_encode($json));
    }
    
    public function slug() {
        $this->language->load('catalog/product');
        $this->theme->model('tool/utility');
        
        $json = array();
        
        if (!isset($this->request->get['name']) || $this->encode->strlen($this->request->get['name']) < 1):
            $json['error'] = $this->language->get('lang_error_name_first');
        else:
            
            // build slug
            $slug = $this->url->build_slug($this->request->get['name']);
            
            // check that the slug is globally unique
            $query = $this->model_tool_utility->findSlugByName($slug);
            
            if ($query):
                if (isset($this->request->get['product_id'])):
                    if ($query != 'product_id:' . $this->request->get['product_id']):
                        $json['error'] = sprintf($this->language->get('lang_error_slug_found'), $slug);
                    else:
                        $json['slug'] = $slug;
                    endif;
                else:
                    $json['error'] = sprintf($this->language->get('lang_error_slug_found'), $slug);
                endif;
            else:
                $json['slug'] = $slug;
            endif;
        endif;
        
        $json = $this->theme->listen(__CLASS__, __FUNCTION__, $json);
        
        $this->response->setOutput(json_encode($json));
    }
}
