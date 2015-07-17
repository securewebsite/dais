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

class ProductPurchased extends Controller {
    
    public function index() {
        $data = Theme::language('report/product_purchased');
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
        
        if (isset(Request::p()->get['filter_order_status_id'])) {
            $url.= '&filter_order_status_id=' . Request::p()->get['filter_order_status_id'];
        }
        
        if (isset(Request::p()->get['page'])) {
            $url.= '&page=' . Request::p()->get['page'];
        }
        
        Breadcrumb::add('lang_heading_title', 'report/product_purchased', $url);
        
        Theme::model('report/product');
        
        $data['products'] = array();
        
        $filter = array('filter_date_start' => $filter_date_start, 'filter_date_end' => $filter_date_end, 'filter_order_status_id' => $filter_order_status_id, 'start' => ($page - 1) * Config::get('config_admin_limit'), 'limit' => Config::get('config_admin_limit'));
        
        $product_total = ReportProduct::getTotalPurchased($filter);
        
        $results = ReportProduct::getPurchased($filter);
        
        foreach ($results as $result) {
            $data['products'][] = array('name' => $result['name'], 'model' => $result['model'], 'quantity' => $result['quantity'], 'total' => Currency::format($result['total'], Config::get('config_currency')));
        }
        
        Theme::model('locale/order_status');
        
        $data['order_statuses'] = LocaleOrderStatus::getOrderStatuses();
        
        $url = '';
        
        if (isset(Request::p()->get['filter_date_start'])) {
            $url.= '&filter_date_start=' . Request::p()->get['filter_date_start'];
        }
        
        if (isset(Request::p()->get['filter_date_end'])) {
            $url.= '&filter_date_end=' . Request::p()->get['filter_date_end'];
        }
        
        if (isset(Request::p()->get['filter_order_status_id'])) {
            $url.= '&filter_order_status_id=' . Request::p()->get['filter_order_status_id'];
        }
        
        $data['pagination'] = Theme::paginate($product_total, $page, Config::get('config_admin_limit'), Lang::get('lang_text_pagination'), Url::link('report/product_purchased', '' . $url . '&page={page}'));
        
        $data['filter_date_start'] = $filter_date_start;
        $data['filter_date_end'] = $filter_date_end;
        $data['filter_order_status_id'] = $filter_order_status_id;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::render('report/product_purchased', $data));
    }
}
