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

class Page extends Controller {
    
    private $error = array();
    
    public function index() {
        Lang::load('content/page');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('content/page');
        Theme::listen(__CLASS__, __FUNCTION__);
        $this->getList();
    }
    
    public function insert() {
        Lang::load('content/page');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('content/page');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            ContentPage::addPage(Request::post());
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
            
            Response::redirect(Url::link('content/page', '' . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function update() {
        Lang::load('content/page');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('content/page');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            ContentPage::editPage(Request::p()->get['page_id'], Request::post());
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
            
            Response::redirect(Url::link('content/page', '' . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function delete() {
        Lang::load('content/page');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('content/page');
        
        if (isset(Request::p()->post['selected']) && $this->validateDelete()) {
            foreach (Request::p()->post['selected'] as $page_id) {
                ContentPage::deletePage($page_id);
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
            
            Response::redirect(Url::link('content/page', '' . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    protected function getList() {
        $data = Theme::language('content/page');
        
        if (isset(Request::p()->get['sort'])) {
            $sort = Request::p()->get['sort'];
        } else {
            $sort = 'id.title';
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
        
        Breadcrumb::add('lang_heading_title', 'content/page', $url);
        
        $data['insert'] = Url::link('content/page/insert', '' . $url, 'SSL');
        $data['delete'] = Url::link('content/page/delete', '' . $url, 'SSL');
        
        $data['pages'] = array();
        
        $filter = array(
            'sort'  => $sort, 
            'order' => $order, 
            'start' => ($page - 1) * Config::get('config_admin_limit'), 
            'limit' => Config::get('config_admin_limit')
        );
        
        $page_total = ContentPage::getTotalPages();
        
        $results = ContentPage::getPages($filter);
        
        foreach ($results as $result) {
            $action = array();
            
            $action[] = array(
                'text' => Lang::get('lang_text_edit'), 
                'href' => Url::link('content/page/update', '' . 'page_id=' . $result['page_id'] . $url, 'SSL')
            );
            
            $data['pages'][] = array(
                'page_id'    => $result['page_id'], 
                'title'      => $result['title'], 
                'sort_order' => $result['sort_order'], 
                'selected'   => isset(Request::p()->post['selected']) && in_array($result['page_id'], Request::p()->post['selected']), 
                'action'     => $action
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
        
        $data['sort_title']      = Url::link('content/page', '' . 'sort=id.title' . $url, 'SSL');
        $data['sort_sort_order'] = Url::link('content/page', '' . 'sort=i.sort_order' . $url, 'SSL');
        
        $url = '';
        
        if (isset(Request::p()->get['sort'])) {
            $url.= '&sort=' . Request::p()->get['sort'];
        }
        
        if (isset(Request::p()->get['order'])) {
            $url.= '&order=' . Request::p()->get['order'];
        }
        
        $data['pagination'] = Theme::paginate(
            $page_total, 
            $page, 
            Config::get('config_admin_limit'), 
            Lang::get('lang_text_pagination'), 
            Url::link('content/page', '' . $url . '&page={page}', 'SSL')
        );
        
        $data['sort']  = $sort;
        $data['order'] = $order;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('content/page_list', $data));
    }
    
    protected function getForm() {
        $data = Theme::language('content/page');
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        if (isset($this->error['title'])) {
            $data['error_title'] = $this->error['title'];
        } else {
            $data['error_title'] = array();
        }
        
        if (isset($this->error['description'])) {
            $data['error_description'] = $this->error['description'];
        } else {
            $data['error_description'] = array();
        }
        
        if (isset($this->error['meta_description'])) {
            $data['error_meta_description'] = $this->error['meta_description'];
        } else {
            $data['error_meta_description'] = array();
        }
        
        if (isset($this->error['slug'])) {
            $data['error_slug'] = $this->error['slug'];
        } else {
            $data['error_slug'] = '';
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
        
        Breadcrumb::add('lang_heading_title', 'content/page', $url);
        
        if (!isset(Request::p()->get['page_id'])) {
            $data['action'] = Url::link('content/page/insert', '' . $url, 'SSL');
        } else {
            $data['action'] = Url::link('content/page/update', '' . 'page_id=' . Request::p()->get['page_id'] . $url, 'SSL');
        }
        
        $data['cancel'] = Url::link('content/page', '' . $url, 'SSL');
        
        if (isset(Request::p()->get['page_id']) && (Request::p()->server['REQUEST_METHOD'] != 'POST')) {
            $page_info = ContentPage::getPage(Request::p()->get['page_id']);
        }
        
        Theme::model('locale/language');
        
        $data['languages'] = LocaleLanguage::getLanguages();
        
        if (isset(Request::p()->post['page_description'])) {
            $data['page_description'] = Request::p()->post['page_description'];
        } elseif (isset(Request::p()->get['page_id'])) {
            $data['page_description'] = ContentPage::getPageDescriptions(Request::p()->get['page_id']);
        } else {
            $data['page_description'] = array();
        }
        
        Theme::model('setting/store');
        
        $data['stores'] = SettingStore::getStores();
        
        if (isset(Request::p()->post['page_store'])) {
            $data['page_store'] = Request::p()->post['page_store'];
        } elseif (isset(Request::p()->get['page_id'])) {
            $data['page_store'] = ContentPage::getPageStores(Request::p()->get['page_id']);
        } else {
            $data['page_store'] = array(0);
        }
        
        if (isset(Request::p()->post['slug'])) {
            $data['slug'] = Request::p()->post['slug'];
        } elseif (!empty($page_info) && $page_info['event_id'] == 0) {
            $data['slug'] = $page_info['slug'];
        } elseif (!empty($page_info) && $page_info['event_id'] > 0) {
            $data['slug'] = ContentPage::getEventSlug(Request::p()->get['page_id']);
        } else {
            $data['slug'] = '';
        }
        
        if (isset(Request::p()->post['bottom'])) {
            $data['bottom'] = Request::p()->post['bottom'];
        } elseif (!empty($page_info)) {
            $data['bottom'] = $page_info['bottom'];
        } else {
            $data['bottom'] = 0;
        }
        
        if (isset(Request::p()->post['status'])) {
            $data['status'] = (int)Request::p()->post['status'];
        } elseif (!empty($page_info)) {
            $data['status'] = (int)$page_info['status'];
        } else {
            $data['status'] = (int)1;
        }
        
        if (isset(Request::p()->post['sort_order'])) {
            $data['sort_order'] = Request::p()->post['sort_order'];
        } elseif (!empty($page_info)) {
            $data['sort_order'] = $page_info['sort_order'];
        } else {
            $data['sort_order'] = '';
        }

        if (isset(Request::p()->post['event_id'])) {
            $data['event_id'] = Request::p()->post['event_id'];
        } elseif (!empty($page_info)) {
            $data['event_id'] = $page_info['event_id'];
        } else {
            $data['event_id'] = 0;
        }

        // If this is an event, let's get some additional info
        // and change our slug.
        
        $data['event_name'] = false;
        $data['event_url']  = false;

        if ($data['event_id'] > 0):
            $data['event_name'] = ContentPage::getEventName($data['event_id']);
            $data['event_url']  = Url::link('calendar/event/update', '' . 'event_id=' . $data['event_id'], 'SSL');
            $data['slug']       = ContentPage::getEventSlug(Request::p()->get['page_id']);
        endif;
        
        if (isset(Request::p()->post['page_layout'])) {
            $data['page_layout'] = Request::p()->post['page_layout'];
        } elseif (isset(Request::p()->get['page_id'])) {
            $data['page_layout'] = ContentPage::getPageLayouts(Request::p()->get['page_id']);
        } else {
            $data['page_layout'] = array();
        }
        
        Theme::model('design/layout');
        
        $data['layouts'] = DesignLayout::getLayouts();
        
        if (isset(Request::p()->post['visibility'])) {
            $data['visibility'] = Request::p()->post['visibility'];
        } elseif (!empty($page_info)) {
            $data['visibility'] = $page_info['visibility'];
        } else {
            $data['visibility'] = 0;
        }
        
        Theme::model('people/customer_group');
        
        $data['customer_groups'] = PeopleCustomerGroup::getCustomerGroups();

        Theme::loadjs('javascript/content/page_form', $data);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('content/page_form', $data));
    }
    
    protected function validateForm() {
        if (!User::hasPermission('modify', 'content/page')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        foreach (Request::p()->post['page_description'] as $language_id => $value) {
            if ((Encode::strlen($value['title']) < 3) || (Encode::strlen($value['title']) > 64)) {
                $this->error['title'][$language_id] = Lang::get('lang_error_title');
            }
            
            if (Encode::strlen($value['description']) < 3) {
                $this->error['description'][$language_id] = Lang::get('lang_error_description');
            }
        }
        
        if (isset(Request::p()->post['slug']) && Encode::strlen(Request::p()->post['slug']) > 0):
            Theme::model('tool/utility');
            $query = ToolUtility::findSlugByName(Request::p()->post['slug']);
            
            if (isset(Request::p()->get['page_id'])):
                if ($query):
                    if (($query != 'page_id:' . Request::p()->get['page_id']) && ($query != 'event_page_id:' . Request::p()->get['page_id'])):
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
    
    protected function validateDelete() {
        if (!User::hasPermission('modify', 'content/page')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        Theme::model('setting/store');
        Theme::model('calendar/event');
        
        foreach (Request::p()->post['selected'] as $page_id) {
            if (Config::get('config_account_id') == $page_id) {
                $this->error['warning'] = Lang::get('lang_error_account');
            }
            
            if (Config::get('config_checkout_id') == $page_id) {
                $this->error['warning'] = Lang::get('lang_error_checkout');
            }
            
            if (Config::get('config_affiliate_allowed')):
                if (Config::get('config_affiliate_terms') == $page_id):
                    $this->error['warning'] = Lang::get('lang_error_affiliate');
                endif;
            endif;
            
            $store_total = SettingStore::getTotalStoresByPageId($page_id);
            
            if ($store_total) {
                $this->error['warning'] = sprintf(Lang::get('lang_error_store'), $store_total);
            }

            $event_total = CalendarEvent::getTotalEventsByPageId($page_id);

            if ($event_total):
                $this->error['warning'] = sprintf(Lang::get('lang_error_event'), $event_total);
            endif;
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    public function slug() {
        Lang::load('content/page');
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
                if (isset(Request::p()->get['page_id'])):
                    if (($query != 'page_id:' . Request::p()->get['page_id']) && ($query != 'event_page_id:' . Request::p()->get['page_id'])):
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
