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

namespace App\Controllers\Admin\Locale;

use App\Controllers\Controller;

class TaxRate extends Controller {
    
    private $error = array();
    
    public function index() {
        Lang::load('locale/tax_rate');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('locale/tax_rate');
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    public function insert() {
        Lang::load('locale/tax_rate');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('locale/tax_rate');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            LocaleTaxRate::addTaxRate(Request::post());
            Session::p()->data['success'] = Lang::get('lang_text_success');
            
            $url = '';
            
            if (isset(Request::p()->get['sort'])) {
                $url.= '&sort=' . Request::p()->get['sort'];
            }
            
            if (isset(Request::p()->get['order'])) {
                $url.= '&order=' . Request::p()->get['order'];
            }
            
            if (isset(Request::p()->get['page'])) {
                $url.= '&page=' . Request::p()->get['page'];
            }
            
            Response::redirect(Url::link('locale/tax_rate', '' . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function update() {
        Lang::load('locale/tax_rate');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('locale/tax_rate');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            LocaleTaxRate::editTaxRate(Request::p()->get['tax_rate_id'], Request::post());
            Session::p()->data['success'] = Lang::get('lang_text_success');
            
            $url = '';
            
            if (isset(Request::p()->get['sort'])) {
                $url.= '&sort=' . Request::p()->get['sort'];
            }
            
            if (isset(Request::p()->get['order'])) {
                $url.= '&order=' . Request::p()->get['order'];
            }
            
            if (isset(Request::p()->get['page'])) {
                $url.= '&page=' . Request::p()->get['page'];
            }
            
            Response::redirect(Url::link('locale/tax_rate', '' . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function delete() {
        Lang::load('locale/tax_rate');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('locale/tax_rate');
        
        if (isset(Request::p()->post['selected']) && $this->validateDelete()) {
            foreach (Request::p()->post['selected'] as $tax_rate_id) {
                LocaleTaxRate::deleteTaxRate($tax_rate_id);
            }
            
            Session::p()->data['success'] = Lang::get('lang_text_success');
            
            $url = '';
            
            if (isset(Request::p()->get['sort'])) {
                $url.= '&sort=' . Request::p()->get['sort'];
            }
            
            if (isset(Request::p()->get['order'])) {
                $url.= '&order=' . Request::p()->get['order'];
            }
            
            if (isset(Request::p()->get['page'])) {
                $url.= '&page=' . Request::p()->get['page'];
            }
            
            Response::redirect(Url::link('locale/tax_rate', '' . $url, 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    protected function getList() {
        $data = Theme::language('locale/tax_rate');
        
        if (isset(Request::p()->get['sort'])) {
            $sort = Request::p()->get['sort'];
        } else {
            $sort = 'tr.name';
        }
        
        if (isset(Request::p()->get['order'])) {
            $order = Request::p()->get['order'];
        } else {
            $order = 'asc';
        }
        
        if (isset(Request::p()->get['page'])) {
            $page = Request::p()->get['page'];
        } else {
            $page = 1;
        }
        
        $url = '';
        
        if (isset(Request::p()->get['sort'])) {
            $url.= '&sort=' . Request::p()->get['sort'];
        }
        
        if (isset(Request::p()->get['order'])) {
            $url.= '&order=' . Request::p()->get['order'];
        }
        
        if (isset(Request::p()->get['page'])) {
            $url.= '&page=' . Request::p()->get['page'];
        }
        
        Breadcrumb::add('lang_heading_title', 'locale/tax_rate', $url);
        
        $data['insert'] = Url::link('locale/tax_rate/insert', '' . $url, 'SSL');
        $data['delete'] = Url::link('locale/tax_rate/delete', '' . $url, 'SSL');
        
        $data['tax_rates'] = array();
        
        $filter = array('sort' => $sort, 'order' => $order, 'start' => ($page - 1) * Config::get('config_admin_limit'), 'limit' => Config::get('config_admin_limit'));
        
        $tax_rate_total = LocaleTaxRate::getTotalTaxRates();
        
        $results = LocaleTaxRate::getTaxRates($filter);
        
        foreach ($results as $result) {
            $action = array();
            
            $action[] = array('text' => Lang::get('lang_text_edit'), 'href' => Url::link('locale/tax_rate/update', '' . 'tax_rate_id=' . $result['tax_rate_id'] . $url, 'SSL'));
            
            $data['tax_rates'][] = array('tax_rate_id' => $result['tax_rate_id'], 'name' => $result['name'], 'rate' => $result['rate'], 'type' => ($result['type'] == 'F' ? Lang::get('lang_text_amount') : Lang::get('lang_text_percent')), 'geo_zone' => $result['geo_zone'], 'date_added' => date(Lang::get('lang_date_format_short'), strtotime($result['date_added'])), 'date_modified' => date(Lang::get('lang_date_format_short'), strtotime($result['date_modified'])), 'selected' => isset(Request::p()->post['selected']) && in_array($result['tax_rate_id'], Request::p()->post['selected']), 'action' => $action);
        }
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        if (isset(Session::p()->data['success'])) {
            $data['success'] = Session::p()->data['success'];
            
            unset(Session::p()->data['success']);
        } else {
            $data['success'] = '';
        }
        
        $url = '';
        
        if ($order == 'asc') {
            $url.= '&order=desc';
        } else {
            $url.= '&order=asc';
        }
        
        if (isset(Request::p()->get['page'])) {
            $url.= '&page=' . Request::p()->get['page'];
        }
        
        $data['sort_name'] = Url::link('locale/tax_rate', '' . 'sort=tr.name' . $url, 'SSL');
        $data['sort_rate'] = Url::link('locale/tax_rate', '' . 'sort=tr.rate' . $url, 'SSL');
        $data['sort_type'] = Url::link('locale/tax_rate', '' . 'sort=tr.type' . $url, 'SSL');
        $data['sort_geo_zone'] = Url::link('locale/tax_rate', '' . 'sort=gz.name' . $url, 'SSL');
        $data['sort_date_added'] = Url::link('locale/tax_rate', '' . 'sort=tr.date_added' . $url, 'SSL');
        $data['sort_date_modified'] = Url::link('locale/tax_rate', '' . 'sort=tr.date_modified' . $url, 'SSL');
        
        $url = '';
        
        if (isset(Request::p()->get['sort'])) {
            $url.= '&sort=' . Request::p()->get['sort'];
        }
        
        if (isset(Request::p()->get['order'])) {
            $url.= '&order=' . Request::p()->get['order'];
        }
        
        $data['pagination'] = Theme::paginate($tax_rate_total, $page, Config::get('config_admin_limit'), Lang::get('lang_text_pagination'), Url::link('locale/tax_rate', '' . $url . '&page={page}', 'SSL'));
        
        $data['sort'] = $sort;
        $data['order'] = $order;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('locale/tax_rate_list', $data));
    }
    
    protected function getForm() {
        $data = Theme::language('locale/tax_rate');
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        if (isset($this->error['name'])) {
            $data['error_name'] = $this->error['name'];
        } else {
            $data['error_name'] = '';
        }
        
        if (isset($this->error['rate'])) {
            $data['error_rate'] = $this->error['rate'];
        } else {
            $data['error_rate'] = '';
        }
        
        $url = '';
        
        if (isset(Request::p()->get['sort'])) {
            $url.= '&sort=' . Request::p()->get['sort'];
        }
        
        if (isset(Request::p()->get['order'])) {
            $url.= '&order=' . Request::p()->get['order'];
        }
        
        if (isset(Request::p()->get['page'])) {
            $url.= '&page=' . Request::p()->get['page'];
        }
        
        Breadcrumb::add('lang_heading_title', 'locale/tax_rate', $url);
        
        if (!isset(Request::p()->get['tax_rate_id'])) {
            $data['action'] = Url::link('locale/tax_rate/insert', '' . $url, 'SSL');
        } else {
            $data['action'] = Url::link('locale/tax_rate/update', '' . 'tax_rate_id=' . Request::p()->get['tax_rate_id'] . $url, 'SSL');
        }
        
        $data['cancel'] = Url::link('locale/tax_rate', '' . $url, 'SSL');
        
        if (isset(Request::p()->get['tax_rate_id']) && (Request::p()->server['REQUEST_METHOD'] != 'POST')) {
            $tax_rate_info = LocaleTaxRate::getTaxRate(Request::p()->get['tax_rate_id']);
        }
        
        if (isset(Request::p()->post['name'])) {
            $data['name'] = Request::p()->post['name'];
        } elseif (!empty($tax_rate_info)) {
            $data['name'] = $tax_rate_info['name'];
        } else {
            $data['name'] = '';
        }
        
        if (isset(Request::p()->post['rate'])) {
            $data['rate'] = Request::p()->post['rate'];
        } elseif (!empty($tax_rate_info)) {
            $data['rate'] = $tax_rate_info['rate'];
        } else {
            $data['rate'] = '';
        }
        
        if (isset(Request::p()->post['type'])) {
            $data['type'] = Request::p()->post['type'];
        } elseif (!empty($tax_rate_info)) {
            $data['type'] = $tax_rate_info['type'];
        } else {
            $data['type'] = '';
        }
        
        if (isset(Request::p()->post['tax_rate_customer_group'])) {
            $data['tax_rate_customer_group'] = Request::p()->post['tax_rate_customer_group'];
        } elseif (isset(Request::p()->get['tax_rate_id'])) {
            $data['tax_rate_customer_group'] = LocaleTaxRate::getTaxRateCustomerGroups(Request::p()->get['tax_rate_id']);
        } else {
            $data['tax_rate_customer_group'] = array();
        }
        
        Theme::model('people/customer_group');
        
        $data['customer_groups'] = PeopleCustomerGroup::getCustomerGroups();
        
        if (isset(Request::p()->post['geo_zone_id'])) {
            $data['geo_zone_id'] = Request::p()->post['geo_zone_id'];
        } elseif (!empty($tax_rate_info)) {
            $data['geo_zone_id'] = $tax_rate_info['geo_zone_id'];
        } else {
            $data['geo_zone_id'] = '';
        }
        
        Theme::model('locale/geo_zone');
        
        $data['geo_zones'] = LocaleGeoZone::getGeoZones();
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('locale/tax_rate_form', $data));
    }
    
    protected function validateForm() {
        if (!User::hasPermission('modify', 'locale/tax_rate')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        if ((Encode::strlen(Request::p()->post['name']) < 3) || (Encode::strlen(Request::p()->post['name']) > 32)) {
            $this->error['name'] = Lang::get('lang_error_name');
        }
        
        if (!Request::p()->post['rate']) {
            $this->error['rate'] = Lang::get('lang_error_rate');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    protected function validateDelete() {
        if (!User::hasPermission('modify', 'locale/tax_rate')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        Theme::model('locale/tax_class');
        
        foreach (Request::p()->post['selected'] as $tax_rate_id) {
            $tax_rule_total = LocaleTaxClass::getTotalTaxRulesByTaxRateId($tax_rate_id);
            
            if ($tax_rule_total) {
                $this->error['warning'] = sprintf(Lang::get('lang_error_tax_rule'), $tax_rule_total);
            }
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
}
