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

namespace Admin\Controller\Setting;
use Dais\Engine\Controller;
use Dais\Driver\Cache\Mem;

class Setting extends Controller {
    private $error = array();
    
    public function index() {
        $data = $this->language->load('setting/setting');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('setting/setting');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('config', $this->request->post);
            
            if ($this->config->get('config_currency_auto')) {
                $this->theme->model('localization/currency');
                $this->model_localization_currency->updateCurrencies();
            }
            
            $this->session->data['success'] = $this->language->get('lang_text_success');
            
            $this->response->redirect($this->url->link('setting/store', 'token=' . $this->session->data['token'], 'SSL'));
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
        
        if (isset($this->error['giftcard_min'])) {
            $data['error_giftcard_min'] = $this->error['giftcard_min'];
        } else {
            $data['error_giftcard_min'] = '';
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
        
        if (isset($this->error['giftcard_max'])) {
            $data['error_giftcard_max'] = $this->error['giftcard_max'];
        } else {
            $data['error_giftcard_max'] = '';
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
        
        $this->breadcrumb->add('lang_heading_title', 'setting/setting');
        
        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];
            
            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }
        
        $data['action'] = $this->url->link('setting/setting', 'token=' . $this->session->data['token'], 'SSL');
        $data['flush']  = $this->url->link('setting/setting/flush', 'token=' . $this->session->data['token'], 'SSL');
        $data['cancel'] = $this->url->link('setting/store', 'token=' . $this->session->data['token'], 'SSL');
        $data['token']  = $this->session->data['token'];
        
        if (isset($this->request->post['config_name'])) {
            $data['config_name'] = $this->request->post['config_name'];
        } else {
            $data['config_name'] = $this->config->get('config_name');
        }
        
        if (isset($this->request->post['config_owner'])) {
            $data['config_owner'] = $this->request->post['config_owner'];
        } else {
            $data['config_owner'] = $this->config->get('config_owner');
        }
        
        if (isset($this->request->post['config_address'])) {
            $data['config_address'] = $this->request->post['config_address'];
        } else {
            $data['config_address'] = $this->config->get('config_address');
        }
        
        if (isset($this->request->post['config_email'])) {
            $data['config_email'] = $this->request->post['config_email'];
        } else {
            $data['config_email'] = $this->config->get('config_email');
        }
        
        if (isset($this->request->post['config_admin_email'])) {
            $data['config_admin_email'] = $this->request->post['config_admin_email'];
        } else {
            $data['config_admin_email'] = $this->config->get('config_admin_email');
        }

        if (isset($this->request->post['config_telephone'])) {
            $data['config_telephone'] = $this->request->post['config_telephone'];
        } else {
            $data['config_telephone'] = $this->config->get('config_telephone');
        }
        
        if (isset($this->request->post['config_default_visibility'])) {
            $data['config_default_visibility'] = $this->request->post['config_default_visibility'];
        } else {
            $data['config_default_visibility'] = $this->config->get('config_default_visibility');
        }
        
        if (isset($this->request->post['config_free_customer'])) {
            $data['config_free_customer'] = $this->request->post['config_free_customer'];
        } else {
            $data['config_free_customer'] = $this->config->get('config_free_customer');
        }
        
        if (isset($this->request->post['config_top_customer'])) {
            $data['config_top_customer'] = $this->request->post['config_top_customer'];
        } else {
            $data['config_top_customer'] = $this->config->get('config_top_customer');
        }
        
        if (isset($this->request->post['config_site_style'])) {
            $data['config_site_style'] = $this->request->post['config_site_style'];
        } else {
            $data['config_site_style'] = $this->config->get('config_site_style');
        }
        
        $data['site_styles'] = array();
        
        $site_styles = array('shop' => $this->language->get('lang_text_style_shop'), 'content' => $this->language->get('lang_text_style_site'),);
        
        foreach ($site_styles as $key => $value):
            $data['site_styles'][] = array('type' => $key, 'name' => $value);
        endforeach;
        
        if (isset($this->request->post['config_title'])) {
            $data['config_title'] = $this->request->post['config_title'];
        } else {
            $data['config_title'] = $this->config->get('config_title');
        }
        
        if (isset($this->request->post['config_meta_description'])) {
            $data['config_meta_description'] = $this->request->post['config_meta_description'];
        } else {
            $data['config_meta_description'] = $this->config->get('config_meta_description');
        }
        
        if (isset($this->request->post['config_layout_id'])) {
            $data['config_layout_id'] = $this->request->post['config_layout_id'];
        } else {
            $data['config_layout_id'] = $this->config->get('config_layout_id');
        }
        
        $this->theme->model('design/layout');
        
        $data['layouts'] = $this->model_design_layout->getLayouts();
        
        if (isset($this->request->post['config_theme'])) {
            $data['config_theme'] = $this->request->post['config_theme'];
        } else {
            $data['config_theme'] = $this->config->get('config_theme');
        }
        
        $data['themes'] = array();
        
        $directories = glob(dirname($this->get('path.theme')) . '/front/*', GLOB_ONLYDIR);
        
        foreach ($directories as $directory) {
            $data['themes'][] = basename($directory);
        }
        
        unset($directories);
        
        if (isset($this->request->post['config_admin_theme'])) {
            $data['config_admin_theme'] = $this->request->post['config_admin_theme'];
        } else {
            $data['config_admin_theme'] = $this->config->get('config_admin_theme');
        }
        
        $data['admin_themes'] = array();
        
        $directories = glob(dirname($this->get('path.theme')) . '/admin/*', GLOB_ONLYDIR);
        
        foreach ($directories as $directory) {
            $data['admin_themes'][] = basename($directory);
        }
        
        if (isset($this->request->post['config_country_id'])) {
            $data['config_country_id'] = $this->request->post['config_country_id'];
        } else {
            $data['config_country_id'] = $this->config->get('config_country_id');
        }
        
        $this->theme->model('localization/country');
        
        $data['countries'] = $this->model_localization_country->getCountries();
        
        if (isset($this->request->post['config_zone_id'])) {
            $data['config_zone_id'] = $this->request->post['config_zone_id'];
        } else {
            $data['config_zone_id'] = $this->config->get('config_zone_id');
        }
        
        if (isset($this->request->post['config_language'])) {
            $data['config_language'] = $this->request->post['config_language'];
        } else {
            $data['config_language'] = $this->config->get('config_language');
        }
        
        $this->theme->model('localization/language');
        
        $data['languages'] = $this->model_localization_language->getLanguages();
        
        if (isset($this->request->post['config_admin_language'])) {
            $data['config_admin_language'] = $this->request->post['config_admin_language'];
        } else {
            $data['config_admin_language'] = $this->config->get('config_admin_language');
        }
        
        if (isset($this->request->post['config_currency'])) {
            $data['config_currency'] = $this->request->post['config_currency'];
        } else {
            $data['config_currency'] = $this->config->get('config_currency');
        }
        
        if (isset($this->request->post['config_currency_auto'])) {
            $data['config_currency_auto'] = $this->request->post['config_currency_auto'];
        } else {
            $data['config_currency_auto'] = $this->config->get('config_currency_auto');
        }
        
        $this->theme->model('localization/currency');
        
        $data['currencies'] = $this->model_localization_currency->getCurrencies();
        
        if (isset($this->request->post['config_length_class_id'])) {
            $data['config_length_class_id'] = $this->request->post['config_length_class_id'];
        } else {
            $data['config_length_class_id'] = $this->config->get('config_length_class_id');
        }
        
        $this->theme->model('localization/lengthclass');
        
        $data['length_classes'] = $this->model_localization_lengthclass->getLengthClasses();
        
        if (isset($this->request->post['config_weight_class_id'])) {
            $data['config_weight_class_id'] = $this->request->post['config_weight_class_id'];
        } else {
            $data['config_weight_class_id'] = $this->config->get('config_weight_class_id');
        }
        
        $this->theme->model('localization/weightclass');
        
        $data['weight_classes'] = $this->model_localization_weightclass->getWeightClasses();
        
        if (isset($this->request->post['config_catalog_limit'])) {
            $data['config_catalog_limit'] = $this->request->post['config_catalog_limit'];
        } else {
            $data['config_catalog_limit'] = $this->config->get('config_catalog_limit');
        }
        
        if (isset($this->request->post['config_admin_limit'])) {
            $data['config_admin_limit'] = $this->request->post['config_admin_limit'];
        } else {
            $data['config_admin_limit'] = $this->config->get('config_admin_limit');
        }
        
        if (isset($this->request->post['config_product_count'])) {
            $data['config_product_count'] = $this->request->post['config_product_count'];
        } else {
            $data['config_product_count'] = $this->config->get('config_product_count');
        }
        
        if (isset($this->request->post['config_review_status'])) {
            $data['config_review_status'] = $this->request->post['config_review_status'];
        } else {
            $data['config_review_status'] = $this->config->get('config_review_status');
        }
        
        if (isset($this->request->post['config_review_logged'])) {
            $data['config_review_logged'] = $this->request->post['config_review_logged'];
        } else {
            $data['config_review_logged'] = $this->config->get('config_review_logged');
        }
        
        if (isset($this->request->post['config_download'])) {
            $data['config_download'] = $this->request->post['config_download'];
        } else {
            $data['config_download'] = $this->config->get('config_download');
        }
        
        if (isset($this->request->post['config_giftcard_min'])) {
            $data['config_giftcard_min'] = $this->request->post['config_giftcard_min'];
        } else {
            $data['config_giftcard_min'] = $this->config->get('config_giftcard_min');
        }
        
        if (isset($this->request->post['config_giftcard_max'])) {
            $data['config_giftcard_max'] = $this->request->post['config_giftcard_max'];
        } else {
            $data['config_giftcard_max'] = $this->config->get('config_giftcard_max');
        }
        
        if (isset($this->request->post['config_tax'])) {
            $data['config_tax'] = $this->request->post['config_tax'];
        } else {
            $data['config_tax'] = $this->config->get('config_tax');
        }
        
        if (isset($this->request->post['config_vat'])) {
            $data['config_vat'] = $this->request->post['config_vat'];
        } else {
            $data['config_vat'] = $this->config->get('config_vat');
        }
        
        if (isset($this->request->post['config_tax_default'])) {
            $data['config_tax_default'] = $this->request->post['config_tax_default'];
        } else {
            $data['config_tax_default'] = $this->config->get('config_tax_default');
        }
        
        if (isset($this->request->post['config_tax_customer'])) {
            $data['config_tax_customer'] = $this->request->post['config_tax_customer'];
        } else {
            $data['config_tax_customer'] = $this->config->get('config_tax_customer');
        }
        
        if (isset($this->request->post['config_customer_online'])) {
            $data['config_customer_online'] = $this->request->post['config_customer_online'];
        } else {
            $data['config_customer_online'] = $this->config->get('config_customer_online');
        }
        
        if (isset($this->request->post['config_customer_group_id'])) {
            $data['config_customer_group_id'] = $this->request->post['config_customer_group_id'];
        } else {
            $data['config_customer_group_id'] = $this->config->get('config_customer_group_id');
        }
        
        $this->theme->model('people/customergroup');
        
        // assign to local variable so we can use it later
        $customer_groups = $this->model_people_customergroup->getCustomerGroups();
        
        $data['customer_groups'] = $customer_groups;
        
        if (isset($this->request->post['config_customer_group_display'])) {
            $data['config_customer_group_display'] = $this->request->post['config_customer_group_display'];
        } elseif ($this->config->get('config_customer_group_display')) {
            $data['config_customer_group_display'] = $this->config->get('config_customer_group_display');
        } else {
            $data['config_customer_group_display'] = array();
        }
        
        if (isset($this->request->post['config_customer_price'])) {
            $data['config_customer_price'] = $this->request->post['config_customer_price'];
        } else {
            $data['config_customer_price'] = $this->config->get('config_customer_price');
        }

        if (isset($this->request->post['blog_posted_by'])) {
            $data['blog_posted_by'] = $this->request->post['blog_posted_by'];
        } else {
            $data['blog_posted_by'] = $this->config->get('blog_posted_by');
        }
        
        if (isset($this->request->post['blog_comment_status'])) {
            $data['blog_comment_status'] = $this->request->post['blog_comment_status'];
        } else {
            $data['blog_comment_status'] = $this->config->get('blog_comment_status');
        }
        
        if (isset($this->request->post['blog_comment_logged'])) {
            $data['blog_comment_logged'] = $this->request->post['blog_comment_logged'];
        } else {
            $data['blog_comment_logged'] = $this->config->get('blog_comment_logged');
        }
        
        if (isset($this->request->post['blog_comment_require_approve'])) {
            $data['blog_comment_require_approve'] = $this->request->post['blog_comment_require_approve'];
        } else {
            $data['blog_comment_require_approve'] = $this->config->get('blog_comment_require_approve');
        }
        
        if (isset($this->request->post['blog_admin_group_id'])) {
            $data['blog_admin_group_id'] = $this->request->post['blog_admin_group_id'];
        } else {
            $data['blog_admin_group_id'] = $this->config->get('blog_admin_group_id');
        }
        
        if (isset($this->request->post['blog_image_thumb_width'])) {
            $data['blog_image_thumb_width'] = $this->request->post['blog_image_thumb_width'];
        } else {
            $data['blog_image_thumb_width'] = $this->config->get('blog_image_thumb_width');
        }
        
        if (isset($this->request->post['blog_image_thumb_height'])) {
            $data['blog_image_thumb_height'] = $this->request->post['blog_image_thumb_height'];
        } else {
            $data['blog_image_thumb_height'] = $this->config->get('blog_image_thumb_height');
        }
        
        if (isset($this->request->post['blog_image_popup_width'])) {
            $data['blog_image_popup_width'] = $this->request->post['blog_image_popup_width'];
        } else {
            $data['blog_image_popup_width'] = $this->config->get('blog_image_popup_width');
        }
        
        if (isset($this->request->post['blog_image_popup_height'])) {
            $data['blog_image_popup_height'] = $this->request->post['blog_image_popup_height'];
        } else {
            $data['blog_image_popup_height'] = $this->config->get('blog_image_popup_height');
        }
        
        if (isset($this->request->post['blog_image_post_width'])) {
            $data['blog_image_post_width'] = $this->request->post['blog_image_post_width'];
        } else {
            $data['blog_image_post_width'] = $this->config->get('blog_image_post_width');
        }
        
        if (isset($this->request->post['blog_image_post_height'])) {
            $data['blog_image_post_height'] = $this->request->post['blog_image_post_height'];
        } else {
            $data['blog_image_post_height'] = $this->config->get('blog_image_post_height');
        }
        
        if (isset($this->request->post['blog_image_additional_width'])) {
            $data['blog_image_additional_width'] = $this->request->post['blog_image_additional_width'];
        } else {
            $data['blog_image_additional_width'] = $this->config->get('blog_image_additional_width');
        }
        
        if (isset($this->request->post['blog_image_additional_height'])) {
            $data['blog_image_additional_height'] = $this->request->post['blog_image_additional_height'];
        } else {
            $data['blog_image_additional_height'] = $this->config->get('blog_image_additional_height');
        }
        
        if (isset($this->request->post['blog_image_related_width'])) {
            $data['blog_image_related_width'] = $this->request->post['blog_image_related_width'];
        } else {
            $data['blog_image_related_width'] = $this->config->get('blog_image_related_width');
        }
        
        if (isset($this->request->post['blog_image_related_height'])) {
            $data['blog_image_related_height'] = $this->request->post['blog_image_related_height'];
        } else {
            $data['blog_image_related_height'] = $this->config->get('blog_image_related_height');
        }
        
        $this->theme->model('people/user_group');
        
        $data['user_groups'] = $this->model_people_user_group->getUserGroups();
        
        if (isset($this->request->post['config_account_id'])) {
            $data['config_account_id'] = $this->request->post['config_account_id'];
        } else {
            $data['config_account_id'] = $this->config->get('config_account_id');
        }
        
        $this->theme->model('content/page');
        
        $data['pages'] = $this->model_content_page->getPages();
        
        if (isset($this->request->post['config_home_page'])) {
            $data['config_home_page'] = $this->request->post['config_home_page'];
        } else {
            $data['config_home_page'] = $this->config->get('config_home_page');
        }
        
        if (isset($this->request->post['config_cart_weight'])) {
            $data['config_cart_weight'] = $this->request->post['config_cart_weight'];
        } else {
            $data['config_cart_weight'] = $this->config->get('config_cart_weight');
        }
        
        if (isset($this->request->post['config_guest_checkout'])) {
            $data['config_guest_checkout'] = $this->request->post['config_guest_checkout'];
        } else {
            $data['config_guest_checkout'] = $this->config->get('config_guest_checkout');
        }
        
        if (isset($this->request->post['config_checkout_id'])) {
            $data['config_checkout_id'] = $this->request->post['config_checkout_id'];
        } else {
            $data['config_checkout_id'] = $this->config->get('config_checkout_id');
        }
        
        if (isset($this->request->post['config_order_edit'])) {
            $data['config_order_edit'] = $this->request->post['config_order_edit'];
        } elseif ($this->config->get('config_order_edit')) {
            $data['config_order_edit'] = $this->config->get('config_order_edit');
        } else {
            $data['config_order_edit'] = 7;
        }
        
        if (isset($this->request->post['config_invoice_prefix'])) {
            $data['config_invoice_prefix'] = $this->request->post['config_invoice_prefix'];
        } elseif ($this->config->get('config_invoice_prefix')) {
            $data['config_invoice_prefix'] = $this->config->get('config_invoice_prefix');
        } else {
            $data['config_invoice_prefix'] = 'INV-' . date('Y') . '-00';
        }
        
        if (isset($this->request->post['config_order_status_id'])) {
            $data['config_order_status_id'] = $this->request->post['config_order_status_id'];
        } else {
            $data['config_order_status_id'] = $this->config->get('config_order_status_id');
        }
        
        if (isset($this->request->post['config_complete_status_id'])) {
            $data['config_complete_status_id'] = $this->request->post['config_complete_status_id'];
        } else {
            $data['config_complete_status_id'] = $this->config->get('config_complete_status_id');
        }
        
        $this->theme->model('localization/orderstatus');
        
        $data['order_statuses'] = $this->model_localization_orderstatus->getOrderStatuses();
        
        if (isset($this->request->post['config_stock_display'])) {
            $data['config_stock_display'] = $this->request->post['config_stock_display'];
        } else {
            $data['config_stock_display'] = $this->config->get('config_stock_display');
        }
        
        if (isset($this->request->post['config_stock_warning'])) {
            $data['config_stock_warning'] = $this->request->post['config_stock_warning'];
        } else {
            $data['config_stock_warning'] = $this->config->get('config_stock_warning');
        }
        
        if (isset($this->request->post['config_stock_checkout'])) {
            $data['config_stock_checkout'] = $this->request->post['config_stock_checkout'];
        } else {
            $data['config_stock_checkout'] = $this->config->get('config_stock_checkout');
        }
        
        if (isset($this->request->post['config_stock_status_id'])) {
            $data['config_stock_status_id'] = $this->request->post['config_stock_status_id'];
        } else {
            $data['config_stock_status_id'] = $this->config->get('config_stock_status_id');
        }
        
        $this->theme->model('localization/stockstatus');
        
        $data['stock_statuses'] = $this->model_localization_stockstatus->getStockStatuses();
        
        if (isset($this->request->post['config_affiliate_allowed'])) {
            $data['config_affiliate_allowed'] = $this->request->post['config_affiliate_allowed'];
        } else {
            $data['config_affiliate_allowed'] = $this->config->get('config_affiliate_allowed');
        }

        if (isset($this->request->post['config_affiliate_terms'])) {
            $data['config_affiliate_terms'] = $this->request->post['config_affiliate_terms'];
        } else {
            $data['config_affiliate_terms'] = $this->config->get('config_affiliate_terms');
        }
        
        if (isset($this->request->post['config_commission'])) {
            $data['config_commission'] = $this->request->post['config_commission'];
        } elseif ($this->config->has('config_commission')) {
            $data['config_commission'] = $this->config->get('config_commission');
        } else {
            $data['config_commission'] = '5.00';
        }
        
        if (isset($this->request->post['config_return_id'])) {
            $data['config_return_id'] = $this->request->post['config_return_id'];
        } else {
            $data['config_return_id'] = $this->config->get('config_return_id');
        }
        
        if (isset($this->request->post['config_return_status_id'])) {
            $data['config_return_status_id'] = $this->request->post['config_return_status_id'];
        } else {
            $data['config_return_status_id'] = $this->config->get('config_return_status_id');
        }
        
        $this->theme->model('localization/returnstatus');
        
        $data['return_statuses'] = $this->model_localization_returnstatus->getReturnStatuses();
        
        $this->theme->model('tool/image');
        
        if (isset($this->request->post['config_logo'])) {
            $data['config_logo'] = $this->request->post['config_logo'];
        } else {
            $data['config_logo'] = $this->config->get('config_logo');
        }
        
        if ($this->config->get('config_logo') && file_exists($this->get('path.image') . $this->config->get('config_logo')) && is_file($this->get('path.image') . $this->config->get('config_logo'))) {
            $data['logo'] = $this->model_tool_image->resize($this->config->get('config_logo'), 100, 100);
        } else {
            $data['logo'] = $this->model_tool_image->resize('placeholder.png', 100, 100);
        }
        
        if (isset($this->request->post['config_icon'])) {
            $data['config_icon'] = $this->request->post['config_icon'];
        } else {
            $data['config_icon'] = $this->config->get('config_icon');
        }
        
        if ($this->config->get('config_icon') && file_exists($this->get('path.image') . $this->config->get('config_icon')) && is_file($this->get('path.image') . $this->config->get('config_icon'))) {
            $data['icon'] = $this->model_tool_image->resize($this->config->get('config_icon'), 100, 100);
        } else {
            $data['icon'] = $this->model_tool_image->resize('placeholder.png', 100, 100);
        }
        
        $data['no_image'] = $this->model_tool_image->resize('placeholder.png', 100, 100);
        
        if (isset($this->request->post['config_image_category_width'])) {
            $data['config_image_category_width'] = $this->request->post['config_image_category_width'];
        } else {
            $data['config_image_category_width'] = $this->config->get('config_image_category_width');
        }
        
        if (isset($this->request->post['config_image_category_height'])) {
            $data['config_image_category_height'] = $this->request->post['config_image_category_height'];
        } else {
            $data['config_image_category_height'] = $this->config->get('config_image_category_height');
        }
        
        if (isset($this->request->post['config_image_thumb_width'])) {
            $data['config_image_thumb_width'] = $this->request->post['config_image_thumb_width'];
        } else {
            $data['config_image_thumb_width'] = $this->config->get('config_image_thumb_width');
        }
        
        if (isset($this->request->post['config_image_thumb_height'])) {
            $data['config_image_thumb_height'] = $this->request->post['config_image_thumb_height'];
        } else {
            $data['config_image_thumb_height'] = $this->config->get('config_image_thumb_height');
        }
        
        if (isset($this->request->post['config_image_popup_width'])) {
            $data['config_image_popup_width'] = $this->request->post['config_image_popup_width'];
        } else {
            $data['config_image_popup_width'] = $this->config->get('config_image_popup_width');
        }
        
        if (isset($this->request->post['config_image_popup_height'])) {
            $data['config_image_popup_height'] = $this->request->post['config_image_popup_height'];
        } else {
            $data['config_image_popup_height'] = $this->config->get('config_image_popup_height');
        }
        
        if (isset($this->request->post['config_image_product_width'])) {
            $data['config_image_product_width'] = $this->request->post['config_image_product_width'];
        } else {
            $data['config_image_product_width'] = $this->config->get('config_image_product_width');
        }
        
        if (isset($this->request->post['config_image_product_height'])) {
            $data['config_image_product_height'] = $this->request->post['config_image_product_height'];
        } else {
            $data['config_image_product_height'] = $this->config->get('config_image_product_height');
        }
        
        if (isset($this->request->post['config_image_additional_width'])) {
            $data['config_image_additional_width'] = $this->request->post['config_image_additional_width'];
        } else {
            $data['config_image_additional_width'] = $this->config->get('config_image_additional_width');
        }
        
        if (isset($this->request->post['config_image_additional_height'])) {
            $data['config_image_additional_height'] = $this->request->post['config_image_additional_height'];
        } else {
            $data['config_image_additional_height'] = $this->config->get('config_image_additional_height');
        }
        
        if (isset($this->request->post['config_image_related_width'])) {
            $data['config_image_related_width'] = $this->request->post['config_image_related_width'];
        } else {
            $data['config_image_related_width'] = $this->config->get('config_image_related_width');
        }
        
        if (isset($this->request->post['config_image_related_height'])) {
            $data['config_image_related_height'] = $this->request->post['config_image_related_height'];
        } else {
            $data['config_image_related_height'] = $this->config->get('config_image_related_height');
        }
        
        if (isset($this->request->post['config_image_compare_width'])) {
            $data['config_image_compare_width'] = $this->request->post['config_image_compare_width'];
        } else {
            $data['config_image_compare_width'] = $this->config->get('config_image_compare_width');
        }
        
        if (isset($this->request->post['config_image_compare_height'])) {
            $data['config_image_compare_height'] = $this->request->post['config_image_compare_height'];
        } else {
            $data['config_image_compare_height'] = $this->config->get('config_image_compare_height');
        }
        
        if (isset($this->request->post['config_image_wishlist_width'])) {
            $data['config_image_wishlist_width'] = $this->request->post['config_image_wishlist_width'];
        } else {
            $data['config_image_wishlist_width'] = $this->config->get('config_image_wishlist_width');
        }
        
        if (isset($this->request->post['config_image_wishlist_height'])) {
            $data['config_image_wishlist_height'] = $this->request->post['config_image_wishlist_height'];
        } else {
            $data['config_image_wishlist_height'] = $this->config->get('config_image_wishlist_height');
        }
        
        if (isset($this->request->post['config_image_cart_width'])) {
            $data['config_image_cart_width'] = $this->request->post['config_image_cart_width'];
        } else {
            $data['config_image_cart_width'] = $this->config->get('config_image_cart_width');
        }
        
        if (isset($this->request->post['config_image_cart_height'])) {
            $data['config_image_cart_height'] = $this->request->post['config_image_cart_height'];
        } else {
            $data['config_image_cart_height'] = $this->config->get('config_image_cart_height');
        }
        
        if (isset($this->request->post['config_ftp_host'])) {
            $data['config_ftp_host'] = $this->request->post['config_ftp_host'];
        } elseif ($this->config->get('config_ftp_host')) {
            $data['config_ftp_host'] = $this->config->get('config_ftp_host');
        } else {
            $data['config_ftp_host'] = str_replace('www.', '', $this->request->server['HTTP_HOST']);
        }
        
        if (isset($this->request->post['config_ftp_port'])) {
            $data['config_ftp_port'] = $this->request->post['config_ftp_port'];
        } elseif ($this->config->get('config_ftp_port')) {
            $data['config_ftp_port'] = $this->config->get('config_ftp_port');
        } else {
            $data['config_ftp_port'] = 21;
        }
        
        if (isset($this->request->post['config_ftp_username'])) {
            $data['config_ftp_username'] = $this->request->post['config_ftp_username'];
        } else {
            $data['config_ftp_username'] = $this->config->get('config_ftp_username');
        }
        
        if (isset($this->request->post['config_ftp_password'])) {
            $data['config_ftp_password'] = $this->request->post['config_ftp_password'];
        } else {
            $data['config_ftp_password'] = $this->config->get('config_ftp_password');
        }
        
        if (isset($this->request->post['config_ftp_root'])) {
            $data['config_ftp_root'] = $this->request->post['config_ftp_root'];
        } else {
            $data['config_ftp_root'] = $this->config->get('config_ftp_root');
        }
        
        if (isset($this->request->post['config_ftp_status'])) {
            $data['config_ftp_status'] = $this->request->post['config_ftp_status'];
        } else {
            $data['config_ftp_status'] = $this->config->get('config_ftp_status');
        }
        
        if (isset($this->request->post['config_mail_protocol'])) {
            $data['config_mail_protocol'] = $this->request->post['config_mail_protocol'];
        } else {
            $data['config_mail_protocol'] = $this->config->get('config_mail_protocol');
        }
        
        if (isset($this->request->post['config_mail_parameter'])) {
            $data['config_mail_parameter'] = $this->request->post['config_mail_parameter'];
        } else {
            $data['config_mail_parameter'] = $this->config->get('config_mail_parameter');
        }
        
        if (isset($this->request->post['config_smtp_host'])) {
            $data['config_smtp_host'] = $this->request->post['config_smtp_host'];
        } else {
            $data['config_smtp_host'] = $this->config->get('config_smtp_host');
        }
        
        if (isset($this->request->post['config_smtp_username'])) {
            $data['config_smtp_username'] = $this->request->post['config_smtp_username'];
        } else {
            $data['config_smtp_username'] = $this->config->get('config_smtp_username');
        }
        
        if (isset($this->request->post['config_smtp_password'])) {
            $data['config_smtp_password'] = $this->request->post['config_smtp_password'];
        } else {
            $data['config_smtp_password'] = $this->config->get('config_smtp_password');
        }
        
        if (isset($this->request->post['config_smtp_port'])) {
            $data['config_smtp_port'] = $this->request->post['config_smtp_port'];
        } elseif ($this->config->get('config_smtp_port')) {
            $data['config_smtp_port'] = $this->config->get('config_smtp_port');
        } else {
            $data['config_smtp_port'] = 25;
        }
        
        if (isset($this->request->post['config_smtp_timeout'])) {
            $data['config_smtp_timeout'] = $this->request->post['config_smtp_timeout'];
        } elseif ($this->config->get('config_smtp_timeout')) {
            $data['config_smtp_timeout'] = $this->config->get('config_smtp_timeout');
        } else {
            $data['config_smtp_timeout'] = 5;
        }

        $this->theme->model('people/user');

        $users = $this->model_people_user->getUsers();

        $data['users'] = array();

        foreach($users as $user):
            $data['users'][] = array(
                'user_id' => $user['user_id'],
                'name'    => $user['user_name']
            );
        endforeach;

        if (isset($this->request->post['config_admin_email_user'])) {
            $data['config_admin_email_user'] = $this->request->post['config_admin_email_user'];
        } else {
            $data['config_admin_email_user'] = $this->config->get('config_admin_email_user');
        }

        if (isset($this->request->post['config_text_signature'])) {
            $data['config_text_signature'] = $this->request->post['config_text_signature'];
        } else {
            $data['config_text_signature'] = $this->config->get('config_text_signature');
        }

        if (isset($this->request->post['config_html_signature'])) {
            $data['config_html_signature'] = $this->request->post['config_html_signature'];
        } else {
            $data['config_html_signature'] = $this->config->get('config_html_signature');
        }
        
        if (isset($this->request->post['config_mail_twitter'])) {
            $data['config_mail_twitter'] = $this->request->post['config_mail_twitter'];
        } else {
            $data['config_mail_twitter'] = $this->config->get('config_mail_twitter');
        }

        if (isset($this->request->post['config_mail_facebook'])) {
            $data['config_mail_facebook'] = $this->request->post['config_mail_facebook'];
        } else {
            $data['config_mail_facebook'] = $this->config->get('config_mail_facebook');
        }

        if (isset($this->request->post['config_alert_mail'])) {
            $data['config_alert_mail'] = $this->request->post['config_alert_mail'];
        } else {
            $data['config_alert_mail'] = $this->config->get('config_alert_mail');
        }
        
        if (isset($this->request->post['config_account_mail'])) {
            $data['config_account_mail'] = $this->request->post['config_account_mail'];
        } else {
            $data['config_account_mail'] = $this->config->get('config_account_mail');
        }
        
        if (isset($this->request->post['config_alert_emails'])) {
            $data['config_alert_emails'] = $this->request->post['config_alert_emails'];
        } else {
            $data['config_alert_emails'] = $this->config->get('config_alert_emails');
        }
        
        if (isset($this->request->post['config_fraud_detection'])) {
            $data['config_fraud_detection'] = $this->request->post['config_fraud_detection'];
        } else {
            $data['config_fraud_detection'] = $this->config->get('config_fraud_detection');
        }
        
        if (isset($this->request->post['config_fraud_key'])) {
            $data['config_fraud_key'] = $this->request->post['config_fraud_key'];
        } else {
            $data['config_fraud_key'] = $this->config->get('config_fraud_key');
        }
        
        if (isset($this->request->post['config_fraud_score'])) {
            $data['config_fraud_score'] = $this->request->post['config_fraud_score'];
        } else {
            $data['config_fraud_score'] = $this->config->get('config_fraud_score');
        }
        
        if (isset($this->request->post['config_fraud_status_id'])) {
            $data['config_fraud_status_id'] = $this->request->post['config_fraud_status_id'];
        } else {
            $data['config_fraud_status_id'] = $this->config->get('config_fraud_status_id');
        }
        
        if (isset($this->request->post['config_secure'])) {
            $data['config_secure'] = $this->request->post['config_secure'];
        } else {
            $data['config_secure'] = $this->config->get('config_secure');
        }
        
        if (isset($this->request->post['config_shared'])) {
            $data['config_shared'] = $this->request->post['config_shared'];
        } else {
            $data['config_shared'] = $this->config->get('config_shared');
        }
        
        if (isset($this->request->post['config_top_level'])) {
            $data['config_top_level'] = $this->request->post['config_top_level'];
        } else {
            $data['config_top_level'] = $this->config->get('config_top_level');
        }
        
        if (isset($this->request->post['config_ucfirst'])) {
            $data['config_ucfirst'] = $this->request->post['config_ucfirst'];
        } else {
            $data['config_ucfirst'] = $this->config->get('config_ucfirst');
        }
        
        if (isset($this->request->post['config_robots'])) {
            $data['config_robots'] = $this->request->post['config_robots'];
        } else {
            $data['config_robots'] = $this->config->get('config_robots');
        }
        
        if (isset($this->request->post['config_file_extension_allowed'])) {
            $data['config_file_extension_allowed'] = $this->request->post['config_file_extension_allowed'];
        } else {
            $data['config_file_extension_allowed'] = $this->config->get('config_file_extension_allowed');
        }
        
        if (isset($this->request->post['config_file_mime_allowed'])) {
            $data['config_file_mime_allowed'] = $this->request->post['config_file_mime_allowed'];
        } else {
            $data['config_file_mime_allowed'] = $this->config->get('config_file_mime_allowed');
        }
        
        if (isset($this->request->post['config_maintenance'])) {
            $data['config_maintenance'] = $this->request->post['config_maintenance'];
        } else {
            $data['config_maintenance'] = $this->config->get('config_maintenance');
        }
        
        if (isset($this->request->post['config_password'])) {
            $data['config_password'] = $this->request->post['config_password'];
        } else {
            $data['config_password'] = $this->config->get('config_password');
        }
        
        if (isset($this->request->post['config_encryption'])) {
            $data['config_encryption'] = $this->request->post['config_encryption'];
        } else {
            $data['config_encryption'] = $this->config->get('config_encryption');
        }
        
        if (isset($this->request->post['config_compression'])) {
            $data['config_compression'] = $this->request->post['config_compression'];
        } else {
            $data['config_compression'] = $this->config->get('config_compression');
        }
        
        if (isset($this->request->post['config_error_display'])) {
            $data['config_error_display'] = $this->request->post['config_error_display'];
        } else {
            $data['config_error_display'] = $this->config->get('config_error_display');
        }
        
        if (isset($this->request->post['config_error_log'])) {
            $data['config_error_log'] = $this->request->post['config_error_log'];
        } else {
            $data['config_error_log'] = $this->config->get('config_error_log');
        }
        
        if (isset($this->request->post['config_error_filename'])) {
            $data['config_error_filename'] = $this->request->post['config_error_filename'];
        } else {
            $data['config_error_filename'] = $this->config->get('config_error_filename');
        }
        
        if (isset($this->request->post['config_google_analytics'])) {
            $data['config_google_analytics'] = $this->request->post['config_google_analytics'];
        } else {
            $data['config_google_analytics'] = $this->config->get('config_google_analytics');
        }
        
        if (isset($this->request->post['config_cache_type_id'])) {
            $data['config_cache_type_id'] = $this->request->post['config_cache_type_id'];
        } else {
            $data['config_cache_type_id'] = $this->config->get('config_cache_type_id');
        }
        
        if (isset($this->request->post['config_cache_status'])) {
            $data['config_cache_status'] = $this->request->post['config_cache_status'];
        } else {
            $data['config_cache_status'] = $this->config->get('config_cache_status');
        }
        
        $data['cache_types'] = array();
        
        $caches = array();
        
        $caches[] = array('cache_type_id' => 'file', 'name' => 'File');
        
        if (extension_loaded('apc') && phpversion() < '5.5'):
            $caches[] = array('cache_type_id' => 'apc', 'name' => 'APC');
        endif;
        
        if (extension_loaded('memcache')):
            $test = new Mem($this->get('cache.time'), $this->app);
            if ($test->check()):
                $caches[] = array('cache_type_id' => 'mem', 'name' => 'Memcached');
            endif;
        endif;
        
        $data['cache_types'] = $caches;
        
        $this->theme->loadjs('javascript/setting/setting', $data);
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('setting/setting', $data));
    }
    
    protected function validate() {
        if (!$this->user->hasPermission('modify', 'setting/setting')) {
            $this->error['warning'] = $this->language->get('lang_error_permission');
        }
        
        if (!$this->request->post['config_name']) {
            $this->error['name'] = $this->language->get('lang_error_name');
        }
        
        if (($this->encode->strlen($this->request->post['config_owner']) < 3) || ($this->encode->strlen($this->request->post['config_owner']) > 64)) {
            $this->error['owner'] = $this->language->get('lang_error_owner');
        }
        
        if (($this->encode->strlen($this->request->post['config_address']) < 3) || ($this->encode->strlen($this->request->post['config_address']) > 256)) {
            $this->error['address'] = $this->language->get('lang_error_address');
        }
        
        if (($this->encode->strlen($this->request->post['config_email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['config_email'])) {
            $this->error['email'] = $this->language->get('lang_error_email');
        }
        
        if (($this->encode->strlen($this->request->post['config_telephone']) < 3) || ($this->encode->strlen($this->request->post['config_telephone']) > 32)) {
            $this->error['telephone'] = $this->language->get('lang_error_telephone');
        }
        
        if (!$this->request->post['config_title']) {
            $this->error['title'] = $this->language->get('lang_error_title');
        }

        if (!$this->request->post['config_admin_email_user'] || $this->request->post['config_admin_email_user'] < 1) {
            $this->error['admin_email_user'] = $this->language->get('lang_error_admin_email_user');
        }

        if (!$this->request->post['config_text_signature'] || $this->encode->strlen($this->request->post['config_text_signature']) < 1) {
            $this->error['text_signature'] = $this->language->get('lang_error_text_signature');
        }

        if (!$this->request->post['config_html_signature'] || $this->encode->strlen($this->request->post['config_html_signature']) < 1) {
            $this->error['html_signature'] = $this->language->get('lang_error_html_signature');
        }

        // Affiliate settings
        // If allowing affiliates, params for them must be supplied.
        if ($this->request->post['config_affiliate_allowed']):
            if (!$this->request->post['config_affiliate_terms']):
                $this->error['affiliate_terms'] = $this->language->get('lang_error_affiliate_terms');
            endif;

            if ($this->encode->strlen($this->request->post['config_commission']) < 1):
                $this->error['commission'] = $this->language->get('lang_error_affiliate_commission');
            endif;
        endif;
        
        if (!empty($this->request->post['config_customer_group_display']) && !in_array($this->request->post['config_customer_group_id'], $this->request->post['config_customer_group_display'])) {
            $this->error['customer_group_display'] = $this->language->get('lang_error_customer_group_display');
        }
        
        if (!$this->request->post['config_giftcard_min']) {
            $this->error['giftcard_min'] = $this->language->get('lang_error_giftcard_min');
        }
        
        if (!$this->request->post['config_giftcard_max']) {
            $this->error['giftcard_max'] = $this->language->get('lang_error_giftcard_max');
        }
        
        if (!$this->request->post['config_image_category_width'] || !$this->request->post['config_image_category_height']) {
            $this->error['image_category'] = $this->language->get('lang_error_image_category');
        }
        
        if (!$this->request->post['config_image_thumb_width'] || !$this->request->post['config_image_thumb_height']) {
            $this->error['image_thumb'] = $this->language->get('lang_error_image_thumb');
        }
        
        if (!$this->request->post['config_image_popup_width'] || !$this->request->post['config_image_popup_height']) {
            $this->error['image_popup'] = $this->language->get('lang_error_image_popup');
        }
        
        if (!$this->request->post['config_image_product_width'] || !$this->request->post['config_image_product_height']) {
            $this->error['image_product'] = $this->language->get('lang_error_image_product');
        }
        
        if (!$this->request->post['config_image_additional_width'] || !$this->request->post['config_image_additional_height']) {
            $this->error['image_additional'] = $this->language->get('lang_error_image_additional');
        }
        
        if (!$this->request->post['config_image_related_width'] || !$this->request->post['config_image_related_height']) {
            $this->error['image_related'] = $this->language->get('lang_error_image_related');
        }
        
        if (!$this->request->post['config_image_compare_width'] || !$this->request->post['config_image_compare_height']) {
            $this->error['image_compare'] = $this->language->get('lang_error_image_compare');
        }
        
        if (!$this->request->post['config_image_wishlist_width'] || !$this->request->post['config_image_wishlist_height']) {
            $this->error['image_wishlist'] = $this->language->get('lang_error_image_wishlist');
        }
        
        if (!$this->request->post['config_image_cart_width'] || !$this->request->post['config_image_cart_height']) {
            $this->error['image_cart'] = $this->language->get('lang_error_image_cart');
        }
        
        if ($this->request->post['config_ftp_status']) {
            if (!$this->request->post['config_ftp_host']) {
                $this->error['ftp_host'] = $this->language->get('lang_error_ftp_host');
            }
            
            if (!$this->request->post['config_ftp_port']) {
                $this->error['ftp_port'] = $this->language->get('lang_error_ftp_port');
            }
            
            if (!$this->request->post['config_ftp_username']) {
                $this->error['ftp_username'] = $this->language->get('lang_error_ftp_username');
            }
            
            if (!$this->request->post['config_ftp_password']) {
                $this->error['ftp_password'] = $this->language->get('lang_error_ftp_password');
            }
        }
        
        if (!$this->request->post['config_error_filename']) {
            $this->error['error_filename'] = $this->language->get('lang_error_error_filename');
        }
        
        if (!$this->request->post['config_catalog_limit']) {
            $this->error['catalog_limit'] = $this->language->get('lang_error_limit');
        }
        
        if (!$this->request->post['config_admin_limit']) {
            $this->error['admin_limit'] = $this->language->get('lang_error_limit');
        }
        
        if (($this->encode->strlen($this->request->post['config_encryption']) < 3) || ($this->encode->strlen($this->request->post['config_encryption']) > 32)) {
            $this->error['encryption'] = $this->language->get('lang_error_encryption');
        }
        
        if (!$this->request->post['config_default_visibility']):
            $this->error['default_visibility'] = $this->language->get('lang_error_default_visibility');
        endif;
        
        if (!$this->request->post['config_free_customer']):
            $this->error['free_customer'] = $this->language->get('lang_error_free_customer');
        endif;
        
        if (!$this->request->post['config_top_customer']):
            $this->error['top_customer'] = $this->language->get('lang_error_top_customer');
        endif;

        if (!$this->request->post['blog_image_thumb_width'] || !$this->request->post['blog_image_thumb_height']) {
            $this->error['blog_image_thumb'] = $this->language->get('lang_error_blog_image_thumb');
        }
        
        if (!$this->request->post['blog_image_popup_width'] || !$this->request->post['blog_image_popup_height']) {
            $this->error['blog_image_popup'] = $this->language->get('lang_error_blog_image_popup');
        }
        
        if (!$this->request->post['blog_image_post_width'] || !$this->request->post['blog_image_post_height']) {
            $this->error['blog_image_post'] = $this->language->get('lang_error_blog_image_post');
        }
        
        if (!$this->request->post['blog_image_additional_width'] || !$this->request->post['blog_image_additional_height']) {
            $this->error['blog_image_additional'] = $this->language->get('lang_error_blog_image_additional');
        }
        
        if (!$this->request->post['blog_image_related_width'] || !$this->request->post['blog_image_related_height']) {
            $this->error['blog_image_related'] = $this->language->get('lang_error_blog_image_related');
        }
        
        if (!$this->request->post['blog_posted_by']) {
            $this->error['blog_posted_by'] = $this->language->get('lang_error_blog_posted_by');
        }
        
        if (!$this->request->post['blog_admin_group_id']) {
            $this->error['blog_admin_group_id'] = $this->language->get('lang_error_blog_admin_group_id');
        }
        
        if ($this->error && !isset($this->error['warning'])) {
            $this->error['warning'] = $this->language->get('lang_error_warning');
        }
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    public function autocomplete() {
        $json = array();
        
        if (isset($this->request->get['filter_username']) || isset($this->request->get['filter_name'])) {
            $this->theme->model('people/customer');
            
            $filter_username = (isset($this->request->get['filter_username'])) ? $this->request->get['filter_username'] : null;
            $filter_name = (isset($this->request->get['filter_name'])) ? $this->request->get['filter_name'] : null;
            
            $filter = array('filter_username' => $filter_username, 'filter_name' => $filter_name, 'filter_customer_group_id' => $this->config->get('config_top_customer'), 'filter_status' => 1, 'start' => 0, 'limit' => 20);
            
            $results = $this->model_people_customer->getCustomers($filter);
            
            foreach ($results as $result) {
                $json[] = array('customer_id' => $result['customer_id'], 'username' => $result['username'], 'name' => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')));
            }
        }
        
        $sort_order = array();
        
        foreach ($json as $key => $value) {
            $sort_order[$key] = $value;
        }
        
        array_multisort($sort_order, SORT_ASC, $json);
        
        $json = $this->theme->listen(__CLASS__, __FUNCTION__, $json);
        
        $this->response->setOutput(json_encode($json));
    }
    
    public function theme() {
        if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
            $server = $this->get('https.public');
        } else {
            $server = $this->get('http.public');
        }
        
        if (file_exists($this->get('path.image') . 'themes/front/' . basename($this->request->get['theme']) . '.png')) {
            $image = $server . 'image/themes/front/' . basename($this->request->get['theme']) . '.png';
        } else {
            $image = $server . 'image/placeholder.png';
        }
        
        $this->response->setOutput('<img src="' . $image . '" alt="" title="" style="border: 1px solid #EEEEEE;" />');
    }
    
    public function admin_theme() {
        if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
            $server = $this->get('https.public');
        } else {
            $server = $this->get('http.public');
        }
        
        if (file_exists($this->get('path.image') . 'themes/admin/' . basename($this->request->get['theme']) . '.png')) {
            $image = $server . 'image/themes/admin/' . basename($this->request->get['theme']) . '.png';
        } else {
            $image = $server . 'image/placeholder.png';
        }
        
        $this->response->setOutput('<img src="' . $image . '" alt="" title="" style="border: 1px solid #EEEEEE;" />');
    }
    
    public function country() {
        $json = array();
        
        $this->theme->model('localization/country');
        
        $country_info = $this->model_localization_country->getCountry($this->request->get['country_id']);
        
        if ($country_info) {
            $this->theme->model('localization/zone');
            
            $json = array('country_id' => $country_info['country_id'], 'name' => $country_info['name'], 'iso_code_2' => $country_info['iso_code_2'], 'iso_code_3' => $country_info['iso_code_3'], 'address_format' => $country_info['address_format'], 'postcode_required' => $country_info['postcode_required'], 'zone' => $this->model_localization_zone->getZonesByCountryId($this->request->get['country_id']), 'status' => $country_info['status']);
        }
        
        $json = $this->theme->listen(__CLASS__, __FUNCTION__, $json);
        
        $this->response->setOutput(json_encode($json));
    }
    
    public function flush() {
        $this->language->load('setting/setting');
        
        $this->cache->flush_cache();
        $this->filecache->flush_cache();
        
        $this->session->data['success'] = $this->language->get('lang_text_flush_success');
        
        $this->response->redirect($this->url->link('setting/setting', 'token=' . $this->session->data['token']));
    }
}
