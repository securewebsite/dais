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

class Store extends Controller {
    private $error = array();
    
    public function index() {
        Lang::load('setting/store');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('setting/store');
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    public function insert() {
        Lang::load('setting/store');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('setting/store');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $store_id = $this->model_setting_store->addStore($this->request->post);
            
            Theme::model('setting/setting');
            $this->model_setting_setting->editSetting('config', $this->request->post, $store_id);
            $this->session->data['success'] = Lang::get('lang_text_success');
            
            Response::redirect(Url::link('setting/store', 'token=' . $this->session->data['token'], 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function update() {
        Lang::load('setting/store');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('setting/store');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_setting_store->editStore($this->request->get['store_id'], $this->request->post);
            
            Theme::model('setting/setting');
            $this->model_setting_setting->editSetting('config', $this->request->post, $this->request->get['store_id']);
            $this->session->data['success'] = Lang::get('lang_text_success');
            
            Response::redirect(Url::link('setting/store', 'token=' . $this->session->data['token'] . '&store_id=' . $this->request->get['store_id'], 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getForm();
    }
    
    public function delete() {
        Lang::load('setting/store');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('setting/store');
        Theme::model('setting/setting');
        
        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $store_id) {
                $this->model_setting_store->deleteStore($store_id);
                $this->model_setting_setting->deleteSetting('config', $store_id);
            }
            
            $this->session->data['success'] = Lang::get('lang_text_success');
            
            Response::redirect(Url::link('setting/store', 'token=' . $this->session->data['token'], 'SSL'));
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $this->getList();
    }
    
    protected function getList() {
        $data = Theme::language('setting/store');
        
        $url = '';
        
        if (isset($this->request->get['page'])) {
            $url.= '&page=' . $this->request->get['page'];
        }
        
        Breadcrumb::add('lang_heading_title', 'setting/store');
        
        $data['insert'] = Url::link('setting/store/insert', 'token=' . $this->session->data['token'], 'SSL');
        $data['delete'] = Url::link('setting/store/delete', 'token=' . $this->session->data['token'], 'SSL');
        
        $data['stores'] = array();
        
        $action = array();
        
        $action[] = array('text' => Lang::get('lang_text_edit'), 'href' => Url::link('setting/setting', 'token=' . $this->session->data['token'], 'SSL'));
        
        $data['stores'][] = array('store_id' => 0, 'name' => Config::get('config_name') . Lang::get('lang_text_default'), 'url' => Config::get('http.public'), 'selected' => isset($this->request->post['selected']) && in_array(0, $this->request->post['selected']), 'action' => $action);
        
        $results = $this->model_setting_store->getStores();
        
        foreach ($results as $result) {
            $action = array();
            
            $action[] = array('text' => Lang::get('lang_text_edit'), 'href' => Url::link('setting/store/update', 'token=' . $this->session->data['token'] . '&store_id=' . $result['store_id'], 'SSL'));
            
            $data['stores'][] = array('store_id' => $result['store_id'], 'name' => $result['name'], 'url' => $result['url'], 'selected' => isset($this->request->post['selected']) && in_array($result['store_id'], $this->request->post['selected']), 'action' => $action);
        }
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];
            
            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::render_controllers($data);
        
        Response::setOutput(Theme::view('setting/store_list', $data));
    }
    
    public function getForm() {
        $data = Theme::language('setting/store');;
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        if (isset($this->error['url'])) {
            $data['error_url'] = $this->error['url'];
        } else {
            $data['error_url'] = '';
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
        
        if (isset($this->error['catalog_limit'])) {
            $data['error_catalog_limit'] = $this->error['catalog_limit'];
        } else {
            $data['error_catalog_limit'] = '';
        }
        
        Breadcrumb::add('lang_heading_title', 'setting/store');
        
        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];
            
            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }
        
        if (!isset($this->request->get['store_id'])) {
            $data['action'] = Url::link('setting/store/insert', 'token=' . $this->session->data['token'], 'SSL');
        } else {
            $data['action'] = Url::link('setting/store/update', 'token=' . $this->session->data['token'] . '&store_id=' . $this->request->get['store_id'], 'SSL');
        }
        
        $data['cancel'] = Url::link('setting/store', 'token=' . $this->session->data['token'], 'SSL');
        
        if (isset($this->request->get['store_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            Theme::model('setting/setting');
            
            $store_info = $this->model_setting_setting->getSetting('config', $this->request->get['store_id']);
        }
        
        $data['token'] = $this->session->data['token'];
        
        if (isset($this->request->post['config_url'])) {
            $data['config_url'] = $this->request->post['config_url'];
        } elseif (isset($store_info['config_url'])) {
            $data['config_url'] = $store_info['config_url'];
        } else {
            $data['config_url'] = '';
        }
        
        if (isset($this->request->post['config_ssl'])) {
            $data['config_ssl'] = $this->request->post['config_ssl'];
        } elseif (isset($store_info['config_ssl'])) {
            $data['config_ssl'] = $store_info['config_ssl'];
        } else {
            $data['config_ssl'] = '';
        }
        
        if (isset($this->request->post['config_name'])) {
            $data['config_name'] = $this->request->post['config_name'];
        } elseif (isset($store_info['config_name'])) {
            $data['config_name'] = $store_info['config_name'];
        } else {
            $data['config_name'] = '';
        }
        
        if (isset($this->request->post['config_owner'])) {
            $data['config_owner'] = $this->request->post['config_owner'];
        } elseif (isset($store_info['config_owner'])) {
            $data['config_owner'] = $store_info['config_owner'];
        } else {
            $data['config_owner'] = '';
        }
        
        if (isset($this->request->post['config_address'])) {
            $data['config_address'] = $this->request->post['config_address'];
        } elseif (isset($store_info['config_address'])) {
            $data['config_address'] = $store_info['config_address'];
        } else {
            $data['config_address'] = '';
        }
        
        if (isset($this->request->post['config_email'])) {
            $data['config_email'] = $this->request->post['config_email'];
        } elseif (isset($store_info['config_email'])) {
            $data['config_email'] = $store_info['config_email'];
        } else {
            $data['config_email'] = '';
        }
        
        if (isset($this->request->post['config_telephone'])) {
            $data['config_telephone'] = $this->request->post['config_telephone'];
        } elseif (isset($store_info['config_telephone'])) {
            $data['config_telephone'] = $store_info['config_telephone'];
        } else {
            $data['config_telephone'] = '';
        }
        
        if (isset($this->request->post['config_title'])) {
            $data['config_title'] = $this->request->post['config_title'];
        } elseif (isset($store_info['config_title'])) {
            $data['config_title'] = $store_info['config_title'];
        } else {
            $data['config_title'] = '';
        }
        
        if (isset($this->request->post['config_meta_description'])) {
            $data['config_meta_description'] = $this->request->post['config_meta_description'];
        } elseif (isset($store_info['config_meta_description'])) {
            $data['config_meta_description'] = $store_info['config_meta_description'];
        } else {
            $data['config_meta_description'] = '';
        }
        
        if (isset($this->request->post['config_layout_id'])) {
            $data['config_layout_id'] = $this->request->post['config_layout_id'];
        } elseif (isset($store_info['config_layout_id'])) {
            $data['config_layout_id'] = $store_info['config_layout_id'];
        } else {
            $data['config_layout_id'] = '';
        }
        
        Theme::model('design/layout');
        
        $data['layouts'] = $this->model_design_layout->getLayouts();
        
        if (isset($this->request->post['config_theme'])) {
            $data['config_theme'] = $this->request->post['config_theme'];
        } elseif (isset($store_info['config_theme'])) {
            $data['config_theme'] = $store_info['config_theme'];
        } else {
            $data['config_theme'] = '';
        }
        
        $data['themes'] = array();
        
        $directories = glob(Config::get('path.theme') . 'catalog/*', GLOB_ONLYDIR);
        
        foreach ($directories as $directory) {
            $data['themes'][] = basename($directory);
        }
        
        if (isset($this->request->post['config_country_id'])) {
            $data['config_country_id'] = $this->request->post['config_country_id'];
        } elseif (isset($store_info['config_country_id'])) {
            $data['config_country_id'] = $store_info['config_country_id'];
        } else {
            $data['config_country_id'] = Config::get('config_country_id');
        }
        
        Theme::model('locale/country');
        
        $data['countries'] = $this->model_locale_country->getCountries();
        
        if (isset($this->request->post['config_zone_id'])) {
            $data['config_zone_id'] = $this->request->post['config_zone_id'];
        } elseif (isset($store_info['config_zone_id'])) {
            $data['config_zone_id'] = $store_info['config_zone_id'];
        } else {
            $data['config_zone_id'] = Config::get('config_zone_id');
        }
        
        if (isset($this->request->post['config_language'])) {
            $data['config_language'] = $this->request->post['config_language'];
        } elseif (isset($store_info['config_language'])) {
            $data['config_language'] = $store_info['config_language'];
        } else {
            $data['config_language'] = Config::get('config_language');
        }
        
        Theme::model('locale/language');
        
        $data['languages'] = $this->model_locale_language->getLanguages();
        
        if (isset($this->request->post['config_currency'])) {
            $data['config_currency'] = $this->request->post['config_currency'];
        } elseif (isset($store_info['config_currency'])) {
            $data['config_currency'] = $store_info['config_currency'];
        } else {
            $data['config_currency'] = Config::get('config_currency');
        }
        
        Theme::model('locale/currency');
        
        $data['currencies'] = $this->model_locale_currency->getCurrencies();
        
        if (isset($this->request->post['config_catalog_limit'])) {
            $data['config_catalog_limit'] = $this->request->post['config_catalog_limit'];
        } elseif (isset($store_info['config_catalog_limit'])) {
            $data['config_catalog_limit'] = $store_info['config_catalog_limit'];
        } else {
            $data['config_catalog_limit'] = '12';
        }
        
        if (isset($this->request->post['config_tax'])) {
            $data['config_tax'] = $this->request->post['config_tax'];
        } elseif (isset($store_info['config_tax'])) {
            $data['config_tax'] = $store_info['config_tax'];
        } else {
            $data['config_tax'] = '';
        }
        
        if (isset($this->request->post['config_tax_default'])) {
            $data['config_tax_default'] = $this->request->post['config_tax_default'];
        } elseif (isset($store_info['config_tax_default'])) {
            $data['config_tax_default'] = $store_info['config_tax_default'];
        } else {
            $data['config_tax_default'] = '';
        }
        
        if (isset($this->request->post['config_tax_customer'])) {
            $data['config_tax_customer'] = $this->request->post['config_tax_customer'];
        } elseif (isset($store_info['config_tax_customer'])) {
            $data['config_tax_customer'] = $store_info['config_tax_customer'];
        } else {
            $data['config_tax_customer'] = '';
        }
        
        if (isset($this->request->post['config_customer_group_id'])) {
            $data['config_customer_group_id'] = $this->request->post['config_customer_group_id'];
        } elseif (isset($store_info['config_customer_group_id'])) {
            $data['config_customer_group_id'] = $store_info['config_customer_group_id'];
        } else {
            $data['config_customer_group_id'] = '';
        }
        
        Theme::model('people/customer_group');
        
        $data['customer_groups'] = $this->model_people_customer_group->getCustomerGroups();
        
        if (isset($this->request->post['config_customer_group_display'])) {
            $data['config_customer_group_display'] = $this->request->post['config_customer_group_display'];
        } elseif (isset($store_info['config_customer_group_display'])) {
            $data['config_customer_group_display'] = $store_info['config_customer_group_display'];
        } else {
            $data['config_customer_group_display'] = array();
        }
        
        if (isset($this->request->post['config_customer_price'])) {
            $data['config_customer_price'] = $this->request->post['config_customer_price'];
        } elseif (isset($store_info['config_customer_price'])) {
            $data['config_customer_price'] = $store_info['config_customer_price'];
        } else {
            $data['config_customer_price'] = '';
        }
        
        if (isset($this->request->post['config_account_id'])) {
            $data['config_account_id'] = $this->request->post['config_account_id'];
        } elseif (isset($store_info['config_account_id'])) {
            $data['config_account_id'] = $store_info['config_account_id'];
        } else {
            $data['config_account_id'] = '';
        }
        
        Theme::model('content/page');
        
        $data['pages'] = $this->model_content_page->getPages();
        
        if (isset($this->request->post['config_cart_weight'])) {
            $data['config_cart_weight'] = $this->request->post['config_cart_weight'];
        } elseif (isset($store_info['config_cart_weight'])) {
            $data['config_cart_weight'] = $store_info['config_cart_weight'];
        } else {
            $data['config_cart_weight'] = '';
        }
        
        if (isset($this->request->post['config_guest_checkout'])) {
            $data['config_guest_checkout'] = $this->request->post['config_guest_checkout'];
        } elseif (isset($store_info['config_guest_checkout'])) {
            $data['config_guest_checkout'] = $store_info['config_guest_checkout'];
        } else {
            $data['config_guest_checkout'] = '';
        }
        
        if (isset($this->request->post['config_checkout_id'])) {
            $data['config_checkout_id'] = $this->request->post['config_checkout_id'];
        } elseif (isset($store_info['config_checkout_id'])) {
            $data['config_checkout_id'] = $store_info['config_checkout_id'];
        } else {
            $data['config_checkout_id'] = '';
        }
        
        if (isset($this->request->post['config_order_status_id'])) {
            $data['config_order_status_id'] = $this->request->post['config_order_status_id'];
        } elseif (isset($store_info['config_order_status_id'])) {
            $data['config_order_status_id'] = $store_info['config_order_status_id'];
        } else {
            $data['config_order_status_id'] = '';
        }
        
        Theme::model('locale/order_status');
        
        $data['order_statuses'] = $this->model_locale_order_status->getOrderStatuses();
        
        if (isset($this->request->post['config_stock_display'])) {
            $data['config_stock_display'] = $this->request->post['config_stock_display'];
        } elseif (isset($store_info['config_stock_display'])) {
            $data['config_stock_display'] = $store_info['config_stock_display'];
        } else {
            $data['config_stock_display'] = '';
        }
        
        if (isset($this->request->post['config_stock_checkout'])) {
            $data['config_stock_checkout'] = $this->request->post['config_stock_checkout'];
        } elseif (isset($store_info['config_stock_checkout'])) {
            $data['config_stock_checkout'] = $store_info['config_stock_checkout'];
        } else {
            $data['config_stock_checkout'] = '';
        }
        
        Theme::model('tool/image');
        
        if (isset($this->request->post['config_logo'])) {
            $data['config_logo'] = $this->request->post['config_logo'];
        } elseif (isset($store_info['config_logo'])) {
            $data['config_logo'] = $store_info['config_logo'];
        } else {
            $data['config_logo'] = '';
        }
        
        if (isset($store_info['config_logo']) && file_exists(Config::get('path.image') . $store_info['config_logo']) && is_file(Config::get('path.image') . $store_info['config_logo'])) {
            $data['logo'] = $this->model_tool_image->resize($store_info['config_logo'], 100, 100);
        } else {
            $data['logo'] = $this->model_tool_image->resize('placeholder.png', 100, 100);
        }
        
        if (isset($this->request->post['config_icon'])) {
            $data['config_icon'] = $this->request->post['config_icon'];
        } elseif (isset($store_info['config_icon'])) {
            $data['config_icon'] = $store_info['config_icon'];
        } else {
            $data['config_icon'] = '';
        }
        
        if (isset($store_info['config_icon']) && file_exists(Config::get('path.image') . $store_info['config_icon']) && is_file(Config::get('path.image') . $store_info['config_icon'])) {
            $data['icon'] = $this->model_tool_image->resize($store_info['config_icon'], 100, 100);
        } else {
            $data['icon'] = $this->model_tool_image->resize('placeholder.png', 100, 100);
        }
        
        $data['no_image'] = $this->model_tool_image->resize('placeholder.png', 100, 100);
        
        if (isset($this->request->post['config_image_category_height'])) {
            $data['config_image_category_height'] = $this->request->post['config_image_category_height'];
        } elseif (isset($store_info['config_image_category_height'])) {
            $data['config_image_category_height'] = $store_info['config_image_category_height'];
        } else {
            $data['config_image_category_height'] = 80;
        }
        
        if (isset($this->request->post['config_image_thumb_width'])) {
            $data['config_image_thumb_width'] = $this->request->post['config_image_thumb_width'];
        } elseif (isset($store_info['config_image_thumb_width'])) {
            $data['config_image_thumb_width'] = $store_info['config_image_thumb_width'];
        } else {
            $data['config_image_thumb_width'] = 228;
        }
        
        if (isset($this->request->post['config_image_thumb_height'])) {
            $data['config_image_thumb_height'] = $this->request->post['config_image_thumb_height'];
        } elseif (isset($store_info['config_image_thumb_height'])) {
            $data['config_image_thumb_height'] = $store_info['config_image_thumb_height'];
        } else {
            $data['config_image_thumb_height'] = 228;
        }
        
        if (isset($this->request->post['config_image_popup_width'])) {
            $data['config_image_popup_width'] = $this->request->post['config_image_popup_width'];
        } elseif (isset($store_info['config_image_popup_width'])) {
            $data['config_image_popup_width'] = $store_info['config_image_popup_width'];
        } else {
            $data['config_image_popup_width'] = 500;
        }
        
        if (isset($this->request->post['config_image_popup_height'])) {
            $data['config_image_popup_height'] = $this->request->post['config_image_popup_height'];
        } elseif (isset($store_info['config_image_popup_height'])) {
            $data['config_image_popup_height'] = $store_info['config_image_popup_height'];
        } else {
            $data['config_image_popup_height'] = 500;
        }
        
        if (isset($this->request->post['config_image_product_width'])) {
            $data['config_image_product_width'] = $this->request->post['config_image_product_width'];
        } elseif (isset($store_info['config_image_product_width'])) {
            $data['config_image_product_width'] = $store_info['config_image_product_width'];
        } else {
            $data['config_image_product_width'] = 80;
        }
        
        if (isset($this->request->post['config_image_product_height'])) {
            $data['config_image_product_height'] = $this->request->post['config_image_product_height'];
        } elseif (isset($store_info['config_image_product_height'])) {
            $data['config_image_product_height'] = $store_info['config_image_product_height'];
        } else {
            $data['config_image_product_height'] = 80;
        }
        
        if (isset($this->request->post['config_image_category_width'])) {
            $data['config_image_category_width'] = $this->request->post['config_image_category_width'];
        } elseif (isset($store_info['config_image_category_width'])) {
            $data['config_image_category_width'] = $store_info['config_image_category_width'];
        } else {
            $data['config_image_category_width'] = 80;
        }
        
        if (isset($this->request->post['config_image_additional_width'])) {
            $data['config_image_additional_width'] = $this->request->post['config_image_additional_width'];
        } elseif (isset($store_info['config_image_additional_width'])) {
            $data['config_image_additional_width'] = $store_info['config_image_additional_width'];
        } else {
            $data['config_image_additional_width'] = 74;
        }
        
        if (isset($this->request->post['config_image_additional_height'])) {
            $data['config_image_additional_height'] = $this->request->post['config_image_additional_height'];
        } elseif (isset($store_info['config_image_additional_height'])) {
            $data['config_image_additional_height'] = $store_info['config_image_additional_height'];
        } else {
            $data['config_image_additional_height'] = 74;
        }
        
        if (isset($this->request->post['config_image_related_width'])) {
            $data['config_image_related_width'] = $this->request->post['config_image_related_width'];
        } elseif (isset($store_info['config_image_related_width'])) {
            $data['config_image_related_width'] = $store_info['config_image_related_width'];
        } else {
            $data['config_image_related_width'] = 80;
        }
        
        if (isset($this->request->post['config_image_related_height'])) {
            $data['config_image_related_height'] = $this->request->post['config_image_related_height'];
        } elseif (isset($store_info['config_image_related_height'])) {
            $data['config_image_related_height'] = $store_info['config_image_related_height'];
        } else {
            $data['config_image_related_height'] = 80;
        }
        
        if (isset($this->request->post['config_image_compare_width'])) {
            $data['config_image_compare_width'] = $this->request->post['config_image_compare_width'];
        } elseif (isset($store_info['config_image_compare_width'])) {
            $data['config_image_compare_width'] = $store_info['config_image_compare_width'];
        } else {
            $data['config_image_compare_width'] = 90;
        }
        
        if (isset($this->request->post['config_image_compare_height'])) {
            $data['config_image_compare_height'] = $this->request->post['config_image_compare_height'];
        } elseif (isset($store_info['config_image_compare_height'])) {
            $data['config_image_compare_height'] = $store_info['config_image_compare_height'];
        } else {
            $data['config_image_compare_height'] = 90;
        }
        
        if (isset($this->request->post['config_image_wishlist_width'])) {
            $data['config_image_wishlist_width'] = $this->request->post['config_image_wishlist_width'];
        } elseif (isset($store_info['config_image_wishlist_width'])) {
            $data['config_image_wishlist_width'] = $store_info['config_image_wishlist_width'];
        } else {
            $data['config_image_wishlist_width'] = 50;
        }
        
        if (isset($this->request->post['config_image_wishlist_height'])) {
            $data['config_image_wishlist_height'] = $this->request->post['config_image_wishlist_height'];
        } elseif (isset($store_info['config_image_wishlist_height'])) {
            $data['config_image_wishlist_height'] = $store_info['config_image_wishlist_height'];
        } else {
            $data['config_image_wishlist_height'] = 50;
        }
        
        if (isset($this->request->post['config_image_cart_width'])) {
            $data['config_image_cart_width'] = $this->request->post['config_image_cart_width'];
        } elseif (isset($store_info['config_image_cart_width'])) {
            $data['config_image_cart_width'] = $store_info['config_image_cart_width'];
        } else {
            $data['config_image_cart_width'] = 80;
        }
        
        if (isset($this->request->post['config_image_cart_height'])) {
            $data['config_image_cart_height'] = $this->request->post['config_image_cart_height'];
        } elseif (isset($store_info['config_image_cart_height'])) {
            $data['config_image_cart_height'] = $store_info['config_image_cart_height'];
        } else {
            $data['config_image_cart_height'] = 80;
        }
        
        if (isset($this->request->post['config_secure'])) {
            $data['config_secure'] = $this->request->post['config_secure'];
        } elseif (isset($store_info['config_secure'])) {
            $data['config_secure'] = $store_info['config_secure'];
        } else {
            $data['config_secure'] = '';
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::render_controllers($data);
        
        Response::setOutput(Theme::view('setting/store_form', $data));
    }
    
    protected function validateForm() {
        if (!User::hasPermission('modify', 'setting/store')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        if (!$this->request->post['config_url']) {
            $this->error['url'] = Lang::get('lang_error_url');
        }
        
        if (!$this->request->post['config_name']) {
            $this->error['name'] = Lang::get('lang_error_name');
        }
        
        if ((Encode::strlen($this->request->post['config_owner']) < 3) || (Encode::strlen($this->request->post['config_owner']) > 64)) {
            $this->error['owner'] = Lang::get('lang_error_owner');
        }
        
        if ((Encode::strlen($this->request->post['config_address']) < 3) || (Encode::strlen($this->request->post['config_address']) > 256)) {
            $this->error['address'] = Lang::get('lang_error_address');
        }
        
        if ((Encode::strlen($this->request->post['config_email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['config_email'])) {
            $this->error['email'] = Lang::get('lang_error_email');
        }
        
        if ((Encode::strlen($this->request->post['config_telephone']) < 3) || (Encode::strlen($this->request->post['config_telephone']) > 32)) {
            $this->error['telephone'] = Lang::get('lang_error_telephone');
        }
        
        if (!$this->request->post['config_title']) {
            $this->error['title'] = Lang::get('lang_error_title');
        }
        
        if (!empty($this->request->post['config_customer_group_display']) && !in_array($this->request->post['config_customer_group_id'], $this->request->post['config_customer_group_display'])) {
            $this->error['customer_group_display'] = Lang::get('lang_error_customer_group_display');
        }
        
        if (!$this->request->post['config_image_category_width'] || !$this->request->post['config_image_category_height']) {
            $this->error['image_category'] = Lang::get('lang_error_image_category');
        }
        
        if (!$this->request->post['config_image_thumb_width'] || !$this->request->post['config_image_thumb_height']) {
            $this->error['image_thumb'] = Lang::get('lang_error_image_thumb');
        }
        
        if (!$this->request->post['config_image_popup_width'] || !$this->request->post['config_image_popup_height']) {
            $this->error['image_popup'] = Lang::get('lang_error_image_popup');
        }
        
        if (!$this->request->post['config_image_product_width'] || !$this->request->post['config_image_product_height']) {
            $this->error['image_product'] = Lang::get('lang_error_image_product');
        }
        
        if (!$this->request->post['config_image_additional_width'] || !$this->request->post['config_image_additional_height']) {
            $this->error['image_additional'] = Lang::get('lang_error_image_additional');
        }
        
        if (!$this->request->post['config_image_related_width'] || !$this->request->post['config_image_related_height']) {
            $this->error['image_related'] = Lang::get('lang_error_image_related');
        }
        
        if (!$this->request->post['config_image_compare_width'] || !$this->request->post['config_image_compare_height']) {
            $this->error['image_compare'] = Lang::get('lang_error_image_compare');
        }
        
        if (!$this->request->post['config_image_wishlist_width'] || !$this->request->post['config_image_wishlist_height']) {
            $this->error['image_wishlist'] = Lang::get('lang_error_image_wishlist');
        }
        
        if (!$this->request->post['config_image_cart_width'] || !$this->request->post['config_image_cart_height']) {
            $this->error['image_cart'] = Lang::get('lang_error_image_cart');
        }
        
        if (!$this->request->post['config_catalog_limit']) {
            $this->error['catalog_limit'] = Lang::get('lang_error_limit');
        }
        
        if ($this->error && !isset($this->error['warning'])) {
            $this->error['warning'] = Lang::get('lang_error_warning');
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    protected function validateDelete() {
        if (!User::hasPermission('modify', 'setting/store')) {
            $this->error['warning'] = Lang::get('lang_error_permission');
        }
        
        Theme::model('sale/order');
        
        foreach ($this->request->post['selected'] as $store_id) {
            if (!$store_id) {
                $this->error['warning'] = Lang::get('lang_error_default');
            }
            
            $store_total = $this->model_sale_order->getTotalOrdersByStoreId($store_id);
            
            if ($store_total) {
                $this->error['warning'] = sprintf(Lang::get('lang_error_store'), $store_total);
            }
        }
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        return !$this->error;
    }
    
    public function theme() {
        if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
            $server = Config::get('https.public');
        } else {
            $server = Config::get('http.public');
        }
        
        if (file_exists(Config::get('path.image') . 'themes/catalog/' . basename($this->request->get['theme']) . '.png')) {
            $image = $server . 'image/themes/catalog/' . basename($this->request->get['theme']) . '.png';
        } else {
            $image = $server . 'image/placeholder.png';
        }
        
        Response::setOutput('<img src="' . $image . '" alt="" title="" style="border: 1px solid #EEEEEE;" />');
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
        
        Response::setOutput(json_encode($json));
    }
}
