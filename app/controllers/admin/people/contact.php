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
        
        $data['token'] = $this->session->data['token'];
        
        if (isset($this->session->data['success'])):
            $data['success'] = $this->session->data['success'];
            unset($this->session->data['success']);
        endif;
        
        Breadcrumb::add('lang_heading_title', 'people/contact');
        
        $data['cancel'] = Url::link('people/contact', 'token=' . $this->session->data['token'], 'SSL');
        
        Theme::model('setting/store');
        
        $data['stores'] = $this->model_setting_store->getStores();
        
        Theme::model('people/customer_group');
        
        $data['customer_groups'] = $this->model_people_customer_group->getCustomerGroups(0);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        $data = Theme::renderControllers($data);
        
        Response::setOutput(Theme::view('people/contact', $data));
    }
    
    public function send() {
        Lang::load('people/contact');
        
        $json = array();
        
        if ($this->request->server['REQUEST_METHOD'] == 'POST'):
            if (!\User::hasPermission('modify', 'people/contact')):
                $json['error']['warning'] = Lang::get('lang_error_permission');
            endif;
            
            if (!$this->request->post['subject']):
                $json['error']['subject'] = Lang::get('lang_error_subject');
            endif;
            
            if (!$this->request->post['contact_text']):
                $json['error']['text'] = Lang::get('lang_error_text');
            endif;

            if (!$this->request->post['contact_html']):
                $json['error']['html'] = Lang::get('lang_error_html');
            endif;
            
            if (!$json):
                Theme::model('people/customer');
                Theme::model('people/customer_group');
                Theme::model('sale/order');
                
                if (isset($this->request->get['page'])):
                    $page = $this->request->get['page'];
                else:
                    $page = 1;
                endif;
                
                $email_total = 0;
                $emails      = array();
                
                switch ($this->request->post['to']):
                    case 'newsletter':
                        $customer_data = array(
                            'filter_newsletter' => 1, 
                            'start'             => ($page - 1) * 10, 
                            'limit'             => 10
                        );
                        
                        $email_total = $this->model_people_customer->getTotalCustomers($customer_data);
                        $results     = $this->model_people_customer->getCustomers($customer_data);
                        
                        foreach ($results as $result):
                            $emails[] = $result['customer_id'];
                        endforeach;
                        break;
                    case 'customer_all':
                        $customer_data = array(
                            'start' => ($page - 1) * 10, 
                            'limit' => 10
                        );
                        
                        $email_total = $this->model_people_customer->getTotalCustomers($customer_data);
                        $results     = $this->model_people_customer->getCustomers($customer_data);
                        
                        foreach ($results as $result):
                            $emails[] = $result['customer_id'];
                        endforeach;
                        break;
                    case 'customer_group':
                        $customer_data = array(
                            'filter_customer_group_id' => $this->request->post['customer_group_id'], 
                            'start'                    => ($page - 1) * 10, 
                            'limit'                    => 10
                        );
                        
                        $email_total = $this->model_people_customer->getTotalCustomers($customer_data);
                        $results     = $this->model_people_customer->getCustomers($customer_data);
                        
                        foreach ($results as $result):
                            $emails[] = $result['customer_id'];
                        endforeach;
                        break;
                    case 'customer':
                        if (!empty($this->request->post['customer'])):
                            foreach ($this->request->post['customer'] as $customer_id):
                                $customer_info = $this->model_people_customer->getCustomer($customer_id);
                                
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
                        
                        $email_total = $this->model_people_customer->getTotalAffiliates($affiliate_data);
                        $results     = $this->model_people_customer->getAffiliates($affiliate_data);
                        
                        foreach ($results as $result):
                            $emails[] = $result['customer_id'];
                        endforeach;
                        break;
                    case 'affiliate':
                        if (!empty($this->request->post['affiliate'])):
                            foreach ($this->request->post['affiliate'] as $affiliate_id):
                                $affiliate_info = $this->model_people_customer->getCustomer($affiliate_id);
                                
                                if ($affiliate_info):
                                    $emails[] = $affiliate_info['customer_id'];
                                endif;
                            endforeach;
                        endif;
                        break;
                    case 'product':
                        if (isset($this->request->post['product'])):
                            $email_total = $this->model_sale_order->getTotalCustomersByProductsOrdered($this->request->post['product']);
                            $results     = $this->model_sale_order->getCustomersByProductsOrdered($this->request->post['product'], ($page - 1) * 10, 10);
                            
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
                        $json['next'] = str_replace('&amp;', '&', Url::link('people/contact/send', 'token=' . $this->session->data['token'] . '&page=' . ($page + 1), 'SSL'));
                    else:
                        $json['next'] = '';
                    endif;
                    
                    if ($end < $email_total):
                        $json['redirect'] = '';
                    else:
                        $json['redirect'] = str_replace('&amp;', '&', Url::link('people/contact', 'token=' . $this->session->data['token'], 'SSL'));
                        $this->session->data['success'] = Lang::get('lang_text_success');
                    endif;

                    $content = array(
                        'text' => html_entity_decode($this->request->post['contact_text'], ENT_QUOTES, 'UTF-8'),
                        'html' => html_entity_decode($this->request->post['contact_html'], ENT_QUOTES, 'UTF-8')
                    );
                    
                    foreach ($emails as $customer_id):
                        $callback = array(
                            'customer_id' => $customer_id,
                            'subject'     => $this->request->post['subject'],
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
