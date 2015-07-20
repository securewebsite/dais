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

class BankTransfer extends Controller {
    
    public function index() {
        $data = Theme::language('payment/bank_transfer');
        
        $data['bank'] = nl2br(Config::get('bank_transfer_bank_' . Config::get('config_language_id')));
        
        $data['continue'] = Url::link('checkout/success');
        
        Theme::loadjs('javascript/payment/bank_transfer', $data);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data['javascript'] = Theme::controller('common/javascript');
        
        return View::make('payment/bank_transfer', $data);
    }
    
    public function confirm() {
        $data = Theme::language('payment/bank_transfer');
        
        Theme::model('checkout/order');
        
        $comment = Lang::get('lang_text_instruction') . "\n\n";
        $comment.= Config::get('bank_transfer_bank_' . Config::get('config_language_id')) . "\n\n";
        $comment.= Lang::get('lang_text_payment');
        
        $data['comment'] = $comment;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        CheckoutOrder::confirm(Session::p()->data['order_id'], Config::get('bank_transfer_order_status_id'), $data['comment'], true);
    }
}
