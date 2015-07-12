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

class Order extends Controller {
    
    public function index() {
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = Url::link('account/order', '', 'SSL');
            
            $this->response->redirect(Url::link('account/login', '', 'SSL'));
        }
        
        $data = Theme::language('account/order');
        
        Theme::model('account/order');
        
        if (isset($this->request->get['order_id'])) {
            $order_info = $this->model_account_order->getOrder($this->request->get['order_id']);
            
            if ($order_info) {
                $order_products = $this->model_account_order->getOrderProducts($this->request->get['order_id']);
                
                foreach ($order_products as $order_product) {
                    $option_data = array();
                    
                    $order_options = $this->model_account_order->getOrderOptions($this->request->get['order_id'], $order_product['order_product_id']);
                    
                    foreach ($order_options as $order_option) {
                        if ($order_option['type'] == 'select' || $order_option['type'] == 'radio') {
                            $option_data[$order_option['product_option_id']] = $order_option['product_option_value_id'];
                        } elseif ($order_option['type'] == 'checkbox') {
                            $option_data[$order_option['product_option_id']][] = $order_option['product_option_value_id'];
                        } elseif ($order_option['type'] == 'text' || $order_option['type'] == 'textarea' || $order_option['type'] == 'date' || $order_option['type'] == 'datetime' || $order_option['type'] == 'time') {
                            $option_data[$order_option['product_option_id']] = $order_option['value'];
                        } elseif ($order_option['type'] == 'file') {
                            $option_data[$order_option['product_option_id']] = $this->encryption->encrypt($order_option['value']);
                        }
                    }
                    
                    $this->session->data['success'] = sprintf(Lang::get('lang_text_success'), $this->request->get['order_id']);
                    
                    $this->cart->add($order_product['product_id'], $order_product['quantity'], $option_data);
                }
                
                $this->response->redirect(Url::link('checkout/cart'));
            }
        }
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Breadcrumb::add('lang_text_account', 'account/dashboard', null, true, 'SSL');
        
        $url = '';
        
        if (isset($this->request->get['page'])) {
            $url.= '&page=' . $this->request->get['page'];
        }
        
        Breadcrumb::add('lang_heading_title', 'account/order', $url, true, 'SSL');
        
        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }
        
        $data['orders'] = array();
        
        $order_total = $this->model_account_order->getTotalOrders();
        
        $results = $this->model_account_order->getOrders(($page - 1) * 10, 10);
        
        foreach ($results as $result) {
            $product_total  = $this->model_account_order->getTotalOrderProductsByOrderId($result['order_id']);
            $gift_card_total = $this->model_account_order->getTotalOrderGiftcardsByOrderId($result['order_id']);
            
            $data['orders'][] = array(
                'order_id'   => $result['order_id'], 
                'name'       => $result['firstname'] . ' ' . $result['lastname'], 
                'status'     => $result['status'], 
                'date_added' => date(Lang::get('lang_date_format_short'), strtotime($result['date_added'])), 
                'products'   => ($product_total + $gift_card_total), 
                'total'      => $this->currency->format($result['total'], $result['currency_code'], $result['currency_value']), 
                'href'       => Url::link('account/order/info', 'order_id=' . $result['order_id'], 'SSL'), 
                'reorder'    => Url::link('account/order', 'order_id=' . $result['order_id'], 'SSL')
            );
        }
        
        $data['pagination'] = Theme::paginate(
            $order_total, 
            $page, 
            10, 
            Lang::get('lang_text_pagination'), 
            Url::link('account/order', 'page={page}', 'SSL')
        );
        
        $data['continue'] = Url::link('account/dashboard', '', 'SSL');
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        Theme::set_controller('header', 'shop/header');
        Theme::set_controller('footer', 'shop/footer');
        
        $data = Theme::render_controllers($data);
        
        $this->response->setOutput(Theme::view('account/order_list', $data));
    }
    
    public function info() {
        $data = Theme::language('account/order');
        
        if (isset($this->request->get['order_id'])) {
            $order_id = $this->request->get['order_id'];
        } else {
            $order_id = 0;
        }
        
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = Url::link('account/order/info', 'order_id=' . $order_id, 'SSL');
            
            $this->response->redirect(Url::link('account/login', '', 'SSL'));
        }
        
        Theme::model('account/order');
        
        $order_info = $this->model_account_order->getOrder($order_id);
        
        if ($order_info) {
            Theme::setTitle(Lang::get('lang_text_order'));
            
            Breadcrumb::add('lang_text_account', 'account/dashboard', null, true, 'SSL');
            
            $url = '';
            
            if (isset($this->request->get['page'])) {
                $url.= '&page=' . $this->request->get['page'];
            }
            
            Breadcrumb::add('lang_heading_title', 'account/order', $url, true, 'SSL');
            Breadcrumb::add('lang_text_order', 'account/order/info', 'order_id=' . $this->request->get['order_id'] . $url, true, 'SSL');
            
            if ($order_info['invoice_no']) {
                $data['invoice_no'] = $order_info['invoice_prefix'] . $order_info['invoice_no'];
            } else {
                $data['invoice_no'] = '';
            }
            
            $data['order_id'] = $this->request->get['order_id'];
            $data['date_added'] = date(Lang::get('lang_date_format_short'), strtotime($order_info['date_added']));
            
            if ($order_info['payment_address_format']) {
                $format = $order_info['payment_address_format'];
            } else {
                $format = 
                    '{firstname} {lastname}' . "\n" . 
                    '{company}' . "\n" . 
                    '{address_1}' . "\n" . 
                    '{address_2}' . "\n" . 
                    '{city} {postcode}' . "\n" . 
                    '{zone}' . "\n" . 
                    '{country}';
            }
            
            $find = array(
                '{firstname}', 
                '{lastname}', 
                '{company}', 
                '{address_1}', 
                '{address_2}', 
                '{city}', 
                '{postcode}', 
                '{zone}', 
                '{zone_code}', 
                '{country}'
            );
            
            $replace = array(
                'firstname' => $order_info['payment_firstname'], 
                'lastname'  => $order_info['payment_lastname'], 
                'company'   => $order_info['payment_company'], 
                'address_1' => $order_info['payment_address_1'], 
                'address_2' => $order_info['payment_address_2'], 
                'city'      => $order_info['payment_city'], 
                'postcode'  => $order_info['payment_postcode'], 
                'zone'      => $order_info['payment_zone'], 
                'zone_code' => $order_info['payment_zone_code'], 
                'country'   => $order_info['payment_country']
            );
            
            $data['payment_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));
            
            $data['payment_method'] = $order_info['payment_method'];
            
            if ($order_info['shipping_address_format']) {
                $format = $order_info['shipping_address_format'];
            } else {
                $format = 
                    '{firstname} {lastname}' . "\n" . 
                    '{company}' . "\n" . 
                    '{address_1}' . "\n" . 
                    '{address_2}' . "\n" . 
                    '{city} {postcode}' . "\n" . 
                    '{zone}' . "\n" . 
                    '{country}';
            }
            
            $find = array(
                '{firstname}', 
                '{lastname}', 
                '{company}', 
                '{address_1}', 
                '{address_2}', 
                '{city}', 
                '{postcode}', 
                '{zone}', 
                '{zone_code}', 
                '{country}'
            );
            
            $replace = array(
                'firstname' => $order_info['shipping_firstname'], 
                'lastname'  => $order_info['shipping_lastname'], 
                'company'   => $order_info['shipping_company'], 
                'address_1' => $order_info['shipping_address_1'], 
                'address_2' => $order_info['shipping_address_2'], 
                'city'      => $order_info['shipping_city'], 
                'postcode'  => $order_info['shipping_postcode'], 
                'zone'      => $order_info['shipping_zone'], 
                'zone_code' => $order_info['shipping_zone_code'], 
                'country'   => $order_info['shipping_country']
            );
            
            $data['shipping_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));
            
            $data['shipping_method'] = $order_info['shipping_method'];
            
            $data['products'] = array();
            
            $products = $this->model_account_order->getOrderProducts($this->request->get['order_id']);
            
            foreach ($products as $product) {
                $option_data = array();
                
                $options = $this->model_account_order->getOrderOptions($this->request->get['order_id'], $product['order_product_id']);
                
                foreach ($options as $option) {
                    if ($option['type'] != 'file') {
                        $value = $option['value'];
                    } else {
                        $value = $this->encode->substr($option['value'], 0, $this->encode->strrpos($option['value'], '.'));
                    }
                    
                    $option_data[] = array(
                        'name' => $option['name'], 
                        'value' => ($this->encode->strlen($value) > 20 ? $this->encode->substr($value, 0, 20) . '..' : $value)
                    );
                }
                
                $data['products'][] = array(
                    'name'     => $product['name'], 
                    'model'    => $product['model'], 
                    'option'   => $option_data, 
                    'quantity' => $product['quantity'], 
                    'price'    => $this->currency->format($product['price'] + (Config::get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']), 
                    'total'    => $this->currency->format($product['total'] + (Config::get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']), 
                    'return'   => Url::link('account/returns/insert', 'order_id=' . $order_info['order_id'] . '&product_id=' . $product['product_id'], 'SSL')
                );
            }
            
            // Giftcard
            $data['gift_cards'] = array();
            
            $gift_cards = $this->model_account_order->getOrderGiftcards($this->request->get['order_id']);
            
            foreach ($gift_cards as $gift_card) {
                $data['gift_cards'][] = array(
                    'description' => $gift_card['description'], 
                    'amount'      => $this->currency->format($gift_card['amount'], $order_info['currency_code'], $order_info['currency_value'])
                );
            }
            
            $data['totals'] = $this->model_account_order->getOrderTotals($this->request->get['order_id']);
            
            $data['comment'] = nl2br($order_info['comment']);
            
            $data['histories'] = array();
            
            $results = $this->model_account_order->getOrderHistories($this->request->get['order_id']);
            
            foreach ($results as $result) {
                $data['histories'][] = array(
                    'date_added' => date(Lang::get('lang_date_format_short'), strtotime($result['date_added'])), 
                    'status'     => $result['status'], 
                    'comment'    => nl2br($result['comment'])
                );
            }
            
            $data['continue'] = Url::link('account/order', '', 'SSL');
            
            $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
            
            Theme::set_controller('header', 'shop/header');
            Theme::set_controller('footer', 'shop/footer');
            
            $data = Theme::render_controllers($data);
            
            $this->response->setOutput(Theme::view('account/order_info', $data));
        } else {
            Theme::setTitle(Lang::get('lang_text_order'));
            
            $data['heading_title'] = Lang::get('lang_text_order');
            
            Breadcrumb::add('lang_text_account', 'account/dashboard', null, true, 'SSL');
            Breadcrumb::add('lang_heading_title', 'account/order', null, true, 'SSL');
            Breadcrumb::add('lang_text_order', 'account/order/info', 'order_id=' . $order_id, true, 'SSL');
            
            $data['continue'] = Url::link('account/order', '', 'SSL');
            
            $this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . '/1.1 404 Not Found');
            
            $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
            
            Theme::set_controller('header', 'shop/header');
            Theme::set_controller('footer', 'shop/footer');
            
            $data = Theme::render_controllers($data);
            
            $this->response->setOutput(Theme::view('error/not_found', $data));
        }
    }
}
