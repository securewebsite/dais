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

namespace Admin\Controller\Common;
use Dais\Engine\Controller;

class Menu extends Controller {
    
    public function index() {
        
        $data = $this->theme->language('common/menu');
        
        if (!isset($this->request->get['token']) || !isset($this->session->data['token']) && ($this->request->get['token'] != $this->session->data['token'])):
            
            $data['logged'] = false;
        else:
            $data['paypalexpress_status']        = ($this->config->get('paypalexpress_status')) ? : false;
            $data['logged']                      = sprintf($this->language->get('lang_text_logged'), $this->user->getUsername());
            $data['dashboard']                   = $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL');
            $data['allowed'] = false;
            if ($this->config->get('config_affiliate_allowed')):
                $data['affiliate'] = $this->url->link('people/customer', 'token=' . $this->session->data['token'] . '&filter_affiliate=1', 'SSL');
                $data['allowed']   = true;
            endif;
            $data['attribute']                   = $this->url->link('catalog/attribute', 'token=' . $this->session->data['token'], 'SSL');
            $data['attribute_group']             = $this->url->link('catalog/attributegroup', 'token=' . $this->session->data['token'], 'SSL');
            $data['backup']                      = $this->url->link('tool/backup', 'token=' . $this->session->data['token'], 'SSL');
            $data['banner']                      = $this->url->link('design/banner', 'token=' . $this->session->data['token'], 'SSL');
            $data['blog_category']               = $this->url->link('content/category', 'token=' . $this->session->data['token'], 'SSL');
            $data['blog_post']                   = $this->url->link('content/post', 'token=' . $this->session->data['token'], 'SSL');
            $data['blog_comment']                = $this->url->link('content/comment', 'token=' . $this->session->data['token'], 'SSL');
            $data['category']                    = $this->url->link('catalog/category', 'token=' . $this->session->data['token'], 'SSL');
            $data['calendar']                    = $this->url->link('calendar/category', 'token=' . $this->session->data['token'], 'SSL');
            $data['country']                     = $this->url->link('localization/country', 'token=' . $this->session->data['token'], 'SSL');
            $data['coupon']                      = $this->url->link('sale/coupon', 'token=' . $this->session->data['token'], 'SSL');
            $data['currency']                    = $this->url->link('localization/currency', 'token=' . $this->session->data['token'], 'SSL');
            $data['customer']                    = $this->url->link('people/customer', 'token=' . $this->session->data['token'], 'SSL');
            $data['customer_group']              = $this->url->link('people/customergroup', 'token=' . $this->session->data['token'], 'SSL');
            $data['customer_ban_ip']             = $this->url->link('people/customerbanip', 'token=' . $this->session->data['token'], 'SSL');
            $data['download']                    = $this->url->link('catalog/download', 'token=' . $this->session->data['token'], 'SSL');
            $data['error_log']                   = $this->url->link('tool/errorlog', 'token=' . $this->session->data['token'], 'SSL');
            $data['event']                       = $this->url->link('calendar/event', 'token=' . $this->session->data['token'], 'SSL');
            $data['feed']                        = $this->url->link('module/feed', 'token=' . $this->session->data['token'], 'SSL');
            $data['filter']                      = $this->url->link('catalog/filter', 'token=' . $this->session->data['token'], 'SSL');
            $data['geo_zone']                    = $this->url->link('localization/geozone', 'token=' . $this->session->data['token'], 'SSL');
            $data['help']                        = $this->url->link('setting/help', 'token=' . $this->session->data['token'], 'SSL');
            $data['page']                        = $this->url->link('content/page', 'token=' . $this->session->data['token'], 'SSL');
            $data['language']                    = $this->url->link('localization/language', 'token=' . $this->session->data['token'], 'SSL');
            $data['layout']                      = $this->url->link('design/layout', 'token=' . $this->session->data['token'], 'SSL');
            $data['logout']                      = $this->url->link('common/logout', 'token=' . $this->session->data['token'], 'SSL');
            $data['contact']                     = $this->url->link('people/contact', 'token=' . $this->session->data['token'], 'SSL');
            $data['menubuilder']                 = $this->url->link('module/menu', 'token=' . $this->session->data['token'], 'SSL');
            $data['manufacturer']                = $this->url->link('catalog/manufacturer', 'token=' . $this->session->data['token'], 'SSL');
            $data['notification']                = $this->url->link('module/notification', 'token=' . $this->session->data['token'], 'SSL');
            $data['widget']                      = $this->url->link('module/widget', 'token=' . $this->session->data['token'], 'SSL');
            $data['option']                      = $this->url->link('catalog/option', 'token=' . $this->session->data['token'], 'SSL');
            $data['order']                       = $this->url->link('sale/order', 'token=' . $this->session->data['token'], 'SSL');
            $data['order_status']                = $this->url->link('localization/orderstatus', 'token=' . $this->session->data['token'], 'SSL');
            $data['payment']                     = $this->url->link('module/payment', 'token=' . $this->session->data['token'], 'SSL');
            $data['product']                     = $this->url->link('catalog/product', 'token=' . $this->session->data['token'], 'SSL');
            $data['plugin']                      = $this->url->link('module/plugin', 'token=' . $this->session->data['token'], 'SSL');
            $data['report_sale_order']           = $this->url->link('report/saleorder', 'token=' . $this->session->data['token'], 'SSL');
            $data['report_sale_tax']             = $this->url->link('report/saletax', 'token=' . $this->session->data['token'], 'SSL');
            $data['report_sale_shipping']        = $this->url->link('report/saleshipping', 'token=' . $this->session->data['token'], 'SSL');
            $data['report_sale_return']          = $this->url->link('report/salereturn', 'token=' . $this->session->data['token'], 'SSL');
            $data['report_sale_coupon']          = $this->url->link('report/salecoupon', 'token=' . $this->session->data['token'], 'SSL');
            $data['report_product_viewed']       = $this->url->link('report/productviewed', 'token=' . $this->session->data['token'], 'SSL');
            $data['report_product_purchased']    = $this->url->link('report/productpurchased', 'token=' . $this->session->data['token'], 'SSL');
            $data['report_customer_online']      = $this->url->link('report/customeronline', 'token=' . $this->session->data['token'], 'SSL');
            $data['report_customer_order']       = $this->url->link('report/customerorder', 'token=' . $this->session->data['token'], 'SSL');
            $data['report_customer_reward']      = $this->url->link('report/customerreward', 'token=' . $this->session->data['token'], 'SSL');
            $data['report_customer_credit']      = $this->url->link('report/customercredit', 'token=' . $this->session->data['token'], 'SSL');
            $data['report_affiliate_commission'] = $this->url->link('report/affiliatecommission', 'token=' . $this->session->data['token'], 'SSL');
            $data['review']                      = $this->url->link('catalog/review', 'token=' . $this->session->data['token'], 'SSL');
            $data['return']                      = $this->url->link('sale/returns', 'token=' . $this->session->data['token'], 'SSL');
            $data['return_action']               = $this->url->link('localization/returnaction', 'token=' . $this->session->data['token'], 'SSL');
            $data['return_reason']               = $this->url->link('localization/returnreason', 'token=' . $this->session->data['token'], 'SSL');
            $data['return_status']               = $this->url->link('localization/returnstatus', 'token=' . $this->session->data['token'], 'SSL');
            $data['shipping']                    = $this->url->link('module/shipping', 'token=' . $this->session->data['token'], 'SSL');
            $data['store']                       = $this->app['http.public'];
            $data['stock_status']                = $this->url->link('localization/stockstatus', 'token=' . $this->session->data['token'], 'SSL');
            $data['tax_class']                   = $this->url->link('localization/taxclass', 'token=' . $this->session->data['token'], 'SSL');
            $data['tax_rate']                    = $this->url->link('localization/taxrate', 'token=' . $this->session->data['token'], 'SSL');
            $data['total']                       = $this->url->link('module/total', 'token=' . $this->session->data['token'], 'SSL');
            $data['user']                        = $this->url->link('people/user', 'token=' . $this->session->data['token'], 'SSL');
            $data['user_group']                  = $this->url->link('people/userpermission', 'token=' . $this->session->data['token'], 'SSL');
            $data['giftcard']                    = $this->url->link('sale/giftcard', 'token=' . $this->session->data['token'], 'SSL');
            $data['giftcard_theme']              = $this->url->link('sale/giftcardtheme', 'token=' . $this->session->data['token'], 'SSL');
            $data['weight_class']                = $this->url->link('localization/weightclass', 'token=' . $this->session->data['token'], 'SSL');
            $data['length_class']                = $this->url->link('localization/lengthclass', 'token=' . $this->session->data['token'], 'SSL');
            $data['zone']                        = $this->url->link('localization/zone', 'token=' . $this->session->data['token'], 'SSL');
            
            $data['testing']                     = $this->url->link('tool/test', 'token=' . $this->session->data['token'], 'SSL');
            
            $data['paypal_express']              = $this->url->link('payment/paypalexpress', 'token=' . $this->session->data['token'], 'SSL');
            $data['paypal_express_search']       = $this->url->link('payment/paypalexpress/search', 'token=' . $this->session->data['token'], 'SSL');
            
            $data['recurring']                   = $this->url->link('catalog/recurring', 'token=' . $this->session->data['token'], 'SSL');
            $data['order_recurring']             = $this->url->link('sale/recurring', 'token=' . $this->session->data['token'], 'SSL');
            
            // Orders
            $this->theme->model('sale/order');
            $this->theme->model('localization/orderstatus');
            
            $order_status_total = $this->model_sale_order->getTotalOrders(array('filter_order_status_id' => $this->config->get('config_order_status_id')));
            
            $data['order_status_total'] = $order_status_total;
            
            $data['alert_order_status'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&filter_order_status_id=' . $this->config->get('config_order_status_id'), 'SSL');
            
            $data['text_pending_status'] = $this->model_localization_orderstatus->getMenuStatusDescription($this->config->get('config_order_status_id'));
            
            $data['complete_status_total'] = $this->model_sale_order->getTotalOrders(array('filter_order_status_id' => $this->config->get('config_complete_status_id')));
            
            $data['alert_complete_status'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&filter_order_status_id=' . $this->config->get('config_complete_status_id'), 'SSL');
            
            $data['text_complete_status'] = $this->model_localization_orderstatus->getMenuStatusDescription($this->config->get('config_complete_status_id'));
            
            // Returns
            $this->theme->model('sale/returns');
            
            $return_total = $this->model_sale_returns->getTotalReturns(array('filter_return_status_id' => $this->config->get('config_return_status_id')));
            
            $data['return_total'] = $return_total;
            
            $data['alert_return'] = $this->url->link('sale/returns', 'token=' . $this->session->data['token'], 'SSL');
            
            // Customers
            if ($this->config->get('config_customer_online')):
                $this->theme->model('report/dashboard');
                
                $data['online_total'] = $this->model_report_dashboard->getTotalCustomersOnline();
                $data['alert_online'] = $this->url->link('report/customeronline', 'token=' . $this->session->data['token'], 'SSL');
            else:
                $data['online_total'] = false;
                $data['alert_online'] = '';
            endif;
            
            $this->theme->model('people/customer');
            
            $customer_total = $this->model_people_customer->getTotalCustomers(array('filter_approved' => false));
            
            $data['customer_total'] = $customer_total;
            $data['alert_customer_approval'] = $this->url->link('people/customer', 'token=' . $this->session->data['token'] . '&filter_approved=0', 'SSL');
            
            // Products
            $this->theme->model('catalog/product');
            
            $product_total = $this->model_catalog_product->getTotalProductsOutOfStock();
            
            $data['product_total'] = $product_total;
            
            $data['alert_product'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&filter_order_status_id=' . $this->config->get('config_complete_status_id'), 'SSL');
            
            // Reviews
            $this->theme->model('catalog/review');
            
            $review_total = $this->model_catalog_review->getTotalReviewsAwaitingApproval();
            
            $data['review_total'] = $review_total;
            
            $data['alert_review'] = $this->url->link('catalog/review', 'token=' . $this->session->data['token'] . '&filter_status=0', 'SSL');
            
            $data['alerts'] = $order_status_total + $customer_total + $product_total + $review_total + $return_total;
            
            // Online Stores
            $data['stores'] = array();
            
            $this->theme->model('setting/store');
            
            $results = $this->model_setting_store->getStores();
            
            if (count($results) > 0):
                $data['alert_store_setting'] = $this->url->link('setting/store', 'token=' . $this->session->data['token'], 'SSL');
                $data['setting'] = $this->url->link('setting/store', 'token=' . $this->session->data['token'], 'SSL');
            else:
                $data['alert_store_setting'] = $this->url->link('setting/setting', 'token=' . $this->session->data['token'], 'SSL');
                $data['setting'] = $this->url->link('setting/setting', 'token=' . $this->session->data['token'], 'SSL');
            endif;
            
            foreach ($results as $result):
                $data['stores'][] = array('name' => $result['name'], 'href' => $result['url']);
            endforeach;
        endif;
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        return $this->theme->view('common/menu', $data);
    }
}
