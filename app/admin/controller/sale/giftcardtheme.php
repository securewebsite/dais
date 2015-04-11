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

namespace Admin\Controller\Sale;
use Dais\Engine\Controller;

class Giftcardtheme extends Controller {
    private $error = array();
    
    public function index() {
        $this->language->load('sale/giftcard_theme');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('sale/giftcardtheme');
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    public function insert() {
        $this->language->load('sale/giftcard_theme');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('sale/giftcardtheme');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_sale_giftcardtheme->addGiftcardTheme($this->request->post);
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
            
            $this->response->redirect($this->url->link('sale/giftcardtheme', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function update() {
        $this->language->load('sale/giftcard_theme');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('sale/giftcardtheme');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_sale_giftcardtheme->editGiftcardTheme($this->request->get['giftcard_theme_id'], $this->request->post);
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
            
            $this->response->redirect($this->url->link('sale/giftcardtheme', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function delete() {
        $this->language->load('sale/giftcard_theme');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('sale/giftcardtheme');
        
        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $giftcard_theme_id) {
                $this->model_sale_giftcardtheme->deleteGiftcardTheme($giftcard_theme_id);
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
            
            $this->response->redirect($this->url->link('sale/giftcardtheme', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    protected function getList() {
        $data = $this->theme->language('sale/giftcard_theme');
        
        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'vtd.name';
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
        
        $this->breadcrumb->add('lang_heading_title', 'sale/giftcardtheme', $url);
        
        $data['insert'] = $this->url->link('sale/giftcardtheme/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['delete'] = $this->url->link('sale/giftcardtheme/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        $data['giftcard_themes'] = array();
        
        $filter = array(
            'sort'  => $sort, 
            'order' => $order, 
            'start' => ($page - 1) * $this->config->get('config_admin_limit'), 
            'limit' => $this->config->get('config_admin_limit')
        );
        
        $giftcard_theme_total = $this->model_sale_giftcardtheme->getTotalGiftcardThemes();
        
        $results = $this->model_sale_giftcardtheme->getGiftcardThemes($filter);
        
        foreach ($results as $result) {
            $action = array();
            
            $action[] = array(
                'text' => $this->language->get('lang_text_edit'), 
                'href' => $this->url->link('sale/giftcardtheme/update', 'token=' . $this->session->data['token'] . '&giftcard_theme_id=' . $result['giftcard_theme_id'] . $url, 'SSL')
            );
            
            $data['giftcard_themes'][] = array(
                'giftcard_theme_id' => $result['giftcard_theme_id'], 
                'name'              => $result['name'], 
                'selected'          => isset($this->request->post['selected']) && in_array($result['giftcard_theme_id'], $this->request->post['selected']), 
                'action'            => $action
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
        
        $data['sort_name'] = $this->url->link('sale/giftcardtheme', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
        
        $url = '';
        
        if (isset($this->request->get['sort'])) {
            $url.= '&sort=' . $this->request->get['sort'];
        }
        
        if (isset($this->request->get['order'])) {
            $url.= '&order=' . $this->request->get['order'];
        }
        
        $data['pagination'] = $this->theme->paginate(
            $giftcard_theme_total, 
            $page, 
            $this->config->get('config_admin_limit'), 
            $this->language->get('lang_text_pagination'), 
            $this->url->link('sale/giftcardtheme', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL')
        );
        
        $data['sort']  = $sort;
        $data['order'] = $order;
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('sale/giftcard_theme_list', $data));
    }
    
    protected function getForm() {
        $data = $this->theme->language('sale/giftcard_theme');
        
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
        
        if (isset($this->request->get['sort'])) {
            $url.= '&sort=' . $this->request->get['sort'];
        }
        
        if (isset($this->request->get['order'])) {
            $url.= '&order=' . $this->request->get['order'];
        }
        
        if (isset($this->request->get['page'])) {
            $url.= '&page=' . $this->request->get['page'];
        }
        
        $this->breadcrumb->add('lang_heading_title', 'sale/giftcardtheme', $url);
        
        if (!isset($this->request->get['giftcard_theme_id'])) {
            $data['action'] = $this->url->link('sale/giftcardtheme/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        } else {
            $data['action'] = $this->url->link('sale/giftcardtheme/update', 'token=' . $this->session->data['token'] . '&giftcard_theme_id=' . $this->request->get['giftcard_theme_id'] . $url, 'SSL');
        }
        
        $data['cancel'] = $this->url->link('sale/giftcardtheme', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        if (isset($this->request->get['giftcard_theme_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $giftcard_theme_info = $this->model_sale_giftcardtheme->getGiftcardTheme($this->request->get['giftcard_theme_id']);
        }
        
        $data['token'] = $this->session->data['token'];
        
        $this->theme->model('localization/language');
        
        $data['languages'] = $this->model_localization_language->getLanguages();
        
        if (isset($this->request->post['giftcard_theme_description'])) {
            $data['giftcard_theme_description'] = $this->request->post['giftcard_theme_description'];
        } elseif (isset($this->request->get['giftcard_theme_id'])) {
            $data['giftcard_theme_description'] = $this->model_sale_giftcardtheme->getGiftcardThemeDescriptions($this->request->get['giftcard_theme_id']);
        } else {
            $data['giftcard_theme_description'] = array();
        }
        
        if (isset($this->request->post['image'])) {
            $data['image'] = $this->request->post['image'];
        } elseif (!empty($giftcard_theme_info)) {
            $data['image'] = $giftcard_theme_info['image'];
        } else {
            $data['image'] = '';
        }
        
        $this->theme->model('tool/image');
        
        if (isset($giftcard_theme_info) && $giftcard_theme_info['image'] && file_exists($this->app['path.image'] . $giftcard_theme_info['image'])) {
            $data['thumb'] = $this->model_tool_image->resize($giftcard_theme_info['image'], 100, 100);
        } else {
            $data['thumb'] = $this->model_tool_image->resize('placeholder.png', 100, 100);
        }
        
        $data['no_image'] = $this->model_tool_image->resize('placeholder.png', 100, 100);
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('sale/giftcard_theme_form', $data));
    }
    
    protected function validateForm() {
        if (!$this->user->hasPermission('modify', 'sale/giftcardtheme')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        foreach ($this->request->post['giftcard_theme_description'] as $language_id => $value) {
            if (($this->encode->strlen($value['name']) < 3) || ($this->encode->strlen($value['name']) > 32)) {
                $this->error['name'][$language_id] = $this->language->get('lang_error_name');
            }
        }
        
        if (!$this->request->post['image']) {
            $this->error['image'] = $this->language->get('lang_error_image');
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    protected function validateDelete() {
        if (!$this->user->hasPermission('modify', 'sale/giftcardtheme')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        $this->theme->model('sale/giftcard');
        
        foreach ($this->request->post['selected'] as $giftcard_theme_id) {
            $giftcard_total = $this->model_sale_giftcard->getTotalGiftcardsByGiftcardThemeId($giftcard_theme_id);
            
            if ($giftcard_total) {
                $this->error['warning'] = sprintf($this->language->get('lang_error_giftcard'), $giftcard_total);
            }
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
