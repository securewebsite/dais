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

class Reward extends Controller {
    
    public function index() {
        if (!Customer::isLogged()) {
            $this->session->data['redirect'] = Url::link('account/reward', '', 'SSL');
            
            Response::redirect(Url::link('account/login', '', 'SSL'));
        }
        
        $data = Theme::language('account/reward');
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Breadcrumb::add('lang_text_account', 'account/dashboard', null, true, 'SSL');
        Breadcrumb::add('lang_text_reward', 'account/reward', null, true, 'SSL');
        
        Theme::model('account/reward');
        
        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }
        
        $data['rewards'] = array();
        
        $filter = array('sort' => 'date_added', 'order' => 'DESC', 'start' => ($page - 1) * 10, 'limit' => 10);
        
        $reward_total = AccountReward::getTotalRewards($filter);
        
        $results = AccountReward::getRewards($filter);
        
        foreach ($results as $result) {
            $data['rewards'][] = array('order_id' => $result['order_id'], 'points' => $result['points'], 'description' => $result['description'], 'date_added' => date(Lang::get('lang_date_format_short'), strtotime($result['date_added'])), 'href' => Url::link('account/order/info', 'order_id=' . $result['order_id'], 'SSL'));
        }
        
        $data['pagination'] = Theme::paginate($reward_total, $page, 10, Lang::get('lang_text_pagination'), Url::link('account/reward', 'page={page}', 'SSL'));
        
        $data['total'] = (int)Customer::getRewardPoints();
        
        $data['continue'] = Url::link('account/dashboard', '', 'SSL');
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        Theme::setController('header', 'shop/header');
        Theme::setController('footer', 'shop/footer');
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::render('account/reward', $data));
    }
}
