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

namespace App\Controllers\Admin\Design;

use App\Controllers\Controller;

class Banner extends Controller {
    
    private $error = array();
    
    public function index() {
        Lang::load('design/banner');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Theme::model('design/banner');
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    public function insert() {
        Lang::load('design/banner');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Theme::model('design/banner');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_design_banner->addBanner($this->request->post);
            
            $this->session->data['success'] = Lang::get('lang_text_success');
            
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
            
            Response::redirect(Url::link('design/banner', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function update() {
        Lang::load('design/banner');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Theme::model('design/banner');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_design_banner->editBanner($this->request->get['banner_id'], $this->request->post);
            
            $this->session->data['success'] = Lang::get('lang_text_success');
            
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
            
            Response::redirect(Url::link('design/banner', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function delete() {
        Lang::load('design/banner');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Theme::model('design/banner');
        
        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $banner_id) {
                $this->model_design_banner->deleteBanner($banner_id);
            }
            
            $this->session->data['success'] = Lang::get('lang_text_success');
            
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
            
            Response::redirect(Url::link('design/banner', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    protected function getList() {
        $data = Theme::language('design/banner');
        
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
        
        Breadcrumb::add('lang_heading_title', 'design/banner', $url);
        
        $data['insert'] = Url::link('design/banner/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['delete'] = Url::link('design/banner/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        $data['banners'] = array();
        
        $filter = array('sort' => $sort, 'order' => $order, 'start' => ($page - 1) * Config::get('config_admin_limit'), 'limit' => Config::get('config_admin_limit'));
        
        $banner_total = $this->model_design_banner->getTotalBanners();
        
        $results = $this->model_design_banner->getBanners($filter);
        
        foreach ($results as $result) {
            $action = array();
            
            $action[] = array('text' => Lang::get('lang_text_edit'), 'href' => Url::link('design/banner/update', 'token=' . $this->session->data['token'] . '&banner_id=' . $result['banner_id'] . $url, 'SSL'));
            
            $data['banners'][] = array('banner_id' => $result['banner_id'], 'name' => $result['name'], 'status' => ($result['status'] ? Lang::get('lang_text_enabled') : Lang::get('lang_text_disabled')), 'selected' => isset($this->request->post['selected']) && in_array($result['banner_id'], $this->request->post['selected']), 'action' => $action);
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
        
        $data['sort_name'] = Url::link('design/banner', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
        $data['sort_status'] = Url::link('design/banner', 'token=' . $this->session->data['token'] . '&sort=status' . $url, 'SSL');
        
        $url = '';
        
        if (isset($this->request->get['sort'])) {
            $url.= '&sort=' . $this->request->get['sort'];
        }
        
        if (isset($this->request->get['order'])) {
            $url.= '&order=' . $this->request->get['order'];
        }
        
        $data['pagination'] = Theme::paginate($banner_total, $page, Config::get('config_admin_limit'), Lang::get('lang_text_pagination'), Url::link('design/banner', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL'));
        
        $data['sort'] = $sort;
        $data['order'] = $order;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(Theme::view('design/banner_list', $data));
    }
    
    protected function getForm() {
        $data = Theme::language('design/banner');
        
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
        
        Breadcrumb::add('lang_heading_title', 'design/banner', $url);
        
        if (!isset($this->request->get['banner_id'])) {
            $data['action'] = Url::link('design/banner/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        } else {
            $data['action'] = Url::link('design/banner/update', 'token=' . $this->session->data['token'] . '&banner_id=' . $this->request->get['banner_id'] . $url, 'SSL');
        }
        
        $data['cancel'] = Url::link('design/banner', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
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
        
        Theme::model('locale/language');
        
        $data['languages'] = $this->model_locale_language->getLanguages();
        
        Theme::model('tool/image');
        
        if (isset($this->request->post['banner_image'])) {
            $banner_images = $this->request->post['banner_image'];
        } elseif (isset($this->request->get['banner_id'])) {
            $banner_images = $this->model_design_banner->getBannerImages($this->request->get['banner_id']);
        } else {
            $banner_images = array();
        }
        
        $data['banner_images'] = array();
        
        foreach ($banner_images as $banner_image) {
            if ($banner_image['image'] && file_exists(Config::get('path.image') . $banner_image['image'])) {
                $image = $banner_image['image'];
            } else {
                $image = 'placeholder.png';
            }
            
            $data['banner_images'][] = array('banner_image_description' => $banner_image['banner_image_description'], 'link' => $banner_image['link'], 'image' => $image, 'thumb' => $this->model_tool_image->resize($image, 100, 100));
        }
        
        $data['no_image'] = $this->model_tool_image->resize('placeholder.png', 100, 100);
        
        Theme::loadjs('javascript/design/banner_form', $data);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(Theme::view('design/banner_form', $data));
    }
    
    protected function validateForm() {
        if (!User::hasPermission('modify', 'design/banner')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        if ((Encode::strlen($this->request->post['name']) < 3) || (Encode::strlen($this->request->post['name']) > 64)) {
            $this->error['name'] = Lang::get('lang_error_name');
        }
        
        if (isset($this->request->post['banner_image'])) {
            foreach ($this->request->post['banner_image'] as $banner_image_id => $banner_image) {
                foreach ($banner_image['banner_image_description'] as $language_id => $banner_image_description) {
                    if ((Encode::strlen($banner_image_description['title']) < 2) || (Encode::strlen($banner_image_description['title']) > 64)) {
                        $this->error['banner_image'][$banner_image_id][$language_id] = Lang::get('lang_error_title');
                    }
                }
            }
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    protected function validateDelete() {
        if (!User::hasPermission('modify', 'design/banner')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
