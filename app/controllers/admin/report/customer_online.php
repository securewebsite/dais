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

class CustomerOnline extends Controller {
    
    public function index() {
        $data = Theme::language('report/customer_online');
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        if (isset($this->request->get['filter_ip'])) {
            $filter_ip = $this->request->get['filter_ip'];
        } else {
            $filter_ip = null;
        }
        
        if (isset($this->request->get['filter_customer'])) {
            $filter_customer = $this->request->get['filter_customer'];
        } else {
            $filter_customer = null;
        }
        
        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }
        
        $url = '';
        
        if (isset($this->request->get['filter_customer'])) {
            $url.= '&filter_customer=' . urlencode($this->request->get['filter_customer']);
        }
        
        if (isset($this->request->get['filter_ip'])) {
            $url.= '&filter_ip=' . $this->request->get['filter_ip'];
        }
        
        if (isset($this->request->get['page'])) {
            $url.= '&page=' . $this->request->get['page'];
        }
        
        Breadcrumb::add('lang_heading_title', 'report/customer_online', $url);
        
        Theme::model('report/online');
        Theme::model('people/customer');
        
        $data['customers'] = array();
        
        $filter = array('filter_ip' => $filter_ip, 'filter_customer' => $filter_customer, 'start' => ($page - 1) * 20, 'limit' => 20);
        
        $customer_total = $this->model_report_online->getTotalCustomersOnline($filter);
        
        $results = $this->model_report_online->getCustomersOnline($filter);
        
        foreach ($results as $result) {
            $action = array();
            
            if ($result['customer_id']) {
                $action[] = array('text' => 'Edit', 'href' => Url::link('people/customer/update', 'token=' . $this->session->data['token'] . '&customer_id=' . $result['customer_id'], 'SSL'));
            }
            
            $customer_info = $this->model_people_customer->getCustomer($result['customer_id']);
            
            if ($customer_info) {
                $customer = $customer_info['firstname'] . ' ' . $customer_info['lastname'];
            } else {
                $customer = Lang::get('lang_text_guest');
            }
            
            $data['customers'][] = array('ip' => $result['ip'], 'customer' => $customer, 'url' => $result['url'], 'referer' => $result['referer'], 'date_added' => date('d/m/Y H:i:s', strtotime($result['date_added'])), 'action' => $action);
        }
        
        $data['token'] = $this->session->data['token'];
        
        $url = '';
        
        if (isset($this->request->get['filter_customer'])) {
            $url.= '&filter_customer=' . urlencode($this->request->get['filter_customer']);
        }
        
        if (isset($this->request->get['filter_ip'])) {
            $url.= '&filter_ip=' . $this->request->get['filter_ip'];
        }
        
        $data['pagination'] = Theme::paginate($customer_total, $page, 20, Lang::get('lang_text_pagination'), Url::link('report/customer_online', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL'));
        
        $data['filter_customer'] = $filter_customer;
        $data['filter_ip'] = $filter_ip;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(Theme::view('report/customer_online', $data));
    }
}
