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

namespace App\Controllers\Admin\Tool;

use App\Controllers\Controller;

class ErrorLog extends Controller {
    
    public function index() {
        $data = Theme::language('tool/error_log');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        if (isset(Session::p()->data['success'])) {
            $data['success'] = Session::p()->data['success'];
            
            unset(Session::p()->data['success']);
        } else {
            $data['success'] = '';
        }
        
        Breadcrumb::add('lang_heading_title', 'tool/error_log');
        
        $data['clear'] = Url::link('tool/error_log/clear', '', 'SSL');
        
        $file = Config::get('path.logs') . Config::get('config_error_filename');
        
        if (file_exists($file)) {
            $data['log'] = file_get_contents($file, FILE_USE_INCLUDE_PATH, null);
        } else {
            $data['log'] = '';
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::render('tool/error_log', $data));
    }
    
    public function clear() {
        Lang::load('tool/error_log');
        
        $file = Config::get('path.logs') . Config::get('config_error_filename');
        
        $handle = fopen($file, 'w+');
        
        fclose($handle);
        
        Session::p()->data['success'] = Lang::get('lang_text_success');
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        Response::redirect(Url::link('tool/error_log', '', 'SSL'));
    }
}
