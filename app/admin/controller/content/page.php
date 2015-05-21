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

namespace Admin\Controller\Content;
use Dais\Engine\Controller;

class Page extends Controller {
    private $error = array();
    
    public function index() {
        $this->language->load('content/page');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('content/page');
        $this->theme->listen(__CLASS__, __FUNCTION__);
        $this->getList();
    }
    
    public function insert() {
        $this->language->load('content/page');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('content/page');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_content_page->addPage($this->request->post);
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
            
            $this->response->redirect($this->url->link('content/page', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function update() {
        $this->language->load('content/page');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('content/page');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_content_page->editPage($this->request->get['page_id'], $this->request->post);
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
            
            $this->response->redirect($this->url->link('content/page', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function delete() {
        $this->language->load('content/page');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('content/page');
        
        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $page_id) {
                $this->model_content_page->deletePage($page_id);
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
            
            $this->response->redirect($this->url->link('content/page', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    protected function getList() {
        $data = $this->theme->language('content/page');
        
        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'id.title';
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
        
        $this->breadcrumb->add('lang_heading_title', 'content/page', $url);
        
        $data['insert'] = $this->url->link('content/page/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['delete'] = $this->url->link('content/page/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        $data['pages'] = array();
        
        $filter = array(
            'sort'  => $sort, 
            'order' => $order, 
            'start' => ($page - 1) * $this->config->get('config_admin_limit'), 
            'limit' => $this->config->get('config_admin_limit')
        );
        
        $page_total = $this->model_content_page->getTotalPages();
        
        $results = $this->model_content_page->getPages($filter);
        
        foreach ($results as $result) {
            $action = array();
            
            $action[] = array(
                'text' => $this->language->get('lang_text_edit'), 
                'href' => $this->url->link('content/page/update', 'token=' . $this->session->data['token'] . '&page_id=' . $result['page_id'] . $url, 'SSL')
            );
            
            $data['pages'][] = array(
                'page_id'    => $result['page_id'], 
                'title'      => $result['title'], 
                'sort_order' => $result['sort_order'], 
                'selected'   => isset($this->request->post['selected']) && in_array($result['page_id'], $this->request->post['selected']), 
                'action'     => $action
            );
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
        
        $data['sort_title']      = $this->url->link('content/page', 'token=' . $this->session->data['token'] . '&sort=id.title' . $url, 'SSL');
        $data['sort_sort_order'] = $this->url->link('content/page', 'token=' . $this->session->data['token'] . '&sort=i.sort_order' . $url, 'SSL');
        
        $url = '';
        
        if (isset($this->request->get['sort'])) {
            $url.= '&sort=' . $this->request->get['sort'];
        }
        
        if (isset($this->request->get['order'])) {
            $url.= '&order=' . $this->request->get['order'];
        }
        
        $data['pagination'] = $this->theme->paginate(
            $page_total, 
            $page, 
            $this->config->get('config_admin_limit'), 
            $this->language->get('lang_text_pagination'), 
            $this->url->link('content/page', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL')
        );
        
        $data['sort']  = $sort;
        $data['order'] = $order;
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('content/page_list', $data));
    }
    
    protected function getForm() {
        $data = $this->theme->language('content/page');
        
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
        
        if (isset($this->request->get['sort'])) {
            $url.= '&sort=' . $this->request->get['sort'];
        }
        
        if (isset($this->request->get['order'])) {
            $url.= '&order=' . $this->request->get['order'];
        }
        
        if (isset($this->request->get['page'])) {
            $url.= '&page=' . $this->request->get['page'];
        }
        
        $this->breadcrumb->add('lang_heading_title', 'content/page', $url);
        
        if (!isset($this->request->get['page_id'])) {
            $data['action'] = $this->url->link('content/page/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        } else {
            $data['action'] = $this->url->link('content/page/update', 'token=' . $this->session->data['token'] . '&page_id=' . $this->request->get['page_id'] . $url, 'SSL');
        }
        
        $data['cancel'] = $this->url->link('content/page', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        if (isset($this->request->get['page_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $page_info = $this->model_content_page->getPage($this->request->get['page_id']);
        }
        
        $data['token'] = $this->session->data['token'];
        
        $this->theme->model('localization/language');
        
        $data['languages'] = $this->model_localization_language->getLanguages();
        
        if (isset($this->request->post['page_description'])) {
            $data['page_description'] = $this->request->post['page_description'];
        } elseif (isset($this->request->get['page_id'])) {
            $data['page_description'] = $this->model_content_page->getPageDescriptions($this->request->get['page_id']);
        } else {
            $data['page_description'] = array();
        }
        
        $this->theme->model('setting/store');
        
        $data['stores'] = $this->model_setting_store->getStores();
        
        if (isset($this->request->post['page_store'])) {
            $data['page_store'] = $this->request->post['page_store'];
        } elseif (isset($this->request->get['page_id'])) {
            $data['page_store'] = $this->model_content_page->getPageStores($this->request->get['page_id']);
        } else {
            $data['page_store'] = array(0);
        }
        
        if (isset($this->request->post['slug'])) {
            $data['slug'] = $this->request->post['slug'];
        } elseif (!empty($page_info) && $page_info['event_id'] == 0) {
            $data['slug'] = $page_info['slug'];
        } elseif (!empty($page_info) && $page_info['event_id'] > 0) {
            $data['slug'] = $this->model_content_page->getEventSlug($this->request->get['page_id']);
        } else {
            $data['slug'] = '';
        }
        
        if (isset($this->request->post['bottom'])) {
            $data['bottom'] = $this->request->post['bottom'];
        } elseif (!empty($page_info)) {
            $data['bottom'] = $page_info['bottom'];
        } else {
            $data['bottom'] = 0;
        }
        
        if (isset($this->request->post['status'])) {
            $data['status'] = (int)$this->request->post['status'];
        } elseif (!empty($page_info)) {
            $data['status'] = (int)$page_info['status'];
        } else {
            $data['status'] = (int)1;
        }
        
        if (isset($this->request->post['sort_order'])) {
            $data['sort_order'] = $this->request->post['sort_order'];
        } elseif (!empty($page_info)) {
            $data['sort_order'] = $page_info['sort_order'];
        } else {
            $data['sort_order'] = '';
        }

        if (isset($this->request->post['event_id'])) {
            $data['event_id'] = $this->request->post['event_id'];
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
            $data['event_name'] = $this->model_content_page->getEventName($data['event_id']);
            $data['event_url']  = $this->url->link('calendar/event/update', 'token=' . $this->session->data['token'] . '&event_id=' . $data['event_id'], 'SSL');
            $data['slug']       = $this->model_content_page->getEventSlug($this->request->get['page_id']);
        endif;
        
        if (isset($this->request->post['page_layout'])) {
            $data['page_layout'] = $this->request->post['page_layout'];
        } elseif (isset($this->request->get['page_id'])) {
            $data['page_layout'] = $this->model_content_page->getPageLayouts($this->request->get['page_id']);
        } else {
            $data['page_layout'] = array();
        }
        
        $this->theme->model('design/layout');
        
        $data['layouts'] = $this->model_design_layout->getLayouts();
        
        if (isset($this->request->post['visibility'])) {
            $data['visibility'] = $this->request->post['visibility'];
        } elseif (!empty($page_info)) {
            $data['visibility'] = $page_info['visibility'];
        } else {
            $data['visibility'] = 0;
        }
        
        $this->theme->model('people/customer_group');
        
        $data['customer_groups'] = $this->model_people_customer_group->getCustomerGroups();

        $this->theme->loadjs('javascript/content/page_form', $data);
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('content/page_form', $data));
    }
    
    protected function validateForm() {
        if (!$this->user->hasPermission('modify', 'content/page')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        foreach ($this->request->post['page_description'] as $language_id => $value) {
            if (($this->encode->strlen($value['title']) < 3) || ($this->encode->strlen($value['title']) > 64)) {
                $this->error['title'][$language_id] = $this->language->get('lang_error_title');
            }
            
            if ($this->encode->strlen($value['description']) < 3) {
                $this->error['description'][$language_id] = $this->language->get('lang_error_description');
            }
        }
        
        if (isset($this->request->post['slug']) && $this->encode->strlen($this->request->post['slug']) > 0):
            $this->theme->model('tool/utility');
            $query = $this->model_tool_utility->findSlugByName($this->request->post['slug']);
            
            if (isset($this->request->get['page_id'])):
                if ($query):
                    if (($query != 'page_id:' . $this->request->get['page_id']) && ($query != 'event_page_id:' . $this->request->get['page_id'])):
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
        
        if ($this->error && !isset($this->error['warning'])) {
            $this->error['warning'] = $this->language->get('lang_error_warning');
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    protected function validateDelete() {
        if (!$this->user->hasPermission('modify', 'content/page')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        $this->theme->model('setting/store');
        $this->theme->model('calendar/event');
        
        foreach ($this->request->post['selected'] as $page_id) {
            if ($this->config->get('config_account_id') == $page_id) {
                $this->error['warning'] = $this->language->get('lang_error_account');
            }
            
            if ($this->config->get('config_checkout_id') == $page_id) {
                $this->error['warning'] = $this->language->get('lang_error_checkout');
            }
            
            if ($this->config->get('config_affiliate_allowed')):
                if ($this->config->get('config_affiliate_terms') == $page_id):
                    $this->error['warning'] = $this->language->get('lang_error_affiliate');
                endif;
            endif;
            
            $store_total = $this->model_setting_store->getTotalStoresByPageId($page_id);
            
            if ($store_total) {
                $this->error['warning'] = sprintf($this->language->get('lang_error_store'), $store_total);
            }

            $event_total = $this->model_calendar_event->getTotalEventsByPageId($page_id);

            if ($event_total):
                $this->error['warning'] = sprintf($this->language->get('lang_error_event'), $event_total);
            endif;
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    public function slug() {
        $this->language->load('content/page');
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
                if (isset($this->request->get['page_id'])):
                    if (($query != 'page_id:' . $this->request->get['page_id']) && ($query != 'event_page_id:' . $this->request->get['page_id'])):
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

    public function description() {
        $json = array();

        if (isset($this->request->post['description']))
            $json['success'] = $this->keyword->getDescription($this->request->post['description']);

        $this->response->setOutput(json_encode($json));
    }

    public function keyword() {
        $json = array();

        if (isset($this->request->post['keywords'])):
            // let's clean up the data first
            $keywords        = $this->keyword->getDescription($this->request->post['keywords']);
            $json['success'] = $this->keyword->getKeywords($keywords);
        endif;

        $this->response->setOutput(json_encode($json));
    }
}
