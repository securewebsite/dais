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

namespace App\Controllers\Admin\People;

use App\Controllers\Controller;

class Customer extends Controller {
    
    private $error   = array();
    
    private $filters = array(
        'filter_username',
        'filter_name',
        'filter_email',
        'filter_customer_group_id',
        'filter_status',
        'filter_affiliate',
        'sort',
        'order',
        'page'
    );
    
    private $post_errors = array(
        'warning',
        'username',
        'firstname',
        'lastname',
        'email',
        'telephone',
        'password',
        'confirm',
        'address_firstname',
        'address_lastname',
        'address_tax_id',
        'address_address_1',
        'address_city',
        'address_postcode',
        'address_country',
        'address_zone',
        'code',
        'commission',
        'tax_id',
        'payment',
        'cheque',
        'paypal',
        'bank_name',
        'account_name',
        'account_number'
    );
    
    public function index() {
        Lang::load('people/customer');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('people/customer');
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    public function insert() {
        Lang::load('people/customer');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('people/customer');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()):
            PeopleCustomer::addCustomer(Request::post());
            Session::p()->data['success'] = Lang::get('lang_text_success');
            
            $url = Filter::uri($this->filters);
            
            Response::redirect(Url::link('people/customer', '' . $url, 'SSL'));
        endif;
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function update() {
        Lang::load('people/customer');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('people/customer');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()):
            PeopleCustomer::editCustomer(Request::p()->get['customer_id'], Request::post());
            Session::p()->data['success'] = Lang::get('lang_text_success');
            
            $url = Filter::uri($this->filters);
            
            Response::redirect(Url::link('people/customer', '' . $url, 'SSL'));
        endif;
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function delete() {
        Lang::load('people/customer');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('people/customer');
        
        if (isset(Request::p()->post['selected']) && $this->validateDelete()):
            foreach (Request::p()->post['selected'] as $customer_id):
                PeopleCustomer::deleteCustomer($customer_id);
            endforeach;
            
            Session::p()->data['success'] = Lang::get('lang_text_success');
            
            $url = Filter::uri($this->filters);
            
            Response::redirect(Url::link('people/customer', '' . $url, 'SSL'));
        endif;
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    public function approve() {
        Lang::load('people/customer');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Theme::model('people/customer');
        
        if (!\User::hasPermission('modify', 'people/customer')):
            $this->error['warning'] = Lang::get('lang_error_permission');
        elseif (isset(Request::p()->post['selected'])):
            $approved = 0;
            
            foreach (Request::p()->post['selected'] as $customer_id):
                $customer_info = PeopleCustomer::getCustomer($customer_id);
                
                if ($customer_info && !$customer_info['approved']):
                    PeopleCustomer::approve($customer_id);
                    $approved++;
                endif;
            endforeach;
            
            Session::p()->data['success'] = sprintf(Lang::get('lang_text_approved'), $approved);
            
            $url = Filter::uri($this->filters);
            
            Response::redirect(Url::link('people/customer', '' . $url, 'SSL'));
        endif;
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    protected function getList() {
        $data = Theme::language('people/customer');
        
        $url = Filter::uri($this->filters);

        Breadcrumb::add('lang_heading_title', 'people/customer', $url);
        
        $data['approve'] = Url::link('people/customer/approve', '' . $url, 'SSL');
        $data['insert']  = Url::link('people/customer/insert',  '' . $url, 'SSL');
        $data['delete']  = Url::link('people/customer/delete',  '' . $url, 'SSL');
        
        $filter_default = array(
            'sort'  => 'username',
            'order' => 'ASC',
            'page'  => 1
        );

        $filter = Filter::map($this->filters, $filter_default);

        $page = $filter['page'];
        
        $filter['start'] = ($page - 1) * Config::get('config_admin_limit');
        $filter['limit'] = Config::get('config_admin_limit');
        
        $db_filter = $filter;
        unset ($db_filter['page']);

        $customer_total  = PeopleCustomer::getTotalCustomers($db_filter);
        $results         = PeopleCustomer::getCustomers($db_filter);

        $data['customers'] = array();
        
        foreach ($results as $result):
            $action = array();
            
            $action[] = array(
                'text' => Lang::get('lang_text_edit'), 
                'href' => Url::link('people/customer/update', '' . 'customer_id=' . $result['customer_id'] . $url, 'SSL')
            );
            
            $data['customers'][] = array(
                'customer_id'    => $result['customer_id'], 
                'username'       => $result['username'], 
                'name'           => $result['name'], 
                'email'          => $result['email'], 
                'customer_group' => $result['customer_group'], 
                'status'         => ($result['status'] ? Lang::get('lang_text_enabled') : Lang::get('lang_text_disabled')), 
                'approved'       => ($result['approved'] ? Lang::get('lang_text_yes') : Lang::get('lang_text_no')), 
                'ip'             => $result['ip'], 
                'date_added'     => date(Lang::get('lang_date_format_short'), strtotime($result['date_added'])), 
                'selected'       => isset(Request::p()->post['selected']) && in_array($result['customer_id'], Request::p()->post['selected']), 
                'action'         => $action
            );
        endforeach;
        
        if (isset($this->error['warning'])):
            $data['error_warning'] = $this->error['warning'];
        else:
            $data['error_warning'] = '';
        endif;
        
        if (isset(Session::p()->data['success'])):
            $data['success'] = Session::p()->data['success'];
            unset(Session::p()->data['success']);
        else:
            $data['success'] = '';
        endif;

        $sort = Filter::unsort($this->filters);
        $url  = Filter::uri($sort);
        
        if ($filter['order'] == 'ASC'):
            $url .= '&order=DESC';
        else:
            $url .= '&order=ASC'; 
        endif;
        
        $data['sort_username']       = Url::link('people/customer', '' . 'sort=username' . $url, 'SSL');
        $data['sort_name']           = Url::link('people/customer', '' . 'sort=name' . $url, 'SSL');
        $data['sort_email']          = Url::link('people/customer', '' . 'sort=c.email' . $url, 'SSL');
        $data['sort_customer_group'] = Url::link('people/customer', '' . 'sort=customer_group' . $url, 'SSL');
        $data['sort_status']         = Url::link('people/customer', '' . 'sort=c.status' . $url, 'SSL');
        
        $paging = Filter::unpage($this->filters);
        $url    = Filter::uri($paging);
        
        $data['pagination'] = Theme::paginate(
            $customer_total, 
            $page, 
            Config::get('config_admin_limit'), 
            Lang::get('lang_text_pagination'), 
            Url::link('people/customer', '' . $url . '&page={page}', 'SSL')
        );
        
        $data['filter_username']          = $filter['filter_username'];
        $data['filter_name']              = $filter['filter_name'];
        $data['filter_email']             = $filter['filter_email'];
        $data['filter_customer_group_id'] = $filter['filter_customer_group_id'];
        $data['filter_status']            = $filter['filter_status'];
        
        Theme::model('people/customer_group');
        
        $data['customer_groups'] = PeopleCustomerGroup::getCustomerGroups();
        
        Theme::model('setting/store');
        
        $data['stores'] = SettingStore::getStores();
        
        $data['sort']   = $filter['sort'];
        $data['order']  = $filter['order'];
        
        Theme::loadjs('javascript/people/customer_list', $data);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::render('people/customer_list', $data));
    }
    
    protected function getForm() {
        $data = Theme::language('people/customer');
        
        if (isset(Request::p()->get['customer_id'])):
            $data['customer_id'] = Request::p()->get['customer_id'];
        else:
            $data['customer_id'] = 0;
        endif;

        foreach ($this->post_errors as $error):
            if (isset($this->error[$error])):
                $data['error_' . $error] = $this->error[$error];
            else:
                $data['error_' . $error] = '';
            endif;
        endforeach;
        
        $url = Filter::uri($this->filters);
        
        Breadcrumb::add('lang_heading_title', 'people/customer', $url);
        
        if (!isset(Request::p()->get['customer_id'])):
            $data['action'] = Url::link('people/customer/insert', 'token=' . $data['token'] . $url, 'SSL');
        else:
            $data['action'] = Url::link('people/customer/update', 'token=' . $data['token'] . '&customer_id=' . Request::p()->get['customer_id'] . $url, 'SSL');
        endif;
        
        $data['cancel'] = Url::link('people/customer', '' . $url, 'SSL');
        
        if (isset(Request::p()->get['customer_id']) && (Request::p()->server['REQUEST_METHOD'] != 'POST')):
            $customer_info = PeopleCustomer::getCustomer(Request::p()->get['customer_id']);
        endif;

        $defaults = array(
            'username'          => '',
            'firstname'         => '',
            'lastname'          => '',
            'email'             => '',
            'telephone'         => '',
            'newsletter'        => '',
            'customer_group_id' => Config::get('config_customer_group_id'),
            'is_affiliate'      => false,
            'status'            => 1,
            'address_id'        => ''
        );
        
        foreach ($defaults as $key => $value):
            if (isset(Request::p()->post[$key])):
                $data[$key] = Request::p()->post[$key];
            elseif (!empty($customer_info)):
                $data[$key] = $customer_info[$key];
            else:
                $data[$key] = $value;
            endif;
        endforeach;
        
        Theme::model('people/customer_group');
        $data['customer_groups'] = PeopleCustomerGroup::getCustomerGroups();

        if (isset(Request::p()->post['affiliate'])):
            $data['affiliate'] = Request::p()->post['affiliate'];
        elseif (!empty($customer_info)):
            $data['affiliate'] = PeopleCustomer::getAffiliateDetails(Request::p()->get['customer_id']);
        else:
            $data['affiliate'] = array();
        endif;

        if (isset(Request::p()->post['password'])):
            $data['password'] = Request::p()->post['password'];
        else:
            $data['password'] = '';
        endif;
        
        if (isset(Request::p()->post['confirm'])):
            $data['confirm'] = Request::p()->post['confirm'];
        else:
            $data['confirm'] = '';
        endif;
        
        Theme::model('locale/country');
        
        $data['countries'] = LocaleCountry::getCountries(array('filter_status' => 1));
        
        if (isset(Request::p()->post['address'])):
            $data['addresses'] = Request::p()->post['address'];
        elseif (!empty($customer_info)):
            $data['addresses'] = PeopleCustomer::getAddresses(Request::p()->get['customer_id']);
        else:
            $data['addresses'] = array();
        endif;

        $data['referrer'] = false;

        if (!empty($customer_info)):
            $referrer = PeopleCustomer::getReferrer($customer_info['referral_id']);
            if ($referrer):
                $data['referrer'] = array(
                    'firstname' => $referrer['firstname'],
                    'lastname'  => $referrer['lastname'],
                    'username'  => $referrer['username'],
                    'href'      => Url::link('people/customer', '' . 'filter_username=' . $referrer['username'], 'SSL')
                );
            endif;
        endif;
        
        $data['ips'] = array();
        
        if (!empty($customer_info)):
            $results = PeopleCustomer::getIpsByCustomerId(Request::p()->get['customer_id']);
            
            foreach ($results as $result):
                $ban_ip_total = PeopleCustomer::getTotalBanIpsByIp($result['ip']);
                
                $data['ips'][] = array(
                    'ip'         => $result['ip'], 
                    'total'      => PeopleCustomer::getTotalCustomersByIp($result['ip']), 
                    'date_added' => date(Lang::get('lang_date_format_short'), strtotime($result['date_added'])), 
                    'filter_ip'  => Url::link('people/customer', '' . 'filter_ip=' . $result['ip'], 'SSL'), 
                    'ban_ip'     => $ban_ip_total
                );
            endforeach;
        endif;
        
        Theme::loadjs('javascript/people/customer_form', $data);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::render('people/customer_form', $data));
    }
    
    protected function validateForm() {
        if (!\User::hasPermission('modify', 'people/customer')):
            $this->error['warning'] = Lang::get('lang_error_permission');
        endif;
        
        if ((Encode::strlen(Request::p()->post['username']) < 3) || (Encode::strlen(Request::p()->post['username']) > 16)):
            $this->error['username'] = Lang::get('lang_error_username');
        endif;
        
        if ((Encode::strlen(Request::p()->post['firstname']) < 1) || (Encode::strlen(Request::p()->post['firstname']) > 32)):
            $this->error['firstname'] = Lang::get('lang_error_firstname');
        endif;
        
        if ((Encode::strlen(Request::p()->post['lastname']) < 1) || (Encode::strlen(Request::p()->post['lastname']) > 32)):
            $this->error['lastname'] = Lang::get('lang_error_lastname');
        endif;
        
        if ((Encode::strlen(Request::p()->post['email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', Request::p()->post['email'])):
            $this->error['email'] = Lang::get('lang_error_email');
        endif;
        
        $customer_info = PeopleCustomer::getCustomerByEmail(Request::p()->post['username'], Request::p()->post['email']);
        
        if (!isset(Request::p()->get['customer_id'])):
            if ($customer_info):
                $this->error['warning'] = Lang::get('lang_error_exists');
            endif;
        else:
            if ($customer_info && (Request::p()->get['customer_id'] != $customer_info['customer_id'])):
                $this->error['warning'] = Lang::get('lang_error_exists');
            endif;
        endif;
        
        if ((Encode::strlen(Request::p()->post['telephone']) < 3) || (Encode::strlen(Request::p()->post['telephone']) > 32)):
            $this->error['telephone'] = Lang::get('lang_error_telephone');
        endif;
        
        if (Request::p()->post['password'] || (!isset(Request::p()->get['customer_id']))):
            if ((Encode::strlen(Request::p()->post['password']) < 4) || (Encode::strlen(Request::p()->post['password']) > 20)):
                $this->error['password'] = Lang::get('lang_error_password');
            endif;
            
            if (Request::p()->post['password'] != Request::p()->post['confirm']):
                $this->error['confirm'] = Lang::get('lang_error_confirm');
            endif;
        endif;
        
        $address_required = false;
        
        if (isset(Request::p()->post['address']) && $address_required):
            foreach (Request::p()->post['address'] as $key => $value):
                if ((Encode::strlen($value['firstname']) < 1) || (Encode::strlen($value['firstname']) > 32)):
                    $this->error['address_firstname'][$key] = Lang::get('lang_error_firstname');
                endif;
                
                if ((Encode::strlen($value['lastname']) < 1) || (Encode::strlen($value['lastname']) > 32)):
                    $this->error['address_lastname'][$key] = Lang::get('lang_error_lastname');
                endif;
                
                if ((Encode::strlen($value['address_1']) < 3) || (Encode::strlen($value['address_1']) > 128)):
                    $this->error['address_address_1'][$key] = Lang::get('lang_error_address_1');
                endif;
                
                if ((Encode::strlen($value['city']) < 2) || (Encode::strlen($value['city']) > 128)):
                    $this->error['address_city'][$key] = Lang::get('lang_error_city');
                endif;
                
                Theme::model('locale/country');
                
                $country_info = LocaleCountry::getCountry($value['country_id']);
                
                if ($country_info):
                    if ($country_info['postcode_required'] && (Encode::strlen($value['postcode']) < 2) || (Encode::strlen($value['postcode']) > 10)):
                        $this->error['address_postcode'][$key] = Lang::get('lang_error_postcode');
                    endif;
                    
                    if (Config::get('config_vat') && $value['tax_id'] && ($this->vat->validate($country_info['iso_code_2'], $value['tax_id']) == 'invalid')):
                        $this->error['address_tax_id'][$key] = Lang::get('lang_error_vat');
                    endif;
                endif;
                
                if ($value['country_id'] == ''):
                    $this->error['address_country'][$key] = Lang::get('lang_error_country');
                endif;
                
                if (!isset($value['zone_id']) || $value['zone_id'] == ''):
                    $this->error['address_zone'][$key] = Lang::get('lang_error_zone');
                endif;
            endforeach;
        endif;

        // check affiliate goodies
        if (isset(Request::p()->post['affiliate'])):
            // check all our parameters for validity
            if (Encode::strlen(Request::p()->post['affiliate']['code']) < 1):
                $this->error['code'] = Lang::get('lang_error_code');
            endif;
            
            if (Encode::strlen(Request::p()->post['affiliate']['commission']) < 1):
                $this->error['commission'] = Lang::get('lang_error_commission');
            endif;

            if (Encode::strlen(Request::p()->post['affiliate']['tax_id']) < 1):
                $this->error['tax_id'] = Lang::get('lang_error_tax_id');
            endif;

            if (!Request::p()->post['affiliate']['payment_method']):
                $this->error['payment'] = Lang::get('lang_error_payment');
            else:
                if (Request::p()->post['affiliate']['payment_method'] == 'cheque' && Encode::strlen(Request::p()->post['affiliate']['cheque']) < 1):
                    $this->error['cheque'] = Lang::get('lang_error_cheque');
                endif;

                if (Request::p()->post['affiliate']['payment_method'] == 'paypal' && Encode::strlen(Request::p()->post['affiliate']['paypal']) < 1):
                    $this->error['paypal'] = Lang::get('lang_error_paypal');
                endif;

                if (Request::p()->post['affiliate']['payment_method'] == 'bank' && Encode::strlen(Request::p()->post['affiliate']['bank_name']) < 1):
                    $this->error['bank_name'] = Lang::get('lang_error_bank_name');
                endif;

                if (Request::p()->post['affiliate']['payment_method'] == 'bank' && Encode::strlen(Request::p()->post['affiliate']['bank_account_name']) < 1):
                    $this->error['account_name'] = Lang::get('lang_error_account_name');
                endif;

                if (Request::p()->post['affiliate']['payment_method'] == 'bank' && Encode::strlen(Request::p()->post['affiliate']['bank_account_number']) < 1):
                    $this->error['account_number'] = Lang::get('lang_error_account_number');
                endif;
            endif;
        endif;
        
        if ($this->error && !isset($this->error['warning'])):
            $this->error['warning'] = Lang::get('lang_error_warning');
        endif;
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    protected function validateDelete() {
        if (!\User::hasPermission('modify', 'people/customer')):
            $this->error['warning'] = Lang::get('lang_error_permission');
        endif;
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    public function login() {
        $json = array();
        
        if (isset(Request::p()->get['customer_id'])):
            $customer_id = Request::p()->get['customer_id'];
        else:
            $customer_id = 0;
        endif;
        
        Theme::model('people/customer');
        
        $customer_info = PeopleCustomer::getCustomer($customer_id);
        
        if ($customer_info):
            $token = md5(mt_rand());
            
            PeopleCustomer::editToken($customer_id, $token);
            
            if (isset(Request::p()->get['store_id'])):
                $store_id = Request::p()->get['store_id'];
            else:
                $store_id = 0;
            endif;
            
            Theme::model('setting/store');
            
            $store_info = SettingStore::getStore($store_id);
            
            if ($store_info):
                $json['redirect'] = $store_info['url'] . 'account/login&token=' . $token;
            else:
                $json['redirect'] = Config::get('http.public') . 'account/login&token=' . $token;
            endif;
            
            Response::setOutput(json_encode($json));
        else:
            $data = Theme::language('error/not_found');
            Theme::setTitle(Lang::get('lang_heading_title'));
            Breadcrumb::add('lang_heading_title', 'error/not_found');
            $data = Theme::renderControllers($data);
            Response::setOutput(View::render('error/not_found', $data));
        endif;
    }
    
    public function history() {
        $data = Theme::language('people/customer');
        
        Theme::model('people/customer');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && \User::hasPermission('modify', 'people/customer')):
            PeopleCustomer::addHistory(Request::p()->get['customer_id'], Request::p()->post['comment']);
            $data['success'] = Lang::get('lang_text_success');
        else:
            $data['success'] = '';
        endif;
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && !\User::hasPermission('modify', 'people/customer')):
            $data['error_warning'] = Lang::get('lang_error_permission');
        else:
            $data['error_warning'] = '';
        endif;
        
        if (isset(Request::p()->get['page'])):
            $page = Request::p()->get['page'];
        else:
            $page = 1;
        endif;
        
        $data['histories'] = array();
        
        $results = PeopleCustomer::getHistories(Request::p()->get['customer_id'], ($page - 1) * 10, 10);
        
        foreach ($results as $result):
            $data['histories'][] = array(
                'comment'    => $result['comment'], 
                'date_added' => date(Lang::get('lang_date_format_short'), strtotime($result['date_added']))
            );
        endforeach;
        
        $history_total = PeopleCustomer::getTotalHistories(Request::p()->get['customer_id']);
        
        $data['pagination'] = Theme::paginate(
            $history_total, 
            $page, 
            10, 
            Lang::get('lang_text_pagination'), 
            Url::link('people/customer/history', '' . 'customer_id=' . Request::p()->get['customer_id'] . '&page={page}', 'SSL')
        );
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        Response::setOutput(View::render('people/customer_history', $data));
    }
    
    public function credit() {
        $data = Theme::language('people/customer');
        
        Theme::model('people/customer');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && \User::hasPermission('modify', 'people/customer')):
            PeopleCustomer::addCredit(Request::p()->get['customer_id'], Request::p()->post['description'], Request::p()->post['amount']);
            $data['success'] = Lang::get('lang_text_credit_success');
        else:
            $data['success'] = '';
        endif;
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && !\User::hasPermission('modify', 'people/customer')):
            $data['error_warning'] = Lang::get('lang_error_permission');
        else:
            $data['error_warning'] = '';
        endif;
        
        if (isset(Request::p()->get['page'])):
            $page = Request::p()->get['page'];
        else:
            $page = 1;
        endif;
        
        $data['credits'] = array();
        
        $results = PeopleCustomer::getCredits(Request::p()->get['customer_id'], ($page - 1) * 10, 10);
        
        foreach ($results as $result):
            $data['credits'][] = array(
                'amount'      => Currency::format($result['amount'], Config::get('config_currency')), 
                'description' => $result['description'], 
                'date_added'  => date(Lang::get('lang_date_format_short'), strtotime($result['date_added']))
            );
        endforeach;
        
        $data['balance'] = Currency::format(PeopleCustomer::getCreditTotal(Request::p()->get['customer_id']), Config::get('config_currency'));
        
        $credit_total = PeopleCustomer::getTotalCredits(Request::p()->get['customer_id']);
        
        $data['pagination'] = Theme::paginate(
            $credit_total, 
            $page, 
            10, 
            Lang::get('lang_text_pagination'), 
            Url::link('people/customer/credit', '' . 'customer_id=' . Request::p()->get['customer_id'] . '&page={page}', 'SSL')
        );
        
        Theme::loadjs('javascript/people/customer_alert', $data);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data['javascript'] = Theme::controller('common/javascript');
        
        Response::setOutput(View::render('people/customer_credit', $data));
    }

    public function commission() {
        $data = Theme::language('people/customer');
        
        Theme::model('people/customer');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && \User::hasPermission('modify', 'people/customer')):
            PeopleCustomer::addCommission(Request::p()->get['customer_id'], Request::p()->post['description'], Request::p()->post['amount']);
            $data['success'] = Lang::get('lang_text_commission_success');
        else:
            $data['success'] = '';
        endif;
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && !\User::hasPermission('modify', 'people/customer')):
            $data['error_warning'] = Lang::get('lang_error_permission');
        else:
            $data['error_warning'] = '';
        endif;
        
        if (isset(Request::p()->get['page'])):
            $page = Request::p()->get['page'];
        else:
            $page = 1;
        endif;
        
        $data['commissions'] = array();
        
        $results = PeopleCustomer::getCommissions(Request::p()->get['customer_id'], ($page - 1) * 10, 10);
        
        foreach ($results as $result):
            $data['commissions'][] = array(
                'amount'      => Currency::format($result['amount'], Config::get('config_currency')), 
                'description' => $result['description'], 
                'date_added'  => date(Lang::get('lang_date_format_short'), strtotime($result['date_added']))
            );
        endforeach;
        
        $data['balance'] = Currency::format(PeopleCustomer::getCommissionTotal(Request::p()->get['customer_id']), Config::get('config_currency'));
        
        $commission_total = PeopleCustomer::getTotalCommissions(Request::p()->get['customer_id']);
        
        $data['pagination'] = Theme::paginate(
            $commission_total, 
            $page, 
            Config::get('config_admin_limit'), 
            Lang::get('lang_text_pagination'), 
            Url::link('people/customer/commission', '' . 'customer_id=' . Request::p()->get['customer_id'] . '&page={page}', 'SSL')
        );
        
        Theme::loadjs('javascript/people/customer_alert', $data);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data['javascript'] = Theme::controller('common/javascript');
        
        Response::setOutput(View::render('people/customer_commission', $data));
    }
    
    public function reward() {
        $data = Theme::language('people/customer');
        
        Theme::model('people/customer');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && \User::hasPermission('modify', 'people/customer')):
            PeopleCustomer::addReward(Request::p()->get['customer_id'], Request::p()->post['description'], Request::p()->post['points']);
            $data['success'] = Lang::get('lang_text_reward_success');
        else:
            $data['success'] = '';
        endif;
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && !\User::hasPermission('modify', 'people/customer')):
            $data['error_warning'] = Lang::get('lang_error_permission');
        else:
            $data['error_warning'] = '';
        endif;
        
        if (isset(Request::p()->get['page'])):
            $page = Request::p()->get['page'];
        else:
            $page = 1;
        endif;
        
        $data['rewards'] = array();
        
        $results = PeopleCustomer::getRewards(Request::p()->get['customer_id'], ($page - 1) * 10, 10);
        
        foreach ($results as $result):
            $data['rewards'][] = array(
                'points'      => $result['points'], 
                'description' => $result['description'], 
                'date_added'  => date(Lang::get('lang_date_format_short'), strtotime($result['date_added']))
            );
        endforeach;
        
        $data['balance'] = PeopleCustomer::getRewardTotal(Request::p()->get['customer_id']);
        
        $reward_total = PeopleCustomer::getTotalRewards(Request::p()->get['customer_id']);
        
        $data['pagination'] = Theme::paginate(
            $reward_total, 
            $page, 
            10, 
            Lang::get('lang_text_pagination'), 
            Url::link('people/customer/reward', '' . 'customer_id=' . Request::p()->get['customer_id'] . '&page={page}', 'SSL')
        );
        
        Theme::loadjs('javascript/people/customer_alert', $data);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data['javascript'] = Theme::controller('common/javascript');
        
        Response::setOutput(View::render('people/customer_reward', $data));
    }
    
    public function addBanIP() {
        Lang::load('people/customer');
        
        $json = array();
        
        if (isset(Request::p()->post['ip'])):
            if (!\User::hasPermission('modify', 'people/customer')):
                $json['error'] = Lang::get('lang_error_permission');
            else:
                Theme::model('people/customer');
                
                PeopleCustomer::addBanIP(Request::p()->post['ip']);
                
                $json['success'] = Lang::get('lang_text_success');
            endif;
        endif;
        
        $json = Theme::listen(__CLASS__, __FUNCTION__, $json);
        
        Response::setOutput(json_encode($json));
    }
    
    public function removeBanIP() {
        Lang::load('people/customer');
        
        $json = array();
        
        if (isset(Request::p()->post['ip'])):
            if (!\User::hasPermission('modify', 'people/customer')):
                $json['error'] = Lang::get('lang_error_permission');
            else:
                Theme::model('people/customer');
                
                PeopleCustomer::removeBanIP(Request::p()->post['ip']);
                
                $json['success'] = Lang::get('lang_text_success');
            endif;
        endif;
        
        $json = Theme::listen(__CLASS__, __FUNCTION__, $json);
        
        Response::setOutput(json_encode($json));
    }
    
    public function autocomplete() {
        $json = array();
        
        if (isset(Request::p()->get['filter_username']) || isset(Request::p()->get['filter_name']) || isset(Request::p()->get['filter_email'])):
            Theme::model('people/customer');
            
            $filter_username = (isset(Request::p()->get['filter_username'])) ? Request::p()->get['filter_username'] : null;
            $filter_name     = (isset(Request::p()->get['filter_name'])) ? Request::p()->get['filter_name'] : null;
            $filter_email    = (isset(Request::p()->get['filter_email'])) ? Request::p()->get['filter_email'] : null;
            
            $filter = array(
                'filter_username' => $filter_username, 
                'filter_name'     => $filter_name, 
                'filter_email'    => $filter_email, 
                'start'           => 0, 
                'limit'           => 20
            );
            
            $results = PeopleCustomer::getCustomers($filter);
            
            foreach ($results as $result):
                $json[] = array(
                    'customer_id'       => $result['customer_id'], 
                    'customer_group_id' => $result['customer_group_id'], 
                    'username'          => $result['username'], 
                    'name'              => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')), 
                    'customer_group'    => $result['customer_group'], 
                    'firstname'         => $result['firstname'], 
                    'lastname'          => $result['lastname'], 
                    'email'             => $result['email'], 
                    'telephone'         => $result['telephone'], 
                    'address'           => PeopleCustomer::getAddresses($result['customer_id'])
                );
            endforeach;
        endif;
        
        $sort_order = array();
        
        foreach ($json as $key => $value):
            $sort_order[$key] = $value['name'];
        endforeach;
        
        array_multisort($sort_order, SORT_ASC, $json);
        
        $json = Theme::listen(__CLASS__, __FUNCTION__, $json);
        
        Response::setOutput(json_encode($json));
    }
    
    public function country() {
        $json = array();
        
        Theme::model('locale/country');
        
        $country_info = LocaleCountry::getCountry(Request::p()->get['country_id']);
        
        if ($country_info):
            Theme::model('locale/zone');
            
            $json = array(
                'country_id'        => $country_info['country_id'], 
                'name'              => $country_info['name'], 
                'iso_code_2'        => $country_info['iso_code_2'], 
                'iso_code_3'        => $country_info['iso_code_3'], 
                'address_format'    => $country_info['address_format'], 
                'postcode_required' => $country_info['postcode_required'], 
                'zone'              => LocaleZone::getZonesByCountryId(Request::p()->get['country_id']), 
                'status'            => $country_info['status']
            );
        endif;
        
        $json = Theme::listen(__CLASS__, __FUNCTION__, $json);
        
        Response::setOutput(json_encode($json));
    }
    
    public function address() {
        $json = array();
        
        if (!empty(Request::p()->get['address_id'])):
            Theme::model('people/customer');
            $json = PeopleCustomer::getAddress(Request::p()->get['address_id']);
        endif;
        
        $json = Theme::listen(__CLASS__, __FUNCTION__, $json);
        
        Response::setOutput(json_encode($json));
    }
}
