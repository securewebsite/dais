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

namespace Admin\Controller\Report;
use Dais\Engine\Controller;

class CustomerOrder extends Controller {
    public function index() {
        $data = Theme::language('report/customer_order');
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
        
        if (isset($this->request->get['filter_order_status_id'])) {
            $filter_order_status_id = $this->request->get['filter_order_status_id'];
        } else {
            $filter_order_status_id = 0;
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
        
        if (isset($this->request->get['filter_order_status_id'])) {
            $url.= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
        }
        
        if (isset($this->request->get['page'])) {
            $url.= '&page=' . $this->request->get['page'];
        }
        
        Breadcrumb::add('lang_heading_title', 'report/customer_order', $url);
        
        Theme::model('report/customer');
        
        $data['customers'] = array();
        
        $filter = array('filter_date_start' => $filter_date_start, 'filter_date_end' => $filter_date_end, 'filter_order_status_id' => $filter_order_status_id, 'start' => ($page - 1) * Config::get('config_admin_limit'), 'limit' => Config::get('config_admin_limit'));
        
        $customer_total = $this->model_report_customer->getTotalOrders($filter);
        
        $results = $this->model_report_customer->getOrders($filter);
        
        foreach ($results as $result) {
            $action = array();
            
            $action[] = array('text' => Lang::get('lang_text_edit'), 'href' => Url::link('people/customer/update', 'token=' . $this->session->data['token'] . '&customer_id=' . $result['customer_id'] . $url, 'SSL'));
            
            $data['customers'][] = array('customer' => $result['customer'], 'email' => $result['email'], 'customer_group' => $result['customer_group'], 'status' => ($result['status'] ? Lang::get('lang_text_enabled') : Lang::get('lang_text_disabled')), 'orders' => $result['orders'], 'products' => $result['products'], 'total' => Currency::format($result['total'], Config::get('config_currency')), 'action' => $action);
        }
        
        $data['token'] = $this->session->data['token'];
        
        Theme::model('localization/order_status');
        
        $data['order_statuses'] = $this->model_localization_order_status->getOrderStatuses();
        
        $url = '';
        
        if (isset($this->request->get['filter_date_start'])) {
            $url.= '&filter_date_start=' . $this->request->get['filter_date_start'];
        }
        
        if (isset($this->request->get['filter_date_end'])) {
            $url.= '&filter_date_end=' . $this->request->get['filter_date_end'];
        }
        
        if (isset($this->request->get['filter_order_status_id'])) {
            $url.= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
        }
        
        $data['pagination'] = Theme::paginate($customer_total, $page, Config::get('config_admin_limit'), Lang::get('lang_text_pagination'), Url::link('report/customer_order', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL'));
        
        $data['filter_date_start'] = $filter_date_start;
        $data['filter_date_end'] = $filter_date_end;
        $data['filter_order_status_id'] = $filter_order_status_id;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::render_controllers($data);
        
        Response::setOutput(Theme::view('report/customer_order', $data));
    }
}
