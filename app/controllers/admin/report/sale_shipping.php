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

class SaleShipping extends Controller {
    
    public function index() {
        $data = Theme::language('report/sale_shipping');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        if (isset(Request::p()->get['filter_date_start'])) {
            $filter_date_start = Request::p()->get['filter_date_start'];
        } else {
            $filter_date_start = '';
        }
        
        if (isset(Request::p()->get['filter_date_end'])) {
            $filter_date_end = Request::p()->get['filter_date_end'];
        } else {
            $filter_date_end = '';
        }
        
        if (isset(Request::p()->get['filter_group'])) {
            $filter_group = Request::p()->get['filter_group'];
        } else {
            $filter_group = 'week';
        }
        
        if (isset(Request::p()->get['filter_order_status_id'])) {
            $filter_order_status_id = Request::p()->get['filter_order_status_id'];
        } else {
            $filter_order_status_id = 0;
        }
        
        if (isset(Request::p()->get['page'])) {
            $page = Request::p()->get['page'];
        } else {
            $page = 1;
        }
        
        $url = '';
        
        if (isset(Request::p()->get['filter_date_start'])) {
            $url.= '&filter_date_start=' . Request::p()->get['filter_date_start'];
        }
        
        if (isset(Request::p()->get['filter_date_end'])) {
            $url.= '&filter_date_end=' . Request::p()->get['filter_date_end'];
        }
        
        if (isset(Request::p()->get['filter_group'])) {
            $url.= '&filter_group=' . Request::p()->get['filter_group'];
        }
        
        if (isset(Request::p()->get['filter_order_status_id'])) {
            $url.= '&filter_order_status_id=' . Request::p()->get['filter_order_status_id'];
        }
        
        if (isset(Request::p()->get['page'])) {
            $url.= '&page=' . Request::p()->get['page'];
        }
        
        Breadcrumb::add('lang_heading_title', 'report/sale_shipping', $url);
        
        Theme::model('report/sale');
        
        $data['orders'] = array();
        
        $filter = array('filter_date_start' => $filter_date_start, 'filter_date_end' => $filter_date_end, 'filter_group' => $filter_group, 'filter_order_status_id' => $filter_order_status_id, 'start' => ($page - 1) * Config::get('config_admin_limit'), 'limit' => Config::get('config_admin_limit'));
        
        $order_total = ReportSale::getTotalShipping($filter);
        
        $results = ReportSale::getShipping($filter);
        
        foreach ($results as $result) {
            $data['orders'][] = array('date_start' => date(Lang::get('lang_date_format_short'), strtotime($result['date_start'])), 'date_end' => date(Lang::get('lang_date_format_short'), strtotime($result['date_end'])), 'title' => $result['title'], 'orders' => $result['orders'], 'total' => Currency::format($result['total'], Config::get('config_currency')));
        }
        
        Theme::model('locale/order_status');
        
        $data['order_statuses'] = LocaleOrderStatus::getOrderStatuses();
        
        $data['groups'] = array();
        
        $data['groups'][] = array('text' => Lang::get('lang_text_year'), 'value' => 'year',);
        
        $data['groups'][] = array('text' => Lang::get('lang_text_month'), 'value' => 'month',);
        
        $data['groups'][] = array('text' => Lang::get('lang_text_week'), 'value' => 'week',);
        
        $data['groups'][] = array('text' => Lang::get('lang_text_day'), 'value' => 'day',);
        
        $url = '';
        
        if (isset(Request::p()->get['filter_date_start'])) {
            $url.= '&filter_date_start=' . Request::p()->get['filter_date_start'];
        }
        
        if (isset(Request::p()->get['filter_date_end'])) {
            $url.= '&filter_date_end=' . Request::p()->get['filter_date_end'];
        }
        
        if (isset(Request::p()->get['filter_group'])) {
            $url.= '&filter_group=' . Request::p()->get['filter_group'];
        }
        
        if (isset(Request::p()->get['filter_order_status_id'])) {
            $url.= '&filter_order_status_id=' . Request::p()->get['filter_order_status_id'];
        }
        
        $data['pagination'] = Theme::paginate($order_total, $page, Config::get('config_admin_limit'), Lang::get('lang_text_pagination'), Url::link('report/sale_shipping', '' . $url . '&page={page}', 'SSL'));
        
        $data['filter_date_start'] = $filter_date_start;
        $data['filter_date_end'] = $filter_date_end;
        $data['filter_group'] = $filter_group;
        $data['filter_order_status_id'] = $filter_order_status_id;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::render('report/sale_shipping', $data));
    }
}
