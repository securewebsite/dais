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
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('account/reward', '', 'SSL');
            
            $this->response->redirect($this->url->link('account/login', '', 'SSL'));
        }
        
        $data = $this->theme->language('account/reward');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        
        $this->breadcrumb->add('lang_text_account', 'account/dashboard', null, true, 'SSL');
        $this->breadcrumb->add('lang_text_reward', 'account/reward', null, true, 'SSL');
        
        $this->theme->model('account/reward');
        
        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }
        
        $data['rewards'] = array();
        
        $filter = array('sort' => 'date_added', 'order' => 'DESC', 'start' => ($page - 1) * 10, 'limit' => 10);
        
        $reward_total = $this->model_account_reward->getTotalRewards($filter);
        
        $results = $this->model_account_reward->getRewards($filter);
        
        foreach ($results as $result) {
            $data['rewards'][] = array('order_id' => $result['order_id'], 'points' => $result['points'], 'description' => $result['description'], 'date_added' => date($this->language->get('lang_date_format_short'), strtotime($result['date_added'])), 'href' => $this->url->link('account/order/info', 'order_id=' . $result['order_id'], 'SSL'));
        }
        
        $data['pagination'] = $this->theme->paginate($reward_total, $page, 10, $this->language->get('lang_text_pagination'), $this->url->link('account/reward', 'page={page}', 'SSL'));
        
        $data['total'] = (int)$this->customer->getRewardPoints();
        
        $data['continue'] = $this->url->link('account/dashboard', '', 'SSL');
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $this->theme->set_controller('header', 'shop/header');
        $this->theme->set_controller('footer', 'shop/footer');
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('account/reward', $data));
    }
}
