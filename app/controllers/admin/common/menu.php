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

        if (!User::isLogged() || !Response::match()):
            $data['logged'] = false;
        else:
            $data['paypal_express_status']       = (Config::get('paypal_express_status')) ? : false;
            $data['logged']                      = sprintf(Lang::get('lang_text_logged'), User::getUsername());
            $data['dashboard']                   = Url::link('common/dashboard', '', 'SSL');
            $data['allowed'] = false;
            if (Config::get('config_affiliate_allowed')):
                $data['affiliate'] = Url::link('people/customer', '' . '&filter_affiliate=1', 'SSL');
                $data['allowed']   = true;
            endif;
            $data['attribute']                   = Url::link('catalog/attribute', '', 'SSL');
            $data['attribute_group']             = Url::link('catalog/attribute_group', '', 'SSL');
            $data['backup']                      = Url::link('tool/backup', '', 'SSL');
            $data['banner']                      = Url::link('design/banner', '', 'SSL');
            $data['blog_category']               = Url::link('content/category', '', 'SSL');
            $data['blog_post']                   = Url::link('content/post', '', 'SSL');
            $data['blog_comment']                = Url::link('content/comment', '', 'SSL');
            $data['category']                    = Url::link('catalog/category', '', 'SSL');
            $data['country']                     = Url::link('locale/country', '', 'SSL');
            $data['coupon']                      = Url::link('sale/coupon', '', 'SSL');
            $data['currency']                    = Url::link('locale/currency', '', 'SSL');
            $data['customer']                    = Url::link('people/customer', '', 'SSL');
            $data['customer_group']              = Url::link('people/customer_group', '', 'SSL');
            $data['customer_ban_ip']             = Url::link('people/customer_ban_ip', '', 'SSL');
            $data['download']                    = Url::link('catalog/download', '', 'SSL');
            $data['error_log']                   = Url::link('tool/error_log', '', 'SSL');
            $data['event']                       = Url::link('calendar/event', '', 'SSL');
            $data['presenter']                   = Url::link('calendar/event/presenter_list', '', 'SSL');
            $data['feed']                        = Url::link('module/feed', '', 'SSL');
            $data['filter']                      = Url::link('catalog/filter', '', 'SSL');
            $data['geo_zone']                    = Url::link('locale/geo_zone', '', 'SSL');
            $data['help']                        = Url::link('setting/help', '', 'SSL');
            $data['page']                        = Url::link('content/page', '', 'SSL');
            $data['language']                    = Url::link('locale/language', '', 'SSL');
            $data['layout']                      = Url::link('design/layout', '', 'SSL');
            $data['logout']                      = Url::link('common/logout', '', 'SSL');
            $data['contact']                     = Url::link('people/contact', '', 'SSL');
            $data['menubuilder']                 = Url::link('module/menu', '', 'SSL');
            $data['share']                       = Url::link('module/share', '', 'SSL');
            $data['manufacturer']                = Url::link('catalog/manufacturer', '', 'SSL');
            $data['notification']                = Url::link('module/notification', '', 'SSL');
            $data['widget']                      = Url::link('module/widget', '', 'SSL');
            $data['option']                      = Url::link('catalog/option', '', 'SSL');
            $data['order']                       = Url::link('sale/order', '', 'SSL');
            $data['order_status']                = Url::link('locale/order_status', '', 'SSL');
            $data['payment']                     = Url::link('module/payment', '', 'SSL');
            $data['product']                     = Url::link('catalog/product', '', 'SSL');
            $data['plugin']                      = Url::link('module/plugin', '', 'SSL');
            $data['report_sale_order']           = Url::link('report/sale_order', '', 'SSL');
            $data['report_sale_tax']             = Url::link('report/sale_tax', '', 'SSL');
            $data['report_sale_shipping']        = Url::link('report/sale_shipping', '', 'SSL');
            $data['report_sale_return']          = Url::link('report/sale_return', '', 'SSL');
            $data['report_sale_coupon']          = Url::link('report/sale_coupon', '', 'SSL');
            $data['report_product_viewed']       = Url::link('report/product_viewed', '', 'SSL');
            $data['report_product_purchased']    = Url::link('report/product_purchased', '', 'SSL');
            $data['report_customer_online']      = Url::link('report/customer_online', '', 'SSL');
            $data['report_customer_order']       = Url::link('report/customer_order', '', 'SSL');
            $data['report_customer_reward']      = Url::link('report/customer_reward', '', 'SSL');
            $data['report_customer_credit']      = Url::link('report/customer_credit', '', 'SSL');
            $data['report_affiliate_commission'] = Url::link('report/affiliate_commission', '', 'SSL');
            $data['review']                      = Url::link('catalog/review', '', 'SSL');
            $data['return']                      = Url::link('sale/returns', '', 'SSL');
            $data['return_action']               = Url::link('locale/return_action', '', 'SSL');
            $data['return_reason']               = Url::link('locale/return_reason', '', 'SSL');
            $data['return_status']               = Url::link('locale/return_status', '', 'SSL');
            $data['route']                       = Url::link('design/route', '', 'SSL');
            $data['shipping']                    = Url::link('module/shipping', '', 'SSL');
            $data['store']                       = Config::get('http.public');
            $data['stock_status']                = Url::link('locale/stock_status', '', 'SSL');
            $data['tax_class']                   = Url::link('locale/tax_class', '', 'SSL');
            $data['tax_rate']                    = Url::link('locale/tax_rate', '', 'SSL');
            $data['total']                       = Url::link('module/total', '', 'SSL');
            $data['user']                        = Url::link('people/user', '', 'SSL');
            $data['user_group']                  = Url::link('people/user_permission', '', 'SSL');
            $data['gift_card']                   = Url::link('sale/gift_card', '', 'SSL');
            $data['gift_card_theme']             = Url::link('sale/gift_card_theme', '', 'SSL');
            $data['weight_class']                = Url::link('locale/weight_class', '', 'SSL');
            $data['length_class']                = Url::link('locale/length_class', '', 'SSL');
            $data['zone']                        = Url::link('locale/zone', '', 'SSL');
            
            $data['testing']                     = Url::link('tool/test', '', 'SSL');
            
            $data['paypal_express']              = Url::link('payment/paypal_express', '', 'SSL');
            $data['paypal_express_search']       = Url::link('payment/paypal_express/search', '', 'SSL');
            
            $data['recurring']                   = Url::link('catalog/recurring', '', 'SSL');
            $data['order_recurring']             = Url::link('sale/recurring', '', 'SSL');
            
            // Orders
            Theme::model('sale/order');
            Theme::model('locale/order_status');
            
            $order_status_total = SaleOrder::getTotalOrders(array('filter_order_status_id' => Config::get('config_order_status_id')));
            
            $data['order_status_total'] = $order_status_total;
            
            $data['alert_order_status'] = Url::link('sale/order', '' . '&filter_order_status_id=' . Config::get('config_order_status_id'), 'SSL');
            
            $data['text_pending_status'] = LocaleOrderStatus::getMenuStatusDescription(Config::get('config_order_status_id'));
            
            $data['complete_status_total'] = SaleOrder::getTotalOrders(array('filter_order_status_id' => Config::get('config_complete_status_id')));
            
            $data['alert_complete_status'] = Url::link('sale/order', '' . '&filter_order_status_id=' . Config::get('config_complete_status_id'), 'SSL');
            
            $data['text_complete_status'] = LocaleOrderStatus::getMenuStatusDescription(Config::get('config_complete_status_id'));
            
            // Returns
            Theme::model('sale/returns');
            
            $return_total = SaleReturns::getTotalReturns(array('filter_return_status_id' => Config::get('config_return_status_id')));
            
            $data['return_total'] = $return_total;
            
            $data['alert_return'] = Url::link('sale/returns', '', 'SSL');
            
            // Customers
            if (Config::get('config_customer_online')):
                Theme::model('report/dashboard');
                
                $data['online_total'] = ReportDashboard::getTotalCustomersOnline();
                $data['alert_online'] = Url::link('report/customer_online', '', 'SSL');
            else:
                $data['online_total'] = false;
                $data['alert_online'] = '';
            endif;
            
            Theme::model('people/customer');
            
            $customer_total = PeopleCustomer::getTotalCustomers(array('filter_approved' => false));
            
            $data['customer_total'] = $customer_total;
            $data['alert_customer_approval'] = Url::link('people/customer', '' . '&filter_approved=0', 'SSL');
            
            // Products
            Theme::model('catalog/product');
            
            $product_total = CatalogProduct::getTotalProductsOutOfStock();
            
            $data['product_total'] = $product_total;
            
            $data['alert_product'] = Url::link('catalog/product', '' . '&filter_order_status_id=' . Config::get('config_complete_status_id'), 'SSL');
            
            // Reviews
            Theme::model('catalog/review');
            
            $review_total = CatalogReview::getTotalReviewsAwaitingApproval();
            
            $data['review_total'] = $review_total;
            
            $data['alert_review'] = Url::link('catalog/review', '' . '&filter_status=0', 'SSL');
            
            $data['alerts'] = $order_status_total + $customer_total + $product_total + $review_total + $return_total;
            
            // Online Stores
            $data['stores'] = array();
            
            Theme::model('setting/store');
            
            $results = SettingStore::getStores();
            
            if (count($results) > 0):
                $data['alert_store_setting'] = Url::link('setting/store', '', 'SSL');
                $data['setting'] = Url::link('setting/store', '', 'SSL');
            else:
                $data['alert_store_setting'] = Url::link('setting/setting', '', 'SSL');
                $data['setting'] = Url::link('setting/setting', '', 'SSL');
            endif;
            
            foreach ($results as $result):
                $data['stores'][] = array('name' => $result['name'], 'href' => $result['url']);
            endforeach;
        endif;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        return View::render('common/menu', $data);
    }
}
