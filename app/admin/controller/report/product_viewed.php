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
use Dais\Base\Controller;

class ProductViewed extends Controller {
    public function index() {
        $data = Theme::language('report/product_viewed');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }
        
        $url = '';
        
        if (isset($this->request->get['page'])) {
            $url.= '&page=' . $this->request->get['page'];
        }
        
        Breadcrumb::add('lang_heading_title', 'report/product_viewed', $url);
        
        Theme::model('report/product');
        
        $filter = array('start' => ($page - 1) * Config::get('config_admin_limit'), 'limit' => Config::get('config_admin_limit'));
        
        $product_viewed_total = $this->model_report_product->getTotalProductsViewed($filter);
        
        $product_views_total = $this->model_report_product->getTotalProductViews();
        
        $data['products'] = array();
        
        $results = $this->model_report_product->getProductsViewed($filter);
        
        foreach ($results as $result) {
            if ($result['viewed']) {
                $percent = round($result['viewed'] / $product_views_total * 100, 2);
            } else {
                $percent = 0;
            }
            
            $data['products'][] = array('name' => $result['name'], 'model' => $result['model'], 'viewed' => $result['viewed'], 'percent' => $percent . '%');
        }
        
        $url = '';
        
        if (isset($this->request->get['page'])) {
            $url.= '&page=' . $this->request->get['page'];
        }
        
        $data['reset'] = Url::link('report/product_viewed/reset', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];
            
            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }
        
        $data['pagination'] = Theme::paginate($product_viewed_total, $page, Config::get('config_admin_limit'), Lang::get('lang_text_pagination'), Url::link('report/product_viewed', 'token=' . $this->session->data['token'] . '&page={page}', 'SSL'));
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::render_controllers($data);
        
        Response::setOutput(Theme::view('report/product_viewed', $data));
    }
    
    public function reset() {
        Lang::load('report/product_viewed');
        Theme::model('report/product');
        $this->model_report_product->reset();
        
        $this->session->data['success'] = Lang::get('lang_text_success');
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        Response::redirect(Url::link('report/product_viewed', 'token=' . $this->session->data['token'], 'SSL'));
    }
}
