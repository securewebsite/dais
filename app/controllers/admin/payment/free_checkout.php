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

namespace App\Controllers\Admin\Payment;

use App\Controllers\Controller;

class FreeCheckout extends Controller {
    
    private $error = array();
    
    public function index() {
        $data = Theme::language('payment/free_checkout');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('setting/setting');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            SettingSetting::editSetting('free_checkout', Request::post());
            Session::p()->data['success'] = Lang::get('lang_text_success');
            
            Response::redirect(Url::link('module/payment', '', 'SSL'));
        }
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        Breadcrumb::add('lang_text_payment', 'module/payment');
        Breadcrumb::add('lang_heading_title', 'payment/free_checkout');
        
        $data['action'] = Url::link('payment/free_checkout', '', 'SSL');
        
        $data['cancel'] = Url::link('module/payment', '', 'SSL');
        
        if (isset(Request::p()->post['free_checkout_order_status_id'])) {
            $data['free_checkout_order_status_id'] = Request::p()->post['free_checkout_order_status_id'];
        } else {
            $data['free_checkout_order_status_id'] = Config::get('free_checkout_order_status_id');
        }
        
        Theme::model('locale/order_status');
        
        $data['order_statuses'] = LocaleOrderStatus::getOrderStatuses();
        
        if (isset(Request::p()->post['free_checkout_status'])) {
            $data['free_checkout_status'] = Request::p()->post['free_checkout_status'];
        } else {
            $data['free_checkout_status'] = Config::get('free_checkout_status');
        }
        
        if (isset(Request::p()->post['free_checkout_sort_order'])) {
            $data['free_checkout_sort_order'] = Request::p()->post['free_checkout_sort_order'];
        } else {
            $data['free_checkout_sort_order'] = Config::get('free_checkout_sort_order');
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('payment/free_checkout', $data));
    }
    
    protected function validate() {
        if (!User::hasPermission('modify', 'payment/free_checkout')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
