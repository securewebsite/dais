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

namespace App\Controllers\Admin\Report;
use App\Controllers\Controller;

class AffiliateCommission extends Controller {
    public function index() {
        $data = Theme::language('report/affiliate_commission');
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        if (isset($this->request->get['filter_date_start'])) {
            $filter_date_start = $this->request->get['filter_date_start'];
        } else {
            $filter_date_start = '';
        }
        
        if (isset($this->request->get['filter_date_end'])) {
            $filter_date_end = $this->request->get['filter_date_end'];
        } else {
            $filter_date_end = '';
        }
        
        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }
        
        $url = '';
        
        if (isset($this->request->get['filter_date_start'])) {
            $url.= '&filter_date_start=' . $this->request->get['filter_date_start'];
        }
        
        if (isset($this->request->get['filter_date_end'])) {
            $url.= '&filter_date_end=' . $this->request->get['filter_date_end'];
        }
        
        if (isset($this->request->get['page'])) {
            $url.= '&page=' . $this->request->get['page'];
        }
        
        Breadcrumb::add('lang_heading_title', 'report/affiliate_commission', $url);
        Theme::model('report/affiliate');
        
        $data['affiliates'] = array();
        
        $filter = array(
            'filter_date_start' => $filter_date_start, 
            'filter_date_end'   => $filter_date_end, 
            'start'             => ($page - 1) * Config::get('config_admin_limit'), 
            'limit'             => Config::get('config_admin_limit')
        );
        
        $affiliate_total = $this->model_report_affiliate->getTotalCommission($filter);
        $results         = $this->model_report_affiliate->getCommission($filter);
        
        foreach ($results as $result) {
            $action = array();
            
            $action[] = array(
                'text' => Lang::get('lang_text_edit'), 
                'href' => Url::link('people/customer/update', 'token=' . $this->session->data['token'] . '&customer_id=' . $result['customer_id'] . $url, 'SSL')
            );
            
            $data['affiliates'][] = array(
                'affiliate'  => $result['affiliate'], 
                'email'      => $result['email'], 
                'status'     => ($result['status'] ? Lang::get('lang_text_enabled') : Lang::get('lang_text_disabled')), 
                'commission' => Currency::format($result['commission'], Config::get('config_currency')), 
                'orders'     => $result['orders'], 
                'total'      => Currency::format($result['total'], Config::get('config_currency')), 
                'action'     => $action
            );
        }
        
        $data['token'] = $this->session->data['token'];
        
        $url = '';
        
        if (isset($this->request->get['filter_date_start'])) {
            $url.= '&filter_date_start=' . $this->request->get['filter_date_start'];
        }
        
        if (isset($this->request->get['filter_date_end'])) {
            $url.= '&filter_date_end=' . $this->request->get['filter_date_end'];
        }
        
        $data['pagination'] = Theme::paginate(
            $affiliate_total, 
            $page, 
            Config::get('config_admin_limit'), 
            Lang::get('lang_text_pagination'), 
            Url::link('report/affiliate_commission', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL')
        );
        
        $data['filter_date_start'] = $filter_date_start;
        $data['filter_date_end']   = $filter_date_end;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::render_controllers($data);
        
        Response::setOutput(Theme::view('report/affiliate_commission', $data));
    }
}
