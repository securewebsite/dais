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

class ProductViewed extends Controller {
    
    public function index() {
        $data = Theme::language('report/product_viewed');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        if (isset(Request::p()->get['page'])) {
            $page = Request::p()->get['page'];
        } else {
            $page = 1;
        }
        
        $url = '';
        
        if (isset(Request::p()->get['page'])) {
            $url.= '&page=' . Request::p()->get['page'];
        }
        
        Breadcrumb::add('lang_heading_title', 'report/product_viewed', $url);
        
        Theme::model('report/product');
        
        $filter = array('start' => ($page - 1) * Config::get('config_admin_limit'), 'limit' => Config::get('config_admin_limit'));
        
        $product_viewed_total = ReportProduct::getTotalProductsViewed($filter);
        
        $product_views_total = ReportProduct::getTotalProductViews();
        
        $data['products'] = array();
        
        $results = ReportProduct::getProductsViewed($filter);
        
        foreach ($results as $result) {
            if ($result['viewed']) {
                $percent = round($result['viewed'] / $product_views_total * 100, 2);
            } else {
                $percent = 0;
            }
            
            $data['products'][] = array('name' => $result['name'], 'model' => $result['model'], 'viewed' => $result['viewed'], 'percent' => $percent . '%');
        }
        
        $url = '';
        
        if (isset(Request::p()->get['page'])) {
            $url.= '&page=' . Request::p()->get['page'];
        }
        
        $data['reset'] = Url::link('report/product_viewed/reset', '' . $url, 'SSL');
        
        if (isset(Session::p()->data['success'])) {
            $data['success'] = Session::p()->data['success'];
            
            unset(Session::p()->data['success']);
        } else {
            $data['success'] = '';
        }
        
        $data['pagination'] = Theme::paginate($product_viewed_total, $page, Config::get('config_admin_limit'), Lang::get('lang_text_pagination'), Url::link('report/product_viewed', '' . 'page={page}', 'SSL'));
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('report/product_viewed', $data));
    }
    
    public function reset() {
        Lang::load('report/product_viewed');
        Theme::model('report/product');
        ReportProduct::reset();
        
        Session::p()->data['success'] = Lang::get('lang_text_success');
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        Response::redirect(Url::link('report/product_viewed', '', 'SSL'));
    }
}
