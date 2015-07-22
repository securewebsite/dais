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

namespace App\Controllers\Admin\Sale;

use App\Controllers\Controller;

class GiftCardTheme extends Controller {
    
    private $error = array();
    
    public function index() {
        Lang::load('sale/gift_card_theme');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('sale/gift_card_theme');
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    public function insert() {
        Lang::load('sale/gift_card_theme');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('sale/gift_card_theme');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            SaleGiftCardTheme::addGiftcardTheme(Request::post());
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
            
            Response::redirect(Url::link('sale/gift_card_theme', $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function update() {
        Lang::load('sale/gift_card_theme');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('sale/gift_card_theme');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            SaleGiftCardTheme::editGiftcardTheme(Request::p()->get['gift_card_theme_id'], Request::post());
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
            
            Response::redirect(Url::link('sale/gift_card_theme', $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function delete() {
        Lang::load('sale/gift_card_theme');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('sale/gift_card_theme');
        
        if (isset(Request::p()->post['selected']) && $this->validateDelete()) {
            foreach (Request::p()->post['selected'] as $gift_card_theme_id) {
                SaleGiftCardTheme::deleteGiftcardTheme($gift_card_theme_id);
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
            
            Response::redirect(Url::link('sale/gift_card_theme', $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    protected function getList() {
        $data = Theme::language('sale/gift_card_theme');
        
        if (isset(Request::p()->get['sort'])) {
            $sort = Request::p()->get['sort'];
        } else {
            $sort = 'vtd.name';
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
        
        if (isset(Request::p()->get['sort'])) {
            $url.= '&sort=' . Request::p()->get['sort'];
        }
        
        if (isset(Request::p()->get['order'])) {
            $url.= '&order=' . Request::p()->get['order'];
        }
        
        if (isset(Request::p()->get['page'])) {
            $url.= '&page=' . Request::p()->get['page'];
        }
        
        Breadcrumb::add('lang_heading_title', 'sale/gift_card_theme', $url);
        
        $data['insert'] = Url::link('sale/gift_card_theme/insert', $url, 'SSL');
        $data['delete'] = Url::link('sale/gift_card_theme/delete', $url, 'SSL');
        
        $data['gift_card_themes'] = array();
        
        $filter = array(
            'sort'  => $sort, 
            'order' => $order, 
            'start' => ($page - 1) * Config::get('config_admin_limit'), 
            'limit' => Config::get('config_admin_limit')
        );
        
        $gift_card_theme_total = SaleGiftCardTheme::getTotalGiftcardThemes();
        
        $results = SaleGiftCardTheme::getGiftcardThemes($filter);
        
        foreach ($results as $result) {
            $action = array();
            
            $action[] = array(
                'text' => Lang::get('lang_text_edit'), 
                'href' => Url::link('sale/gift_card_theme/update', 'gift_card_theme_id=' . $result['gift_card_theme_id'] . $url, 'SSL')
            );
            
            $data['gift_card_themes'][] = array(
                'gift_card_theme_id' => $result['gift_card_theme_id'], 
                'name'              => $result['name'], 
                'selected'          => isset(Request::p()->post['selected']) && in_array($result['gift_card_theme_id'], Request::p()->post['selected']), 
                'action'            => $action
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
        
        $url = '';
        
        if ($order == 'asc') {
            $url.= '&order=desc';
        } else {
            $url.= '&order=asc';
        }
        
        if (isset(Request::p()->get['page'])) {
            $url.= '&page=' . Request::p()->get['page'];
        }
        
        $data['sort_name'] = Url::link('sale/gift_card_theme', 'sort=name' . $url, 'SSL');
        
        $url = '';
        
        if (isset(Request::p()->get['sort'])) {
            $url.= '&sort=' . Request::p()->get['sort'];
        }
        
        if (isset(Request::p()->get['order'])) {
            $url.= '&order=' . Request::p()->get['order'];
        }
        
        $data['pagination'] = Theme::paginate(
            $gift_card_theme_total, 
            $page, 
            Config::get('config_admin_limit'), 
            Lang::get('lang_text_pagination'), 
            Url::link('sale/gift_card_theme', $url . '&page={page}', 'SSL')
        );
        
        $data['sort']  = $sort;
        $data['order'] = $order;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('sale/gift_card_theme_list', $data));
    }
    
    protected function getForm() {
        $data = Theme::language('sale/gift_card_theme');
        
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
        
        if (isset($this->error['image'])) {
            $data['error_image'] = $this->error['image'];
        } else {
            $data['error_image'] = '';
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
        
        Breadcrumb::add('lang_heading_title', 'sale/gift_card_theme', $url);
        
        if (!isset(Request::p()->get['gift_card_theme_id'])) {
            $data['action'] = Url::link('sale/gift_card_theme/insert', $url, 'SSL');
        } else {
            $data['action'] = Url::link('sale/gift_card_theme/update', 'gift_card_theme_id=' . Request::p()->get['gift_card_theme_id'] . $url, 'SSL');
        }
        
        $data['cancel'] = Url::link('sale/gift_card_theme', $url, 'SSL');
        
        if (isset(Request::p()->get['gift_card_theme_id']) && (Request::p()->server['REQUEST_METHOD'] != 'POST')) {
            $gift_card_theme_info = SaleGiftCardTheme::getGiftcardTheme(Request::p()->get['gift_card_theme_id']);
        }
        
        Theme::model('locale/language');
        
        $data['languages'] = LocaleLanguage::getLanguages();
        
        if (isset(Request::p()->post['gift_card_theme_description'])) {
            $data['gift_card_theme_description'] = Request::p()->post['gift_card_theme_description'];
        } elseif (isset(Request::p()->get['gift_card_theme_id'])) {
            $data['gift_card_theme_description'] = SaleGiftCardTheme::getGiftcardThemeDescriptions(Request::p()->get['gift_card_theme_id']);
        } else {
            $data['gift_card_theme_description'] = array();
        }
        
        if (isset(Request::p()->post['image'])) {
            $data['image'] = Request::p()->post['image'];
        } elseif (!empty($gift_card_theme_info)) {
            $data['image'] = $gift_card_theme_info['image'];
        } else {
            $data['image'] = '';
        }
        
        Theme::model('tool/image');
        
        if (isset($gift_card_theme_info) && $gift_card_theme_info['image'] && file_exists(Config::get('path.image') . $gift_card_theme_info['image'])) {
            $data['thumb'] = ToolImage::resize($gift_card_theme_info['image'], 100, 100);
        } else {
            $data['thumb'] = ToolImage::resize('placeholder.png', 100, 100);
        }
        
        $data['no_image'] = ToolImage::resize('placeholder.png', 100, 100);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('sale/gift_card_theme_form', $data));
    }
    
    protected function validateForm() {
        if (!User::hasPermission('modify', 'sale/gift_card_theme')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        foreach (Request::p()->post['gift_card_theme_description'] as $language_id => $value) {
            if ((Encode::strlen($value['name']) < 3) || (Encode::strlen($value['name']) > 32)) {
                $this->error['name'][$language_id] = Lang::get('lang_error_name');
            }
        }
        
        if (!Request::p()->post['image']) {
            $this->error['image'] = Lang::get('lang_error_image');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    protected function validateDelete() {
        if (!User::hasPermission('modify', 'sale/gift_card_theme')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        Theme::model('sale/gift_card');
        
        foreach (Request::p()->post['selected'] as $gift_card_theme_id) {
            $gift_card_total = SaleGiftCard::getTotalGiftcardsByGiftcardThemeId($gift_card_theme_id);
            
            if ($gift_card_total) {
                $this->error['warning'] = sprintf(Lang::get('lang_error_gift_card'), $gift_card_total);
            }
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
