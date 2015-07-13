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

class Masonry extends Controller {
    private $error = array();
    
    public function index() {
        $data = Theme::language('widget/masonry');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('setting/setting');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('masonry_widget', $this->request->post);
            $this->cache->delete('products.masonry');
            $this->session->data['success'] = Lang::get('lang_text_success');
            
            if (!empty($this->request->get['continue'])) {
                Response::redirect(Url::link('widget/masonry', 'token=' . $this->session->data['token'], 'SSL'));
            } else {
                Response::redirect(Url::link('module/widget', 'token=' . $this->session->data['token'], 'SSL'));
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
        
        $data['breadcrumbs'] = array();
        
        Breadcrumb::add('lang_text_widget', 'module/widget');
        Breadcrumb::add('lang_heading_title', 'widget/masonry');
        
        $data['action'] = Url::link('widget/masonry', 'token=' . $this->session->data['token'], 'SSL');
        $data['cancel'] = Url::link('module/widget', 'token=' . $this->session->data['token'], 'SSL');
        
        if (isset($this->request->post['masonry_cart'])) {
            $data['masonry_cart'] = $this->request->post['masonry_cart'];
        } else {
            $data['masonry_cart'] = Config::get('masonry_cart');
        }
        
        $data['widgets'] = array();
        
        if (isset($this->request->post['masonry_widget'])) {
            $data['widgets'] = $this->request->post['masonry_widget'];
        } elseif (Config::get('masonry_widget')) {
            $data['widgets'] = Config::get('masonry_widget');
        }
        
        $data['product_types'] = array('latest' => Lang::get('lang_text_latest'), 'featured' => Lang::get('lang_text_featured'), 'special' => Lang::get('lang_text_special'), 'best_seller' => Lang::get('lang_text_best_seller'));
        
        Theme::model('design/layout');
        
        $data['layouts'] = $this->model_design_layout->getLayouts();
        
        Theme::loadjs('javascript/widget/masonry', $data);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::render_controllers($data);
        
        Response::setOutput(Theme::view('widget/masonry', $data));
    }
    
    private function validate() {
        if (!User::hasPermission('modify', 'widget/masonry')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        if (isset($this->request->post['masonry_widget'])) {
            foreach ($this->request->post['masonry_widget'] as $key => $value) {
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
