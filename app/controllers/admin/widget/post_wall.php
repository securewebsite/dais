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

namespace App\Controllers\Admin\Widget;

use App\Controllers\Controller;

class PostWall extends Controller {
    
    private $error = array();
    
    public function index() {
        $data = Theme::language('widget/post_wall');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('setting/setting');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            SettingSetting::editSetting('post_wall_widget', $this->request->post);
            Cache::delete('posts.masonry');
            $this->session->data['success'] = Lang::get('lang_text_success');
            
            if (!empty($this->request->get['continue'])) {
                Response::redirect(Url::link('widget/post_wall', '', 'SSL'));
            } else {
                Response::redirect(Url::link('module/widget', '', 'SSL'));
            }
        }
        
        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];
            
            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        if (isset($this->error['asterisk'])) {
            $data['error_asterisk'] = $this->error['asterisk'];
        } else {
            $data['error_asterisk'] = array();
        }
        
        Breadcrumb::add('lang_text_widget', 'module/widget');
        Breadcrumb::add('lang_heading_title', 'widget/post_wall');
        
        $data['action'] = Url::link('widget/post_wall', '', 'SSL');
        $data['cancel'] = Url::link('module/widget', '', 'SSL');
        
        $data['widgets'] = array();
        
        if (isset($this->request->post['post_wall_widget'])) {
            $data['widgets'] = $this->request->post['post_wall_widget'];
        } elseif (Config::get('post_wall_widget')) {
            $data['widgets'] = Config::get('post_wall_widget');
        }
        
        $data['post_types'] = array('latest' => Lang::get('lang_text_latest'), 'featured' => Lang::get('lang_text_featured'));
        
        Theme::model('design/layout');
        
        $data['layouts'] = DesignLayout::getLayouts();
        
        Theme::loadjs('javascript/widget/post_wall', $data);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::render('widget/post_wall', $data));
    }
    
    private function validate() {
        if (!User::hasPermission('modify', 'widget/post_wall')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        if (isset($this->request->post['post_wall_widget'])) {
            foreach ($this->request->post['post_wall_widget'] as $key => $value) {
                if ($value['span'] == 1 && $value['description']) {
                    $this->error['asterisk'][$key]['description'] = Lang::get('lang_error_asterisk');
                }
                
                if ($value['span'] == 1 && $value['button']) {
                    $this->error['asterisk'][$key]['button'] = Lang::get('lang_error_asterisk');
                }
            }
        }
        
        if ($this->error && !isset($this->error['warning'])) {
            $this->error['warning'] = Lang::get('lang_error_span');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
