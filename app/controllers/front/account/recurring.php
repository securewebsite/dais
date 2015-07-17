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

class Recurring extends Controller {
    
    public function index() {
        if (!Customer::isLogged()):
            Session::p()->data['redirect'] = Url::link('account/order', '', 'SSL');
            Response::redirect(Url::link('account/login', '', 'SSL'));
        endif;
        
        $data = Theme::language('account/recurring');
        Theme::model('account/recurring');
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        $url = '';
        
        if (isset(Request::p()->get['page'])):
            $url.= '&page=' . Request::p()->get['page'];
        endif;
        
        Breadcrumb::add('lang_text_account', 'account/dashboard', $url, true, 'SSL');
        Breadcrumb::add('lang_heading_title', 'account/recurring', $url, true, 'SSL');
        
        if (isset(Request::p()->get['page'])):
            $page = Request::p()->get['page'];
        else:
            $page = 1;
        endif;
        
        $data['orders'] = array();
        
        $recurring_total = AccountRecurring::getTotalRecurring();
        $results = AccountRecurring::getAllRecurring(($page - 1) * 10, 10);
        
        $data['recurrings'] = array();
        
        if ($results):
            foreach ($results as $result):
                $data['recurrings'][] = array('id' => $result['order_recurring_id'], 'name' => $result['product_name'], 'status' => $result['status'], 'date_added' => date(Lang::get('lang_date_format_short'), strtotime($result['date_added'])), 'href' => Url::link('account/recurring/info', 'recurring_id=' . $result['order_recurring_id'], 'SSL'),);
            endforeach;
        endif;
        
        $data['status_types'] = array(1 => Lang::get('lang_text_status_inactive'), 2 => Lang::get('lang_text_status_active'), 3 => Lang::get('lang_text_status_suspended'), 4 => Lang::get('lang_text_status_cancelled'), 5 => Lang::get('lang_text_status_expired'), 6 => Lang::get('lang_text_status_pending'),);
        
        $data['pagination'] = Theme::paginate($recurring_total, $page, 10, Lang::get('lang_text_pagination'), Url::link('account/recurring', 'page={page}', 'SSL'));
        
        $data['continue'] = Url::link('account/account', '', 'SSL');
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        Theme::setController('header', 'shop/header');
        Theme::setController('footer', 'shop/footer');
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::render('account/recurring_list', $data));
    }
    
    public function info() {
        $data = Theme::language('account/recurring');
        Theme::model('account/recurring');
        
        if (isset(Request::p()->get['recurring_id'])):
            $recurring_id = Request::p()->get['recurring_id'];
        else:
            $recurring_id = 0;
        endif;
        
        if (!Customer::isLogged()):
            Session::p()->data['redirect'] = Url::link('account/recurring/info', 'recurring_id=' . $recurring_id, 'SSL');
            Response::redirect(Url::link('account/login', '', 'SSL'));
        endif;
        
        if (isset(Session::p()->data['error'])):
            $data['error_warning'] = Session::p()->data['error'];
            unset(Session::p()->data['error']);
        else:
            $data['error_warning'] = '';
        endif;
        
        if (isset(Session::p()->data['success'])):
            $data['success'] = Session::p()->data['success'];
            unset(Session::p()->data['success']);
        else:
            $data['success'] = '';
        endif;
        
        $recurring = AccountRecurring::getRecurring(Request::p()->get['recurring_id']);
        
        $data['status_types'] = array(1 => Lang::get('lang_text_status_inactive'), 2 => Lang::get('lang_text_status_active'), 3 => Lang::get('lang_text_status_suspended'), 4 => Lang::get('lang_text_status_cancelled'), 5 => Lang::get('lang_text_status_expired'), 6 => Lang::get('lang_text_status_pending'),);
        
        $data['transaction_types'] = array(0 => Lang::get('lang_text_transaction_date_added'), 1 => Lang::get('lang_text_transaction_payment'), 2 => Lang::get('lang_text_transaction_outstanding_payment'), 3 => Lang::get('lang_text_transaction_skipped'), 4 => Lang::get('lang_text_transaction_failed'), 5 => Lang::get('lang_text_transaction_cancelled'), 6 => Lang::get('lang_text_transaction_suspended'), 7 => Lang::get('lang_text_transaction_suspended_failed'), 8 => Lang::get('lang_text_transaction_outstanding_failed'), 9 => Lang::get('lang_text_transaction_expired'),);
        
        if ($recurring):
            $recurring['transactions'] = AccountRecurring::getRecurringTransactions(Request::p()->get['recurring_id']);
            $recurring['date_added'] = date(Lang::get('lang_date_format_short'), strtotime($recurring['date_added']));
            $recurring['product_link'] = Url::link('product/product', 'product_id=' . $recurring['product_id'], 'SSL');
            $recurring['order_link'] = Url::link('account/order/info', 'order_id=' . $recurring['order_id'], 'SSL');
            
            Theme::setTitle(Lang::get('lang_text_recurring'));
            
            Breadcrumb::add('lang_text_account', 'account/dashboard', '', true, 'SSL');
            
            $url = '';
            
            if (isset(Request::p()->get['page'])):
                $url.= '&page=' . Request::p()->get['page'];
            endif;
            
            Breadcrumb::add('lang_heading_title', 'account/recurring', $url, true, 'SSL');
            Breadcrumb::add('lang_text_recurring', 'account/recurring/info', 'recurring_id=' . Request::p()->get['recurring_id'] . $url, true, 'SSL');
            
            $data['recurring'] = $recurring;
            
            Theme::loadjs('javascript/account/recurring_info', $data);
            
            $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
            
            Theme::setController('header', 'shop/header');
            Theme::setController('footer', 'shop/footer');
            Theme::setController('buttons', 'payment/' . $recurring['payment_code'] . '/recurringButtons');
            
            $data = Theme::renderControllers($data);
            
            Response::setOutput(View::render('account/recurring_info', $data));
        else:
            Response::redirect(Url::link('account/recurring', '', 'SSL'));
        endif;
    }
}
