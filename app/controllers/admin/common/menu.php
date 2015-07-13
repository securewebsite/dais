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

namespace App\Controllers\Admin\Common;
use App\Controllers\Controller;

class Menu extends Controller {
    
    public function index() {
        
        $data = Theme::language('common/menu');
        
        if (!isset($this->request->get['token']) || !isset($this->session->data['token']) && ($this->request->get['token'] != $this->session->data['token'])):
            
            $data['logged'] = false;
        else:
            $data['paypal_express_status']       = (Config::get('paypal_express_status')) ? : false;
            $data['logged']                      = sprintf(Lang::get('lang_text_logged'), User::getUsername());
            $data['dashboard']                   = Url::link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL');
            $data['allowed'] = false;
            if (Config::get('config_affiliate_allowed')):
                $data['affiliate'] = Url::link('people/customer', 'token=' . $this->session->data['token'] . '&filter_affiliate=1', 'SSL');
                $data['allowed']   = true;
            endif;
            $data['attribute']                   = Url::link('catalog/attribute', 'token=' . $this->session->data['token'], 'SSL');
            $data['attribute_group']             = Url::link('catalog/attribute_group', 'token=' . $this->session->data['token'], 'SSL');
            $data['backup']                      = Url::link('tool/backup', 'token=' . $this->session->data['token'], 'SSL');
            $data['banner']                      = Url::link('design/banner', 'token=' . $this->session->data['token'], 'SSL');
            $data['blog_category']               = Url::link('content/category', 'token=' . $this->session->data['token'], 'SSL');
            $data['blog_post']                   = Url::link('content/post', 'token=' . $this->session->data['token'], 'SSL');
            $data['blog_comment']                = Url::link('content/comment', 'token=' . $this->session->data['token'], 'SSL');
            $data['category']                    = Url::link('catalog/category', 'token=' . $this->session->data['token'], 'SSL');
            $data['country']                     = Url::link('localization/country', 'token=' . $this->session->data['token'], 'SSL');
            $data['coupon']                      = Url::link('sale/coupon', 'token=' . $this->session->data['token'], 'SSL');
            $data['currency']                    = Url::link('localization/currency', 'token=' . $this->session->data['token'], 'SSL');
            $data['customer']                    = Url::link('people/customer', 'token=' . $this->session->data['token'], 'SSL');
            $data['customer_group']              = Url::link('people/customer_group', 'token=' . $this->session->data['token'], 'SSL');
            $data['customer_ban_ip']             = Url::link('people/customer_ban_ip', 'token=' . $this->session->data['token'], 'SSL');
            $data['download']                    = Url::link('catalog/download', 'token=' . $this->session->data['token'], 'SSL');
            $data['error_log']                   = Url::link('tool/error_log', 'token=' . $this->session->data['token'], 'SSL');
            $data['event']                       = Url::link('calendar/event', 'token=' . $this->session->data['token'], 'SSL');
            $data['presenter']                   = Url::link('calendar/event/presenter_list', 'token=' . $this->session->data['token'], 'SSL');
            $data['feed']                        = Url::link('module/feed', 'token=' . $this->session->data['token'], 'SSL');
            $data['filter']                      = Url::link('catalog/filter', 'token=' . $this->session->data['token'], 'SSL');
            $data['geo_zone']                    = Url::link('localization/geo_zone', 'token=' . $this->session->data['token'], 'SSL');
            $data['help']                        = Url::link('setting/help', 'token=' . $this->session->data['token'], 'SSL');
            $data['page']                        = Url::link('content/page', 'token=' . $this->session->data['token'], 'SSL');
            $data['language']                    = Url::link('localization/language', 'token=' . $this->session->data['token'], 'SSL');
            $data['layout']                      = Url::link('design/layout', 'token=' . $this->session->data['token'], 'SSL');
            $data['logout']                      = Url::link('common/logout', 'token=' . $this->session->data['token'], 'SSL');
            $data['contact']                     = Url::link('people/contact', 'token=' . $this->session->data['token'], 'SSL');
            $data['menubuilder']                 = Url::link('module/menu', 'token=' . $this->session->data['token'], 'SSL');
            $data['share']                       = Url::link('module/share', 'token=' . $this->session->data['token'], 'SSL');
            $data['manufacturer']                = Url::link('catalog/manufacturer', 'token=' . $this->session->data['token'], 'SSL');
            $data['notification']                = Url::link('module/notification', 'token=' . $this->session->data['token'], 'SSL');
            $data['widget']                      = Url::link('module/widget', 'token=' . $this->session->data['token'], 'SSL');
            $data['option']                      = Url::link('catalog/option', 'token=' . $this->session->data['token'], 'SSL');
            $data['order']                       = Url::link('sale/order', 'token=' . $this->session->data['token'], 'SSL');
            $data['order_status']                = Url::link('localization/order_status', 'token=' . $this->session->data['token'], 'SSL');
            $data['payment']                     = Url::link('module/payment', 'token=' . $this->session->data['token'], 'SSL');
            $data['product']                     = Url::link('catalog/product', 'token=' . $this->session->data['token'], 'SSL');
            $data['plugin']                      = Url::link('module/plugin', 'token=' . $this->session->data['token'], 'SSL');
            $data['report_sale_order']           = Url::link('report/sale_order', 'token=' . $this->session->data['token'], 'SSL');
            $data['report_sale_tax']             = Url::link('report/sale_tax', 'token=' . $this->session->data['token'], 'SSL');
            $data['report_sale_shipping']        = Url::link('report/sale_shipping', 'token=' . $this->session->data['token'], 'SSL');
            $data['report_sale_return']          = Url::link('report/sale_return', 'token=' . $this->session->data['token'], 'SSL');
            $data['report_sale_coupon']          = Url::link('report/sale_coupon', 'token=' . $this->session->data['token'], 'SSL');
            $data['report_product_viewed']       = Url::link('report/product_viewed', 'token=' . $this->session->data['token'], 'SSL');
            $data['report_product_purchased']    = Url::link('report/product_purchased', 'token=' . $this->session->data['token'], 'SSL');
            $data['report_customer_online']      = Url::link('report/customer_online', 'token=' . $this->session->data['token'], 'SSL');
            $data['report_customer_order']       = Url::link('report/customer_order', 'token=' . $this->session->data['token'], 'SSL');
            $data['report_customer_reward']      = Url::link('report/customer_reward', 'token=' . $this->session->data['token'], 'SSL');
            $data['report_customer_credit']      = Url::link('report/customer_credit', 'token=' . $this->session->data['token'], 'SSL');
            $data['report_affiliate_commission'] = Url::link('report/affiliate_commission', 'token=' . $this->session->data['token'], 'SSL');
            $data['review']                      = Url::link('catalog/review', 'token=' . $this->session->data['token'], 'SSL');
            $data['return']                      = Url::link('sale/returns', 'token=' . $this->session->data['token'], 'SSL');
            $data['return_action']               = Url::link('localization/return_action', 'token=' . $this->session->data['token'], 'SSL');
            $data['return_reason']               = Url::link('localization/return_reason', 'token=' . $this->session->data['token'], 'SSL');
            $data['return_status']               = Url::link('localization/return_status', 'token=' . $this->session->data['token'], 'SSL');
            $data['route']                       = Url::link('design/route', 'token=' . $this->session->data['token'], 'SSL');
            $data['shipping']                    = Url::link('module/shipping', 'token=' . $this->session->data['token'], 'SSL');
            $data['store']                       = Config::get('http.public');
            $data['stock_status']                = Url::link('localization/stock_status', 'token=' . $this->session->data['token'], 'SSL');
            $data['tax_class']                   = Url::link('localization/tax_class', 'token=' . $this->session->data['token'], 'SSL');
            $data['tax_rate']                    = Url::link('localization/tax_rate', 'token=' . $this->session->data['token'], 'SSL');
            $data['total']                       = Url::link('module/total', 'token=' . $this->session->data['token'], 'SSL');
            $data['user']                        = Url::link('people/user', 'token=' . $this->session->data['token'], 'SSL');
            $data['user_group']                  = Url::link('people/user_permission', 'token=' . $this->session->data['token'], 'SSL');
            $data['gift_card']                   = Url::link('sale/gift_card', 'token=' . $this->session->data['token'], 'SSL');
            $data['gift_card_theme']             = Url::link('sale/gift_card_theme', 'token=' . $this->session->data['token'], 'SSL');
            $data['weight_class']                = Url::link('localization/weight_class', 'token=' . $this->session->data['token'], 'SSL');
            $data['length_class']                = Url::link('localization/length_class', 'token=' . $this->session->data['token'], 'SSL');
            $data['zone']                        = Url::link('localization/zone', 'token=' . $this->session->data['token'], 'SSL');
            
            $data['testing']                     = Url::link('tool/test', 'token=' . $this->session->data['token'], 'SSL');
            
            $data['paypal_express']              = Url::link('payment/paypal_express', 'token=' . $this->session->data['token'], 'SSL');
            $data['paypal_express_search']       = Url::link('payment/paypal_express/search', 'token=' . $this->session->data['token'], 'SSL');
            
            $data['recurring']                   = Url::link('catalog/recurring', 'token=' . $this->session->data['token'], 'SSL');
            $data['order_recurring']             = Url::link('sale/recurring', 'token=' . $this->session->data['token'], 'SSL');
            
            // Orders
            Theme::model('sale/order');
            Theme::model('localization/order_status');
            
            $order_status_total = $this->model_sale_order->getTotalOrders(array('filter_order_status_id' => Config::get('config_order_status_id')));
            
            $data['order_status_total'] = $order_status_total;
            
            $data['alert_order_status'] = Url::link('sale/order', 'token=' . $this->session->data['token'] . '&filter_order_status_id=' . Config::get('config_order_status_id'), 'SSL');
            
            $data['text_pending_status'] = $this->model_localization_order_status->getMenuStatusDescription(Config::get('config_order_status_id'));
            
            $data['complete_status_total'] = $this->model_sale_order->getTotalOrders(array('filter_order_status_id' => Config::get('config_complete_status_id')));
            
            $data['alert_complete_status'] = Url::link('sale/order', 'token=' . $this->session->data['token'] . '&filter_order_status_id=' . Config::get('config_complete_status_id'), 'SSL');
            
            $data['text_complete_status'] = $this->model_localization_order_status->getMenuStatusDescription(Config::get('config_complete_status_id'));
            
            // Returns
            Theme::model('sale/returns');
            
            $return_total = $this->model_sale_returns->getTotalReturns(array('filter_return_status_id' => Config::get('config_return_status_id')));
            
            $data['return_total'] = $return_total;
            
            $data['alert_return'] = Url::link('sale/returns', 'token=' . $this->session->data['token'], 'SSL');
            
            // Customers
            if (Config::get('config_customer_online')):
                Theme::model('report/dashboard');
                
                $data['online_total'] = $this->model_report_dashboard->getTotalCustomersOnline();
                $data['alert_online'] = Url::link('report/customer_online', 'token=' . $this->session->data['token'], 'SSL');
            else:
                $data['online_total'] = false;
                $data['alert_online'] = '';
            endif;
            
            Theme::model('people/customer');
            
            $customer_total = $this->model_people_customer->getTotalCustomers(array('filter_approved' => false));
            
            $data['customer_total'] = $customer_total;
            $data['alert_customer_approval'] = Url::link('people/customer', 'token=' . $this->session->data['token'] . '&filter_approved=0', 'SSL');
            
            // Products
            Theme::model('catalog/product');
            
            $product_total = $this->model_catalog_product->getTotalProductsOutOfStock();
            
            $data['product_total'] = $product_total;
            
            $data['alert_product'] = Url::link('catalog/product', 'token=' . $this->session->data['token'] . '&filter_order_status_id=' . Config::get('config_complete_status_id'), 'SSL');
            
            // Reviews
            Theme::model('catalog/review');
            
            $review_total = $this->model_catalog_review->getTotalReviewsAwaitingApproval();
            
            $data['review_total'] = $review_total;
            
            $data['alert_review'] = Url::link('catalog/review', 'token=' . $this->session->data['token'] . '&filter_status=0', 'SSL');
            
            $data['alerts'] = $order_status_total + $customer_total + $product_total + $review_total + $return_total;
            
            // Online Stores
            $data['stores'] = array();
            
            Theme::model('setting/store');
            
            $results = $this->model_setting_store->getStores();
            
            if (count($results) > 0):
                $data['alert_store_setting'] = Url::link('setting/store', 'token=' . $this->session->data['token'], 'SSL');
                $data['setting'] = Url::link('setting/store', 'token=' . $this->session->data['token'], 'SSL');
            else:
                $data['alert_store_setting'] = Url::link('setting/setting', 'token=' . $this->session->data['token'], 'SSL');
                $data['setting'] = Url::link('setting/setting', 'token=' . $this->session->data['token'], 'SSL');
            endif;
            
            foreach ($results as $result):
                $data['stores'][] = array('name' => $result['name'], 'href' => $result['url']);
            endforeach;
        endif;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        return Theme::view('common/menu', $data);
    }
}
