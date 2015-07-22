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

class Contact extends Controller {
    
    public function index() {
        $data = Theme::language('people/contact');
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        if (isset(Session::p()->data['success'])):
            $data['success'] = Session::p()->data['success'];
            unset(Session::p()->data['success']);
        endif;
        
        Breadcrumb::add('lang_heading_title', 'people/contact');
        
        $data['cancel'] = Url::link('people/contact', '', 'SSL');
        
        Theme::model('setting/store');
        
        $data['stores'] = SettingStore::getStores();
        
        Theme::model('people/customer_group');
        
        $data['customer_groups'] = PeopleCustomerGroup::getCustomerGroups(0);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('people/contact', $data));
    }
    
    public function send() {
        Lang::load('people/contact');
        
        $json = array();
        
        if (Request::p()->server['REQUEST_METHOD'] == 'POST'):
            if (!\User::hasPermission('modify', 'people/contact')):
                $json['error']['warning'] = Lang::get('lang_error_permission');
            endif;
            
            if (!Request::p()->post['subject']):
                $json['error']['subject'] = Lang::get('lang_error_subject');
            endif;
            
            if (!Request::p()->post['contact_text']):
                $json['error']['text'] = Lang::get('lang_error_text');
            endif;

            if (!Request::p()->post['contact_html']):
                $json['error']['html'] = Lang::get('lang_error_html');
            endif;
            
            if (!$json):
                Theme::model('people/customer');
                Theme::model('people/customer_group');
                Theme::model('sale/order');
                
                if (isset(Request::p()->get['page'])):
                    $page = Request::p()->get['page'];
                else:
                    $page = 1;
                endif;
                
                $email_total = 0;
                $emails      = array();
                
                switch (Request::p()->post['to']):
                    case 'newsletter':
                        $customer_data = array(
                            'filter_newsletter' => 1, 
                            'start'             => ($page - 1) * 10, 
                            'limit'             => 10
                        );
                        
                        $email_total = PeopleCustomer::getTotalCustomers($customer_data);
                        $results     = PeopleCustomer::getCustomers($customer_data);
                        
                        foreach ($results as $result):
                            $emails[] = $result['customer_id'];
                        endforeach;
                        break;
                    case 'customer_all':
                        $customer_data = array(
                            'start' => ($page - 1) * 10, 
                            'limit' => 10
                        );
                        
                        $email_total = PeopleCustomer::getTotalCustomers($customer_data);
                        $results     = PeopleCustomer::getCustomers($customer_data);
                        
                        foreach ($results as $result):
                            $emails[] = $result['customer_id'];
                        endforeach;
                        break;
                    case 'customer_group':
                        $customer_data = array(
                            'filter_customer_group_id' => Request::p()->post['customer_group_id'], 
                            'start'                    => ($page - 1) * 10, 
                            'limit'                    => 10
                        );
                        
                        $email_total = PeopleCustomer::getTotalCustomers($customer_data);
                        $results     = PeopleCustomer::getCustomers($customer_data);
                        
                        foreach ($results as $result):
                            $emails[] = $result['customer_id'];
                        endforeach;
                        break;
                    case 'customer':
                        if (!empty(Request::p()->post['customer'])):
                            foreach (Request::p()->post['customer'] as $customer_id):
                                $customer_info = PeopleCustomer::getCustomer($customer_id);
                                
                                if ($customer_info):
                                    $emails[] = $customer_info['customer_id'];
                                endif;
                            endforeach;
                        endif;
                        break;
                    case 'affiliate_all':
                        $affiliate_data = array(
                            'start' => ($page - 1) * 10, 
                            'limit' => 10
                        );
                        
                        $email_total = PeopleCustomer::getTotalAffiliates($affiliate_data);
                        $results     = PeopleCustomer::getAffiliates($affiliate_data);
                        
                        foreach ($results as $result):
                            $emails[] = $result['customer_id'];
                        endforeach;
                        break;
                    case 'affiliate':
                        if (!empty(Request::p()->post['affiliate'])):
                            foreach (Request::p()->post['affiliate'] as $affiliate_id):
                                $affiliate_info = PeopleCustomer::getCustomer($affiliate_id);
                                
                                if ($affiliate_info):
                                    $emails[] = $affiliate_info['customer_id'];
                                endif;
                            endforeach;
                        endif;
                        break;
                    case 'product':
                        if (isset(Request::p()->post['product'])):
                            $email_total = SaleOrder::getTotalCustomersByProductsOrdered(Request::p()->post['product']);
                            $results     = SaleOrder::getCustomersByProductsOrdered(Request::p()->post['product'], ($page - 1) * 10, 10);
                            
                            foreach ($results as $result):
                                $emails[] = $result['customer_id'];
                            endforeach;
                        endif;
                        break;
                endswitch;
                
                if ($emails):
                    $start = ($page - 1) * 10;
                    $end   = $start + 10;
                    
                    if ($end < $email_total):
                        $json['success'] = sprintf(Lang::get('lang_text_sent'), $start, $email_total);
                    else:
                        $json['success'] = Lang::get('lang_text_success');
                    endif;
                    
                    if ($end < $email_total):
                        $json['next'] = str_replace('&amp;', '&', Url::link('people/contact/send', 'page=' . ($page + 1), 'SSL'));
                    else:
                        $json['next'] = '';
                    endif;
                    
                    if ($end < $email_total):
                        $json['redirect'] = '';
                    else:
                        $json['redirect'] = str_replace('&amp;', '&', Url::link('people/contact', '', 'SSL'));
                        Session::p()->data['success'] = Lang::get('lang_text_success');
                    endif;

                    $content = array(
                        'text' => html_entity_decode(Request::p()->post['contact_text'], ENT_QUOTES, 'UTF-8'),
                        'html' => html_entity_decode(Request::p()->post['contact_html'], ENT_QUOTES, 'UTF-8')
                    );
                    
                    foreach ($emails as $customer_id):
                        $callback = array(
                            'customer_id' => $customer_id,
                            'subject'     => Request::p()->post['subject'],
                            'content'     => $content,
                            'callback'    => array(
                                'class'  => __CLASS__,
                                'method' => 'admin_people_contact'
                            )
                        );

                        Theme::notify('admin_people_contact', $callback);
                    endforeach;
                endif;
            endif;
        endif;
        
        $json = Theme::listen(__CLASS__, __FUNCTION__, $json);
        
        Response::setOutput(json_encode($json));
    }

    public function admin_people_contact($data, $message) {
       
        $message['subject'] = $data['subject'];
        $message['text']    = str_replace('!content!', $data['content']['text'], $message['text']);
        $message['html']    = str_replace('!content!', $data['content']['html'], $message['html']);

        return $message;
    }
}
