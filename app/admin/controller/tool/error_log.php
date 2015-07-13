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
use Dais\Base\Controller;

class ErrorLog extends Controller {
    
    public function index() {
        $data = Theme::language('tool/error_log');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];
            
            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }
        
        Breadcrumb::add('lang_heading_title', 'tool/error_log');
        
        $data['clear'] = Url::link('tool/error_log/clear', 'token=' . $this->session->data['token'], 'SSL');
        
        $file = Config::get('path.logs') . Config::get('config_error_filename');
        
        if (file_exists($file)) {
            $data['log'] = file_get_contents($file, FILE_USE_INCLUDE_PATH, null);
        } else {
            $data['log'] = '';
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::render_controllers($data);
        
        Response::setOutput(Theme::view('tool/error_log', $data));
    }
    
    public function clear() {
        Lang::load('tool/error_log');
        
        $file = Config::get('path.logs') . Config::get('config_error_filename');
        
        $handle = fopen($file, 'w+');
        
        fclose($handle);
        
        $this->session->data['success'] = Lang::get('lang_text_success');
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        Response::redirect(Url::link('tool/error_log', 'token=' . $this->session->data['token'], 'SSL'));
    }
}
