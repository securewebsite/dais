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

class BlogHotTopics extends Controller {
    
    private $error = array();
    
    public function index() {
        $data = Theme::language('widget/blog_hot_topics');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('setting/setting');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            SettingSetting::editSetting('blog_hot_topics', Request::post());
            Session::p()->data['success'] = Lang::get('lang_text_success');
            
            Response::redirect(Url::link('module/widget', '', 'SSL'));
        }
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        Breadcrumb::add('lang_text_widget', 'module/widget');
        Breadcrumb::add('lang_heading_title', 'widget/blog_hot_topics');
        
        $data['action'] = Url::link('widget/blog_hot_topics', '', 'SSL');
        $data['cancel'] = Url::link('module/widget', '', 'SSL');
        
        $data['widgets'] = array();
        
        if (isset(Request::p()->post['blog_hot_topics_widget'])) {
            $data['widgets'] = Request::p()->post['blog_hot_topics_widget'];
        } elseif (Config::get('blog_hot_topics_widget')) {
            $data['widgets'] = Config::get('blog_hot_topics_widget');
        }
        
        Theme::model('design/layout');
        
        $data['layouts'] = DesignLayout::getLayouts();
        
        Theme::loadjs('javascript/widget/blog_hot_topics', $data);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::render('widget/blog_hot_topics', $data));
    }
    
    private function validate() {
        if (!User::hasPermission('modify', 'widget/blog_hot_topics')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
