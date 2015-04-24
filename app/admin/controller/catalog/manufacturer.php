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

class Manufacturer extends Controller {
    private $error = array();
    
    public function index() {
        $this->language->load('catalog/manufacturer');
        
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        
        $this->theme->model('catalog/manufacturer');
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    public function insert() {
        $this->language->load('catalog/manufacturer');
        
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        
        $this->theme->model('catalog/manufacturer');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_catalog_manufacturer->addManufacturer($this->request->post);
            
            $this->session->data['success'] = $this->language->get('lang_text_success');
            
            $url = '';
            
            if (isset($this->request->get['sort'])) {
                $url.= '&sort=' . $this->request->get['sort'];
            }
            
            if (isset($this->request->get['order'])) {
                $url.= '&order=' . $this->request->get['order'];
            }
            
            if (isset($this->request->get['page'])) {
                $url.= '&page=' . $this->request->get['page'];
            }
            
            $this->response->redirect($this->url->link('catalog/manufacturer', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function update() {
        $this->language->load('catalog/manufacturer');
        
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        
        $this->theme->model('catalog/manufacturer');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_catalog_manufacturer->editManufacturer($this->request->get['manufacturer_id'], $this->request->post);
            
            $this->session->data['success'] = $this->language->get('lang_text_success');
            
            $url = '';
            
            if (isset($this->request->get['sort'])) {
                $url.= '&sort=' . $this->request->get['sort'];
            }
            
            if (isset($this->request->get['order'])) {
                $url.= '&order=' . $this->request->get['order'];
            }
            
            if (isset($this->request->get['page'])) {
                $url.= '&page=' . $this->request->get['page'];
            }
            
            $this->response->redirect($this->url->link('catalog/manufacturer', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function delete() {
        $this->language->load('catalog/manufacturer');
        
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        
        $this->theme->model('catalog/manufacturer');
        
        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $manufacturer_id) {
                $this->model_catalog_manufacturer->deleteManufacturer($manufacturer_id);
            }
            
            $this->session->data['success'] = $this->language->get('lang_text_success');
            
            $url = '';
            
            if (isset($this->request->get['sort'])) {
                $url.= '&sort=' . $this->request->get['sort'];
            }
            
            if (isset($this->request->get['order'])) {
                $url.= '&order=' . $this->request->get['order'];
            }
            
            if (isset($this->request->get['page'])) {
                $url.= '&page=' . $this->request->get['page'];
            }
            
            $this->response->redirect($this->url->link('catalog/manufacturer', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    protected function getList() {
        $data = $this->theme->language('catalog/manufacturer');
        
        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'name';
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
        
        if (isset($this->request->get['sort'])) {
            $url.= '&sort=' . $this->request->get['sort'];
        }
        
        if (isset($this->request->get['order'])) {
            $url.= '&order=' . $this->request->get['order'];
        }
        
        if (isset($this->request->get['page'])) {
            $url.= '&page=' . $this->request->get['page'];
        }
        
        $this->breadcrumb->add('lang_heading_title', 'catalog/manufacturer', $url);
        
        $data['insert'] = $this->url->link('catalog/manufacturer/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['delete'] = $this->url->link('catalog/manufacturer/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        $data['manufacturers'] = array();
        
        $filter = array('sort' => $sort, 'order' => $order, 'start' => ($page - 1) * $this->config->get('config_admin_limit'), 'limit' => $this->config->get('config_admin_limit'));
        
        $manufacturer_total = $this->model_catalog_manufacturer->getTotalManufacturers();
        
        $results = $this->model_catalog_manufacturer->getManufacturers($filter);
        
        foreach ($results as $result) {
            $action = array();
            
            $action[] = array('text' => $this->language->get('lang_text_edit'), 'href' => $this->url->link('catalog/manufacturer/update', 'token=' . $this->session->data['token'] . '&manufacturer_id=' . $result['manufacturer_id'] . $url, 'SSL'));
            
            $data['manufacturers'][] = array('manufacturer_id' => $result['manufacturer_id'], 'name' => $result['name'], 'sort_order' => $result['sort_order'], 'selected' => isset($this->request->post['selected']) && in_array($result['manufacturer_id'], $this->request->post['selected']), 'action' => $action);
        }
        
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
        
        if ($order == 'ASC') {
            $url.= '&order=DESC';
        } else {
            $url.= '&order=ASC';
        }
        
        if (isset($this->request->get['page'])) {
            $url.= '&page=' . $this->request->get['page'];
        }
        
        $data['sort_name'] = $this->url->link('catalog/manufacturer', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
        $data['sort_sort_order'] = $this->url->link('catalog/manufacturer', 'token=' . $this->session->data['token'] . '&sort=sort_order' . $url, 'SSL');
        
        $url = '';
        
        if (isset($this->request->get['sort'])) {
            $url.= '&sort=' . $this->request->get['sort'];
        }
        
        if (isset($this->request->get['order'])) {
            $url.= '&order=' . $this->request->get['order'];
        }
        
        $data['pagination'] = $this->theme->paginate($manufacturer_total, $page, $this->config->get('config_admin_limit'), $this->language->get('lang_text_pagination'), $this->url->link('catalog/manufacturer', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL'));
        
        $data['sort'] = $sort;
        $data['order'] = $order;
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('catalog/manufacturer_list', $data));
    }
    
    protected function getForm() {
        $data = $this->theme->language('catalog/manufacturer');
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        if (isset($this->error['name'])) {
            $data['error_name'] = $this->error['name'];
        } else {
            $data['error_name'] = '';
        }
        
        if (isset($this->error['slug'])) {
            $data['error_slug'] = $this->error['slug'];
        } else {
            $data['error_slug'] = '';
        }
        
        $url = '';
        
        if (isset($this->request->get['sort'])) {
            $url.= '&sort=' . $this->request->get['sort'];
        }
        
        if (isset($this->request->get['order'])) {
            $url.= '&order=' . $this->request->get['order'];
        }
        
        if (isset($this->request->get['page'])) {
            $url.= '&page=' . $this->request->get['page'];
        }
        
        $this->breadcrumb->add('lang_heading_title', 'catalog/manufacturer', $url);
        
        if (!isset($this->request->get['manufacturer_id'])) {
            $data['action'] = $this->url->link('catalog/manufacturer/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        } else {
            $data['action'] = $this->url->link('catalog/manufacturer/update', 'token=' . $this->session->data['token'] . '&manufacturer_id=' . $this->request->get['manufacturer_id'] . $url, 'SSL');
        }
        
        $data['cancel'] = $this->url->link('catalog/manufacturer', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        if (isset($this->request->get['manufacturer_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($this->request->get['manufacturer_id']);
        }
        
        $data['token'] = $this->session->data['token'];
        
        if (isset($this->request->post['name'])) {
            $data['name'] = $this->request->post['name'];
        } elseif (!empty($manufacturer_info)) {
            $data['name'] = $manufacturer_info['name'];
        } else {
            $data['name'] = '';
        }
        
        $this->theme->model('setting/store');
        
        $data['stores'] = $this->model_setting_store->getStores();
        
        if (isset($this->request->post['manufacturer_store'])) {
            $data['manufacturer_store'] = $this->request->post['manufacturer_store'];
        } elseif (isset($this->request->get['manufacturer_id'])) {
            $data['manufacturer_store'] = $this->model_catalog_manufacturer->getManufacturerStores($this->request->get['manufacturer_id']);
        } else {
            $data['manufacturer_store'] = array(0);
        }
        
        if (isset($this->request->post['slug'])) {
            $data['slug'] = $this->request->post['slug'];
        } elseif (!empty($manufacturer_info)) {
            $data['slug'] = $manufacturer_info['slug'];
        } else {
            $data['slug'] = '';
        }
        
        if (isset($this->request->post['image'])) {
            $data['image'] = $this->request->post['image'];
        } elseif (!empty($manufacturer_info)) {
            $data['image'] = $manufacturer_info['image'];
        } else {
            $data['image'] = '';
        }
        
        $this->theme->model('tool/image');
        
        if (isset($this->request->post['image']) && file_exists($this->app['path.image'] . $this->request->post['image'])) {
            $data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
        } elseif (!empty($manufacturer_info) && $manufacturer_info['image'] && file_exists($this->app['path.image'] . $manufacturer_info['image'])) {
            $data['thumb'] = $this->model_tool_image->resize($manufacturer_info['image'], 100, 100);
        } else {
            $data['thumb'] = $this->model_tool_image->resize('placeholder.png', 100, 100);
        }
        
        $data['no_image'] = $this->model_tool_image->resize('placeholder.png', 100, 100);
        
        if (isset($this->request->post['sort_order'])) {
            $data['sort_order'] = $this->request->post['sort_order'];
        } elseif (!empty($manufacturer_info)) {
            $data['sort_order'] = $manufacturer_info['sort_order'];
        } else {
            $data['sort_order'] = '';
        }
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('catalog/manufacturer_form', $data));
    }
    
    protected function validateForm() {
        if (!$this->user->hasPermission('modify', 'catalog/manufacturer')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        if (($this->encode->strlen($this->request->post['name']) < 3) || ($this->encode->strlen($this->request->post['name']) > 64)) {
            $this->error['name'] = $this->language->get('lang_error_name');
        }
        
        if (isset($this->request->post['slug']) && $this->encode->strlen($this->request->post['slug']) > 0):
            $this->theme->model('tool/utility');
            $query = $this->model_tool_utility->findSlugByName($this->request->post['slug']);
            
            if (isset($this->request->get['manufacturer_id'])):
                if ($query):
                    if ($query != 'manufacturer_id:' . $this->request->get['manufacturer_id']):
                        $this->error['slug'] = sprintf($this->language->get('lang_error_slug_found'), $this->request->post['slug']);
                    endif;
                endif;
            else:
                if ($query):
                    $this->error['slug'] = sprintf($this->language->get('lang_error_slug_found'), $this->request->post['slug']);
                endif;
            endif;
        else:
            $this->error['slug'] = $this->language->get('lang_error_slug');
        endif;
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    protected function validateDelete() {
        if (!$this->user->hasPermission('modify', 'catalog/manufacturer')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        $this->theme->model('catalog/product');
        
        foreach ($this->request->post['selected'] as $manufacturer_id) {
            $product_total = $this->model_catalog_product->getTotalProductsByManufacturerId($manufacturer_id);
            
            if ($product_total) {
                $this->error['warning'] = sprintf($this->language->get('lang_error_product'), $product_total);
            }
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    public function autocomplete() {
        $json = array();
        
        if (isset($this->request->get['filter_name'])) {
            $this->theme->model('catalog/manufacturer');
            
            $filter = array('filter_name' => $this->request->get['filter_name'], 'start' => 0, 'limit' => 20);
            
            $results = $this->model_catalog_manufacturer->getManufacturers($filter);
            
            foreach ($results as $result) {
                $json[] = array('manufacturer_id' => $result['manufacturer_id'], 'name' => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')));
            }
        }
        
        $sort_order = array();
        
        foreach ($json as $key => $value) {
            $sort_order[$key] = $value['name'];
        }
        
        array_multisort($sort_order, SORT_ASC, $json);
        
        $json = $this->theme->listen(__CLASS__, __FUNCTION__, $json);
        
        $this->response->setOutput(json_encode($json));
    }
    
    public function slug() {
        $this->language->load('catalog/manufacturer');
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
                if (isset($this->request->get['manufacturer_id'])):
                    if ($query != 'manufacturer_id:' . $this->request->get['manufacturer_id']):
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
