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

namespace Admin\Controller\Design;
use Dais\Engine\Controller;

class Banner extends Controller {
    private $error = array();
    
    public function index() {
        $this->language->load('design/banner');
        
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        
        $this->theme->model('design/banner');
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    public function insert() {
        $this->language->load('design/banner');
        
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        
        $this->theme->model('design/banner');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_design_banner->addBanner($this->request->post);
            
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
            
            $this->response->redirect($this->url->link('design/banner', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function update() {
        $this->language->load('design/banner');
        
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        
        $this->theme->model('design/banner');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_design_banner->editBanner($this->request->get['banner_id'], $this->request->post);
            
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
            
            $this->response->redirect($this->url->link('design/banner', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function delete() {
        $this->language->load('design/banner');
        
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        
        $this->theme->model('design/banner');
        
        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $banner_id) {
                $this->model_design_banner->deleteBanner($banner_id);
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
            
            $this->response->redirect($this->url->link('design/banner', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    protected function getList() {
        $data = $this->theme->language('design/banner');
        
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
        
        $this->breadcrumb->add('lang_heading_title', 'design/banner', $url);
        
        $data['insert'] = $this->url->link('design/banner/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['delete'] = $this->url->link('design/banner/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        $data['banners'] = array();
        
        $filter = array('sort' => $sort, 'order' => $order, 'start' => ($page - 1) * $this->config->get('config_admin_limit'), 'limit' => $this->config->get('config_admin_limit'));
        
        $banner_total = $this->model_design_banner->getTotalBanners();
        
        $results = $this->model_design_banner->getBanners($filter);
        
        foreach ($results as $result) {
            $action = array();
            
            $action[] = array('text' => $this->language->get('lang_text_edit'), 'href' => $this->url->link('design/banner/update', 'token=' . $this->session->data['token'] . '&banner_id=' . $result['banner_id'] . $url, 'SSL'));
            
            $data['banners'][] = array('banner_id' => $result['banner_id'], 'name' => $result['name'], 'status' => ($result['status'] ? $this->language->get('lang_text_enabled') : $this->language->get('lang_text_disabled')), 'selected' => isset($this->request->post['selected']) && in_array($result['banner_id'], $this->request->post['selected']), 'action' => $action);
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
        
        $data['sort_name'] = $this->url->link('design/banner', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
        $data['sort_status'] = $this->url->link('design/banner', 'token=' . $this->session->data['token'] . '&sort=status' . $url, 'SSL');
        
        $url = '';
        
        if (isset($this->request->get['sort'])) {
            $url.= '&sort=' . $this->request->get['sort'];
        }
        
        if (isset($this->request->get['order'])) {
            $url.= '&order=' . $this->request->get['order'];
        }
        
        $data['pagination'] = $this->theme->paginate($banner_total, $page, $this->config->get('config_admin_limit'), $this->language->get('lang_text_pagination'), $this->url->link('design/banner', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL'));
        
        $data['sort'] = $sort;
        $data['order'] = $order;
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('design/banner_list', $data));
    }
    
    protected function getForm() {
        $data = $this->theme->language('design/banner');
        
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
        
        if (isset($this->error['banner_image'])) {
            $data['error_banner_image'] = $this->error['banner_image'];
        } else {
            $data['error_banner_image'] = array();
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
        
        $this->breadcrumb->add('lang_heading_title', 'design/banner', $url);
        
        if (!isset($this->request->get['banner_id'])) {
            $data['action'] = $this->url->link('design/banner/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        } else {
            $data['action'] = $this->url->link('design/banner/update', 'token=' . $this->session->data['token'] . '&banner_id=' . $this->request->get['banner_id'] . $url, 'SSL');
        }
        
        $data['cancel'] = $this->url->link('design/banner', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        if (isset($this->request->get['banner_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $banner_info = $this->model_design_banner->getBanner($this->request->get['banner_id']);
        }
        
        $data['token'] = $this->session->data['token'];
        
        if (isset($this->request->post['name'])) {
            $data['name'] = $this->request->post['name'];
        } elseif (!empty($banner_info)) {
            $data['name'] = $banner_info['name'];
        } else {
            $data['name'] = '';
        }
        
        if (isset($this->request->post['status'])) {
            $data['status'] = $this->request->post['status'];
        } elseif (!empty($banner_info)) {
            $data['status'] = $banner_info['status'];
        } else {
            $data['status'] = true;
        }
        
        $this->theme->model('localization/language');
        
        $data['languages'] = $this->model_localization_language->getLanguages();
        
        $this->theme->model('tool/image');
        
        if (isset($this->request->post['banner_image'])) {
            $banner_images = $this->request->post['banner_image'];
        } elseif (isset($this->request->get['banner_id'])) {
            $banner_images = $this->model_design_banner->getBannerImages($this->request->get['banner_id']);
        } else {
            $banner_images = array();
        }
        
        $data['banner_images'] = array();
        
        foreach ($banner_images as $banner_image) {
            if ($banner_image['image'] && file_exists($this->app['path.image'] . $banner_image['image'])) {
                $image = $banner_image['image'];
            } else {
                $image = 'placeholder.png';
            }
            
            $data['banner_images'][] = array('banner_image_description' => $banner_image['banner_image_description'], 'link' => $banner_image['link'], 'image' => $image, 'thumb' => $this->model_tool_image->resize($image, 100, 100));
        }
        
        $data['no_image'] = $this->model_tool_image->resize('placeholder.png', 100, 100);
        
        $this->theme->loadjs('javascript/design/banner_form', $data);
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('design/banner_form', $data));
    }
    
    protected function validateForm() {
        if (!$this->user->hasPermission('modify', 'design/banner')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        if (($this->encode->strlen($this->request->post['name']) < 3) || ($this->encode->strlen($this->request->post['name']) > 64)) {
            $this->error['name'] = $this->language->get('lang_error_name');
        }
        
        if (isset($this->request->post['banner_image'])) {
            foreach ($this->request->post['banner_image'] as $banner_image_id => $banner_image) {
                foreach ($banner_image['banner_image_description'] as $language_id => $banner_image_description) {
                    if (($this->encode->strlen($banner_image_description['title']) < 2) || ($this->encode->strlen($banner_image_description['title']) > 64)) {
                        $this->error['banner_image'][$banner_image_id][$language_id] = $this->language->get('lang_error_title');
                    }
                }
            }
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    protected function validateDelete() {
        if (!$this->user->hasPermission('modify', 'design/banner')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
