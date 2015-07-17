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
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            DesignBanner::addBanner(Request::post());
            
            Session::p()->data['success'] = Lang::get('lang_text_success');
            
            $url = '';
            
            if (isset(Request::p()->get['sort'])) {
                $url.= '&sort=' . Request::p()->get['sort'];
            }
            
            if (isset(Request::p()->get['order'])) {
                $url.= '&order=' . Request::p()->get['order'];
            }
            
            if (isset(Request::p()->get['page'])) {
                $url.= '&page=' . Request::p()->get['page'];
            }
            
            Response::redirect(Url::link('design/banner', '' . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function update() {
        Lang::load('design/banner');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Theme::model('design/banner');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            DesignBanner::editBanner(Request::p()->get['banner_id'], Request::post());
            
            Session::p()->data['success'] = Lang::get('lang_text_success');
            
            $url = '';
            
            if (isset(Request::p()->get['sort'])) {
                $url.= '&sort=' . Request::p()->get['sort'];
            }
            
            if (isset(Request::p()->get['order'])) {
                $url.= '&order=' . Request::p()->get['order'];
            }
            
            if (isset(Request::p()->get['page'])) {
                $url.= '&page=' . Request::p()->get['page'];
            }
            
            Response::redirect(Url::link('design/banner', '' . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function delete() {
        Lang::load('design/banner');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Theme::model('design/banner');
        
        if (isset(Request::p()->post['selected']) && $this->validateDelete()) {
            foreach (Request::p()->post['selected'] as $banner_id) {
                DesignBanner::deleteBanner($banner_id);
            }
            
            Session::p()->data['success'] = Lang::get('lang_text_success');
            
            $url = '';
            
            if (isset(Request::p()->get['sort'])) {
                $url.= '&sort=' . Request::p()->get['sort'];
            }
            
            if (isset(Request::p()->get['order'])) {
                $url.= '&order=' . Request::p()->get['order'];
            }
            
            if (isset(Request::p()->get['page'])) {
                $url.= '&page=' . Request::p()->get['page'];
            }
            
            Response::redirect(Url::link('design/banner', '' . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    protected function getList() {
        $data = Theme::language('design/banner');
        
        if (isset(Request::p()->get['sort'])) {
            $sort = Request::p()->get['sort'];
        } else {
            $sort = 'name';
        }
        
        if (isset(Request::p()->get['order'])) {
            $order = Request::p()->get['order'];
        } else {
            $order = 'ASC';
        }
        
        if (isset(Request::p()->get['page'])) {
            $page = Request::p()->get['page'];
        } else {
            $page = 1;
        }
        
        $url = '';
        
        if (isset(Request::p()->get['sort'])) {
            $url.= '&sort=' . Request::p()->get['sort'];
        }
        
        if (isset(Request::p()->get['order'])) {
            $url.= '&order=' . Request::p()->get['order'];
        }
        
        if (isset(Request::p()->get['page'])) {
            $url.= '&page=' . Request::p()->get['page'];
        }
        
        Breadcrumb::add('lang_heading_title', 'design/banner', $url);
        
        $data['insert'] = Url::link('design/banner/insert', '' . $url, 'SSL');
        $data['delete'] = Url::link('design/banner/delete', '' . $url, 'SSL');
        
        $data['banners'] = array();
        
        $filter = array('sort' => $sort, 'order' => $order, 'start' => ($page - 1) * Config::get('config_admin_limit'), 'limit' => Config::get('config_admin_limit'));
        
        $banner_total = DesignBanner::getTotalBanners();
        
        $results = DesignBanner::getBanners($filter);
        
        foreach ($results as $result) {
            $action = array();
            
            $action[] = array('text' => Lang::get('lang_text_edit'), 'href' => Url::link('design/banner/update', '' . 'banner_id=' . $result['banner_id'] . $url, 'SSL'));
            
            $data['banners'][] = array('banner_id' => $result['banner_id'], 'name' => $result['name'], 'status' => ($result['status'] ? Lang::get('lang_text_enabled') : Lang::get('lang_text_disabled')), 'selected' => isset(Request::p()->post['selected']) && in_array($result['banner_id'], Request::p()->post['selected']), 'action' => $action);
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
        
        if ($order == 'ASC') {
            $url.= '&order=DESC';
        } else {
            $url.= '&order=ASC';
        }
        
        if (isset(Request::p()->get['page'])) {
            $url.= '&page=' . Request::p()->get['page'];
        }
        
        $data['sort_name'] = Url::link('design/banner', '' . 'sort=name' . $url, 'SSL');
        $data['sort_status'] = Url::link('design/banner', '' . 'sort=status' . $url, 'SSL');
        
        $url = '';
        
        if (isset(Request::p()->get['sort'])) {
            $url.= '&sort=' . Request::p()->get['sort'];
        }
        
        if (isset(Request::p()->get['order'])) {
            $url.= '&order=' . Request::p()->get['order'];
        }
        
        $data['pagination'] = Theme::paginate($banner_total, $page, Config::get('config_admin_limit'), Lang::get('lang_text_pagination'), Url::link('design/banner', '' . $url . '&page={page}', 'SSL'));
        
        $data['sort'] = $sort;
        $data['order'] = $order;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::render('design/banner_list', $data));
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
        
        if (isset(Request::p()->get['sort'])) {
            $url.= '&sort=' . Request::p()->get['sort'];
        }
        
        if (isset(Request::p()->get['order'])) {
            $url.= '&order=' . Request::p()->get['order'];
        }
        
        if (isset(Request::p()->get['page'])) {
            $url.= '&page=' . Request::p()->get['page'];
        }
        
        Breadcrumb::add('lang_heading_title', 'design/banner', $url);
        
        if (!isset(Request::p()->get['banner_id'])) {
            $data['action'] = Url::link('design/banner/insert', '' . $url, 'SSL');
        } else {
            $data['action'] = Url::link('design/banner/update', '' . 'banner_id=' . Request::p()->get['banner_id'] . $url, 'SSL');
        }
        
        $data['cancel'] = Url::link('design/banner', '' . $url, 'SSL');
        
        if (isset(Request::p()->get['banner_id']) && (Request::p()->server['REQUEST_METHOD'] != 'POST')) {
            $banner_info = DesignBanner::getBanner(Request::p()->get['banner_id']);
        }
        
        if (isset(Request::p()->post['name'])) {
            $data['name'] = Request::p()->post['name'];
        } elseif (!empty($banner_info)) {
            $data['name'] = $banner_info['name'];
        } else {
            $data['name'] = '';
        }
        
        if (isset(Request::p()->post['status'])) {
            $data['status'] = Request::p()->post['status'];
        } elseif (!empty($banner_info)) {
            $data['status'] = $banner_info['status'];
        } else {
            $data['status'] = true;
        }
        
        Theme::model('locale/language');
        
        $data['languages'] = LocaleLanguage::getLanguages();
        
        Theme::model('tool/image');
        
        if (isset(Request::p()->post['banner_image'])) {
            $banner_images = Request::p()->post['banner_image'];
        } elseif (isset(Request::p()->get['banner_id'])) {
            $banner_images = DesignBanner::getBannerImages(Request::p()->get['banner_id']);
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
            
            $data['banner_images'][] = array('banner_image_description' => $banner_image['banner_image_description'], 'link' => $banner_image['link'], 'image' => $image, 'thumb' => ToolImage::resize($image, 100, 100));
        }
        
        $data['no_image'] = ToolImage::resize('placeholder.png', 100, 100);
        
        Theme::loadjs('javascript/design/banner_form', $data);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::render('design/banner_form', $data));
    }
    
    protected function validateForm() {
        if (!User::hasPermission('modify', 'design/banner')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        if ((Encode::strlen(Request::p()->post['name']) < 3) || (Encode::strlen(Request::p()->post['name']) > 64)) {
            $this->error['name'] = Lang::get('lang_error_name');
        }
        
        if (isset(Request::p()->post['banner_image'])) {
            foreach (Request::p()->post['banner_image'] as $banner_image_id => $banner_image) {
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
