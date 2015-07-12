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

namespace App\Controllers\Admin\Common;
use App\Controllers\Controller;

class FileManager extends Controller {
    
    public function index() {
        $data = Theme::language('common/file_manager');
        
        JS::reset();
        
        JS::register('jquery.min', null)
            ->register('migrate.min', 'jquery.min')
            ->register('bootstrap.min', 'migrate.min')
            ->register('filemanager.min', 'bootstrap.min', true);
        
        CSS::reset();
        CSS::register('filemanager.min', null, true);
        
        $data['title'] = Lang::get('lang_heading_title');
        
        if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
            $data['base'] = Config::get('https.server');
        } else {
            $data['base'] = Config::get('http.server');
        }
        
        $data['token'] = $this->session->data['token'];
        
        $data['directory'] = Config::get('http.public') . 'image/data/';
        
        Theme::model('tool/image');
        
        $data['no_image'] = $this->model_tool_image->resize('placeholder.png', 100, 100);
        
        if (isset($this->request->get['field'])) {
            $data['field'] = $this->request->get['field'];
        } else {
            $data['field'] = '';
        }
        
        Theme::loadjs('javascript/common/file_manager', $data);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data['javascript'] = Theme::controller('common/javascript');

        $css_key = CSS::compile();
        $js_key  = JS::compile();
        
        $data['css_link'] = Config::get('https.public') . 'asset/' . Config::get('theme.name') . '/compiled/' . Filecache::get_key($css_key, 'css');
        $data['js_link']  = Config::get('https.public') . 'asset/' . Config::get('theme.name') . '/compiled/' . Filecache::get_key($js_key, 'js');
        
        Response::setOutput(Theme::view('common/file_manager', $data));
    }
    
    public function image() {
        Theme::model('tool/image');
        
        if (isset($this->request->get['image'])) {
            Response::setOutput($this->model_tool_image->resize(html_entity_decode($this->request->get['image'], ENT_QUOTES, 'UTF-8'), 100, 100));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
    }
    
    public function directory() {
        $json = array();
        
        if (isset($this->request->post['directory'])) {
            $directories = glob(rtrim(Config::get('path.image') . 'data/' . str_replace('../', '', $this->request->post['directory']), '/') . '/*', GLOB_ONLYDIR);
            
            if ($directories) {
                $i = 0;
                
                foreach ($directories as $directory) {
                    $json[$i]['data'] = basename($directory);
                    $json[$i]['attributes']['directory'] = Encode::substr($directory, strlen(Config::get('path.image') . 'data/'));
                    
                    $children = glob(rtrim($directory, '/') . '/*', GLOB_ONLYDIR);
                    
                    if ($children) {
                        $json[$i]['children'] = ' ';
                    }
                    
                    $i++;
                }
            }
        }
        
        $json = Theme::listen(__CLASS__, __FUNCTION__, $json);
        
        Response::setOutput(json_encode($json));
    }
    
    public function files() {
        $json = array();
        
        if (!empty($this->request->post['directory'])) {
            $directory = Config::get('path.image') . 'data/' . str_replace('../', '', $this->request->post['directory']);
        } else {
            $directory = Config::get('path.image') . 'data/';
        }
        
        $allowed = array('.jpg', '.jpeg', '.png', '.gif');
        
        $files = glob(rtrim($directory, '/') . '/*');
        
        if ($files) {
            foreach ($files as $file) {
                if (is_file($file)) {
                    $ext = strrchr($file, '.');
                } else {
                    $ext = '';
                }
                
                if (in_array(strtolower($ext), $allowed)) {
                    $size = filesize($file);
                    
                    $i = 0;
                    
                    $suffix = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
                    
                    while (($size / 1024) > 1) {
                        $size = $size / 1024;
                        $i++;
                    }
                    
                    $json[] = array('filename' => basename($file), 'file' => Encode::substr($file, Encode::strlen(Config::get('path.image') . 'data/')), 'size' => round(Encode::substr($size, 0, Encode::strpos($size, '.') + 4), 2) . $suffix[$i]);
                }
            }
        }
        
        $json = Theme::listen(__CLASS__, __FUNCTION__, $json);
        
        Response::setOutput(json_encode($json));
    }
    
    public function create() {
        Lang::load('common/file_manager');
        
        $json = array();
        
        if (isset($this->request->post['directory'])) {
            if (isset($this->request->post['name']) || $this->request->post['name']) {
                $directory = rtrim(Config::get('path.image') . 'data/' . str_replace('../', '', $this->request->post['directory']), '/');
                
                if (!is_dir($directory)) {
                    $json['error'] = Lang::get('lang_error_directory');
                }
                
                if (file_exists($directory . '/' . str_replace('../', '', $this->request->post['name']))) {
                    $json['error'] = Lang::get('lang_error_exists');
                }
            } else {
                $json['error'] = Lang::get('lang_error_name');
            }
        } else {
            $json['error'] = Lang::get('lang_error_directory');
        }
        
        if (!User::hasPermission('modify', 'common/file_manager')) {
            $json['error'] = Lang::get('lang_error_permission');
        }
        
        if (!isset($json['error'])) {
            mkdir($directory . '/' . str_replace('../', '', $this->request->post['name']), 0777);
            
            $json['success'] = Lang::get('lang_text_create');
        }
        
        $json = Theme::listen(__CLASS__, __FUNCTION__, $json);
        
        Response::setOutput(json_encode($json));
    }
    
    public function delete() {
        Lang::load('common/file_manager');
        
        $json = array();
        
        if (isset($this->request->post['path'])) {
            $path = rtrim(Config::get('path.image') . 'data/' . str_replace('../', '', html_entity_decode($this->request->post['path'], ENT_QUOTES, 'UTF-8')), '/');
            
            if (!file_exists($path)) {
                $json['error'] = Lang::get('lang_error_select');
            }
            
            if ($path == rtrim(Config::get('path.image') . 'data/', '/')) {
                $json['error'] = Lang::get('lang_error_delete');
            }
        } else {
            $json['error'] = Lang::get('lang_error_select');
        }
        
        if (!User::hasPermission('modify', 'common/file_manager')) {
            $json['error'] = Lang::get('lang_error_permission');
        }
        
        if (!isset($json['error'])) {
            if (is_file($path)) {
                unlink($path);
            } elseif (is_dir($path)) {
                $files = array();
                
                $path = array($path . '*');
                
                while (count($path) != 0) {
                    $next = array_shift($path);
                    
                    foreach (glob($next) as $file) {
                        if (is_dir($file)) {
                            $path[] = $file . '/*';
                        }
                        
                        $files[] = $file;
                    }
                }
                
                rsort($files);
                
                foreach ($files as $file) {
                    if (is_file($file)) {
                        unlink($file);
                    } elseif (is_dir($file)) {
                        rmdir($file);
                    }
                }
            }
            
            $json['success'] = Lang::get('lang_text_delete');
        }
        
        $json = Theme::listen(__CLASS__, __FUNCTION__, $json);
        
        Response::setOutput(json_encode($json));
    }
    
    public function move() {
        Lang::load('common/file_manager');
        
        $json = array();
        
        if (isset($this->request->post['from']) && isset($this->request->post['to'])) {
            $from = rtrim(Config::get('path.image') . 'data/' . str_replace('../', '', html_entity_decode($this->request->post['from'], ENT_QUOTES, 'UTF-8')), '/');
            
            if (!file_exists($from)) {
                $json['error'] = Lang::get('lang_error_missing');
            }
            
            if ($from == Config::get('path.image') . 'data') {
                $json['error'] = Lang::get('lang_error_default');
            }
            
            $to = rtrim(Config::get('path.image') . 'data/' . str_replace('../', '', html_entity_decode($this->request->post['to'], ENT_QUOTES, 'UTF-8')), '/');
            
            if (!file_exists($to)) {
                $json['error'] = Lang::get('lang_error_move');
            }
            
            if (file_exists($to . '/' . basename($from))) {
                $json['error'] = Lang::get('lang_error_exists');
            }
        } else {
            $json['error'] = Lang::get('lang_error_directory');
        }
        
        if (!User::hasPermission('modify', 'common/file_manager')) {
            $json['error'] = Lang::get('lang_error_permission');
        }
        
        if (!isset($json['error'])) {
            rename($from, $to . '/' . basename($from));
            
            $json['success'] = Lang::get('lang_text_move');
        }
        
        $json = Theme::listen(__CLASS__, __FUNCTION__, $json);
        
        Response::setOutput(json_encode($json));
    }
    
    public function copy() {
        Lang::load('common/file_manager');
        
        $json = array();
        
        if (isset($this->request->post['path']) && isset($this->request->post['name'])) {
            if ((Encode::strlen($this->request->post['name']) < 3) || (Encode::strlen($this->request->post['name']) > 255)) {
                $json['error'] = Lang::get('lang_error_filename');
            }
            
            $old_name = rtrim(Config::get('path.image') . 'data/' . str_replace('../', '', html_entity_decode($this->request->post['path'], ENT_QUOTES, 'UTF-8')), '/');
            
            if (!file_exists($old_name) || $old_name == Config::get('path.image') . 'data') {
                $json['error'] = Lang::get('lang_error_copy');
            }
            
            if (is_file($old_name)) {
                $ext = strrchr($old_name, '.');
            } else {
                $ext = '';
            }
            
            $new_name = dirname($old_name) . '/' . str_replace('../', '', html_entity_decode($this->request->post['name'], ENT_QUOTES, 'UTF-8') . $ext);
            
            if (file_exists($new_name)) {
                $json['error'] = Lang::get('lang_error_exists');
            }
        } else {
            $json['error'] = Lang::get('lang_error_select');
        }
        
        if (!User::hasPermission('modify', 'common/file_manager')) {
            $json['error'] = Lang::get('lang_error_permission');
        }
        
        if (!isset($json['error'])) {
            if (is_file($old_name)) {
                copy($old_name, $new_name);
            } else {
                $this->recursiveCopy($old_name, $new_name);
            }
            
            $json['success'] = Lang::get('lang_text_copy');
        }
        
        $json = Theme::listen(__CLASS__, __FUNCTION__, $json);
        
        Response::setOutput(json_encode($json));
    }
    
    function recursiveCopy($source, $destination) {
        $directory = opendir($source);
        
        @mkdir($destination);
        
        while (false !== ($file = readdir($directory))) {
            if (($file != '.') && ($file != '..')) {
                if (is_dir($source . '/' . $file)) {
                    $this->recursiveCopy($source . '/' . $file, $destination . '/' . $file);
                } else {
                    copy($source . '/' . $file, $destination . '/' . $file);
                }
            }
        }
        
        closedir($directory);
    }
    
    public function folders() {
        Response::setOutput($this->recursiveFolders(Config::get('path.image') . 'data/'));
    }
    
    protected function recursiveFolders($directory) {
        $output = '';
        
        $output.= '<option value="' . Encode::substr($directory, strlen(Config::get('path.image') . 'data/')) . '">' . Encode::substr($directory, strlen(Config::get('path.image') . 'data/')) . '</option>';
        
        $directories = glob(rtrim(str_replace('../', '', $directory), '/') . '/*', GLOB_ONLYDIR);
        
        foreach ($directories as $directory) {
            $output.= $this->recursiveFolders($directory);
        }
        
        return $output;
    }
    
    public function rename() {
        Lang::load('common/file_manager');
        
        $json = array();
        
        if (isset($this->request->post['path']) && isset($this->request->post['name'])) {
            if ((Encode::strlen($this->request->post['name']) < 3) || (Encode::strlen($this->request->post['name']) > 255)) {
                $json['error'] = Lang::get('lang_error_filename');
            }
            
            $old_name = rtrim(Config::get('path.image') . 'data/' . str_replace('../', '', html_entity_decode($this->request->post['path'], ENT_QUOTES, 'UTF-8')), '/');
            
            if (!file_exists($old_name) || $old_name == Config::get('path.image') . 'data') {
                $json['error'] = Lang::get('lang_error_rename');
            }
            
            if (is_file($old_name)) {
                $ext = strrchr($old_name, '.');
            } else {
                $ext = '';
            }
            
            $new_name = dirname($old_name) . '/' . str_replace('../', '', html_entity_decode($this->request->post['name'], ENT_QUOTES, 'UTF-8') . $ext);
            
            if (file_exists($new_name)) {
                $json['error'] = Lang::get('lang_error_exists');
            }
        }
        
        if (!User::hasPermission('modify', 'common/file_manager')) {
            $json['error'] = Lang::get('lang_error_permission');
        }
        
        if (!isset($json['error'])) {
            rename($old_name, $new_name);
            
            $json['success'] = Lang::get('lang_text_rename');
        }
        
        $json = Theme::listen(__CLASS__, __FUNCTION__, $json);
        
        Response::setOutput(json_encode($json));
    }
    
    public function upload() {
        Lang::load('common/file_manager');
        
        $json = array();
        
        if (isset($this->request->post['directory'])) {
            if (isset($this->request->files['image']) && $this->request->files['image']['tmp_name']) {
                $filename = basename(html_entity_decode($this->request->files['image']['name'], ENT_QUOTES, 'UTF-8'));
                
                if ((strlen($filename) < 3) || (strlen($filename) > 255)) {
                    $json['error'] = Lang::get('lang_error_filename');
                }
                
                $directory = rtrim(Config::get('path.image') . 'data/' . str_replace('../', '', $this->request->post['directory']), '/');
                
                if (!is_dir($directory)) {
                    $json['error'] = Lang::get('lang_error_directory');
                }
                
                if ($this->request->files['image']['size'] > 300000000) {
                    $json['error'] = Lang::get('lang_error_file_size');
                }
                
                $allowed = array('image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png', 'image/gif', 'application/x-shockwave-flash');
                
                if (!in_array($this->request->files['image']['type'], $allowed)) {
                    $json['error'] = Lang::get('lang_error_file_type');
                }
                
                $allowed = array('.jpg', '.jpeg', '.gif', '.png', '.flv');
                
                if (!in_array(strtolower(strrchr($filename, '.')), $allowed)) {
                    $json['error'] = Lang::get('lang_error_file_type');
                }
                
                // Check to see if any PHP files are trying to be uploaded
                $content = file_get_contents($this->request->files['image']['tmp_name']);
                
                if (preg_match('/\<\?php/i', $content)) {
                    $json['error'] = Lang::get('lang_error_file_type');
                }
                
                if ($this->request->files['image']['error'] != UPLOAD_ERR_OK) {
                    $json['error'] = 'error_upload_' . $this->request->files['image']['error'];
                }
            } else {
                $json['error'] = Lang::get('lang_error_file');
            }
        } else {
            $json['error'] = Lang::get('lang_error_directory');
        }
        
        if (!User::hasPermission('modify', 'common/file_manager')) {
            $json['error'] = Lang::get('lang_error_permission');
        }
        
        if (!isset($json['error'])) {
            if (@move_uploaded_file($this->request->files['image']['tmp_name'], $directory . '/' . $filename)) {
                $json['success'] = Lang::get('lang_text_uploaded');
            } else {
                $json['error'] = Lang::get('lang_error_uploaded');
            }
        }
        
        $json = Theme::listen(__CLASS__, __FUNCTION__, $json);
        
        Response::setOutput(json_encode($json));
    }
    
    public function editor_upload() {
        Lang::load('common/file_manager');
        
        $json = array();
        
        if (isset($this->request->post['directory'])) {
            if (isset($this->request->files['image']) && $this->request->files['image']['tmp_name']) {
                $filename = basename(html_entity_decode($this->request->files['image']['name'], ENT_QUOTES, 'UTF-8'));
                
                if ((strlen($filename) < 3) || (strlen($filename) > 255)) {
                    $json['error'] = Lang::get('lang_error_filename');
                }
                
                $directory = rtrim(Config::get('path.image') . 'data/' . str_replace('../', '', $this->request->post['directory']), '/');
                
                if (!is_dir($directory)) {
                    $json['error'] = Lang::get('lang_error_directory');
                }
                
                if ($this->request->files['image']['size'] > 300000) {
                    $json['error'] = Lang::get('lang_error_file_size');
                }
                
                $allowed = array('image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png', 'image/gif', 'application/x-shockwave-flash');
                
                if (!in_array($this->request->files['image']['type'], $allowed)) {
                    $json['error'] = Lang::get('lang_error_file_type');
                }
                
                $allowed = array('.jpg', '.jpeg', '.gif', '.png', '.flv');
                
                if (!in_array(strtolower(strrchr($filename, '.')), $allowed)) {
                    $json['error'] = Lang::get('lang_error_file_type');
                }
                
                // Check to see if any PHP files are trying to be uploaded
                $content = file_get_contents($this->request->files['image']['tmp_name']);
                
                if (preg_match('/\<\?php/i', $content)) {
                    $json['error'] = Lang::get('lang_error_file_type');
                }
                
                if ($this->request->files['image']['error'] != UPLOAD_ERR_OK) {
                    $json['error'] = 'error_upload_' . $this->request->files['image']['error'];
                }
            } else {
                $json['error'] = Lang::get('lang_error_file');
            }
        } else {
            $json['error'] = Lang::get('lang_error_directory');
        }
        
        if (!User::hasPermission('modify', 'common/file_manager')) {
            $json['error'] = Lang::get('lang_error_permission');
        }
        
        if (!isset($json['error'])) {
            if (@move_uploaded_file($this->request->files['image']['tmp_name'], $directory . '/' . $filename)) {
                $json['success'] = PUBLIC_IMAGE . $this->request->post['directory'] . '/' . $filename;
            } else {
                $json['error'] = Lang::get('lang_error_uploaded');
            }
        }
        
        $json = Theme::listen(__CLASS__, __FUNCTION__, $json);
        
        Response::setOutput(json_encode($json));
    }
}
