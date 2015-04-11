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

class Saletax extends Controller {
    public function index() {
        $data = $this->theme->language('report/sale_tax');
        
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        
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
        
        if (isset($this->request->get['filter_group'])) {
            $filter_group = $this->request->get['filter_group'];
        } else {
            $filter_group = 'week';
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
        
        if (isset($this->request->get['filter_group'])) {
            $url.= '&filter_group=' . $this->request->get['filter_group'];
        }
        
        if (isset($this->request->get['filter_order_status_id'])) {
            $url.= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
        }
        
        if (isset($this->request->get['page'])) {
            $url.= '&page=' . $this->request->get['page'];
        }
        
        $this->breadcrumb->add('lang_heading_title', 'report/saletax', $url);
        
        $this->theme->model('report/sale');
        
        $data['orders'] = array();
        
        $filter = array('filter_date_start' => $filter_date_start, 'filter_date_end' => $filter_date_end, 'filter_group' => $filter_group, 'filter_order_status_id' => $filter_order_status_id, 'start' => ($page - 1) * $this->config->get('config_admin_limit'), 'limit' => $this->config->get('config_admin_limit'));
        
        $order_total = $this->model_report_sale->getTotalTaxes($filter);
        
        $data['orders'] = array();
        
        $results = $this->model_report_sale->getTaxes($filter);
        
        foreach ($results as $result) {
            $data['orders'][] = array('date_start' => date($this->language->get('lang_date_format_short'), strtotime($result['date_start'])), 'date_end' => date($this->language->get('lang_date_format_short'), strtotime($result['date_end'])), 'title' => $result['title'], 'orders' => $result['orders'], 'total' => $this->currency->format($result['total'], $this->config->get('config_currency')));
        }
        
        $data['token'] = $this->session->data['token'];
        
        $this->theme->model('localization/orderstatus');
        
        $data['order_statuses'] = $this->model_localization_orderstatus->getOrderStatuses();
        
        $data['groups'] = array();
        
        $data['groups'][] = array('text' => $this->language->get('lang_text_year'), 'value' => 'year',);
        
        $data['groups'][] = array('text' => $this->language->get('lang_text_month'), 'value' => 'month',);
        
        $data['groups'][] = array('text' => $this->language->get('lang_text_week'), 'value' => 'week',);
        
        $data['groups'][] = array('text' => $this->language->get('lang_text_day'), 'value' => 'day',);
        
        $url = '';
        
        if (isset($this->request->get['filter_date_start'])) {
            $url.= '&filter_date_start=' . $this->request->get['filter_date_start'];
        }
        
        if (isset($this->request->get['filter_date_end'])) {
            $url.= '&filter_date_end=' . $this->request->get['filter_date_end'];
        }
        
        if (isset($this->request->get['filter_group'])) {
            $url.= '&filter_group=' . $this->request->get['filter_group'];
        }
        
        if (isset($this->request->get['filter_order_status_id'])) {
            $url.= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
        }
        
        $data['pagination'] = $this->theme->paginate($order_total, $page, $this->config->get('config_admin_limit'), $this->language->get('lang_text_pagination'), $this->url->link('report/saletax', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL'));
        
        $data['filter_date_start'] = $filter_date_start;
        $data['filter_date_end'] = $filter_date_end;
        $data['filter_group'] = $filter_group;
        $data['filter_order_status_id'] = $filter_order_status_id;
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('report/sale_tax', $data));
    }
}
