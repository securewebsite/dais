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

namespace App\Controllers\Front\Payment;

use App\Controllers\Controller;

class Check extends Controller {
    
    public function index() {
        $data = Theme::language('payment/check');
        
        $data['payable'] = Config::get('check_payable');
        $data['address'] = nl2br(Config::get('config_address'));
        
        $data['continue'] = Url::link('checkout/success');
        
        Theme::loadjs('javascript/payment/check', $data);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data['javascript'] = Theme::controller('common/javascript');
        
        return View::render('payment/check', $data);
    }
    
    public function confirm() {
        $data = Theme::language('payment/check');
        
        Theme::model('checkout/order');
        
        $comment = Lang::get('lang_text_payable') . "\n";
        $comment.= Config::get('check_payable') . "\n\n";
        $comment.= Lang::get('lang_text_address') . "\n";
        $comment.= Config::get('config_address') . "\n\n";
        $comment.= Lang::get('lang_text_payment') . "\n";
        
        $data['comment'] = $comment;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        CheckoutOrder::confirm(Session::p()->data['order_id'], Config::get('check_order_status_id'), $data['comment'], true);
    }
}
