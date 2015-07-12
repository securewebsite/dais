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


namespace App\Controllers\Front\Account;
use App\Controllers\Controller;

class Register extends Controller {
    private $error = array();
    
    public function index() {
        if ($this->customer->isLogged()) {
            $this->response->redirect(Url::link('account/dashboard', '', 'SSL'));
        }
        
        $data = Theme::language('account/register');
        
        Theme::setTitle(Lang::get('lang_heading_title'));

        JS::register('validation/validate.min', 'migrate.min')
            ->register('validation/validate.bootstrap.min', 'validate.min')
            ->register('steps.min', 'validate.bootstrap.min');

        CSS::register('steps', 'calendar')
            ->register('validate', 'steps');
        
        Theme::model('account/customer');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_account_customer->addCustomer($this->request->post);
            
            $this->customer->login($this->request->post['email'], $this->request->post['password']);
            
            unset($this->session->data['guest']);

            // Default Shipping Address
            if (Config::get('config_tax_customer') == 'shipping') {
                $this->session->data['shipping_country_id'] = $this->request->post['country_id'];
                $this->session->data['shipping_zone_id']    = $this->request->post['zone_id'];
                $this->session->data['shipping_postcode']   = $this->request->post['postcode'];               
            }

            // Default Payment Address
            if (Config::get('config_tax_customer') == 'payment') {
                $this->session->data['payment_country_id'] = $this->request->post['country_id'];
                $this->session->data['payment_zone_id']    = $this->request->post['zone_id'];          
            }
            
            $this->response->redirect(Url::link('account/success'));
        }
        
        Breadcrumb::add('lang_text_register', 'account/register', null, true, 'SSL');
        
        $data['text_account_already'] = sprintf(Lang::get('lang_text_account_already'), Url::link('account/login', '', 'SSL'));
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        if (isset($this->error['username'])) {
            $data['error_username'] = $this->error['username'];
        } else {
            $data['error_username'] = '';
        }

        if (isset($this->error['firstname'])) {
            $data['error_firstname'] = $this->error['firstname'];
        } else {
            $data['error_firstname'] = '';
        }   

        if (isset($this->error['lastname'])) {
            $data['error_lastname'] = $this->error['lastname'];
        } else {
            $data['error_lastname'] = '';
        }
        
        if (isset($this->error['email'])) {
            $data['error_email'] = $this->error['email'];
        } else {
            $data['error_email'] = '';
        }

        if (isset($this->error['telephone'])) {
            $data['error_telephone'] = $this->error['telephone'];
        } else {
            $data['error_telephone'] = '';
        }
        
        if (isset($this->error['password'])) {
            $data['error_password'] = $this->error['password'];
        } else {
            $data['error_password'] = '';
        }
        
        if (isset($this->error['confirm'])) {
            $data['error_confirm'] = $this->error['confirm'];
        } else {
            $data['error_confirm'] = '';
        }

        if (isset($this->error['company_id'])) {
            $data['error_company_id'] = $this->error['company_id'];
        } else {
            $data['error_company_id'] = '';
        }

        if (isset($this->error['tax_id'])) {
            $data['error_tax_id'] = $this->error['tax_id'];
        } else {
            $data['error_tax_id'] = '';
        }

        if (isset($this->error['address_1'])) {
            $data['error_address_1'] = $this->error['address_1'];
        } else {
            $data['error_address_1'] = '';
        }

        if (isset($this->error['city'])) {
            $data['error_city'] = $this->error['city'];
        } else {
            $data['error_city'] = '';
        }

        if (isset($this->error['postcode'])) {
            $data['error_postcode'] = $this->error['postcode'];
        } else {
            $data['error_postcode'] = '';
        }

        if (isset($this->error['country'])) {
            $data['error_country'] = $this->error['country'];
        } else {
            $data['error_country'] = '';
        }

        if (isset($this->error['zone'])) {
            $data['error_zone'] = $this->error['zone'];
        } else {
            $data['error_zone'] = '';
        }
        
        $data['action'] = Url::link('account/register', '', 'SSL');
        
        if (isset($this->request->post['username'])) {
            $data['username'] = $this->request->post['username'];
        } else {
            $data['username'] = '';
        }

        if (isset($this->request->post['firstname'])) {
            $data['firstname'] = $this->request->post['firstname'];
        } else {
            $data['firstname'] = '';
        }

        if (isset($this->request->post['lastname'])) {
            $data['lastname'] = $this->request->post['lastname'];
        } else {
            $data['lastname'] = '';
        }
        
        if (isset($this->request->post['email'])) {
            $data['email'] = $this->request->post['email'];
        } else {
            $data['email'] = '';
        }

        if (isset($this->request->post['telephone'])) {
            $data['telephone'] = $this->request->post['telephone'];
        } else {
            $data['telephone'] = '';
        }

        if (isset($this->request->post['company'])) {
            $data['company'] = $this->request->post['company'];
        } else {
            $data['company'] = '';
        }
        
        Theme::model('account/customer_group');
        
        $data['customer_groups'] = array();
        
        if (is_array(Config::get('config_customer_group_display'))) {
            $customer_groups = $this->model_account_customer_group->getCustomerGroups();
            
            foreach ($customer_groups as $customer_group) {
                if (in_array($customer_group['customer_group_id'], Config::get('config_customer_group_display'))) {
                    $data['customer_groups'][] = $customer_group;
                }
            }
        }
        
        if (isset($this->request->post['customer_group_id'])) {
            $data['customer_group_id'] = $this->request->post['customer_group_id'];
        } else {
            $data['customer_group_id'] = Config::get('config_customer_group_id');
        }

        // Company ID
        if (isset($this->request->post['company_id'])) {
            $data['company_id'] = $this->request->post['company_id'];
        } else {
            $data['company_id'] = '';
        }

        // Tax ID
        if (isset($this->request->post['tax_id'])) {
            $data['tax_id'] = $this->request->post['tax_id'];
        } else {
            $data['tax_id'] = '';
        }

        if (isset($this->request->post['address_1'])) {
            $data['address_1'] = $this->request->post['address_1'];
        } else {
            $data['address_1'] = '';
        }

        if (isset($this->request->post['address_2'])) {
            $data['address_2'] = $this->request->post['address_2'];
        } else {
            $data['address_2'] = '';
        }

        if (isset($this->request->post['postcode'])) {
            $data['postcode'] = $this->request->post['postcode'];
        } elseif (isset($this->session->data['shipping_postcode'])) {
            $data['postcode'] = $this->session->data['shipping_postcode'];      
        } else {
            $data['postcode'] = '';
        }

        if (isset($this->request->post['city'])) {
            $data['city'] = $this->request->post['city'];
        } else {
            $data['city'] = '';
        }

        if (isset($this->request->post['country_id'])) {
            $data['country_id'] = $this->request->post['country_id'];
        } elseif (isset($this->session->data['shipping_country_id'])) {
            $data['country_id'] = $this->session->data['shipping_country_id'];      
        } else {    
            $data['country_id'] = Config::get('config_country_id');
        }

        if (isset($this->request->post['zone_id'])) {
            $data['zone_id'] = $this->request->post['zone_id'];
        } elseif (isset($this->session->data['shipping_zone_id'])) {
            $data['zone_id'] = $this->session->data['shipping_zone_id'];            
        } else {
            $data['zone_id'] = '';
        }

        $data['params'] = htmlentities('{"zone_id":"' . $data['zone_id'] . '","select":"' . Lang::get('lang_text_select') . '","none":"' . Lang::get('lang_text_none') . '"}');

        Theme::model('locale/country');

        $data['countries'] = $this->model_locale_country->getCountries();
        
        if (isset($this->request->post['password'])) {
            $data['password'] = $this->request->post['password'];
        } else {
            $data['password'] = '';
        }
        
        if (isset($this->request->post['confirm'])) {
            $data['confirm'] = $this->request->post['confirm'];
        } else {
            $data['confirm'] = '';
        }

        if (isset($this->request->post['newsletter'])) {
            $data['newsletter'] = $this->request->post['newsletter'];
        } else {
            $data['newsletter'] = '';
        }
        
        if (Config::get('config_account_id')) {
            Theme::model('content/page');
            
            $page_info = $this->model_content_page->getPage(Config::get('config_account_id'));
            if ($page_info) {
                $data['text_agree']             = sprintf(Lang::get('lang_text_agree'), Url::link('content/page/info', 'page_id=' . Config::get('config_account_id'), 'SSL'), $page_info['title'], $page_info['title']);
                $data['legal_account']          = sprintf(Lang::get('lang_text_legal_account'), $page_info['title']);
                $data['lang_error_req_account'] = sprintf(Lang::get('lang_error_req_account'), $page_info['title']);
            } else {
                $data['text_agree']             = '';
                $data['legal_account']          = '';
                $data['lang_error_req_account'] = '';
            }
        } else {
            $data['text_agree']             = '';
            $data['legal_account']          = '';
            $data['lang_error_req_account'] = ''; 
        }
        
        if (isset($this->request->post['agree'])) {
            $data['agree'] = $this->request->post['agree'];
        } else {
            $data['agree'] = false;
        }

        /**
         * Adding in affiliate stuff if allowed.
         */
        
        $data['affiliate_allowed'] = false;

        if (Config::get('config_affiliate_allowed')):
            $data['affiliate_allowed'] = true;

            // errors first
            if (isset($this->error['tax'])):
                $data['error_tax'] = $this->error['tax'];
            else:
                $data['error_tax'] = '';
            endif;

            if (isset($this->error['cheque'])):
                $data['error_cheque'] = $this->error['cheque'];
            else:
                $data['error_cheque'] = '';
            endif;

            if (isset($this->error['paypal'])):
                $data['error_paypal'] = $this->error['paypal'];
            else:
                $data['error_paypal'] = '';
            endif;

            if (isset($this->error['bank_name'])):
                $data['error_bank_name'] = $this->error['bank_name'];
            else:
                $data['error_bank_name'] = '';
            endif;

            if (isset($this->error['bank_account_name'])):
                $data['error_bank_account_name'] = $this->error['bank_account_name'];
            else:
                $data['error_bank_account_name'] = '';
            endif;

            if (isset($this->error['bank_account_number'])):
                $data['error_bank_account_number'] = $this->error['bank_account_number'];
            else:
                $data['error_bank_account_number'] = '';
            endif;

            if (isset($this->error['slug'])):
                $data['error_slug'] = $this->error['slug'];
            else:
                $data['error_slug'] = '';
            endif;

            if (isset($this->error['affiliate_agree'])):
                $data['error_affiliate_agree'] = $this->error['affiliate_agree'];
            else:
                $data['error_affiliate_agree'] = '';
            endif;

            $data['vanity_base'] = Config::get('http.server');

            if (isset($this->request->post['affiliate'])):
                $data['affiliate'] = $this->request->post['affiliate'];
            else:
                $data['affiliate']['status']              = 0;
                $data['affiliate']['website']             = '';
                $data['affiliate']['slug']                = '';
                $data['affiliate']['tax']                 = '';
                $data['affiliate']['payment_method']      = 'cheque';
                $data['affiliate']['cheque']              = '';
                $data['affiliate']['paypal']              = '';
                $data['affiliate']['bank_name']           = '';
                $data['affiliate']['bank_branch_number']  = '';
                $data['affiliate']['bank_swift_code']     = '';
                $data['affiliate']['bank_account_name']   = '';
                $data['affiliate']['bank_account_number'] = '';

                if (Config::get('config_affiliate_terms')):
                    Theme::model('content/page');
                    
                    $page_info = $this->model_content_page->getPage(Config::get('config_affiliate_terms'));
                    if ($page_info):
                        $data['text_affiliate_agree']     = sprintf(Lang::get('lang_text_agree'), Url::link('content/page/info', 'page_id=' . Config::get('config_affiliate_terms'), 'SSL'), $page_info['title'], $page_info['title']);
                        $data['legal_affiliate']          = sprintf(Lang::get('lang_text_legal_affiliate'), $page_info['title']);
                        $data['lang_error_req_affiliate'] = sprintf(Lang::get('lang_error_req_affiliate'), $page_info['title']);
                    else:
                        $data['text_agree']               = '';
                        $data['legal_affiliate']          = '';
                        $data['lang_error_req_affiliate'] = '';
                    endif;
                else:
                    $data['text_agree']               = '';
                    $data['legal_affiliate']          = '';
                    $data['lang_error_req_affiliate'] = '';
                endif;

                if (isset($this->request->post['affiliate_agree'])):
                    $data['affiliate_agree'] = $this->request->post['affiliate_agree'];
                else:
                    $data['affiliate_agree'] = false;
                endif;
            endif;
        endif;
        
        Theme::loadjs('javascript/account/register', $data);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::render_controllers($data);
        
        $this->response->setOutput(Theme::view('account/register', $data));
    }
    
    protected function validate() {
        // Customer Group
        Theme::model('account/customer_group');

        if (isset($this->request->post['customer_group_id']) && is_array(Config::get('config_customer_group_display')) && in_array($this->request->post['customer_group_id'], Config::get('config_customer_group_display'))) {
            $customer_group_id = $this->request->post['customer_group_id'];
        } else {
            $customer_group_id = Config::get('config_customer_group_id');
        }

        $customer_group = $this->model_account_customer_group->getCustomerGroup($customer_group_id);

        if ($customer_group) {  
            // Company ID
            if ($customer_group['company_id_display'] && $customer_group['company_id_required'] && empty($this->request->post['company_id'])) {
                $this->error['company_id'] = Lang::get('lang_error_company_id');
            }

            // Tax ID 
            if ($customer_group['tax_id_display'] && $customer_group['tax_id_required'] && empty($this->request->post['tax_id'])) {
                $this->error['tax_id'] = Lang::get('lang_error_tax_id');
            }                       
        }

        if (($this->encode->strlen($this->request->post['address_1']) < 3) || ($this->encode->strlen($this->request->post['address_1']) > 128)) {
            $this->error['address_1'] = Lang::get('lang_error_address_1');
        }

        if (($this->encode->strlen($this->request->post['city']) < 2) || ($this->encode->strlen($this->request->post['city']) > 128)) {
            $this->error['city'] = Lang::get('lang_error_city');
        }

        Theme::model('locale/country');

        $country_info = $this->model_locale_country->getCountry($this->request->post['country_id']);

        if ($country_info) {
            if ($country_info['postcode_required'] && ($this->encode->strlen($this->request->post['postcode']) < 2) || ($this->encode->strlen($this->request->post['postcode']) > 10)) {
                $this->error['postcode'] = Lang::get('lang_error_postcode');
            }

            if (Config::get('config_vat') && $this->request->post['tax_id'] && ($this->vat->validate($country_info['iso_code_2'], $this->request->post['tax_id']) == 'invalid')) {
                $this->error['tax_id'] = Lang::get('lang_error_vat');
            }
        }
        
        if (Config::get('config_account_id')) {
            Theme::model('content/page');
            
            $page_info = $this->model_content_page->getPage(Config::get('config_account_id'));
            
            if ($page_info && !isset($this->request->post['agree'])) {
                $this->error['warning'] = sprintf(Lang::get('lang_error_agree'), $page_info['title']);
            }
        }

        if (!empty($this->request->post['affiliate']) && $this->request->post['affiliate']['status'] == 1):
            if ($this->encode->strlen($this->request->post['affiliate']['tax']) < 1):
                $this->error['tax'] = Lang::get('lang_error_tax_id');
            endif;

            if ($this->encode->strlen($this->request->post['affiliate']['slug']) < 1):
                $this->error['slug'] = Lang::get('lang_error_vanity');
            endif;

            if (!$this->request->post['affiliate']['payment_method']):
                $this->error['payment_method'] = Lang::get('lang_error_payment_method');
            else:
                if ($this->request->post['affiliate']['payment_method'] == 'cheque' && $this->encode->strlen($this->request->post['affiliate']['cheque']) < 1):
                    $this->error['cheque'] = Lang::get('lang_error_cheque');
                endif;

                if ($this->request->post['affiliate']['payment_method'] == 'paypal' && $this->encode->strlen($this->request->post['affiliate']['paypal']) < 1):
                    $this->error['paypal'] = Lang::get('lang_error_paypal');
                endif;

                if ($this->request->post['affiliate']['payment_method'] == 'bank' && $this->encode->strlen($this->request->post['affiliate']['bank_name']) < 1):
                    $this->error['bank_name'] = Lang::get('lang_error_bank_name');
                endif;

                if ($this->request->post['affiliate']['payment_method'] == 'bank' && $this->encode->strlen($this->request->post['affiliate']['bank_account_name']) < 1):
                    $this->error['bank_account_name'] = Lang::get('lang_error_bank_account_name');
                endif;

                if ($this->request->post['affiliate']['payment_method'] == 'bank' && $this->encode->strlen($this->request->post['affiliate']['bank_account_number']) < 1):
                    $this->error['bank_account_number'] = Lang::get('lang_error_bank_account_number');
                endif;
            endif;
        endif;
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    public function username() {
        $json = array();
        
        Theme::language('account/register');
        Theme::model('account/customer');
        
        $json['valid'] = true;
        
        if ($this->model_account_customer->getTotalCustomersByUsername($this->request->get['username'])):
            $json['valid']   = false;
            $json['message'] = Lang::get('lang_error_uexists');
        endif;
        
        $this->response->setOutput(json_encode($json));
    }
    
    public function email() {
        $json = array();
        
        Theme::language('account/register');
        Theme::model('account/customer');
        
        $json['valid'] = true;
        
        if ($this->model_account_customer->getTotalCustomersByEmail($this->request->get['email'])):
            $json['valid']   = false;
            $json['message'] = Lang::get('lang_error_exists');
        endif;
        
        $this->response->setOutput(json_encode($json));
    }

    public function country() {
        $json = array();
        
        Theme::model('locale/country');
        
        $country_info = $this->model_locale_country->getCountry($this->request->get['country_id']);
        
        if ($country_info) {
            Theme::model('locale/zone');
            
            $json = array('country_id' => $country_info['country_id'], 'name' => $country_info['name'], 'iso_code_2' => $country_info['iso_code_2'], 'iso_code_3' => $country_info['iso_code_3'], 'address_format' => $country_info['address_format'], 'postcode_required' => $country_info['postcode_required'], 'zone' => $this->model_locale_zone->getZonesByCountryId($this->request->get['country_id']), 'status' => $country_info['status']);
        }
        
        $json = Theme::listen(__CLASS__, __FUNCTION__, $json);
        
        $this->response->setOutput(json_encode($json));
    }

    public function slug() {
        Lang::load('account/affiliate');
        Theme::model('tool/utility');
        
        $json = array();
        
        $json['valid'] = true;
        
        if (!isset($this->request->get['affiliate']['slug']) || $this->encode->strlen($this->request->get['affiliate']['slug']) < 1):
            $json['valid']   = false;
            $json['message'] = Lang::get('lang_error_slug');
        else:
            
            // build slug
            $slug = $this->url->build_slug($this->request->get['affiliate']['slug']);
            
            // check that the slug is globally unique
            $query = $this->model_tool_utility->findSlugByName($slug);
            
            if ($query):
                $json['valid']   = false;
                $json['message'] = sprintf(Lang::get('lang_error_slug_found'), $slug);
            else:
                $json['slug'] = $slug;
            endif;
        endif;
        
        $json = Theme::listen(__CLASS__, __FUNCTION__, $json);
        
        $this->response->setOutput(json_encode($json));
    }
}
