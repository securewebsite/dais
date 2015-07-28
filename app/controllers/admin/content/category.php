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

namespace App\Controllers\Admin\Content;

use App\Controllers\Controller;

class Category extends Controller {
    
    private $error = array();
    
    public function index() {
        Theme::language('content/category');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('content/category');
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    public function insert() {
        Theme::language('content/category');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('content/category');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            ContentCategory::addCategory(Request::post());
            Session::p()->data['success'] = Lang::get('lang_text_success');
            
            Response::redirect(Url::link('content/category', '', 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function update() {
        Theme::language('content/category');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('content/category');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            ContentCategory::editCategory(Request::p()->get['category_id'], Request::post());
            Session::p()->data['success'] = Lang::get('lang_text_success');
            
            Response::redirect(Url::link('content/category', '', 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function delete() {
        Theme::language('content/category');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('content/category');
        
        if (isset(Request::p()->post['selected']) && $this->validateDelete()) {
            foreach (Request::p()->post['selected'] as $category_id) {
                ContentCategory::deleteCategory($category_id);
            }
            
            Session::p()->data['success'] = Lang::get('lang_text_success');
            Response::redirect(Url::link('content/category', '', 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    private function getList() {
        $data = Theme::language('content/category');
        
        Breadcrumb::add('lang_heading_title', 'content/category');
        
        $data['insert'] = Url::link('content/category/insert', '', 'SSL');
        $data['delete'] = Url::link('content/category/delete', '', 'SSL');
        
        $data['categories'] = array();
        
        $results = ContentCategory::getCategories(0);
        
        foreach ($results as $result) {
            $action = array();
            
            $action[] = array(
                'text' => Lang::get('lang_text_edit'), 
                'href' => Url::link('content/category/update', 'category_id=' . $result['category_id'], 'SSL')
            );
            
            $data['categories'][] = array(
                'category_id' => $result['category_id'], 
                'name'        => $result['name'], 
                'sort_order'  => $result['sort_order'], 
                'selected'    => isset(Request::p()->post['selected']) && in_array($result['category_id'], Request::p()->post['selected']), 
                'action'      => $action
            );
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
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('content/category_list', $data));
    }
    
    private function getForm() {
        $data = Theme::language('content/category');
        
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
        
        if (isset($this->error['slug'])) {
            $data['error_slug'] = $this->error['slug'];
        } else {
            $data['error_slug'] = array();
        }
        
        Breadcrumb::add('lang_heading_title', 'content/category');
        
        if (!isset(Request::p()->get['category_id'])) {
            $data['action'] = Url::link('content/category/insert', '', 'SSL');
        } else {
            $data['action'] = Url::link('content/category/update', 'category_id=' . Request::p()->get['category_id'], 'SSL');
        }
        
        $data['cancel'] = Url::link('content/category', '', 'SSL');
        
        if (isset(Request::p()->get['category_id']) && (Request::p()->server['REQUEST_METHOD'] != 'POST')) {
            $category_info = ContentCategory::getCategory(Request::p()->get['category_id']);
        }
        
        Theme::model('locale/language');
        
        $data['languages'] = LocaleLanguage::getLanguages();
        
        if (isset(Request::p()->post['category_description'])) {
            $data['category_description'] = Request::p()->post['category_description'];
        } elseif (isset(Request::p()->get['category_id'])) {
            $data['category_description'] = ContentCategory::getCategoryDescriptions(Request::p()->get['category_id']);
        } else {
            $data['category_description'] = array();
        }
        
        $categories = ContentCategory::getCategories(0);
        
        // Remove own id from list
        if (!empty($category_info)) {
            foreach ($categories as $key => $category) {
                if ($category['category_id'] == $category_info['category_id']) {
                    unset($categories[$key]);
                }
            }
        }
        
        $data['categories'] = $categories;
        
        if (isset(Request::p()->post['parent_id'])) {
            $data['parent_id'] = Request::p()->post['parent_id'];
        } elseif (!empty($category_info)) {
            $data['parent_id'] = $category_info['parent_id'];
        } else {
            $data['parent_id'] = 0;
        }
        
        Theme::model('setting/store');
        
        $data['stores'] = SettingStore::getStores();
        
        if (isset(Request::p()->post['category_store'])) {
            $data['category_store'] = Request::p()->post['category_store'];
        } elseif (isset(Request::p()->get['category_id'])) {
            $data['category_store'] = ContentCategory::getCategoryStores(Request::p()->get['category_id']);
        } else {
            $data['category_store'] = array(0);
        }
        
        if (isset(Request::p()->post['slug'])) {
            $data['slug'] = Request::p()->post['slug'];
        } elseif (!empty($category_info)) {
            $data['slug'] = $category_info['slug'];
        } else {
            $data['slug'] = '';
        }
        
        if (isset(Request::p()->post['image'])) {
            $data['image'] = Request::p()->post['image'];
        } elseif (!empty($category_info)) {
            $data['image'] = $category_info['image'];
        } else {
            $data['image'] = '';
        }
        
        Theme::model('tool/image');
        
        if (isset(Request::p()->post['image']) && file_exists(Config::get('path.image') . Request::p()->post['image'])) {
            $data['thumb'] = ToolImage::resize(Request::p()->post['image'], 100, 100);
        } elseif (!empty($category_info) && $category_info['image'] && file_exists(Config::get('path.image') . $category_info['image'])) {
            $data['thumb'] = ToolImage::resize($category_info['image'], 100, 100);
        } else {
            $data['thumb'] = ToolImage::resize('placeholder.png', 100, 100);
        }
        
        $data['no_image'] = ToolImage::resize('placeholder.png', 100, 100);
        
        if (isset(Request::p()->post['sort_order'])) {
            $data['sort_order'] = Request::p()->post['sort_order'];
        } elseif (!empty($category_info)) {
            $data['sort_order'] = $category_info['sort_order'];
        } else {
            $data['sort_order'] = 0;
        }
        
        if (isset(Request::p()->post['status'])) {
            $data['status'] = Request::p()->post['status'];
        } elseif (!empty($category_info)) {
            $data['status'] = $category_info['status'];
        } else {
            $data['status'] = 1;
        }
        
        if (isset(Request::p()->post['category_layout'])) {
            $data['category_layout'] = Request::p()->post['category_layout'];
        } elseif (isset(Request::p()->get['category_id'])) {
            $data['category_layout'] = ContentCategory::getCategoryLayouts(Request::p()->get['category_id']);
        } else {
            $data['category_layout'] = array();
        }
        
        Theme::model('design/layout');
        
        $data['layouts'] = DesignLayout::getLayouts();

        Theme::loadjs('javascript/content/category_form', $data);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('content/category_form', $data));
    }
    
    private function validateForm() {
        if (!User::hasPermission('modify', 'content/category')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        foreach (Request::p()->post['category_description'] as $language_id => $value) {
            if ((Encode::strlen($value['name']) < 2) || (Encode::strlen($value['name']) > 255)) {
                $this->error['name'][$language_id] = Lang::get('lang_error_name');
            }
        }
        
        if (isset(Request::p()->post['slug']) && Encode::strlen(Request::p()->post['slug']) > 0):
            Theme::model('tool/utility');
            $query = ToolUtility::findSlugByName(Request::p()->post['slug']);
            
            if (isset(Request::p()->get['category_id'])):
                if ($query):
                    if ($query != 'blog_category_id:' . Request::p()->get['category_id']):
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
        
        if ($this->error && !isset($this->error['warning'])) {
            $this->error['warning'] = Lang::get('lang_error_warning');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    private function validateDelete() {
        if (!User::hasPermission('modify', 'content/category')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    public function slug() {
        Lang::load('content/category');
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
                if (isset(Request::p()->get['category_id'])):
                    if ($query != 'blog_category_id:' . Request::p()->get['category_id']):
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
            $json['success'] = Keyword::getDescription(Request::p()->post['description']);

        Response::setOutput(json_encode($json));
    }

    public function keyword() {
        $json = array();

        if (isset(Request::p()->post['keywords'])):
            // let's clean up the data first
            $keywords        = Keyword::getDescription(Request::p()->post['keywords']);
            $json['success'] = Keyword::getKeywords($keywords);
        endif;

        Response::setOutput(json_encode($json));
    }
}
