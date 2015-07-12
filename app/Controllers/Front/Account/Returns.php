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


namespace App\Controllers\Front\Account;
use App\Controllers\Controller;
use Front\Controller\Tool\Captcha as Captcha;

class Returns extends Controller {
    private $error = array();
    
    public function index() {
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = Url::link('account/returns', '', 'SSL');
            
            $this->response->redirect(Url::link('account/login', '', 'SSL'));
        }
        
        $data = Theme::language('account/returns');
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Breadcrumb::add('lang_text_account', 'account/dashboard', null, true, 'SSL');
        
        $url = '';
        
        if (isset($this->request->get['page'])) {
            $url.= '&page=' . $this->request->get['page'];
        }
        
        Breadcrumb::add('lang_heading_title', 'account/returns', $url, true, 'SSL');
        
        Theme::model('account/returns');
        
        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }
        
        $data['returns'] = array();
        
        $return_total = $this->model_account_returns->getTotalReturns();
        
        $results = $this->model_account_returns->getReturns(($page - 1) * 10, 10);
        
        foreach ($results as $result) {
            $data['returns'][] = array(
                'return_id'  => $result['return_id'], 
                'order_id'   => $result['order_id'], 
                'name'       => $result['firstname'] . ' ' . $result['lastname'], 
                'status'     => $result['status'], 
                'date_added' => date(Lang::get('lang_date_format_short'), strtotime($result['date_added'])), 
                'href'       => Url::link('account/returns/info', 'return_id=' . $result['return_id'] . $url, 'SSL')
            );
        }
        
        $data['pagination'] = Theme::paginate(
            $return_total, 
            $page, 
            Config::get('config_catalog_limit'), 
            Lang::get('lang_text_pagination'), 
            Url::link('account/history', 'page={page}', 'SSL')
        );
        
        $data['continue'] = Url::link('account/dashboard', '', 'SSL');
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        Theme::set_controller('header', 'shop/header');
        Theme::set_controller('footer', 'shop/footer');
        
        $data = Theme::render_controllers($data);
        
        $this->response->setOutput(Theme::view('account/return_list', $data));
    }
    
    public function info() {
        $data = Theme::language('account/returns');
        
        if (isset($this->request->get['return_id'])) {
            $return_id = $this->request->get['return_id'];
        } else {
            $return_id = 0;
        }
        
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = Url::link('account/returns/info', 'return_id=' . $return_id, 'SSL');
            
            $this->response->redirect(Url::link('account/login', '', 'SSL'));
        }
        
        Theme::model('account/returns');
        
        $return_info = $this->model_account_returns->getReturn($return_id);
        
        if ($return_info) {
            Theme::setTitle(Lang::get('lang_text_return'));
            
            Breadcrumb::add('lang_text_account', 'account/dashboard', null, true, 'SSL');
            
            $url = '';
            
            if (isset($this->request->get['page'])) {
                $url.= '&page=' . $this->request->get['page'];
            }
            
            Breadcrumb::add('lang_heading_title', 'account/returns', $url, true, 'SSL');
            Breadcrumb::add('lang_text_return', 'account/returns/info', 'return_id=' . $this->request->get['return_id'] . $url, true, 'SSL');
            
            $data['return_id']    = $return_info['return_id'];
            $data['order_id']     = $return_info['order_id'];
            $data['date_ordered'] = date(Lang::get('lang_date_format_short'), strtotime($return_info['date_ordered']));
            $data['date_added']   = date(Lang::get('lang_date_format_short'), strtotime($return_info['date_added']));
            $data['firstname']    = $return_info['firstname'];
            $data['lastname']     = $return_info['lastname'];
            $data['email']        = $return_info['email'];
            $data['telephone']    = $return_info['telephone'];
            $data['product']      = $return_info['product'];
            $data['model']        = $return_info['model'];
            $data['quantity']     = $return_info['quantity'];
            $data['reason']       = $return_info['reason'];
            $data['opened']       = $return_info['opened'] ? Lang::get('lang_text_yes') : Lang::get('lang_text_no');
            $data['comment']      = nl2br($return_info['comment']);
            $data['action']       = $return_info['action'];
            
            $data['histories'] = array();
            
            $results = $this->model_account_returns->getReturnHistories($this->request->get['return_id']);
            
            foreach ($results as $result) {
                $data['histories'][] = array(
                    'date_added' => date(Lang::get('lang_date_format_short'), strtotime($result['date_added'])), 
                    'status' => $result['status'], 
                    'comment' => nl2br($result['comment'])
                );
            }
            
            $data['continue'] = Url::link('account/returns', $url, 'SSL');
            
            $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
            
            Theme::set_controller('header', 'shop/header');
            Theme::set_controller('footer', 'shop/footer');
            
            $data = Theme::render_controllers($data);
            
            $this->response->setOutput(Theme::view('account/return_info', $data));
        } else {
            Theme::setTitle(Lang::get('lang_text_return'));
            
            Breadcrumb::add('lang_text_account', 'account/dashboard', null, true, 'SSL');
            Breadcrumb::add('lang_heading_title', 'account/returns', null, true, 'SSL');
            
            $url = '';
            
            if (isset($this->request->get['page'])) {
                $url.= '&page=' . $this->request->get['page'];
            }
            
            Breadcrumb::add('lang_text_return', 'account/returns/info', 'return_id=' . $return_id . $url, true, 'SSL');
            
            $data['heading_title'] = Lang::get('lang_text_return');
            $data['continue'] = Url::link('account/returns', '', 'SSL');
            
            $this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . '/1.1 404 Not Found');
            
            $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
            
            Theme::set_controller('header', 'shop/header');
            Theme::set_controller('footer', 'shop/footer');
            
            $data = Theme::render_controllers($data);
            
            $this->response->setOutput(Theme::view('error/not_found', $data));
        }
    }
    
    public function insert() {
        $data = Theme::language('account/returns');
        Theme::model('account/returns');
        
        JS::register('datetimepicker.min', 'bootstrap.min');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            unset($this->session->data['captcha']);
            $this->model_account_returns->addReturn($this->request->post);
            
            $this->response->redirect(Url::link('account/returns/success', '', 'SSL'));
        }
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Breadcrumb::add('lang_text_account', 'account/dashboard', null, true, 'SSL');
        Breadcrumb::add('lang_heading_title', 'account/returns/insert', null, true, 'SSL');
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        if (isset($this->error['order_id'])) {
            $data['error_order_id'] = $this->error['order_id'];
        } else {
            $data['error_order_id'] = '';
        }
        
        if (isset($this->error['firstname'])) {
            $data['error_firstname'] = $this->error['firstname'];
        } else {
            $data['error_firstname'] = '';
        }
        
        if (isset($this->error['lastname'])) {
            $data['error_lastname'] = $this->error['lastname'];
        } else {
            $data['error_lastname'] = '';
        }
        
        if (isset($this->error['email'])) {
            $data['error_email'] = $this->error['email'];
        } else {
            $data['error_email'] = '';
        }
        
        if (isset($this->error['telephone'])) {
            $data['error_telephone'] = $this->error['telephone'];
        } else {
            $data['error_telephone'] = '';
        }
        
        if (isset($this->error['product'])) {
            $data['error_product'] = $this->error['product'];
        } else {
            $data['error_product'] = '';
        }
        
        if (isset($this->error['model'])) {
            $data['error_model'] = $this->error['model'];
        } else {
            $data['error_model'] = '';
        }
        
        if (isset($this->error['reason'])) {
            $data['error_reason'] = $this->error['reason'];
        } else {
            $data['error_reason'] = '';
        }
        
        if (isset($this->error['captcha'])) {
            $data['error_captcha'] = $this->error['captcha'];
        } else {
            $data['error_captcha'] = '';
        }
        
        $data['action'] = Url::link('account/returns/insert', '', 'SSL');
        
        Theme::model('account/order');
        
        if (isset($this->request->get['order_id'])) {
            $order_info = $this->model_account_order->getOrder($this->request->get['order_id']);
        }
        
        Theme::model('catalog/product');
        
        if (isset($this->request->get['product_id'])) {
            $product_info = $this->model_catalog_product->getProduct($this->request->get['product_id']);
        }
        
        if (isset($this->request->post['order_id'])) {
            $data['order_id'] = $this->request->post['order_id'];
        } elseif (!empty($order_info)) {
            $data['order_id'] = $order_info['order_id'];
        } else {
            $data['order_id'] = '';
        }
        
        if (isset($this->request->post['date_ordered'])) {
            $data['date_ordered'] = $this->request->post['date_ordered'];
        } elseif (!empty($order_info)) {
            $data['date_ordered'] = date('Y-m-d', strtotime($order_info['date_added']));
        } else {
            $data['date_ordered'] = '';
        }
        
        if (isset($this->request->post['firstname'])) {
            $data['firstname'] = $this->request->post['firstname'];
        } elseif (!empty($order_info)) {
            $data['firstname'] = $order_info['firstname'];
        } else {
            $data['firstname'] = $this->customer->getFirstName();
        }
        
        if (isset($this->request->post['lastname'])) {
            $data['lastname'] = $this->request->post['lastname'];
        } elseif (!empty($order_info)) {
            $data['lastname'] = $order_info['lastname'];
        } else {
            $data['lastname'] = $this->customer->getLastName();
        }
        
        if (isset($this->request->post['email'])) {
            $data['email'] = $this->request->post['email'];
        } elseif (!empty($order_info)) {
            $data['email'] = $order_info['email'];
        } else {
            $data['email'] = $this->customer->getEmail();
        }
        
        if (isset($this->request->post['telephone'])) {
            $data['telephone'] = $this->request->post['telephone'];
        } elseif (!empty($order_info)) {
            $data['telephone'] = $order_info['telephone'];
        } else {
            $data['telephone'] = $this->customer->getTelephone();
        }
        
        if (isset($this->request->post['product'])) {
            $data['product'] = $this->request->post['product'];
        } elseif (!empty($product_info)) {
            $data['product'] = $product_info['name'];
        } else {
            $data['product'] = '';
        }
        
        if (isset($this->request->post['model'])) {
            $data['model'] = $this->request->post['model'];
        } elseif (!empty($product_info)) {
            $data['model'] = $product_info['model'];
        } else {
            $data['model'] = '';
        }
        
        if (isset($this->request->post['quantity'])) {
            $data['quantity'] = $this->request->post['quantity'];
        } else {
            $data['quantity'] = 1;
        }
        
        if (isset($this->request->post['opened'])) {
            $data['opened'] = $this->request->post['opened'];
        } else {
            $data['opened'] = false;
        }
        
        if (isset($this->request->post['return_reason_id'])) {
            $data['return_reason_id'] = $this->request->post['return_reason_id'];
        } else {
            $data['return_reason_id'] = '';
        }
        
        Theme::model('locale/return_reason');
        
        $data['return_reasons'] = $this->model_locale_return_reason->getReturnReasons();
        
        if (isset($this->request->post['comment'])) {
            $data['comment'] = $this->request->post['comment'];
        } else {
            $data['comment'] = '';
        }
        
        if (isset($this->request->post['captcha'])) {
            $data['captcha'] = $this->request->post['captcha'];
        } else {
            $data['captcha'] = '';
        }
        
        if (Config::get('config_return_id')) {
            Theme::model('content/page');
            
            $page_info = $this->model_content_page->getPage(Config::get('config_return_id'));
            
            if ($page_info) {
                $data['text_agree'] = sprintf(Lang::get('lang_text_agree'), Url::link('content/page/info', 'page_id=' . Config::get('config_return_id'), 'SSL'), $page_info['title'], $page_info['title']);
            } else {
                $data['text_agree'] = '';
            }
        } else {
            $data['text_agree'] = '';
        }
        
        if (isset($this->request->post['agree'])) {
            $data['agree'] = $this->request->post['agree'];
        } else {
            $data['agree'] = false;
        }
        
        if (!empty($order_info)):
            $data['back'] = Url::link('account/order/info', 'order_id=' . $order_info['order_id'], 'SSL');
        else:
            $data['back'] = '';
        endif;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        Theme::set_controller('header', 'shop/header');
        Theme::set_controller('footer', 'shop/footer');
        
        $data = Theme::render_controllers($data);
        
        $this->response->setOutput(Theme::view('account/return_form', $data));
    }
    
    public function success() {
        $data = Theme::language('account/returns');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Breadcrumb::add('lang_heading_title', 'account/returns', null, true, 'SSL');
        
        $data['continue']     = Url::link('shop/home');
        $data['text_message'] = Lang::get('lang_text_message');
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        Theme::set_controller('header', 'shop/header');
        Theme::set_controller('footer', 'shop/footer');
        
        $data = Theme::render_controllers($data);
        
        $this->response->setOutput(Theme::view('common/success', $data));
    }
    
    protected function validate() {
        if (!$this->request->post['order_id']) {
            $this->error['order_id'] = Lang::get('lang_error_order_id');
        }
        
        if (($this->encode->strlen($this->request->post['firstname']) < 1) || ($this->encode->strlen($this->request->post['firstname']) > 32)) {
            $this->error['firstname'] = Lang::get('lang_error_firstname');
        }
        
        if (($this->encode->strlen($this->request->post['lastname']) < 1) || ($this->encode->strlen($this->request->post['lastname']) > 32)) {
            $this->error['lastname'] = Lang::get('lang_error_lastname');
        }
        
        if (($this->encode->strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email'])) {
            $this->error['email'] = Lang::get('lang_error_email');
        }
        
        if (($this->encode->strlen($this->request->post['telephone']) < 3) || ($this->encode->strlen($this->request->post['telephone']) > 32)) {
            $this->error['telephone'] = Lang::get('lang_error_telephone');
        }
        
        if (($this->encode->strlen($this->request->post['product']) < 1) || ($this->encode->strlen($this->request->post['product']) > 255)) {
            $this->error['product'] = Lang::get('lang_error_product');
        }
        
        if (($this->encode->strlen($this->request->post['model']) < 1) || ($this->encode->strlen($this->request->post['model']) > 64)) {
            $this->error['model'] = Lang::get('lang_error_model');
        }
        
        if (empty($this->request->post['return_reason_id'])) {
            $this->error['reason'] = Lang::get('lang_error_reason');
        }
        
        if (empty($this->session->data['captcha']) || ($this->session->data['captcha'] != $this->request->post['captcha'])) {
            $this->error['captcha'] = Lang::get('lang_error_captcha');
        }
        
        if (Config::get('config_return_id')) {
            Theme::model('content/page');
            
            $page_info = $this->model_content_page->getPage(Config::get('config_return_id'));
            
            if ($page_info && !isset($this->request->post['agree'])) {
                $this->error['warning'] = sprintf(Lang::get('lang_error_agree'), $page_info['title']);
            }
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    public function captcha() {
        $captcha = new Captcha();
        
        $this->session->data['captcha'] = $captcha->getCode();
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $captcha->showImage();
    }
}
