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

namespace Admin\Controller\Tool;
use Dais\Engine\Controller;

class Backup extends Controller {
    private $error = array();
    
    public function index() {
        $data = Theme::language('tool/backup');
        Theme::setTitle($this->language->get('lang_heading_title'));
        Theme::model('tool/backup');
        
        if ($this->request->server['REQUEST_METHOD'] == 'POST' && User::hasPermission('modify', 'tool/backup')) {
            if (is_uploaded_file($this->request->files['import']['tmp_name'])) {
                $content = file_get_contents($this->request->files['import']['tmp_name']);
            } else {
                $content = false;
            }
            
            if ($content) {
                $this->model_tool_backup->restore($content);
                $this->session->data['success'] = $this->language->get('lang_text_success');
                
                Response::redirect($this->url->link('tool/backup', 'token=' . $this->session->data['token'], 'SSL'));
            } else {
                $this->error['warning'] = $this->language->get('lang_error_empty');
            }
        }
        
        if (isset($this->session->data['error'])) {
            $data['error_warning'] = $this->session->data['error'];
            
            unset($this->session->data['error']);
        } elseif (isset($this->error['warning'])) {
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
        
        $this->breadcrumb->add('lang_heading_title', 'tool/backup');
        
        $data['restore'] = $this->url->link('tool/backup', 'token=' . $this->session->data['token'], 'SSL');
        $data['backup'] = $this->url->link('tool/backup/backup', 'token=' . $this->session->data['token'], 'SSL');
        $data['tables'] = $this->model_tool_backup->getTables();
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::render_controllers($data);
        
        Response::setOutput(Theme::view('tool/backup', $data));
    }
    
    public function backup() {
        $this->language->load('tool/backup');
        
        if (!isset($this->request->post['backup'])) {
            $this->session->data['error'] = $this->language->get('lang_error_backup');
            
            Theme::listen(__CLASS__, __FUNCTION__);
            
            Response::redirect($this->url->link('tool/backup', 'token=' . $this->session->data['token'], 'SSL'));
        } elseif (User::hasPermission('modify', 'tool/backup')) {
            Response::addheader('Pragma: public');
            Response::addheader('Expires: 0');
            Response::addheader('Content-Description: File Transfer');
            Response::addheader('Content-Type: application/octet-stream');
            Response::addheader('Content-Disposition: attachment; filename=' . date('Y-m-d_H-i-s', time()) . '_backup.sql');
            Response::addheader('Content-Transfer-Encoding: binary');
            
            Theme::model('tool/backup');
            
            Theme::listen(__CLASS__, __FUNCTION__);
            
            Response::setOutput($this->model_tool_backup->backup($this->request->post['backup']));
        } else {
            $this->session->data['error'] = $this->language->get('lang_error_permission');
            
            Theme::listen(__CLASS__, __FUNCTION__);
            
            Response::redirect($this->url->link('tool/backup', 'token=' . $this->session->data['token'], 'SSL'));
        }
    }
}
