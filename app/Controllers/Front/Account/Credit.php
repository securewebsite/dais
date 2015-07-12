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

class Credit extends Controller {
    public function index() {
        if (!$this->customer->isLogged()):
            $this->session->data['redirect'] = Url::link('account/credit', '', 'SSL');
            $this->response->redirect(Url::link('account/login', '', 'SSL'));
        endif;
        
        $data = Theme::language('account/credit');
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Breadcrumb::add('lang_text_account', 'account/dashboard', null, true, 'SSL');
        Breadcrumb::add('lang_text_transaction', 'account/credit', null, true, 'SSL');
        
        Theme::model('account/credit');
        
        $data['column_amount'] = sprintf(Lang::get('lang_column_amount'), Config::get('config_currency'));
        
        if (isset($this->request->get['page'])):
            $page = $this->request->get['page'];
        else:
            $page = 1;
        endif;
        
        $data['credits'] = array();
        
        $filter = array(
            'sort'  => 'date_added', 
            'order' => 'DESC', 
            'start' => ($page - 1) * 10, 
            'limit' => 10
        );
        
        $credit_total = $this->model_account_credit->getTotalCredits($filter);
        $results      = $this->model_account_credit->getCredits($filter);
        
        foreach ($results as $result) {
            $data['credits'][] = array(
                'amount'      => $this->currency->format($result['amount'], Config::get('config_currency')), 
                'description' => $result['description'], 
                'date_added'  => date(Lang::get('lang_date_format_short'), strtotime($result['date_added']))
            );
        }
        
        $data['pagination'] = Theme::paginate(
            $credit_total, 
            $page, 10, 
            Lang::get('lang_text_pagination'), 
            Url::link('account/credit', 'page={page}', 'SSL')
        );
        
        $data['total']    = $this->currency->format($this->customer->getBalance());
        $data['continue'] = Url::link('account/dashboard', '', 'SSL');
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        Theme::set_controller('header', 'shop/header');
        Theme::set_controller('footer', 'shop/footer');
        
        $data = Theme::render_controllers($data);
        
        $this->response->setOutput(Theme::view('account/credit', $data));
    }
}
