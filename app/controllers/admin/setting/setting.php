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

namespace App\Controllers\Admin\Setting;

use App\Controllers\Controller;
use Dais\Driver\Cache\Mem;

class Setting extends Controller {
    
    private $error = array();
    
    public function index() {
        $data = Lang::load('setting/setting');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('setting/setting');
        
        if ((Request::p()->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            SettingSetting::editSetting('config', Request::post());
            
            if (Config::get('config_currency_auto')) {
                Theme::model('locale/currency');
                LocaleCurrency::updateCurrencies();
            }
            
            Session::p()->data['success'] = Lang::get('lang_text_success');
            
            Response::redirect(Url::link('setting/store', '', 'SSL'));
        }
        
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
        
        if (isset($this->error['owner'])) {
            $data['error_owner'] = $this->error['owner'];
        } else {
            $data['error_owner'] = '';
        }
        
        if (isset($this->error['address'])) {
            $data['error_address'] = $this->error['address'];
        } else {
            $data['error_address'] = '';
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
        
        if (isset($this->error['title'])) {
            $data['error_title'] = $this->error['title'];
        } else {
            $data['error_title'] = '';
        }
        
        if (isset($this->error['customer_group_display'])) {
            $data['error_customer_group_display'] = $this->error['customer_group_display'];
        } else {
            $data['error_customer_group_display'] = '';
        }

        if (isset($this->error['blog_image_thumb'])) {
            $data['error_blog_image_thumb'] = $this->error['blog_image_thumb'];
        } else {
            $data['error_blog_image_thumb'] = '';
        }

        if (isset($this->error['blog_image_popup'])) {
            $data['error_blog_image_popup'] = $this->error['blog_image_popup'];
        } else {
            $data['error_blog_image_popup'] = '';
        }
        
        if (isset($this->error['blog_image_post'])) {
            $data['error_blog_image_post'] = $this->error['blog_image_post'];
        } else {
            $data['error_blog_image_post'] = '';
        }
        
        if (isset($this->error['blog_image_additional'])) {
            $data['error_blog_image_additional'] = $this->error['blog_image_additional'];
        } else {
            $data['error_blog_image_additional'] = '';
        }
        
        if (isset($this->error['blog_image_related'])) {
            $data['error_blog_image_related'] = $this->error['blog_image_related'];
        } else {
            $data['error_blog_image_related'] = '';
        }
        
        if (isset($this->error['blog_posted_by'])) {
            $data['error_blog_posted_by'] = $this->error['blog_posted_by'];
        } else {
            $data['error_blog_posted_by'] = '';
        }
        
        if (isset($this->error['blog_admin_group_id'])) {
            $data['error_blog_admin_group_id'] = $this->error['blog_admin_group_id'];
        } else {
            $data['error_blog_admin_group_id'] = '';
        }
        
        if (isset($this->error['gift_card_min'])) {
            $data['error_gift_card_min'] = $this->error['gift_card_min'];
        } else {
            $data['error_gift_card_min'] = '';
        }

        if (isset($this->error['affiliate_terms'])) {
            $data['error_affiliate_terms'] = $this->error['affiliate_terms'];
        } else {
            $data['error_affiliate_terms'] = '';
        }

        if (isset($this->error['commission'])) {
            $data['error_commission'] = $this->error['commission'];
        } else {
            $data['error_commission'] = '';
        }
        
        if (isset($this->error['gift_card_max'])) {
            $data['error_gift_card_max'] = $this->error['gift_card_max'];
        } else {
            $data['error_gift_card_max'] = '';
        }
        
        if (isset($this->error['ftp_host'])) {
            $data['error_ftp_host'] = $this->error['ftp_host'];
        } else {
            $data['error_ftp_host'] = '';
        }
        
        if (isset($this->error['ftp_port'])) {
            $data['error_ftp_port'] = $this->error['ftp_port'];
        } else {
            $data['error_ftp_port'] = '';
        }
        
        if (isset($this->error['ftp_username'])) {
            $data['error_ftp_username'] = $this->error['ftp_username'];
        } else {
            $data['error_ftp_username'] = '';
        }
        
        if (isset($this->error['ftp_password'])) {
            $data['error_ftp_password'] = $this->error['ftp_password'];
        } else {
            $data['error_ftp_password'] = '';
        }
        
        if (isset($this->error['image_category'])) {
            $data['error_image_category'] = $this->error['image_category'];
        } else {
            $data['error_image_category'] = '';
        }
        
        if (isset($this->error['image_thumb'])) {
            $data['error_image_thumb'] = $this->error['image_thumb'];
        } else {
            $data['error_image_thumb'] = '';
        }
        
        if (isset($this->error['image_popup'])) {
            $data['error_image_popup'] = $this->error['image_popup'];
        } else {
            $data['error_image_popup'] = '';
        }
        
        if (isset($this->error['image_product'])) {
            $data['error_image_product'] = $this->error['image_product'];
        } else {
            $data['error_image_product'] = '';
        }
        
        if (isset($this->error['image_additional'])) {
            $data['error_image_additional'] = $this->error['image_additional'];
        } else {
            $data['error_image_additional'] = '';
        }
        
        if (isset($this->error['image_related'])) {
            $data['error_image_related'] = $this->error['image_related'];
        } else {
            $data['error_image_related'] = '';
        }
        
        if (isset($this->error['image_compare'])) {
            $data['error_image_compare'] = $this->error['image_compare'];
        } else {
            $data['error_image_compare'] = '';
        }
        
        if (isset($this->error['image_wishlist'])) {
            $data['error_image_wishlist'] = $this->error['image_wishlist'];
        } else {
            $data['error_image_wishlist'] = '';
        }
        
        if (isset($this->error['image_cart'])) {
            $data['error_image_cart'] = $this->error['image_cart'];
        } else {
            $data['error_image_cart'] = '';
        }
        
        if (isset($this->error['error_filename'])) {
            $data['error_error_filename'] = $this->error['error_filename'];
        } else {
            $data['error_error_filename'] = '';
        }
        
        if (isset($this->error['catalog_limit'])) {
            $data['error_catalog_limit'] = $this->error['catalog_limit'];
        } else {
            $data['error_catalog_limit'] = '';
        }
        
        if (isset($this->error['admin_limit'])) {
            $data['error_admin_limit'] = $this->error['admin_limit'];
        } else {
            $data['error_admin_limit'] = '';
        }
        
        if (isset($this->error['encryption'])) {
            $data['error_encryption'] = $this->error['encryption'];
        } else {
            $data['error_encryption'] = '';
        }
        
        if (isset($this->error['default_visibility'])) {
            $data['error_default_visibility'] = $this->error['default_visibility'];
        } else {
            $data['error_default_visibility'] = '';
        }
        
        if (isset($this->error['free_customer'])) {
            $data['error_free_customer'] = $this->error['free_customer'];
        } else {
            $data['error_free_customer'] = '';
        }
        
        if (isset($this->error['top_customer'])) {
            $data['error_top_customer'] = $this->error['top_customer'];
        } else {
            $data['error_top_customer'] = '';
        }

        if (isset($this->error['admin_email_user'])) {
            $data['error_admin_email_user'] = $this->error['admin_email_user'];
        } else {
            $data['error_admin_email_user'] = '';
        }

        if (isset($this->error['text_signature'])) {
            $data['error_text_signature'] = $this->error['text_signature'];
        } else {
            $data['error_text_signature'] = '';
        }

        if (isset($this->error['html_signature'])) {
            $data['error_html_signature'] = $this->error['html_signature'];
        } else {
            $data['error_html_signature'] = '';
        }
        
        Breadcrumb::add('lang_heading_title', 'setting/setting');
        
        if (isset(Session::p()->data['success'])) {
            $data['success'] = Session::p()->data['success'];
            
            unset(Session::p()->data['success']);
        } else {
            $data['success'] = '';
        }
        
        $data['action'] = Url::link('setting/setting', '', 'SSL');
        $data['flush']  = Url::link('setting/setting/flush', '', 'SSL');
        $data['cancel'] = Url::link('setting/store', '', 'SSL');
        
        if (isset(Request::p()->post['config_name'])) {
            $data['config_name'] = Request::p()->post['config_name'];
        } else {
            $data['config_name'] = Config::get('config_name');
        }
        
        if (isset(Request::p()->post['config_owner'])) {
            $data['config_owner'] = Request::p()->post['config_owner'];
        } else {
            $data['config_owner'] = Config::get('config_owner');
        }
        
        if (isset(Request::p()->post['config_address'])) {
            $data['config_address'] = Request::p()->post['config_address'];
        } else {
            $data['config_address'] = Config::get('config_address');
        }
        
        if (isset(Request::p()->post['config_email'])) {
            $data['config_email'] = Request::p()->post['config_email'];
        } else {
            $data['config_email'] = Config::get('config_email');
        }
        
        if (isset(Request::p()->post['config_admin_email'])) {
            $data['config_admin_email'] = Request::p()->post['config_admin_email'];
        } else {
            $data['config_admin_email'] = Config::get('config_admin_email');
        }

        if (isset(Request::p()->post['config_telephone'])) {
            $data['config_telephone'] = Request::p()->post['config_telephone'];
        } else {
            $data['config_telephone'] = Config::get('config_telephone');
        }
        
        if (isset(Request::p()->post['config_default_visibility'])) {
            $data['config_default_visibility'] = Request::p()->post['config_default_visibility'];
        } else {
            $data['config_default_visibility'] = Config::get('config_default_visibility');
        }
        
        if (isset(Request::p()->post['config_free_customer'])) {
            $data['config_free_customer'] = Request::p()->post['config_free_customer'];
        } else {
            $data['config_free_customer'] = Config::get('config_free_customer');
        }
        
        if (isset(Request::p()->post['config_top_customer'])) {
            $data['config_top_customer'] = Request::p()->post['config_top_customer'];
        } else {
            $data['config_top_customer'] = Config::get('config_top_customer');
        }
        
        if (isset(Request::p()->post['config_site_style'])) {
            $data['config_site_style'] = Request::p()->post['config_site_style'];
        } else {
            $data['config_site_style'] = Config::get('config_site_style');
        }
        
        $data['site_styles'] = array();
        
        $site_styles = array('shop' => Lang::get('lang_text_style_shop'), 'content' => Lang::get('lang_text_style_site'),);
        
        foreach ($site_styles as $key => $value):
            $data['site_styles'][] = array('type' => $key, 'name' => $value);
        endforeach;
        
        if (isset(Request::p()->post['config_title'])) {
            $data['config_title'] = Request::p()->post['config_title'];
        } else {
            $data['config_title'] = Config::get('config_title');
        }
        
        if (isset(Request::p()->post['config_meta_description'])) {
            $data['config_meta_description'] = Request::p()->post['config_meta_description'];
        } else {
            $data['config_meta_description'] = Config::get('config_meta_description');
        }
        
        if (isset(Request::p()->post['config_layout_id'])) {
            $data['config_layout_id'] = Request::p()->post['config_layout_id'];
        } else {
            $data['config_layout_id'] = Config::get('config_layout_id');
        }
        
        Theme::model('design/layout');
        
        $data['layouts'] = DesignLayout::getLayouts();
        
        if (isset(Request::p()->post['config_theme'])) {
            $data['config_theme'] = Request::p()->post['config_theme'];
        } else {
            $data['config_theme'] = Config::get('config_theme');
        }
        
        $data['themes'] = array();
        
        $directories = glob(dirname(Config::get('path.theme')) . '/front/*', GLOB_ONLYDIR);
        
        foreach ($directories as $directory) {
            $data['themes'][] = basename($directory);
        }
        
        unset($directories);
        
        if (isset(Request::p()->post['config_admin_theme'])) {
            $data['config_admin_theme'] = Request::p()->post['config_admin_theme'];
        } else {
            $data['config_admin_theme'] = Config::get('config_admin_theme');
        }
        
        $data['admin_themes'] = array();
        
        $directories = glob(dirname(Config::get('path.theme')) . '/admin/*', GLOB_ONLYDIR);
        
        foreach ($directories as $directory) {
            $data['admin_themes'][] = basename($directory);
        }
        
        if (isset(Request::p()->post['config_country_id'])) {
            $data['config_country_id'] = Request::p()->post['config_country_id'];
        } else {
            $data['config_country_id'] = Config::get('config_country_id');
        }
        
        Theme::model('locale/country');
        
        $data['countries'] = LocaleCountry::getCountries();
        
        if (isset(Request::p()->post['config_zone_id'])) {
            $data['config_zone_id'] = Request::p()->post['config_zone_id'];
        } else {
            $data['config_zone_id'] = Config::get('config_zone_id');
        }
        
        if (isset(Request::p()->post['config_language'])) {
            $data['config_language'] = Request::p()->post['config_language'];
        } else {
            $data['config_language'] = Config::get('config_language');
        }
        
        Theme::model('locale/language');
        
        $data['languages'] = LocaleLanguage::getLanguages();
        
        if (isset(Request::p()->post['config_admin_language'])) {
            $data['config_admin_language'] = Request::p()->post['config_admin_language'];
        } else {
            $data['config_admin_language'] = Config::get('config_admin_language');
        }
        
        if (isset(Request::p()->post['config_currency'])) {
            $data['config_currency'] = Request::p()->post['config_currency'];
        } else {
            $data['config_currency'] = Config::get('config_currency');
        }
        
        if (isset(Request::p()->post['config_currency_auto'])) {
            $data['config_currency_auto'] = Request::p()->post['config_currency_auto'];
        } else {
            $data['config_currency_auto'] = Config::get('config_currency_auto');
        }
        
        Theme::model('locale/currency');
        
        $data['currencies'] = LocaleCurrency::getCurrencies();
        
        if (isset(Request::p()->post['config_length_class_id'])) {
            $data['config_length_class_id'] = Request::p()->post['config_length_class_id'];
        } else {
            $data['config_length_class_id'] = Config::get('config_length_class_id');
        }
        
        Theme::model('locale/length_class');
        
        $data['length_classes'] = LocaleLengthClass::getLengthClasses();
        
        if (isset(Request::p()->post['config_weight_class_id'])) {
            $data['config_weight_class_id'] = Request::p()->post['config_weight_class_id'];
        } else {
            $data['config_weight_class_id'] = Config::get('config_weight_class_id');
        }
        
        Theme::model('locale/weight_class');
        
        $data['weight_classes'] = LocaleWeightClass::getWeightClasses();
        
        if (isset(Request::p()->post['config_catalog_limit'])) {
            $data['config_catalog_limit'] = Request::p()->post['config_catalog_limit'];
        } else {
            $data['config_catalog_limit'] = Config::get('config_catalog_limit');
        }
        
        if (isset(Request::p()->post['config_admin_limit'])) {
            $data['config_admin_limit'] = Request::p()->post['config_admin_limit'];
        } else {
            $data['config_admin_limit'] = Config::get('config_admin_limit');
        }
        
        if (isset(Request::p()->post['config_product_count'])) {
            $data['config_product_count'] = Request::p()->post['config_product_count'];
        } else {
            $data['config_product_count'] = Config::get('config_product_count');
        }
        
        if (isset(Request::p()->post['config_review_status'])) {
            $data['config_review_status'] = Request::p()->post['config_review_status'];
        } else {
            $data['config_review_status'] = Config::get('config_review_status');
        }
        
        if (isset(Request::p()->post['config_review_logged'])) {
            $data['config_review_logged'] = Request::p()->post['config_review_logged'];
        } else {
            $data['config_review_logged'] = Config::get('config_review_logged');
        }
        
        if (isset(Request::p()->post['config_download'])) {
            $data['config_download'] = Request::p()->post['config_download'];
        } else {
            $data['config_download'] = Config::get('config_download');
        }
        
        if (isset(Request::p()->post['config_gift_card_min'])) {
            $data['config_gift_card_min'] = Request::p()->post['config_gift_card_min'];
        } else {
            $data['config_gift_card_min'] = Config::get('config_gift_card_min');
        }
        
        if (isset(Request::p()->post['config_gift_card_max'])) {
            $data['config_gift_card_max'] = Request::p()->post['config_gift_card_max'];
        } else {
            $data['config_gift_card_max'] = Config::get('config_gift_card_max');
        }
        
        if (isset(Request::p()->post['config_tax'])) {
            $data['config_tax'] = Request::p()->post['config_tax'];
        } else {
            $data['config_tax'] = Config::get('config_tax');
        }
        
        if (isset(Request::p()->post['config_vat'])) {
            $data['config_vat'] = Request::p()->post['config_vat'];
        } else {
            $data['config_vat'] = Config::get('config_vat');
        }
        
        if (isset(Request::p()->post['config_tax_default'])) {
            $data['config_tax_default'] = Request::p()->post['config_tax_default'];
        } else {
            $data['config_tax_default'] = Config::get('config_tax_default');
        }
        
        if (isset(Request::p()->post['config_tax_customer'])) {
            $data['config_tax_customer'] = Request::p()->post['config_tax_customer'];
        } else {
            $data['config_tax_customer'] = Config::get('config_tax_customer');
        }
        
        if (isset(Request::p()->post['config_customer_online'])) {
            $data['config_customer_online'] = Request::p()->post['config_customer_online'];
        } else {
            $data['config_customer_online'] = Config::get('config_customer_online');
        }
        
        if (isset(Request::p()->post['config_customer_group_id'])) {
            $data['config_customer_group_id'] = Request::p()->post['config_customer_group_id'];
        } else {
            $data['config_customer_group_id'] = Config::get('config_customer_group_id');
        }
        
        Theme::model('people/customer_group');
        
        // assign to local variable so we can use it later
        $customer_groups = PeopleCustomerGroup::getCustomerGroups();
        
        $data['customer_groups'] = $customer_groups;
        
        if (isset(Request::p()->post['config_customer_group_display'])) {
            $data['config_customer_group_display'] = Request::p()->post['config_customer_group_display'];
        } elseif (Config::get('config_customer_group_display')) {
            $data['config_customer_group_display'] = Config::get('config_customer_group_display');
        } else {
            $data['config_customer_group_display'] = array();
        }
        
        if (isset(Request::p()->post['config_customer_price'])) {
            $data['config_customer_price'] = Request::p()->post['config_customer_price'];
        } else {
            $data['config_customer_price'] = Config::get('config_customer_price');
        }

        if (isset(Request::p()->post['blog_posted_by'])) {
            $data['blog_posted_by'] = Request::p()->post['blog_posted_by'];
        } else {
            $data['blog_posted_by'] = Config::get('blog_posted_by');
        }
        
        if (isset(Request::p()->post['blog_comment_status'])) {
            $data['blog_comment_status'] = Request::p()->post['blog_comment_status'];
        } else {
            $data['blog_comment_status'] = Config::get('blog_comment_status');
        }
        
        if (isset(Request::p()->post['blog_comment_logged'])) {
            $data['blog_comment_logged'] = Request::p()->post['blog_comment_logged'];
        } else {
            $data['blog_comment_logged'] = Config::get('blog_comment_logged');
        }
        
        if (isset(Request::p()->post['blog_comment_require_approve'])) {
            $data['blog_comment_require_approve'] = Request::p()->post['blog_comment_require_approve'];
        } else {
            $data['blog_comment_require_approve'] = Config::get('blog_comment_require_approve');
        }
        
        if (isset(Request::p()->post['blog_admin_group_id'])) {
            $data['blog_admin_group_id'] = Request::p()->post['blog_admin_group_id'];
        } else {
            $data['blog_admin_group_id'] = Config::get('blog_admin_group_id');
        }
        
        if (isset(Request::p()->post['blog_image_thumb_width'])) {
            $data['blog_image_thumb_width'] = Request::p()->post['blog_image_thumb_width'];
        } else {
            $data['blog_image_thumb_width'] = Config::get('blog_image_thumb_width');
        }
        
        if (isset(Request::p()->post['blog_image_thumb_height'])) {
            $data['blog_image_thumb_height'] = Request::p()->post['blog_image_thumb_height'];
        } else {
            $data['blog_image_thumb_height'] = Config::get('blog_image_thumb_height');
        }
        
        if (isset(Request::p()->post['blog_image_popup_width'])) {
            $data['blog_image_popup_width'] = Request::p()->post['blog_image_popup_width'];
        } else {
            $data['blog_image_popup_width'] = Config::get('blog_image_popup_width');
        }
        
        if (isset(Request::p()->post['blog_image_popup_height'])) {
            $data['blog_image_popup_height'] = Request::p()->post['blog_image_popup_height'];
        } else {
            $data['blog_image_popup_height'] = Config::get('blog_image_popup_height');
        }
        
        if (isset(Request::p()->post['blog_image_post_width'])) {
            $data['blog_image_post_width'] = Request::p()->post['blog_image_post_width'];
        } else {
            $data['blog_image_post_width'] = Config::get('blog_image_post_width');
        }
        
        if (isset(Request::p()->post['blog_image_post_height'])) {
            $data['blog_image_post_height'] = Request::p()->post['blog_image_post_height'];
        } else {
            $data['blog_image_post_height'] = Config::get('blog_image_post_height');
        }
        
        if (isset(Request::p()->post['blog_image_additional_width'])) {
            $data['blog_image_additional_width'] = Request::p()->post['blog_image_additional_width'];
        } else {
            $data['blog_image_additional_width'] = Config::get('blog_image_additional_width');
        }
        
        if (isset(Request::p()->post['blog_image_additional_height'])) {
            $data['blog_image_additional_height'] = Request::p()->post['blog_image_additional_height'];
        } else {
            $data['blog_image_additional_height'] = Config::get('blog_image_additional_height');
        }
        
        if (isset(Request::p()->post['blog_image_related_width'])) {
            $data['blog_image_related_width'] = Request::p()->post['blog_image_related_width'];
        } else {
            $data['blog_image_related_width'] = Config::get('blog_image_related_width');
        }
        
        if (isset(Request::p()->post['blog_image_related_height'])) {
            $data['blog_image_related_height'] = Request::p()->post['blog_image_related_height'];
        } else {
            $data['blog_image_related_height'] = Config::get('blog_image_related_height');
        }
        
        Theme::model('people/user_group');
        
        $data['user_groups'] = PeopleUserGroup::getUserGroups();
        
        if (isset(Request::p()->post['config_account_id'])) {
            $data['config_account_id'] = Request::p()->post['config_account_id'];
        } else {
            $data['config_account_id'] = Config::get('config_account_id');
        }
        
        Theme::model('content/page');
        
        $data['pages'] = ContentPage::getPages();
        
        if (isset(Request::p()->post['config_home_page'])) {
            $data['config_home_page'] = Request::p()->post['config_home_page'];
        } else {
            $data['config_home_page'] = Config::get('config_home_page');
        }
        
        if (isset(Request::p()->post['config_cart_weight'])) {
            $data['config_cart_weight'] = Request::p()->post['config_cart_weight'];
        } else {
            $data['config_cart_weight'] = Config::get('config_cart_weight');
        }
        
        if (isset(Request::p()->post['config_guest_checkout'])) {
            $data['config_guest_checkout'] = Request::p()->post['config_guest_checkout'];
        } else {
            $data['config_guest_checkout'] = Config::get('config_guest_checkout');
        }
        
        if (isset(Request::p()->post['config_checkout_id'])) {
            $data['config_checkout_id'] = Request::p()->post['config_checkout_id'];
        } else {
            $data['config_checkout_id'] = Config::get('config_checkout_id');
        }
        
        if (isset(Request::p()->post['config_order_edit'])) {
            $data['config_order_edit'] = Request::p()->post['config_order_edit'];
        } elseif (Config::get('config_order_edit')) {
            $data['config_order_edit'] = Config::get('config_order_edit');
        } else {
            $data['config_order_edit'] = 7;
        }
        
        if (isset(Request::p()->post['config_invoice_prefix'])) {
            $data['config_invoice_prefix'] = Request::p()->post['config_invoice_prefix'];
        } elseif (Config::get('config_invoice_prefix')) {
            $data['config_invoice_prefix'] = Config::get('config_invoice_prefix');
        } else {
            $data['config_invoice_prefix'] = 'INV-' . date('Y') . '-00';
        }
        
        if (isset(Request::p()->post['config_order_status_id'])) {
            $data['config_order_status_id'] = Request::p()->post['config_order_status_id'];
        } else {
            $data['config_order_status_id'] = Config::get('config_order_status_id');
        }
        
        if (isset(Request::p()->post['config_complete_status_id'])) {
            $data['config_complete_status_id'] = Request::p()->post['config_complete_status_id'];
        } else {
            $data['config_complete_status_id'] = Config::get('config_complete_status_id');
        }
        
        Theme::model('locale/order_status');
        
        $data['order_statuses'] = LocaleOrderStatus::getOrderStatuses();
        
        if (isset(Request::p()->post['config_stock_display'])) {
            $data['config_stock_display'] = Request::p()->post['config_stock_display'];
        } else {
            $data['config_stock_display'] = Config::get('config_stock_display');
        }
        
        if (isset(Request::p()->post['config_stock_warning'])) {
            $data['config_stock_warning'] = Request::p()->post['config_stock_warning'];
        } else {
            $data['config_stock_warning'] = Config::get('config_stock_warning');
        }
        
        if (isset(Request::p()->post['config_stock_checkout'])) {
            $data['config_stock_checkout'] = Request::p()->post['config_stock_checkout'];
        } else {
            $data['config_stock_checkout'] = Config::get('config_stock_checkout');
        }
        
        if (isset(Request::p()->post['config_stock_status_id'])) {
            $data['config_stock_status_id'] = Request::p()->post['config_stock_status_id'];
        } else {
            $data['config_stock_status_id'] = Config::get('config_stock_status_id');
        }
        
        Theme::model('locale/stock_status');
        
        $data['stock_statuses'] = LocaleStockStatus::getStockStatuses();
        
        if (isset(Request::p()->post['config_affiliate_allowed'])) {
            $data['config_affiliate_allowed'] = Request::p()->post['config_affiliate_allowed'];
        } else {
            $data['config_affiliate_allowed'] = Config::get('config_affiliate_allowed');
        }

        if (isset(Request::p()->post['config_affiliate_terms'])) {
            $data['config_affiliate_terms'] = Request::p()->post['config_affiliate_terms'];
        } else {
            $data['config_affiliate_terms'] = Config::get('config_affiliate_terms');
        }
        
        if (isset(Request::p()->post['config_commission'])) {
            $data['config_commission'] = Request::p()->post['config_commission'];
        } elseif (Config::has('config_commission')) {
            $data['config_commission'] = Config::get('config_commission');
        } else {
            $data['config_commission'] = '5.00';
        }
        
        if (isset(Request::p()->post['config_return_id'])) {
            $data['config_return_id'] = Request::p()->post['config_return_id'];
        } else {
            $data['config_return_id'] = Config::get('config_return_id');
        }
        
        if (isset(Request::p()->post['config_return_status_id'])) {
            $data['config_return_status_id'] = Request::p()->post['config_return_status_id'];
        } else {
            $data['config_return_status_id'] = Config::get('config_return_status_id');
        }
        
        Theme::model('locale/return_status');
        
        $data['return_statuses'] = LocaleReturnStatus::getReturnStatuses();
        
        Theme::model('tool/image');
        
        if (isset(Request::p()->post['config_logo'])) {
            $data['config_logo'] = Request::p()->post['config_logo'];
        } else {
            $data['config_logo'] = Config::get('config_logo');
        }
        
        if (Config::get('config_logo') && file_exists(Config::get('path.image') . Config::get('config_logo')) && is_file(Config::get('path.image') . Config::get('config_logo'))) {
            $data['logo'] = ToolImage::resize(Config::get('config_logo'), 100, 100);
        } else {
            $data['logo'] = ToolImage::resize('placeholder.png', 100, 100);
        }
        
        if (isset(Request::p()->post['config_icon'])) {
            $data['config_icon'] = Request::p()->post['config_icon'];
        } else {
            $data['config_icon'] = Config::get('config_icon');
        }
        
        if (Config::get('config_icon') && file_exists(Config::get('path.image') . Config::get('config_icon')) && is_file(Config::get('path.image') . Config::get('config_icon'))) {
            $data['icon'] = ToolImage::resize(Config::get('config_icon'), 100, 100);
        } else {
            $data['icon'] = ToolImage::resize('placeholder.png', 100, 100);
        }
        
        $data['no_image'] = ToolImage::resize('placeholder.png', 100, 100);
        
        if (isset(Request::p()->post['config_image_category_width'])) {
            $data['config_image_category_width'] = Request::p()->post['config_image_category_width'];
        } else {
            $data['config_image_category_width'] = Config::get('config_image_category_width');
        }
        
        if (isset(Request::p()->post['config_image_category_height'])) {
            $data['config_image_category_height'] = Request::p()->post['config_image_category_height'];
        } else {
            $data['config_image_category_height'] = Config::get('config_image_category_height');
        }
        
        if (isset(Request::p()->post['config_image_thumb_width'])) {
            $data['config_image_thumb_width'] = Request::p()->post['config_image_thumb_width'];
        } else {
            $data['config_image_thumb_width'] = Config::get('config_image_thumb_width');
        }
        
        if (isset(Request::p()->post['config_image_thumb_height'])) {
            $data['config_image_thumb_height'] = Request::p()->post['config_image_thumb_height'];
        } else {
            $data['config_image_thumb_height'] = Config::get('config_image_thumb_height');
        }
        
        if (isset(Request::p()->post['config_image_popup_width'])) {
            $data['config_image_popup_width'] = Request::p()->post['config_image_popup_width'];
        } else {
            $data['config_image_popup_width'] = Config::get('config_image_popup_width');
        }
        
        if (isset(Request::p()->post['config_image_popup_height'])) {
            $data['config_image_popup_height'] = Request::p()->post['config_image_popup_height'];
        } else {
            $data['config_image_popup_height'] = Config::get('config_image_popup_height');
        }
        
        if (isset(Request::p()->post['config_image_product_width'])) {
            $data['config_image_product_width'] = Request::p()->post['config_image_product_width'];
        } else {
            $data['config_image_product_width'] = Config::get('config_image_product_width');
        }
        
        if (isset(Request::p()->post['config_image_product_height'])) {
            $data['config_image_product_height'] = Request::p()->post['config_image_product_height'];
        } else {
            $data['config_image_product_height'] = Config::get('config_image_product_height');
        }
        
        if (isset(Request::p()->post['config_image_additional_width'])) {
            $data['config_image_additional_width'] = Request::p()->post['config_image_additional_width'];
        } else {
            $data['config_image_additional_width'] = Config::get('config_image_additional_width');
        }
        
        if (isset(Request::p()->post['config_image_additional_height'])) {
            $data['config_image_additional_height'] = Request::p()->post['config_image_additional_height'];
        } else {
            $data['config_image_additional_height'] = Config::get('config_image_additional_height');
        }
        
        if (isset(Request::p()->post['config_image_related_width'])) {
            $data['config_image_related_width'] = Request::p()->post['config_image_related_width'];
        } else {
            $data['config_image_related_width'] = Config::get('config_image_related_width');
        }
        
        if (isset(Request::p()->post['config_image_related_height'])) {
            $data['config_image_related_height'] = Request::p()->post['config_image_related_height'];
        } else {
            $data['config_image_related_height'] = Config::get('config_image_related_height');
        }
        
        if (isset(Request::p()->post['config_image_compare_width'])) {
            $data['config_image_compare_width'] = Request::p()->post['config_image_compare_width'];
        } else {
            $data['config_image_compare_width'] = Config::get('config_image_compare_width');
        }
        
        if (isset(Request::p()->post['config_image_compare_height'])) {
            $data['config_image_compare_height'] = Request::p()->post['config_image_compare_height'];
        } else {
            $data['config_image_compare_height'] = Config::get('config_image_compare_height');
        }
        
        if (isset(Request::p()->post['config_image_wishlist_width'])) {
            $data['config_image_wishlist_width'] = Request::p()->post['config_image_wishlist_width'];
        } else {
            $data['config_image_wishlist_width'] = Config::get('config_image_wishlist_width');
        }
        
        if (isset(Request::p()->post['config_image_wishlist_height'])) {
            $data['config_image_wishlist_height'] = Request::p()->post['config_image_wishlist_height'];
        } else {
            $data['config_image_wishlist_height'] = Config::get('config_image_wishlist_height');
        }
        
        if (isset(Request::p()->post['config_image_cart_width'])) {
            $data['config_image_cart_width'] = Request::p()->post['config_image_cart_width'];
        } else {
            $data['config_image_cart_width'] = Config::get('config_image_cart_width');
        }
        
        if (isset(Request::p()->post['config_image_cart_height'])) {
            $data['config_image_cart_height'] = Request::p()->post['config_image_cart_height'];
        } else {
            $data['config_image_cart_height'] = Config::get('config_image_cart_height');
        }
        
        if (isset(Request::p()->post['config_ftp_host'])) {
            $data['config_ftp_host'] = Request::p()->post['config_ftp_host'];
        } elseif (Config::get('config_ftp_host')) {
            $data['config_ftp_host'] = Config::get('config_ftp_host');
        } else {
            $data['config_ftp_host'] = str_replace('www.', '', Request::p()->server['HTTP_HOST']);
        }
        
        if (isset(Request::p()->post['config_ftp_port'])) {
            $data['config_ftp_port'] = Request::p()->post['config_ftp_port'];
        } elseif (Config::get('config_ftp_port')) {
            $data['config_ftp_port'] = Config::get('config_ftp_port');
        } else {
            $data['config_ftp_port'] = 21;
        }
        
        if (isset(Request::p()->post['config_ftp_username'])) {
            $data['config_ftp_username'] = Request::p()->post['config_ftp_username'];
        } else {
            $data['config_ftp_username'] = Config::get('config_ftp_username');
        }
        
        if (isset(Request::p()->post['config_ftp_password'])) {
            $data['config_ftp_password'] = Request::p()->post['config_ftp_password'];
        } else {
            $data['config_ftp_password'] = Config::get('config_ftp_password');
        }
        
        if (isset(Request::p()->post['config_ftp_root'])) {
            $data['config_ftp_root'] = Request::p()->post['config_ftp_root'];
        } else {
            $data['config_ftp_root'] = Config::get('config_ftp_root');
        }
        
        if (isset(Request::p()->post['config_ftp_status'])) {
            $data['config_ftp_status'] = Request::p()->post['config_ftp_status'];
        } else {
            $data['config_ftp_status'] = Config::get('config_ftp_status');
        }
        
        if (isset(Request::p()->post['config_mail_protocol'])) {
            $data['config_mail_protocol'] = Request::p()->post['config_mail_protocol'];
        } else {
            $data['config_mail_protocol'] = Config::get('config_mail_protocol');
        }
        
        if (isset(Request::p()->post['config_mail_parameter'])) {
            $data['config_mail_parameter'] = Request::p()->post['config_mail_parameter'];
        } else {
            $data['config_mail_parameter'] = Config::get('config_mail_parameter');
        }
        
        if (isset(Request::p()->post['config_smtp_host'])) {
            $data['config_smtp_host'] = Request::p()->post['config_smtp_host'];
        } else {
            $data['config_smtp_host'] = Config::get('config_smtp_host');
        }
        
        if (isset(Request::p()->post['config_smtp_username'])) {
            $data['config_smtp_username'] = Request::p()->post['config_smtp_username'];
        } else {
            $data['config_smtp_username'] = Config::get('config_smtp_username');
        }
        
        if (isset(Request::p()->post['config_smtp_password'])) {
            $data['config_smtp_password'] = Request::p()->post['config_smtp_password'];
        } else {
            $data['config_smtp_password'] = Config::get('config_smtp_password');
        }
        
        if (isset(Request::p()->post['config_smtp_port'])) {
            $data['config_smtp_port'] = Request::p()->post['config_smtp_port'];
        } elseif (Config::get('config_smtp_port')) {
            $data['config_smtp_port'] = Config::get('config_smtp_port');
        } else {
            $data['config_smtp_port'] = 25;
        }
        
        if (isset(Request::p()->post['config_smtp_timeout'])) {
            $data['config_smtp_timeout'] = Request::p()->post['config_smtp_timeout'];
        } elseif (Config::get('config_smtp_timeout')) {
            $data['config_smtp_timeout'] = Config::get('config_smtp_timeout');
        } else {
            $data['config_smtp_timeout'] = 5;
        }

        Theme::model('people/user');

        $users = PeopleUser::getUsers();

        $data['users'] = array();

        foreach($users as $user):
            $data['users'][] = array(
                'user_id' => $user['user_id'],
                'name'    => $user['user_name']
            );
        endforeach;

        if (isset(Request::p()->post['config_admin_email_user'])) {
            $data['config_admin_email_user'] = Request::p()->post['config_admin_email_user'];
        } else {
            $data['config_admin_email_user'] = Config::get('config_admin_email_user');
        }

        if (isset(Request::p()->post['config_text_signature'])) {
            $data['config_text_signature'] = Request::p()->post['config_text_signature'];
        } else {
            $data['config_text_signature'] = Config::get('config_text_signature');
        }

        if (isset(Request::p()->post['config_html_signature'])) {
            $data['config_html_signature'] = Request::p()->post['config_html_signature'];
        } else {
            $data['config_html_signature'] = Config::get('config_html_signature');
        }
        
        if (isset(Request::p()->post['config_mail_twitter'])) {
            $data['config_mail_twitter'] = Request::p()->post['config_mail_twitter'];
        } else {
            $data['config_mail_twitter'] = Config::get('config_mail_twitter');
        }

        if (isset(Request::p()->post['config_mail_facebook'])) {
            $data['config_mail_facebook'] = Request::p()->post['config_mail_facebook'];
        } else {
            $data['config_mail_facebook'] = Config::get('config_mail_facebook');
        }

        if (isset(Request::p()->post['config_alert_mail'])) {
            $data['config_alert_mail'] = Request::p()->post['config_alert_mail'];
        } else {
            $data['config_alert_mail'] = Config::get('config_alert_mail');
        }
        
        if (isset(Request::p()->post['config_account_mail'])) {
            $data['config_account_mail'] = Request::p()->post['config_account_mail'];
        } else {
            $data['config_account_mail'] = Config::get('config_account_mail');
        }
        
        if (isset(Request::p()->post['config_alert_emails'])) {
            $data['config_alert_emails'] = Request::p()->post['config_alert_emails'];
        } else {
            $data['config_alert_emails'] = Config::get('config_alert_emails');
        }
        
        if (isset(Request::p()->post['config_fraud_detection'])) {
            $data['config_fraud_detection'] = Request::p()->post['config_fraud_detection'];
        } else {
            $data['config_fraud_detection'] = Config::get('config_fraud_detection');
        }
        
        if (isset(Request::p()->post['config_fraud_key'])) {
            $data['config_fraud_key'] = Request::p()->post['config_fraud_key'];
        } else {
            $data['config_fraud_key'] = Config::get('config_fraud_key');
        }
        
        if (isset(Request::p()->post['config_fraud_score'])) {
            $data['config_fraud_score'] = Request::p()->post['config_fraud_score'];
        } else {
            $data['config_fraud_score'] = Config::get('config_fraud_score');
        }
        
        if (isset(Request::p()->post['config_fraud_status_id'])) {
            $data['config_fraud_status_id'] = Request::p()->post['config_fraud_status_id'];
        } else {
            $data['config_fraud_status_id'] = Config::get('config_fraud_status_id');
        }
        
        if (isset(Request::p()->post['config_secure'])) {
            $data['config_secure'] = Request::p()->post['config_secure'];
        } else {
            $data['config_secure'] = Config::get('config_secure');
        }
        
        if (isset(Request::p()->post['config_shared'])) {
            $data['config_shared'] = Request::p()->post['config_shared'];
        } else {
            $data['config_shared'] = Config::get('config_shared');
        }
        
        if (isset(Request::p()->post['config_top_level'])) {
            $data['config_top_level'] = Request::p()->post['config_top_level'];
        } else {
            $data['config_top_level'] = Config::get('config_top_level');
        }
        
        if (isset(Request::p()->post['config_ucfirst'])) {
            $data['config_ucfirst'] = Request::p()->post['config_ucfirst'];
        } else {
            $data['config_ucfirst'] = Config::get('config_ucfirst');
        }
        
        if (isset(Request::p()->post['config_robots'])) {
            $data['config_robots'] = Request::p()->post['config_robots'];
        } else {
            $data['config_robots'] = Config::get('config_robots');
        }
        
        if (isset(Request::p()->post['config_file_extension_allowed'])) {
            $data['config_file_extension_allowed'] = Request::p()->post['config_file_extension_allowed'];
        } else {
            $data['config_file_extension_allowed'] = Config::get('config_file_extension_allowed');
        }
        
        if (isset(Request::p()->post['config_file_mime_allowed'])) {
            $data['config_file_mime_allowed'] = Request::p()->post['config_file_mime_allowed'];
        } else {
            $data['config_file_mime_allowed'] = Config::get('config_file_mime_allowed');
        }
        
        if (isset(Request::p()->post['config_maintenance'])) {
            $data['config_maintenance'] = Request::p()->post['config_maintenance'];
        } else {
            $data['config_maintenance'] = Config::get('config_maintenance');
        }
        
        if (isset(Request::p()->post['config_password'])) {
            $data['config_password'] = Request::p()->post['config_password'];
        } else {
            $data['config_password'] = Config::get('config_password');
        }
        
        if (isset(Request::p()->post['config_encryption'])) {
            $data['config_encryption'] = Request::p()->post['config_encryption'];
        } else {
            $data['config_encryption'] = Config::get('config_encryption');
        }
        
        if (isset(Request::p()->post['config_compression'])) {
            $data['config_compression'] = Request::p()->post['config_compression'];
        } else {
            $data['config_compression'] = Config::get('config_compression');
        }
        
        if (isset(Request::p()->post['config_error_display'])) {
            $data['config_error_display'] = Request::p()->post['config_error_display'];
        } else {
            $data['config_error_display'] = Config::get('config_error_display');
        }
        
        if (isset(Request::p()->post['config_error_log'])) {
            $data['config_error_log'] = Request::p()->post['config_error_log'];
        } else {
            $data['config_error_log'] = Config::get('config_error_log');
        }
        
        if (isset(Request::p()->post['config_error_filename'])) {
            $data['config_error_filename'] = Request::p()->post['config_error_filename'];
        } else {
            $data['config_error_filename'] = Config::get('config_error_filename');
        }
        
        if (isset(Request::p()->post['config_google_analytics'])) {
            $data['config_google_analytics'] = Request::p()->post['config_google_analytics'];
        } else {
            $data['config_google_analytics'] = Config::get('config_google_analytics');
        }
        
        if (isset(Request::p()->post['config_cache_type_id'])) {
            $data['config_cache_type_id'] = Request::p()->post['config_cache_type_id'];
        } else {
            $data['config_cache_type_id'] = Config::get('config_cache_type_id');
        }
        
        if (isset(Request::p()->post['config_cache_status'])) {
            $data['config_cache_status'] = Request::p()->post['config_cache_status'];
        } else {
            $data['config_cache_status'] = Config::get('config_cache_status');
        }
        
        $data['cache_types'] = array();
        
        $caches = array();
        
        $caches[] = array('cache_type_id' => 'file', 'name' => 'File');
        
        if (extension_loaded('apc') && phpversion() < '5.5'):
            $caches[] = array('cache_type_id' => 'apc', 'name' => 'APC');
        endif;
        
        if (extension_loaded('memcache')):
            $test = new Mem;
            if ($test->check()):
                $caches[] = array('cache_type_id' => 'mem', 'name' => 'Memcached');
            endif;
        endif;
        
        $data['cache_types'] = $caches;
        
        Theme::loadjs('javascript/setting/setting', $data);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::make('setting/setting', $data));
    }
    
    protected function validate() {
        if (!User::hasPermission('modify', 'setting/setting')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        if (!Request::p()->post['config_name']) {
            $this->error['name'] = Lang::get('lang_error_name');
        }
        
        if ((Encode::strlen(Request::p()->post['config_owner']) < 3) || (Encode::strlen(Request::p()->post['config_owner']) > 64)) {
            $this->error['owner'] = Lang::get('lang_error_owner');
        }
        
        if ((Encode::strlen(Request::p()->post['config_address']) < 3) || (Encode::strlen(Request::p()->post['config_address']) > 256)) {
            $this->error['address'] = Lang::get('lang_error_address');
        }
        
        if ((Encode::strlen(Request::p()->post['config_email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', Request::p()->post['config_email'])) {
            $this->error['email'] = Lang::get('lang_error_email');
        }
        
        if ((Encode::strlen(Request::p()->post['config_telephone']) < 3) || (Encode::strlen(Request::p()->post['config_telephone']) > 32)) {
            $this->error['telephone'] = Lang::get('lang_error_telephone');
        }
        
        if (!Request::p()->post['config_title']) {
            $this->error['title'] = Lang::get('lang_error_title');
        }

        if (!Request::p()->post['config_admin_email_user'] || Request::p()->post['config_admin_email_user'] < 1) {
            $this->error['admin_email_user'] = Lang::get('lang_error_admin_email_user');
        }

        if (!Request::p()->post['config_text_signature'] || Encode::strlen(Request::p()->post['config_text_signature']) < 1) {
            $this->error['text_signature'] = Lang::get('lang_error_text_signature');
        }

        if (!Request::p()->post['config_html_signature'] || Encode::strlen(Request::p()->post['config_html_signature']) < 1) {
            $this->error['html_signature'] = Lang::get('lang_error_html_signature');
        }

        // Affiliate settings
        // If allowing affiliates, params for them must be supplied.
        if (Request::p()->post['config_affiliate_allowed']):
            if (!Request::p()->post['config_affiliate_terms']):
                $this->error['affiliate_terms'] = Lang::get('lang_error_affiliate_terms');
            endif;

            if (Encode::strlen(Request::p()->post['config_commission']) < 1):
                $this->error['commission'] = Lang::get('lang_error_affiliate_commission');
            endif;
        endif;
        
        if (!empty(Request::p()->post['config_customer_group_display']) && !in_array(Request::p()->post['config_customer_group_id'], Request::p()->post['config_customer_group_display'])) {
            $this->error['customer_group_display'] = Lang::get('lang_error_customer_group_display');
        }
        
        if (!Request::p()->post['config_gift_card_min']) {
            $this->error['gift_card_min'] = Lang::get('lang_error_gift_card_min');
        }
        
        if (!Request::p()->post['config_gift_card_max']) {
            $this->error['gift_card_max'] = Lang::get('lang_error_gift_card_max');
        }
        
        if (!Request::p()->post['config_image_category_width'] || !Request::p()->post['config_image_category_height']) {
            $this->error['image_category'] = Lang::get('lang_error_image_category');
        }
        
        if (!Request::p()->post['config_image_thumb_width'] || !Request::p()->post['config_image_thumb_height']) {
            $this->error['image_thumb'] = Lang::get('lang_error_image_thumb');
        }
        
        if (!Request::p()->post['config_image_popup_width'] || !Request::p()->post['config_image_popup_height']) {
            $this->error['image_popup'] = Lang::get('lang_error_image_popup');
        }
        
        if (!Request::p()->post['config_image_product_width'] || !Request::p()->post['config_image_product_height']) {
            $this->error['image_product'] = Lang::get('lang_error_image_product');
        }
        
        if (!Request::p()->post['config_image_additional_width'] || !Request::p()->post['config_image_additional_height']) {
            $this->error['image_additional'] = Lang::get('lang_error_image_additional');
        }
        
        if (!Request::p()->post['config_image_related_width'] || !Request::p()->post['config_image_related_height']) {
            $this->error['image_related'] = Lang::get('lang_error_image_related');
        }
        
        if (!Request::p()->post['config_image_compare_width'] || !Request::p()->post['config_image_compare_height']) {
            $this->error['image_compare'] = Lang::get('lang_error_image_compare');
        }
        
        if (!Request::p()->post['config_image_wishlist_width'] || !Request::p()->post['config_image_wishlist_height']) {
            $this->error['image_wishlist'] = Lang::get('lang_error_image_wishlist');
        }
        
        if (!Request::p()->post['config_image_cart_width'] || !Request::p()->post['config_image_cart_height']) {
            $this->error['image_cart'] = Lang::get('lang_error_image_cart');
        }
        
        if (Request::p()->post['config_ftp_status']) {
            if (!Request::p()->post['config_ftp_host']) {
                $this->error['ftp_host'] = Lang::get('lang_error_ftp_host');
            }
            
            if (!Request::p()->post['config_ftp_port']) {
                $this->error['ftp_port'] = Lang::get('lang_error_ftp_port');
            }
            
            if (!Request::p()->post['config_ftp_username']) {
                $this->error['ftp_username'] = Lang::get('lang_error_ftp_username');
            }
            
            if (!Request::p()->post['config_ftp_password']) {
                $this->error['ftp_password'] = Lang::get('lang_error_ftp_password');
            }
        }
        
        if (!Request::p()->post['config_error_filename']) {
            $this->error['error_filename'] = Lang::get('lang_error_error_filename');
        }
        
        if (!Request::p()->post['config_catalog_limit']) {
            $this->error['catalog_limit'] = Lang::get('lang_error_limit');
        }
        
        if (!Request::p()->post['config_admin_limit']) {
            $this->error['admin_limit'] = Lang::get('lang_error_limit');
        }
        
        if ((Encode::strlen(Request::p()->post['config_encryption']) < 3) || (Encode::strlen(Request::p()->post['config_encryption']) > 32)) {
            $this->error['encryption'] = Lang::get('lang_error_encryption');
        }
        
        if (!Request::p()->post['config_default_visibility']):
            $this->error['default_visibility'] = Lang::get('lang_error_default_visibility');
        endif;
        
        if (!Request::p()->post['config_free_customer']):
            $this->error['free_customer'] = Lang::get('lang_error_free_customer');
        endif;
        
        if (!Request::p()->post['config_top_customer']):
            $this->error['top_customer'] = Lang::get('lang_error_top_customer');
        endif;

        if (!Request::p()->post['blog_image_thumb_width'] || !Request::p()->post['blog_image_thumb_height']) {
            $this->error['blog_image_thumb'] = Lang::get('lang_error_blog_image_thumb');
        }
        
        if (!Request::p()->post['blog_image_popup_width'] || !Request::p()->post['blog_image_popup_height']) {
            $this->error['blog_image_popup'] = Lang::get('lang_error_blog_image_popup');
        }
        
        if (!Request::p()->post['blog_image_post_width'] || !Request::p()->post['blog_image_post_height']) {
            $this->error['blog_image_post'] = Lang::get('lang_error_blog_image_post');
        }
        
        if (!Request::p()->post['blog_image_additional_width'] || !Request::p()->post['blog_image_additional_height']) {
            $this->error['blog_image_additional'] = Lang::get('lang_error_blog_image_additional');
        }
        
        if (!Request::p()->post['blog_image_related_width'] || !Request::p()->post['blog_image_related_height']) {
            $this->error['blog_image_related'] = Lang::get('lang_error_blog_image_related');
        }
        
        if (!Request::p()->post['blog_posted_by']) {
            $this->error['blog_posted_by'] = Lang::get('lang_error_blog_posted_by');
        }
        
        if (!Request::p()->post['blog_admin_group_id']) {
            $this->error['blog_admin_group_id'] = Lang::get('lang_error_blog_admin_group_id');
        }
        
        if ($this->error && !isset($this->error['warning'])) {
            $this->error['warning'] = Lang::get('lang_error_warning');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    public function autocomplete() {
        $json = array();
        
        if (isset(Request::p()->get['filter_username']) || isset(Request::p()->get['filter_name'])) {
            Theme::model('people/customer');
            
            $filter_username = (isset(Request::p()->get['filter_username'])) ? Request::p()->get['filter_username'] : null;
            $filter_name = (isset(Request::p()->get['filter_name'])) ? Request::p()->get['filter_name'] : null;
            
            $filter = array('filter_username' => $filter_username, 'filter_name' => $filter_name, 'filter_customer_group_id' => Config::get('config_top_customer'), 'filter_status' => 1, 'start' => 0, 'limit' => 20);
            
            $results = PeopleCustomer::getCustomers($filter);
            
            foreach ($results as $result) {
                $json[] = array('customer_id' => $result['customer_id'], 'username' => $result['username'], 'name' => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')));
            }
        }
        
        $sort_order = array();
        
        foreach ($json as $key => $value) {
            $sort_order[$key] = $value;
        }
        
        array_multisort($sort_order, SORT_ASC, $json);
        
        $json = Theme::listen(__CLASS__, __FUNCTION__, $json);
        
        Response::setOutput(json_encode($json));
    }
    
    public function theme() {
        if (isset(Request::p()->server['HTTPS']) && ((Request::p()->server['HTTPS'] == 'on') || (Request::p()->server['HTTPS'] == '1'))) {
            $server = Config::get('https.public');
        } else {
            $server = Config::get('http.public');
        }
        
        if (file_exists(Config::get('path.image') . 'themes/front/' . basename(Request::p()->get['theme']) . '.png')) {
            $image = $server . 'image/themes/front/' . basename(Request::p()->get['theme']) . '.png';
        } else {
            $image = $server . 'image/placeholder.png';
        }
        
        Response::setOutput('<img src="' . $image . '" alt="" title="" style="border: 1px solid #EEEEEE;" />');
    }
    
    public function admin_theme() {
        if (isset(Request::p()->server['HTTPS']) && ((Request::p()->server['HTTPS'] == 'on') || (Request::p()->server['HTTPS'] == '1'))) {
            $server = Config::get('https.public');
        } else {
            $server = Config::get('http.public');
        }
        
        if (file_exists(Config::get('path.image') . 'themes/admin/' . basename(Request::p()->get['theme']) . '.png')) {
            $image = $server . 'image/themes/admin/' . basename(Request::p()->get['theme']) . '.png';
        } else {
            $image = $server . 'image/placeholder.png';
        }
        
        Response::setOutput('<img src="' . $image . '" alt="" title="" style="border: 1px solid #EEEEEE;" />');
    }
    
    public function country() {
        $json = array();
        
        Theme::model('locale/country');
        
        $country_info = LocaleCountry::getCountry(Request::p()->get['country_id']);
        
        if ($country_info) {
            Theme::model('locale/zone');
            
            $json = array('country_id' => $country_info['country_id'], 'name' => $country_info['name'], 'iso_code_2' => $country_info['iso_code_2'], 'iso_code_3' => $country_info['iso_code_3'], 'address_format' => $country_info['address_format'], 'postcode_required' => $country_info['postcode_required'], 'zone' => LocaleZone::getZonesByCountryId(Request::p()->get['country_id']), 'status' => $country_info['status']);
        }
        
        $json = Theme::listen(__CLASS__, __FUNCTION__, $json);
        
        Response::setOutput(json_encode($json));
    }
    
    public function flush() {
        Lang::load('setting/setting');
        
        Cache::flush_cache();
        Filecache::flush_cache();
        
        Session::p()->data['success'] = Lang::get('lang_text_flush_success');
        
        Response::redirect(Url::link('setting/setting', ''));
    }
}
