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

namespace Admin\Controller\Widget;
use Dais\Base\Controller;

class Event extends Controller {
    
    private $error = array();
    
    public function index() {
        $data = Theme::language('widget/event');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('setting/setting');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('event', $this->request->post);
            $this->session->data['success'] = Lang::get('lang_text_success');
            Response::redirect(Url::link('module/widget', 'token=' . $this->session->data['token'], 'SSL'));
        }
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        Breadcrumb::add('lang_text_widget', 'module/widget');
        Breadcrumb::add('lang_heading_title', 'widget/event');
        
        $data['action'] = Url::link('widget/event', 'token=' . $this->session->data['token'], 'SSL');
        $data['cancel'] = Url::link('module/widget', 'token=' . $this->session->data['token'], 'SSL');
        
        $data['widgets'] = array();
        
        if (isset($this->request->post['event_widget'])) {
            $data['widgets'] = $this->request->post['event_widget'];
        } elseif (Config::get('event_widget')) {
            $data['widgets'] = Config::get('event_widget');
        }
        
        Theme::model('design/layout');
        
        $data['layouts'] = $this->model_design_layout->getLayouts();
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        Theme::loadjs('javascript/widget/event', $data);
        
        $data = Theme::render_controllers($data);
        
        Response::setOutput(Theme::view('widget/event', $data));
    }
    
    private function validate() {
        if (!User::hasPermission('modify', 'widget/event')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        return !$this->error;
    }
}
