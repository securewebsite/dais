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

class SaleReturn extends Controller {
    public function index() {
        $data = Theme::language('report/sale_return');
        
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
        
        if (isset($this->request->get['filter_group'])) {
            $filter_group = $this->request->get['filter_group'];
        } else {
            $filter_group = 'week';
        }
        
        if (isset($this->request->get['filter_return_status_id'])) {
            $filter_return_status_id = $this->request->get['filter_return_status_id'];
        } else {
            $filter_return_status_id = 0;
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
        
        if (isset($this->request->get['filter_return_status_id'])) {
            $url.= '&filter_return_status_id=' . $this->request->get['filter_return_status_id'];
        }
        
        if (isset($this->request->get['page'])) {
            $url.= '&page=' . $this->request->get['page'];
        }
        
        Breadcrumb::add('lang_heading_title', 'report/sale_return', $url);
        
        Theme::model('report/returns');
        
        $data['returns'] = array();
        
        $filter = array(
            'filter_date_start'       => $filter_date_start, 
            'filter_date_end'         => $filter_date_end, 
            'filter_group'            => $filter_group, 
            'filter_return_status_id' => $filter_return_status_id, 
            'start'                   => ($page - 1) * Config::get('config_admin_limit'), 
            'limit'                   => Config::get('config_admin_limit')
        );
        
        $return_total = $this->model_report_returns->getTotalReturns($filter);
        
        $results = $this->model_report_returns->getReturns($filter);
        
        foreach ($results as $result) {
            $data['returns'][] = array(
                'date_start' => date(Lang::get('lang_date_format_short'), strtotime($result['date_start'])), 
                'date_end'   => date(Lang::get('lang_date_format_short'), strtotime($result['date_end'])), 
                'returns'    => $result['returns']
            );
        }
        
        $data['token'] = $this->session->data['token'];
        
        Theme::model('localization/return_status');
        
        $data['return_statuses'] = $this->model_localization_return_status->getReturnStatuses();
        
        $data['groups'] = array();
        
        $data['groups'][] = array(
            'text'  => Lang::get('lang_text_year'), 
            'value' => 'year'
        );
        
        $data['groups'][] = array(
            'text'  => Lang::get('lang_text_month'), 
            'value' => 'month'
        );
        
        $data['groups'][] = array(
            'text'  => Lang::get('lang_text_week'), 
            'value' => 'week'
        );
        
        $data['groups'][] = array(
            'text'  => Lang::get('lang_text_day'), 
            'value' => 'day'
        );
        
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
        
        if (isset($this->request->get['filter_return_status_id'])) {
            $url.= '&filter_return_status_id=' . $this->request->get['filter_return_status_id'];
        }
        
        $data['pagination'] = Theme::paginate(
            $return_total, 
            $page, 
            Config::get('config_admin_limit'), 
            Lang::get('lang_text_pagination'), 
            Url::link('report/sale_return', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL')
        );
        
        $data['filter_date_start']       = $filter_date_start;
        $data['filter_date_end']         = $filter_date_end;
        $data['filter_group']            = $filter_group;
        $data['filter_return_status_id'] = $filter_return_status_id;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::render_controllers($data);
        
        Response::setOutput(Theme::view('report/sale_return', $data));
    }
}
