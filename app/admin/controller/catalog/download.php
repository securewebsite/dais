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
use Dais\Base\Controller;

class Download extends Controller {
    private $error = array();
    
    public function index() {
        Lang::load('catalog/download');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Theme::model('catalog/download');
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    public function insert() {
        Lang::load('catalog/download');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Theme::model('catalog/download');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_catalog_download->addDownload($this->request->post);
            
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
            
            Response::redirect(Url::link('catalog/download', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function update() {
        Lang::load('catalog/download');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Theme::model('catalog/download');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_catalog_download->editDownload($this->request->get['download_id'], $this->request->post);
            
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
            
            Response::redirect(Url::link('catalog/download', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function delete() {
        Lang::load('catalog/download');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Theme::model('catalog/download');
        
        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $download_id) {
                $this->model_catalog_download->deleteDownload($download_id);
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
            
            Response::redirect(Url::link('catalog/download', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    protected function getList() {
        $data = Theme::language('catalog/download');
        
        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'dd.name';
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
        
        Breadcrumb::add('lang_heading_title', 'catalog/download', $url);
        
        $data['insert'] = Url::link('catalog/download/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['delete'] = Url::link('catalog/download/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        $data['downloads'] = array();
        
        $filter = array('sort' => $sort, 'order' => $order, 'start' => ($page - 1) * Config::get('config_admin_limit'), 'limit' => Config::get('config_admin_limit'));
        
        $download_total = $this->model_catalog_download->getTotalDownloads();
        
        $results = $this->model_catalog_download->getDownloads($filter);
        
        foreach ($results as $result) {
            $action = array();
            
            $action[] = array('text' => Lang::get('lang_text_edit'), 'href' => Url::link('catalog/download/update', 'token=' . $this->session->data['token'] . '&download_id=' . $result['download_id'] . $url, 'SSL'));
            
            $data['downloads'][] = array('download_id' => $result['download_id'], 'name' => $result['name'], 'remaining' => $result['remaining'], 'selected' => isset($this->request->post['selected']) && in_array($result['download_id'], $this->request->post['selected']), 'action' => $action);
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
        
        $data['sort_name'] = Url::link('catalog/download', 'token=' . $this->session->data['token'] . '&sort=dd.name' . $url, 'SSL');
        $data['sort_remaining'] = Url::link('catalog/download', 'token=' . $this->session->data['token'] . '&sort=d.remaining' . $url, 'SSL');
        
        $url = '';
        
        if (isset($this->request->get['sort'])) {
            $url.= '&sort=' . $this->request->get['sort'];
        }
        
        if (isset($this->request->get['order'])) {
            $url.= '&order=' . $this->request->get['order'];
        }
        
        $data['pagination'] = Theme::paginate($download_total, $page, Config::get('config_admin_limit'), Lang::get('lang_text_pagination'), Url::link('catalog/download', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL'));
        
        $data['sort'] = $sort;
        $data['order'] = $order;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::render_controllers($data);
        
        Response::setOutput(Theme::view('catalog/download_list', $data));
    }
    
    protected function getForm() {
        $data = Theme::language('catalog/download');
        
        JS::register('ajaxupload.min', 'typeahead.min');
        
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
        
        if (isset($this->error['filename'])) {
            $data['error_filename'] = $this->error['filename'];
        } else {
            $data['error_filename'] = '';
        }
        
        if (isset($this->error['mask'])) {
            $data['error_mask'] = $this->error['mask'];
        } else {
            $data['error_mask'] = '';
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
        
        Breadcrumb::add('lang_heading_title', 'catalog/download', $url);
        
        if (!isset($this->request->get['download_id'])) {
            $data['action'] = Url::link('catalog/download/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        } else {
            $data['action'] = Url::link('catalog/download/update', 'token=' . $this->session->data['token'] . '&download_id=' . $this->request->get['download_id'] . $url, 'SSL');
        }
        
        $data['cancel'] = Url::link('catalog/download', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        Theme::model('localization/language');
        
        $data['languages'] = $this->model_localization_language->getLanguages();
        
        if (isset($this->request->get['download_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $download_info = $this->model_catalog_download->getDownload($this->request->get['download_id']);
        }
        
        $data['token'] = $this->session->data['token'];
        
        if (isset($this->request->get['download_id'])) {
            $data['download_id'] = $this->request->get['download_id'];
        } else {
            $data['download_id'] = 0;
        }
        
        if (isset($this->request->post['download_description'])) {
            $data['download_description'] = $this->request->post['download_description'];
        } elseif (isset($this->request->get['download_id'])) {
            $data['download_description'] = $this->model_catalog_download->getDownloadDescriptions($this->request->get['download_id']);
        } else {
            $data['download_description'] = array();
        }
        
        if (isset($this->request->post['filename'])) {
            $data['filename'] = $this->request->post['filename'];
        } elseif (!empty($download_info)) {
            $data['filename'] = $download_info['filename'];
        } else {
            $data['filename'] = '';
        }
        
        if (isset($this->request->post['mask'])) {
            $data['mask'] = $this->request->post['mask'];
        } elseif (!empty($download_info)) {
            $data['mask'] = $download_info['mask'];
        } else {
            $data['mask'] = '';
        }
        
        if (isset($this->request->post['remaining'])) {
            $data['remaining'] = $this->request->post['remaining'];
        } elseif (!empty($download_info)) {
            $data['remaining'] = $download_info['remaining'];
        } else {
            $data['remaining'] = 1;
        }
        
        if (isset($this->request->post['update'])) {
            $data['update'] = $this->request->post['update'];
        } else {
            $data['update'] = false;
        }
        
        Theme::loadjs('javascript/catalog/download_form', $data);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::render_controllers($data);
        
        Response::setOutput(Theme::view('catalog/download_form', $data));
    }
    
    protected function validateForm() {
        if (!User::hasPermission('modify', 'catalog/download')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        foreach ($this->request->post['download_description'] as $language_id => $value) {
            if ((Encode::strlen($value['name']) < 3) || (Encode::strlen($value['name']) > 64)) {
                $this->error['name'][$language_id] = Lang::get('lang_error_name');
            }
        }
        
        if ((Encode::strlen($this->request->post['filename']) < 3) || (Encode::strlen($this->request->post['filename']) > 128)) {
            $this->error['filename'] = Lang::get('lang_error_filename');
        }
        
        if (!file_exists(Config::get('path.download') . $this->request->post['filename']) && !is_file(Config::get('path.download') . $this->request->post['filename'])) {
            $this->error['filename'] = Lang::get('lang_error_exists');
        }
        
        if ((Encode::strlen($this->request->post['mask']) < 3) || (Encode::strlen($this->request->post['mask']) > 128)) {
            $this->error['mask'] = Lang::get('lang_error_mask');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    protected function validateDelete() {
        if (!User::hasPermission('modify', 'catalog/download')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        Theme::model('catalog/product');
        
        foreach ($this->request->post['selected'] as $download_id) {
            $product_total = $this->model_catalog_product->getTotalProductsByDownloadId($download_id);
            
            if ($product_total) {
                $this->error['warning'] = sprintf(Lang::get('lang_error_product'), $product_total);
            }
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    public function upload() {
        Lang::load('sale/order');
        
        $json = array();
        
        if (!User::hasPermission('modify', 'catalog/download')) {
            $json['error'] = Lang::get('lang_error_permission');
        }
        
        if (!isset($json['error'])) {
            if (!empty($this->request->files['file']['name'])) {
                $filename = basename(html_entity_decode($this->request->files['file']['name'], ENT_QUOTES, 'UTF-8'));
                
                if ((Encode::strlen($filename) < 3) || (Encode::strlen($filename) > 128)) {
                    $json['error'] = Lang::get('lang_error_filename');
                }
                
                // Allowed file extension types
                $allowed = array();
                
                $filetypes = explode("\n", str_replace(array("\r\n", "\r"), "\n", Config::get('config_file_extension_allowed')));
                
                foreach ($filetypes as $filetype) {
                    $allowed[] = trim($filetype);
                }
                
                if (!in_array(substr(strrchr($filename, '.'), 1), $allowed)) {
                    $json['error'] = Lang::get('lang_error_filetype');
                }
                
                // Allowed file mime types
                $allowed = array();
                
                $filetypes = explode("\n", str_replace(array("\r\n", "\r"), "\n", Config::get('config_file_mime_allowed')));
                
                foreach ($filetypes as $filetype) {
                    $allowed[] = trim($filetype);
                }
                
                if (!in_array($this->request->files['file']['type'], $allowed)) {
                    $json['error'] = Lang::get('lang_error_filetype');
                }
                
                if ($this->request->files['file']['error'] != UPLOAD_ERR_OK) {
                    $json['error'] = Lang::get('lang_error_upload_' . $this->request->files['file']['error']);
                }
            } else {
                $json['error'] = Lang::get('lang_error_upload');
            }
        }
        
        if (!isset($json['error'])) {
            if (is_uploaded_file($this->request->files['file']['tmp_name']) && file_exists($this->request->files['file']['tmp_name'])) {
                $ext = md5(mt_rand());
                
                $json['filename'] = $filename . '.' . $ext;
                $json['mask'] = $filename;
                
                move_uploaded_file($this->request->files['file']['tmp_name'], Config::get('path.download') . $filename . '.' . $ext);
            }
            
            $json['success'] = Lang::get('lang_text_upload');
        }
        
        $json = Theme::listen(__CLASS__, __FUNCTION__, $json);
        
        Response::setOutput(json_encode($json));
    }
    
    public function autocomplete() {
        $json = array();
        
        if (isset($this->request->get['filter_name'])) {
            Theme::model('catalog/download');
            
            $filter = array('filter_name' => $this->request->get['filter_name'], 'start' => 0, 'limit' => 20);
            
            $results = $this->model_catalog_download->getDownloads($filter);
            
            foreach ($results as $result) {
                $json[] = array('download_id' => $result['download_id'], 'name' => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')));
            }
        }
        
        $sort_order = array();
        
        foreach ($json as $key => $value) {
            $sort_order[$key] = $value['name'];
        }
        
        array_multisort($sort_order, SORT_ASC, $json);
        
        $json = Theme::listen(__CLASS__, __FUNCTION__, $json);
        
        Response::setOutput(json_encode($json));
    }
}
