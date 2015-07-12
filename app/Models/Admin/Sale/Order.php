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

namespace App\Models\Admin\Sale;
use App\Models\Model;

class Order extends Model {
    public function addOrder($data) {
        Theme::model('setting/store');
        
        $store_info = $this->model_setting_store->getStore($data['store_id']);
        
        if ($store_info) {
            $store_name = $store_info['name'];
            $store_url = $store_info['url'];
        } else {
            $store_name = Config::get('config_name');
            $store_url = Config::get('http.public');
        }
        
        Theme::model('setting/setting');
        
        $setting_info = $this->model_setting_setting->getSetting('setting', $data['store_id']);
        
        if (isset($setting_info['invoice_prefix'])) {
            $invoice_prefix = $setting_info['invoice_prefix'];
        } else {
            $invoice_prefix = Config::get('config_invoice_prefix');
        }
        
        Theme::model('locale/country');
        
        Theme::model('locale/zone');
        
        $country_info = $this->model_locale_country->getCountry($data['shipping_country_id']);
        
        if ($country_info) {
            $shipping_country = $country_info['name'];
            $shipping_address_format = $country_info['address_format'];
        } else {
            $shipping_country = '';
            $shipping_address_format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
        }
        
        $zone_info = $this->model_locale_zone->getZone($data['shipping_zone_id']);
        
        if ($zone_info) {
            $shipping_zone = $zone_info['name'];
        } else {
            $shipping_zone = '';
        }
        
        $country_info = $this->model_locale_country->getCountry($data['payment_country_id']);
        
        if ($country_info) {
            $payment_country = $country_info['name'];
            $payment_address_format = $country_info['address_format'];
        } else {
            $payment_country = '';
            $payment_address_format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
        }
        
        $zone_info = $this->model_locale_zone->getZone($data['payment_zone_id']);
        
        if ($zone_info) {
            $payment_zone = $zone_info['name'];
        } else {
            $payment_zone = '';
        }
        
        Theme::model('locale/currency');
        
        $currency_info = $this->model_locale_currency->getCurrencyByCode(Config::get('config_currency'));
        
        if ($currency_info) {
            $currency_id = $currency_info['currency_id'];
            $currency_code = $currency_info['code'];
            $currency_value = $currency_info['value'];
        } else {
            $currency_id = 0;
            $currency_code = Config::get('config_currency');
            $currency_value = 1.00000;
        }
        
        $this->db->query("
			INSERT INTO `{$this->db->prefix}order` 
			SET 
				invoice_prefix          = '" . $this->db->escape($invoice_prefix) . "', 
				store_id                = '" . (int)$data['store_id'] . "', 
				store_name              = '" . $this->db->escape($store_name) . "', 
				store_url               = '" . $this->db->escape($store_url) . "', 
				customer_id             = '" . (int)$data['customer_id'] . "', 
				customer_group_id       = '" . (int)$data['customer_group_id'] . "', 
				firstname               = '" . $this->db->escape($data['firstname']) . "', 
				lastname                = '" . $this->db->escape($data['lastname']) . "', 
				email                   = '" . $this->db->escape($data['email']) . "', 
				telephone               = '" . $this->db->escape($data['telephone']) . "', 
				payment_firstname       = '" . $this->db->escape($data['payment_firstname']) . "', 
				payment_lastname        = '" . $this->db->escape($data['payment_lastname']) . "', 
				payment_company         = '" . $this->db->escape($data['payment_company']) . "', 
				payment_company_id      = '" . $this->db->escape($data['payment_company_id']) . "', 
				payment_tax_id          = '" . $this->db->escape($data['payment_tax_id']) . "', 
				payment_address_1       = '" . $this->db->escape($data['payment_address_1']) . "', 
				payment_address_2       = '" . $this->db->escape($data['payment_address_2']) . "', 
				payment_city            = '" . $this->db->escape($data['payment_city']) . "', 
				payment_postcode        = '" . $this->db->escape($data['payment_postcode']) . "', 
				payment_country         = '" . $this->db->escape($payment_country) . "', 
				payment_country_id      = '" . (int)$data['payment_country_id'] . "', 
				payment_zone            = '" . $this->db->escape($payment_zone) . "', 
				payment_zone_id         = '" . (int)$data['payment_zone_id'] . "', 
				payment_address_format  = '" . $this->db->escape($payment_address_format) . "', 
				payment_method          = '" . $this->db->escape($data['payment_method']) . "', 
				payment_code            = '" . $this->db->escape($data['payment_code']) . "', 
				shipping_firstname      = '" . $this->db->escape($data['shipping_firstname']) . "', 
				shipping_lastname       = '" . $this->db->escape($data['shipping_lastname']) . "', 
				shipping_company        = '" . $this->db->escape($data['shipping_company']) . "', 
				shipping_address_1      = '" . $this->db->escape($data['shipping_address_1']) . "', 
				shipping_address_2      = '" . $this->db->escape($data['shipping_address_2']) . "', 
				shipping_city           = '" . $this->db->escape($data['shipping_city']) . "', 
				shipping_postcode       = '" . $this->db->escape($data['shipping_postcode']) . "', 
				shipping_country        = '" . $this->db->escape($shipping_country) . "', 
				shipping_country_id     = '" . (int)$data['shipping_country_id'] . "', 
				shipping_zone           = '" . $this->db->escape($shipping_zone) . "', 
				shipping_zone_id        = '" . (int)$data['shipping_zone_id'] . "', 
				shipping_address_format = '" . $this->db->escape($shipping_address_format) . "', 
				shipping_method         = '" . $this->db->escape($data['shipping_method']) . "', 
				shipping_code           = '" . $this->db->escape($data['shipping_code']) . "', 
				comment                 = '" . $this->db->escape($data['comment']) . "', 
				order_status_id         = '" . (int)$data['order_status_id'] . "', 
				affiliate_id            = '" . (int)$data['affiliate_id'] . "', 
				language_id             = '" . (int)Config::get('config_language_id') . "', 
				currency_id             = '" . (int)$currency_id . "', 
				currency_code           = '" . $this->db->escape($currency_code) . "', 
				currency_value          = '" . (float)$currency_value . "', 
				date_added              = NOW(), 
				date_modified           = NOW()
		");
        
        $order_id = $this->db->getLastId();
        
        if (isset($data['order_product'])) {
            foreach ($data['order_product'] as $order_product) {
                $this->db->query("
					INSERT INTO {$this->db->prefix}order_product 
					SET 
						order_id   = '" . (int)$order_id . "', 
						product_id = '" . (int)$order_product['product_id'] . "', 
						name       = '" . $this->db->escape($order_product['name']) . "', 
						model      = '" . $this->db->escape($order_product['model']) . "', 
						quantity   = '" . (int)$order_product['quantity'] . "', 
						price      = '" . (float)$order_product['price'] . "', 
						total      = '" . (float)$order_product['total'] . "', 
						tax        = '" . (float)$order_product['tax'] . "', 
						reward     = '" . (int)$order_product['reward'] . "'
				");
                
                $order_product_id = $this->db->getLastId();
                
                $this->db->query("
					UPDATE {$this->db->prefix}product 
					SET 
						quantity = (quantity - " . (int)$order_product['quantity'] . ") 
					WHERE product_id = '" . (int)$order_product['product_id'] . "' 
					AND subtract = '1'
				");
                
                if (isset($order_product['order_option'])) {
                    foreach ($order_product['order_option'] as $order_option) {
                        $this->db->query("
							INSERT INTO {$this->db->prefix}order_option 
							SET 
								order_id                = '" . (int)$order_id . "', 
								order_product_id        = '" . (int)$order_product_id . "', 
								product_option_id       = '" . (int)$order_option['product_option_id'] . "', 
								product_option_value_id = '" . (int)$order_option['product_option_value_id'] . "', 
								name                    = '" . $this->db->escape($order_option['name']) . "', 
								`value`                 = '" . $this->db->escape($order_option['value']) . "', 
								`type`                  = '" . $this->db->escape($order_option['type']) . "'
						");
                        
                        $this->db->query("
							UPDATE {$this->db->prefix}product_option_value 
							SET 
								quantity = (quantity - " . (int)$order_product['quantity'] . ") 
							WHERE product_option_value_id = '" . (int)$order_option['product_option_value_id'] . "' 
							AND subtract = '1'
						");
                    }
                }
                
                if (isset($order_product['order_download'])) {
                    foreach ($order_product['order_download'] as $order_download) {
                        $this->db->query("
							INSERT INTO {$this->db->prefix}order_download 
							SET 
								order_id         = '" . (int)$order_id . "', 
								order_product_id = '" . (int)$order_product_id . "', 
								name             = '" . $this->db->escape($order_download['name']) . "', 
								filename         = '" . $this->db->escape($order_download['filename']) . "', 
								mask             = '" . $this->db->escape($order_download['mask']) . "', 
								remaining        = '" . (int)$order_download['remaining'] . "'
						");
                    }
                }
            }
        }
        
        if (isset($data['order_gift_card'])) {
            foreach ($data['order_gift_card'] as $order_gift_card) {
                $this->db->query("
					INSERT INTO {$this->db->prefix}order_gift_card 
					SET 
						order_id          = '" . (int)$order_id . "', 
						gift_card_id       = '" . (int)$order_gift_card['gift_card_id'] . "', 
						description       = '" . $this->db->escape($order_gift_card['description']) . "', 
						code              = '" . $this->db->escape($order_gift_card['code']) . "', 
						from_name         = '" . $this->db->escape($order_gift_card['from_name']) . "', 
						from_email        = '" . $this->db->escape($order_gift_card['from_email']) . "', 
						to_name           = '" . $this->db->escape($order_gift_card['to_name']) . "', 
						to_email          = '" . $this->db->escape($order_gift_card['to_email']) . "', 
						gift_card_theme_id = '" . (int)$order_gift_card['gift_card_theme_id'] . "', 
						message           = '" . $this->db->escape($order_gift_card['message']) . "', 
						amount            = '" . (float)$order_gift_card['amount'] . "'
				");
                
                $this->db->query("
					UPDATE {$this->db->prefix}gift_card 
					SET 
						order_id = '" . (int)$order_id . "' 
					WHERE gift_card_id = '" . (int)$order_gift_card['gift_card_id'] . "'
				");
            }
        }
        
        // Get the total
        $total = 0;
        
        if (isset($data['order_total'])) {
            foreach ($data['order_total'] as $order_total) {
                $this->db->query("
					INSERT INTO {$this->db->prefix}order_total 
					SET 
						order_id   = '" . (int)$order_id . "', 
						code       = '" . $this->db->escape($order_total['code']) . "', 
						title      = '" . $this->db->escape($order_total['title']) . "', 
						text       = '" . $this->db->escape($order_total['text']) . "', 
						`value`    = '" . (float)$order_total['value'] . "', 
						sort_order = '" . (int)$order_total['sort_order'] . "'
				");
            }
            
            $total+= $order_total['value'];
        }
        
        // Affiliate
		$affiliate_id = 0;
		$commission   = 0;
        
        if (!empty($this->request->post['affiliate_id'])) {
            Theme::model('people/customer');
            $affiliate_info = $this->model_people_customer->getCustomer($this->request->post['affiliate_id']);
            
            if ($affiliate_info) {
                $affiliate_id = $affiliate_info['customer_id'];
                $commission = ($total / 100) * $affiliate_info['commission'];
            }
        }
        
        // Update order total
        $this->db->query("
			UPDATE `{$this->db->prefix}order` 
			SET 
				total        = '" . (float)$total . "', 
				affiliate_id = '" . (int)$affiliate_id . "', 
				commission   = '" . (float)$commission . "' 
			WHERE order_id = '" . (int)$order_id . "'
		");
    }
    
    public function editOrder($order_id, $data) {
        Theme::model('locale/country');
        
        Theme::model('locale/zone');
        
        $country_info = $this->model_locale_country->getCountry($data['shipping_country_id']);
        
        if ($country_info) {
            $shipping_country = $country_info['name'];
            $shipping_address_format = $country_info['address_format'];
        } else {
            $shipping_country = '';
            $shipping_address_format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
        }
        
        $zone_info = $this->model_locale_zone->getZone($data['shipping_zone_id']);
        
        if ($zone_info) {
            $shipping_zone = $zone_info['name'];
        } else {
            $shipping_zone = '';
        }
        
        $country_info = $this->model_locale_country->getCountry($data['payment_country_id']);
        
        if ($country_info) {
            $payment_country = $country_info['name'];
            $payment_address_format = $country_info['address_format'];
        } else {
            $payment_country = '';
            $payment_address_format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
        }
        
        $zone_info = $this->model_locale_zone->getZone($data['payment_zone_id']);
        
        if ($zone_info) {
            $payment_zone = $zone_info['name'];
        } else {
            $payment_zone = '';
        }
        
        // Restock products before subtracting the stock later on
        $order_query = $this->db->query("
			SELECT * 
			FROM `{$this->db->prefix}order` 
			WHERE order_status_id > '0' 
			AND order_id = '" . (int)$order_id . "'
		");
        
        if ($order_query->num_rows) {
            $product_query = $this->db->query("
				SELECT * 
				FROM {$this->db->prefix}order_product 
				WHERE order_id = '" . (int)$order_id . "'
			");
            
            foreach ($product_query->rows as $product) {
                $this->db->query("
					UPDATE `{$this->db->prefix}product` 
					SET 
						quantity = (quantity + " . (int)$product['quantity'] . ") 
					WHERE product_id = '" . (int)$product['product_id'] . "' 
					AND subtract = '1'
				");
                
                $option_query = $this->db->query("
					SELECT * 
					FROM {$this->db->prefix}order_option 
					WHERE order_id = '" . (int)$order_id . "' 
					AND order_product_id = '" . (int)$product['order_product_id'] . "'
				");
                
                foreach ($option_query->rows as $option) {
                    $this->db->query("
						UPDATE {$this->db->prefix}product_option_value 
						SET 
							quantity = (quantity + " . (int)$product['quantity'] . ") 
						WHERE product_option_value_id = '" . (int)$option['product_option_value_id'] . "' 
						AND subtract = '1'
					");
                }
            }
        }
        
        $this->db->query("
			UPDATE `{$this->db->prefix}order` 
			SET 
				firstname               = '" . $this->db->escape($data['firstname']) . "', 
				lastname                = '" . $this->db->escape($data['lastname']) . "', 
				email                   = '" . $this->db->escape($data['email']) . "', 
				telephone               = '" . $this->db->escape($data['telephone']) . "', 
				payment_firstname       = '" . $this->db->escape($data['payment_firstname']) . "', 
				payment_lastname        = '" . $this->db->escape($data['payment_lastname']) . "', 
				payment_company         = '" . $this->db->escape($data['payment_company']) . "', 
				payment_company_id      = '" . $this->db->escape($data['payment_company_id']) . "', 
				payment_tax_id          = '" . $this->db->escape($data['payment_tax_id']) . "', 
				payment_address_1       = '" . $this->db->escape($data['payment_address_1']) . "', 
				payment_address_2       = '" . $this->db->escape($data['payment_address_2']) . "', 
				payment_city            = '" . $this->db->escape($data['payment_city']) . "', 
				payment_postcode        = '" . $this->db->escape($data['payment_postcode']) . "', 
				payment_country         = '" . $this->db->escape($payment_country) . "', 
				payment_country_id      = '" . (int)$data['payment_country_id'] . "', 
				payment_zone            = '" . $this->db->escape($payment_zone) . "', 
				payment_zone_id         = '" . (int)$data['payment_zone_id'] . "', 
				payment_address_format  = '" . $this->db->escape($payment_address_format) . "', 
				payment_method          = '" . $this->db->escape($data['payment_method']) . "', 
				payment_code            = '" . $this->db->escape($data['payment_code']) . "', 
				shipping_firstname      = '" . $this->db->escape($data['shipping_firstname']) . "', 
				shipping_lastname       = '" . $this->db->escape($data['shipping_lastname']) . "', 
				shipping_company        = '" . $this->db->escape($data['shipping_company']) . "', 
				shipping_address_1      = '" . $this->db->escape($data['shipping_address_1']) . "', 
				shipping_address_2      = '" . $this->db->escape($data['shipping_address_2']) . "', 
				shipping_city           = '" . $this->db->escape($data['shipping_city']) . "', 
				shipping_postcode       = '" . $this->db->escape($data['shipping_postcode']) . "', 
				shipping_country        = '" . $this->db->escape($shipping_country) . "', 
				shipping_country_id     = '" . (int)$data['shipping_country_id'] . "', 
				shipping_zone           = '" . $this->db->escape($shipping_zone) . "', 
				shipping_zone_id        = '" . (int)$data['shipping_zone_id'] . "', 
				shipping_address_format = '" . $this->db->escape($shipping_address_format) . "', 
				shipping_method         = '" . $this->db->escape($data['shipping_method']) . "', 
				shipping_code           = '" . $this->db->escape($data['shipping_code']) . "', 
				comment                 = '" . $this->db->escape($data['comment']) . "', 
				order_status_id         = '" . (int)$data['order_status_id'] . "', 
				affiliate_id            = '" . (int)$data['affiliate_id'] . "', 
				date_modified           = NOW() 
			WHERE order_id = '" . (int)$order_id . "'
		");
        
        $this->db->query("DELETE FROM {$this->db->prefix}order_product WHERE order_id = '" . (int)$order_id . "'");
        $this->db->query("DELETE FROM {$this->db->prefix}order_option WHERE order_id = '" . (int)$order_id . "'");
        $this->db->query("DELETE FROM {$this->db->prefix}order_download WHERE order_id = '" . (int)$order_id . "'");
        
        if (isset($data['order_product'])) {
            foreach ($data['order_product'] as $order_product) {
                $this->db->query("
					INSERT INTO {$this->db->prefix}order_product 
					SET 
						order_product_id = '" . (int)$order_product['order_product_id'] . "', 
						order_id         = '" . (int)$order_id . "', 
						product_id       = '" . (int)$order_product['product_id'] . "', 
						name             = '" . $this->db->escape($order_product['name']) . "', 
						model            = '" . $this->db->escape($order_product['model']) . "', 
						quantity         = '" . (int)$order_product['quantity'] . "', 
						price            = '" . (float)$order_product['price'] . "', 
						total            = '" . (float)$order_product['total'] . "', 
						tax              = '" . (float)$order_product['tax'] . "', 
						reward           = '" . (int)$order_product['reward'] . "'
				");
                
                $order_product_id = $this->db->getLastId();
                
                $this->db->query("
					UPDATE {$this->db->prefix}product 
					SET 
						quantity = (quantity - " . (int)$order_product['quantity'] . ") 
					WHERE product_id = '" . (int)$order_product['product_id'] . "' 
					AND subtract = '1'
				");
                
                if (isset($order_product['order_option'])) {
                    foreach ($order_product['order_option'] as $order_option) {
                        $this->db->query("
							INSERT INTO {$this->db->prefix}order_option 
							SET 
								order_option_id         = '" . (int)$order_option['order_option_id'] . "', 
								order_id                = '" . (int)$order_id . "', 
								order_product_id        = '" . (int)$order_product_id . "', 
								product_option_id       = '" . (int)$order_option['product_option_id'] . "', 
								product_option_value_id = '" . (int)$order_option['product_option_value_id'] . "', 
								name                    = '" . $this->db->escape($order_option['name']) . "', 
								`value`                 = '" . $this->db->escape($order_option['value']) . "', 
								`type`                  = '" . $this->db->escape($order_option['type']) . "'
						");
                        
                        $this->db->query("
							UPDATE {$this->db->prefix}product_option_value 
							SET 
								quantity = (quantity - " . (int)$order_product['quantity'] . ") 
							WHERE product_option_value_id = '" . (int)$order_option['product_option_value_id'] . "' 
							AND subtract = '1'
						");
                    }
                }
                
                if (isset($order_product['order_download'])) {
                    foreach ($order_product['order_download'] as $order_download) {
                        $this->db->query("
							INSERT INTO {$this->db->prefix}order_download 
							SET 
								order_download_id = '" . (int)$order_download['order_download_id'] . "', 
								order_id          = '" . (int)$order_id . "', 
								order_product_id  = '" . (int)$order_product_id . "', 
								name              = '" . $this->db->escape($order_download['name']) . "', 
								filename          = '" . $this->db->escape($order_download['filename']) . "', 
								mask              = '" . $this->db->escape($order_download['mask']) . "', 
								remaining         = '" . (int)$order_download['remaining'] . "'
						");
                    }
                }
            }
        }
        
        $this->db->query("DELETE FROM {$this->db->prefix}order_gift_card WHERE order_id = '" . (int)$order_id . "'");
        
        if (isset($data['order_gift_card'])) {
            foreach ($data['order_gift_card'] as $order_gift_card) {
                $this->db->query("
					INSERT INTO {$this->db->prefix}order_gift_card 
					SET 
						order_gift_card_id = '" . (int)$order_gift_card['order_gift_card_id'] . "', 
						order_id          = '" . (int)$order_id . "', 
						gift_card_id       = '" . (int)$order_gift_card['gift_card_id'] . "', 
						description       = '" . $this->db->escape($order_gift_card['description']) . "', 
						code              = '" . $this->db->escape($order_gift_card['code']) . "', 
						from_name         = '" . $this->db->escape($order_gift_card['from_name']) . "', 
						from_email        = '" . $this->db->escape($order_gift_card['from_email']) . "', 
						to_name           = '" . $this->db->escape($order_gift_card['to_name']) . "', 
						to_email          = '" . $this->db->escape($order_gift_card['to_email']) . "', 
						gift_card_theme_id = '" . (int)$order_gift_card['gift_card_theme_id'] . "', 
						message           = '" . $this->db->escape($order_gift_card['message']) . "', 
						amount            = '" . (float)$order_gift_card['amount'] . "'
				");
                
                $this->db->query("
					UPDATE {$this->db->prefix}gift_card 
					SET 
						order_id = '" . (int)$order_id . "' 
					WHERE gift_card_id = '" . (int)$order_gift_card['gift_card_id'] . "'
				");
            }
        }
        
        // Get the total
        $total = 0;
        
        $this->db->query("DELETE FROM {$this->db->prefix}order_total WHERE order_id = '" . (int)$order_id . "'");
        
        if (isset($data['order_total'])) {
            foreach ($data['order_total'] as $order_total) {
                $this->db->query("
					INSERT INTO {$this->db->prefix}order_total 
					SET 
						order_total_id = '" . (int)$order_total['order_total_id'] . "', 
						order_id       = '" . (int)$order_id . "', 
						code           = '" . $this->db->escape($order_total['code']) . "', 
						title          = '" . $this->db->escape($order_total['title']) . "', 
						text           = '" . $this->db->escape($order_total['text']) . "', 
						`value`        = '" . (float)$order_total['value'] . "', 
						sort_order     = '" . (int)$order_total['sort_order'] . "'
				");
            }
            
            $total+= $order_total['value'];
        }
        
        // Affiliate
		$affiliate_id = 0;
		$commission   = 0;
        
        if (!empty($this->request->post['affiliate_id'])) {
            Theme::model('people/customer');
            
            $affiliate_info = $this->model_people_customer->getCustomer($this->request->post['affiliate_id']);
            
            if ($affiliate_info) {
                $affiliate_id = $affiliate_info['customer_id'];
                $commission = ($total / 100) * $affiliate_info['commission'];
            }
        }
        
        $this->db->query("
			UPDATE `{$this->db->prefix}order` 
			SET 
				total        = '" . (float)$total . "', 
				affiliate_id = '" . (int)$affiliate_id . "', 
				commission   = '" . (float)$commission . "' 
			WHERE order_id = '" . (int)$order_id . "'
		");
    }
    
    public function deleteOrder($order_id) {
        $order_query = $this->db->query("
			SELECT * 
			FROM `{$this->db->prefix}order` 
			WHERE order_status_id > '0' 
			AND order_id = '" . (int)$order_id . "'
		");
        
        if ($order_query->num_rows) {
            $product_query = $this->db->query("
				SELECT * 
				FROM {$this->db->prefix}order_product 
				WHERE order_id = '" . (int)$order_id . "'
			");
            
            foreach ($product_query->rows as $product) {
                $this->db->query("
					UPDATE `{$this->db->prefix}product` 
					SET 
						quantity = (quantity + " . (int)$product['quantity'] . ") 
					WHERE product_id = '" . (int)$product['product_id'] . "' 
					AND subtract = '1'
				");
                
                $option_query = $this->db->query("
					SELECT * 
					FROM {$this->db->prefix}order_option 
					WHERE order_id = '" . (int)$order_id . "' 
					AND order_product_id = '" . (int)$product['order_product_id'] . "'
				");
                
                foreach ($option_query->rows as $option) {
                    $this->db->query("
						UPDATE {$this->db->prefix}product_option_value 
						SET 
							quantity = (quantity + " . (int)$product['quantity'] . ") 
						WHERE product_option_value_id = '" . (int)$option['product_option_value_id'] . "' 
						AND subtract = '1'
					");
                }
            }
        }
        
        $this->db->query("DELETE FROM `{$this->db->prefix}order` WHERE order_id = '" . (int)$order_id . "'");
        $this->db->query("DELETE FROM {$this->db->prefix}order_product WHERE order_id = '" . (int)$order_id . "'");
        $this->db->query("DELETE FROM {$this->db->prefix}order_option WHERE order_id = '" . (int)$order_id . "'");
        $this->db->query("DELETE FROM {$this->db->prefix}order_download WHERE order_id = '" . (int)$order_id . "'");
        $this->db->query("DELETE FROM {$this->db->prefix}order_gift_card WHERE order_id = '" . (int)$order_id . "'");
        $this->db->query("DELETE FROM {$this->db->prefix}order_total WHERE order_id = '" . (int)$order_id . "'");
        $this->db->query("DELETE FROM {$this->db->prefix}order_history WHERE order_id = '" . (int)$order_id . "'");
        $this->db->query("DELETE FROM {$this->db->prefix}order_fraud WHERE order_id = '" . (int)$order_id . "'");
        $this->db->query("DELETE FROM {$this->db->prefix}order_fraud WHERE order_id = '" . (int)$order_id . "'");
        $this->db->query("DELETE FROM {$this->db->prefix}customer_credit WHERE order_id = '" . (int)$order_id . "'");
        $this->db->query("DELETE FROM {$this->db->prefix}customer_reward WHERE order_id = '" . (int)$order_id . "'");
        $this->db->query("DELETE FROM {$this->db->prefix}customer_commission WHERE order_id = '" . (int)$order_id . "'");
        
        $recurring = $this->db->query("
			SELECT order_recurring_id 
			FROM {$this->db->prefix}order_recurring 
			WHERE order_id = '" . (int)$order_id . "'");
        
        if ($recurring->num_rows):
            $recurring_order_id = $recurring->row['order_recurring_id'];
            
            $this->db->query("
				DELETE 
				FROM {$this->db->prefix}order_recurring_transaction 
				WHERE order_recurring_id = '" . (int)$recurring_order_id . "'");
            
            $this->db->query("
				DELETE 
				FROM {$this->db->prefix}order_recurring 
				WHERE order_id = '" . (int)$order_id . "'");
        endif;
    }
    
    public function getOrder($order_id) {
        $order_query = $this->db->query("
			SELECT *, 
				(SELECT CONCAT(c.firstname, ' ', c.lastname) 
				FROM {$this->db->prefix}customer c 
				WHERE c.customer_id = o.customer_id) AS customer 
			FROM `{$this->db->prefix}order` o 
			WHERE o.order_id = '" . (int)$order_id . "'
		");
        
        if ($order_query->num_rows) {
            $reward = 0;
            
            $order_product_query = $this->db->query("
				SELECT * 
				FROM {$this->db->prefix}order_product 
				WHERE order_id = '" . (int)$order_id . "'
			");
            
            foreach ($order_product_query->rows as $product) {
                $reward+= $product['reward'];
            }
            
            $country_query = $this->db->query("
				SELECT * 
				FROM `{$this->db->prefix}country` 
				WHERE country_id = '" . (int)$order_query->row['payment_country_id'] . "'
			");
            
            if ($country_query->num_rows) {
                $payment_iso_code_2 = $country_query->row['iso_code_2'];
                $payment_iso_code_3 = $country_query->row['iso_code_3'];
            } else {
                $payment_iso_code_2 = '';
                $payment_iso_code_3 = '';
            }
            
            $zone_query = $this->db->query("
				SELECT * 
				FROM `{$this->db->prefix}zone` 
				WHERE zone_id = '" . (int)$order_query->row['payment_zone_id'] . "'
			");
            
            if ($zone_query->num_rows) {
                $payment_zone_code = $zone_query->row['code'];
            } else {
                $payment_zone_code = '';
            }
            
            $country_query = $this->db->query("
				SELECT * 
				FROM `{$this->db->prefix}country` 
				WHERE country_id = '" . (int)$order_query->row['shipping_country_id'] . "'
			");
            
            if ($country_query->num_rows) {
                $shipping_iso_code_2 = $country_query->row['iso_code_2'];
                $shipping_iso_code_3 = $country_query->row['iso_code_3'];
            } else {
                $shipping_iso_code_2 = '';
                $shipping_iso_code_3 = '';
            }
            
            $zone_query = $this->db->query("
				SELECT * 
				FROM `{$this->db->prefix}zone` 
				WHERE zone_id = '" . (int)$order_query->row['shipping_zone_id'] . "'
			");
            
            if ($zone_query->num_rows) {
                $shipping_zone_code = $zone_query->row['code'];
            } else {
                $shipping_zone_code = '';
            }
            
            if ($order_query->row['affiliate_id']) {
                $affiliate_id = $order_query->row['affiliate_id'];
            } else {
                $affiliate_id = 0;
            }
            
            Theme::model('people/customer');
            $affiliate_info = $this->model_people_customer->getCustomer($affiliate_id);
            
            if ($affiliate_info) {
				$affiliate_firstname = $affiliate_info['firstname'];
				$affiliate_lastname  = $affiliate_info['lastname'];
            } else {
				$affiliate_firstname = '';
				$affiliate_lastname  = '';
            }
            
            Theme::model('locale/language');
            
            $language_info = $this->model_locale_language->getLanguage($order_query->row['language_id']);
            
            if ($language_info) {
                $language_code = $language_info['code'];
                $language_filename = $language_info['filename'];
                $language_directory = $language_info['directory'];
            } else {
                $language_code = '';
                $language_filename = '';
                $language_directory = '';
            }
            
            return array(
				'order_id'                => $order_query->row['order_id'], 
				'invoice_no'              => $order_query->row['invoice_no'], 
				'invoice_prefix'          => $order_query->row['invoice_prefix'], 
				'store_id'                => $order_query->row['store_id'], 
				'store_name'              => $order_query->row['store_name'], 
				'store_url'               => $order_query->row['store_url'], 
				'customer_id'             => $order_query->row['customer_id'], 
				'customer'                => $order_query->row['customer'], 
				'customer_group_id'       => $order_query->row['customer_group_id'], 
				'firstname'               => $order_query->row['firstname'], 
				'lastname'                => $order_query->row['lastname'], 
				'telephone'               => $order_query->row['telephone'], 
				'email'                   => $order_query->row['email'], 
				'payment_firstname'       => $order_query->row['payment_firstname'], 
				'payment_lastname'        => $order_query->row['payment_lastname'], 
				'payment_company'         => $order_query->row['payment_company'], 
				'payment_company_id'      => $order_query->row['payment_company_id'], 
				'payment_tax_id'          => $order_query->row['payment_tax_id'], 
				'payment_address_1'       => $order_query->row['payment_address_1'], 
				'payment_address_2'       => $order_query->row['payment_address_2'], 
				'payment_postcode'        => $order_query->row['payment_postcode'], 
				'payment_city'            => $order_query->row['payment_city'], 
				'payment_zone_id'         => $order_query->row['payment_zone_id'], 
				'payment_zone'            => $order_query->row['payment_zone'], 
				'payment_zone_code'       => $payment_zone_code, 
				'payment_country_id'      => $order_query->row['payment_country_id'], 
				'payment_country'         => $order_query->row['payment_country'], 
				'payment_iso_code_2'      => $payment_iso_code_2, 
				'payment_iso_code_3'      => $payment_iso_code_3, 
				'payment_address_format'  => $order_query->row['payment_address_format'], 
				'payment_method'          => $order_query->row['payment_method'], 
				'payment_code'            => $order_query->row['payment_code'], 
				'shipping_firstname'      => $order_query->row['shipping_firstname'], 
				'shipping_lastname'       => $order_query->row['shipping_lastname'], 
				'shipping_company'        => $order_query->row['shipping_company'], 
				'shipping_address_1'      => $order_query->row['shipping_address_1'], 
				'shipping_address_2'      => $order_query->row['shipping_address_2'], 
				'shipping_postcode'       => $order_query->row['shipping_postcode'], 
				'shipping_city'           => $order_query->row['shipping_city'], 
				'shipping_zone_id'        => $order_query->row['shipping_zone_id'], 
				'shipping_zone'           => $order_query->row['shipping_zone'], 
				'shipping_zone_code'      => $shipping_zone_code, 
				'shipping_country_id'     => $order_query->row['shipping_country_id'], 
				'shipping_country'        => $order_query->row['shipping_country'], 
				'shipping_iso_code_2'     => $shipping_iso_code_2, 
				'shipping_iso_code_3'     => $shipping_iso_code_3, 
				'shipping_address_format' => $order_query->row['shipping_address_format'], 
				'shipping_method'         => $order_query->row['shipping_method'], 
				'shipping_code'           => $order_query->row['shipping_code'], 
				'comment'                 => $order_query->row['comment'], 
				'total'                   => $order_query->row['total'], 
				'reward'                  => $reward, 
				'order_status_id'         => $order_query->row['order_status_id'], 
				'affiliate_id'            => $order_query->row['affiliate_id'], 
				'affiliate_firstname'     => $affiliate_firstname, 
				'affiliate_lastname'      => $affiliate_lastname, 
				'commission'              => $order_query->row['commission'], 
				'language_id'             => $order_query->row['language_id'], 
				'language_code'           => $language_code, 
				'language_filename'       => $language_filename, 
				'language_directory'      => $language_directory, 
				'currency_id'             => $order_query->row['currency_id'], 
				'currency_code'           => $order_query->row['currency_code'], 
				'currency_value'          => $order_query->row['currency_value'], 
				'ip'                      => $order_query->row['ip'], 
				'forwarded_ip'            => $order_query->row['forwarded_ip'], 
				'user_agent'              => $order_query->row['user_agent'], 
				'accept_language'         => $order_query->row['accept_language'], 
				'date_added'              => $order_query->row['date_added'], 
				'date_modified'           => $order_query->row['date_modified']
            );
        } else {
            return false;
        }
    }
    
    public function getOrders($data = array()) {
        $sql = "
			SELECT 
				o.order_id, 
				CONCAT(o.firstname, ' ', o.lastname) AS customer, 
				(SELECT os.name 
				FROM {$this->db->prefix}order_status os 
				WHERE os.order_status_id = o.order_status_id 
				AND os.language_id = '" . (int)Config::get('config_language_id') . "') AS status, 
				o.total, 
				o.currency_code, 
				o.currency_value, 
				o.date_added, 
				o.date_modified 
			FROM `{$this->db->prefix}order` o";
        
        if (isset($data['filter_order_status_id']) && !is_null($data['filter_order_status_id'])) {
            $sql.= " WHERE o.order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
        } else {
            $sql.= " WHERE o.order_status_id > '0'";
        }
        
        if (!empty($data['filter_order_id'])) {
            $sql.= " AND o.order_id = '" . (int)$data['filter_order_id'] . "'";
        }
        
        if (!empty($data['filter_customer'])) {
            $sql.= " AND CONCAT(o.firstname, ' ', o.lastname) LIKE '%" . $this->db->escape($data['filter_customer']) . "%'";
        }
        
        if (!empty($data['filter_date_added'])) {
            $sql.= " AND DATE(o.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
        }
        
        if (!empty($data['filter_date_modified'])) {
            $sql.= " AND DATE(o.date_modified) = DATE('" . $this->db->escape($data['filter_date_modified']) . "')";
        }
        
        if (!empty($data['filter_total'])) {
            $sql.= " AND o.total = '" . (float)$data['filter_total'] . "'";
        }
        
        $sort_data = array('o.order_id', 'customer', 'status', 'o.date_added', 'o.date_modified', 'o.total');
        
        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql.= " ORDER BY {$data['sort']}";
        } else {
            $sql.= " ORDER BY o.order_id";
        }
        
        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql.= " DESC";
        } else {
            $sql.= " ASC";
        }
        
        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }
            
            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }
            
            $sql.= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }
        
        $query = $this->db->query($sql);
        
        return $query->rows;
    }
    
    public function getOrderProducts($order_id) {
        $query = $this->db->query("
			SELECT * 
			FROM {$this->db->prefix}order_product 
			WHERE order_id = '" . (int)$order_id . "'
		");
        
        return $query->rows;
    }
    
    public function getOrderOption($order_id, $order_option_id) {
        $query = $this->db->query("
			SELECT * 
			FROM {$this->db->prefix}order_option 
			WHERE order_id = '" . (int)$order_id . "' 
			AND order_option_id = '" . (int)$order_option_id . "'
		");
        
        return $query->row;
    }
    
    public function getOrderOptions($order_id, $order_product_id) {
        $query = $this->db->query("
			SELECT oo.* 
			FROM {$this->db->prefix}order_option AS oo 
			LEFT JOIN {$this->db->prefix}product_option po 
				USING(product_option_id) 
			LEFT JOIN `{$this->db->prefix}option` o 
				USING(option_id) 
			WHERE order_id = '" . (int)$order_id . "' 
			AND order_product_id = '" . (int)$order_product_id . "' 
			ORDER BY o.sort_order
		");
        
        return $query->rows;
    }
    
    public function getOrderDownloads($order_id, $order_product_id) {
        $query = $this->db->query("
			SELECT * 
			FROM {$this->db->prefix}order_download 
			WHERE order_id = '" . (int)$order_id . "' 
			AND order_product_id = '" . (int)$order_product_id . "'
		");
        
        return $query->rows;
    }
    
    public function getOrderGiftcards($order_id) {
        $query = $this->db->query("
			SELECT * 
			FROM {$this->db->prefix}order_gift_card 
			WHERE order_id = '" . (int)$order_id . "'
		");
        
        return $query->rows;
    }
    
    public function getOrderGiftcardByGiftcardId($gift_card_id) {
        $query = $this->db->query("
			SELECT * 
			FROM `{$this->db->prefix}order_gift_card` 
			WHERE gift_card_id = '" . (int)$gift_card_id . "'
		");
        
        return $query->row;
    }
    
    public function getOrderTotals($order_id) {
        $query = $this->db->query("
			SELECT * 
			FROM {$this->db->prefix}order_total 
			WHERE order_id = '" . (int)$order_id . "' 
			ORDER BY sort_order
		");
        
        return $query->rows;
    }
    
    public function getTotalOrders($data = array()) {
        $sql = "
        	SELECT COUNT(*) AS total 
        	FROM `{$this->db->prefix}order`";
        
        if (isset($data['filter_order_status_id']) && !is_null($data['filter_order_status_id'])) {
            $sql.= " WHERE order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
        } else {
            $sql.= " WHERE order_status_id > '0'";
        }
        
        if (!empty($data['filter_order_id'])) {
            $sql.= " AND order_id = '" . (int)$data['filter_order_id'] . "'";
        }
        
        if (!empty($data['filter_customer'])) {
            $sql.= " AND CONCAT(firstname, ' ', lastname) LIKE '%" . $this->db->escape($data['filter_customer']) . "%'";
        }
        
        if (!empty($data['filter_date_added'])) {
            $sql.= " AND DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
        }
        
        if (!empty($data['filter_date_modified'])) {
            $sql.= " AND DATE(date_modified) = DATE('" . $this->db->escape($data['filter_date_modified']) . "')";
        }
        
        if (!empty($data['filter_total'])) {
            $sql.= " AND total = '" . (float)$data['filter_total'] . "'";
        }
        
        $query = $this->db->query($sql);
        
        return $query->row['total'];
    }
    
    public function getTotalOrdersByStoreId($store_id) {
        $query = $this->db->query("
			SELECT 
				COUNT(*) AS total 
			FROM `{$this->db->prefix}order` 
			WHERE store_id = '" . (int)$store_id . "'
		");
        
        return $query->row['total'];
    }
    
    public function getTotalOrdersByOrderStatusId($order_status_id) {
        $query = $this->db->query("
			SELECT 
				COUNT(*) AS total 
			FROM `{$this->db->prefix}order` 
			WHERE order_status_id = '" . (int)$order_status_id . "' 
			AND order_status_id > '0'
		");
        
        return $query->row['total'];
    }
    
    public function getTotalOrdersByLanguageId($language_id) {
        $query = $this->db->query("
			SELECT 
				COUNT(*) AS total 
			FROM `{$this->db->prefix}order` 
			WHERE language_id = '" . (int)$language_id . "' 
			AND order_status_id > '0'
		");
        
        return $query->row['total'];
    }
    
    public function getTotalOrdersByCurrencyId($currency_id) {
        $query = $this->db->query("
			SELECT 
				COUNT(*) AS total 
			FROM `{$this->db->prefix}order` 
			WHERE currency_id = '" . (int)$currency_id . "' 
			AND order_status_id > '0'
		");
        
        return $query->row['total'];
    }
    
    public function getTotalSales() {
        $query = $this->db->query("
			SELECT 
				SUM(total) AS total 
			FROM `{$this->db->prefix}order` 
			WHERE order_status_id > '0'
		");
        
        return $query->row['total'];
    }
    
    public function getTotalSalesByYear($year) {
        $query = $this->db->query("
			SELECT 
				SUM(total) AS total 
			FROM `{$this->db->prefix}order` 
			WHERE order_status_id > '0' 
			AND YEAR(date_added) = '" . (int)$year . "'
		");
        
        return $query->row['total'];
    }
    
    public function createInvoiceNo($order_id) {
        $order_info = $this->getOrder($order_id);
        
        if ($order_info && !$order_info['invoice_no']) {
            $query = $this->db->query("
				SELECT 
					MAX(invoice_no) AS invoice_no 
				FROM `{$this->db->prefix}order` 
				WHERE invoice_prefix = '" . $this->db->escape($order_info['invoice_prefix']) . "'
			");
            
            if ($query->row['invoice_no']) {
                $invoice_no = $query->row['invoice_no'] + 1;
            } else {
                $invoice_no = 1;
            }
            
            $this->db->query("
				UPDATE `{$this->db->prefix}order` 
				SET 
					invoice_no = '" . (int)$invoice_no . "', 
					invoice_prefix = '" . $this->db->escape($order_info['invoice_prefix']) . "' 
				WHERE order_id = '" . (int)$order_id . "'
			");
            
            return $order_info['invoice_prefix'] . $invoice_no;
        }
    }
    
    public function addOrderHistory($order_id, $data) {
        $this->db->query("
			UPDATE `{$this->db->prefix}order` 
			SET 
				order_status_id = '" . (int)$data['order_status_id'] . "', 
				date_modified = NOW() 
			WHERE order_id = '" . (int)$order_id . "'
		");
        
        $this->db->query("
			INSERT INTO {$this->db->prefix}order_history 
			SET 
				order_id        = '" . (int)$order_id . "', 
				order_status_id = '" . (int)$data['order_status_id'] . "', 
				notify          = '" . (isset($data['notify']) ? (int)$data['notify'] : 0) . "', 
				comment         = '" . $this->db->escape(strip_tags($data['comment'])) . "', 
				date_added      = NOW()
		");
        
        $order_info = $this->getOrder($order_id);
        
        // Send out any gift gift_card mails
        if (Config::get('config_complete_status_id') == $data['order_status_id']) {
            Theme::model('sale/gift_card');
            
            $results = $this->getOrderGiftcards($order_id);
            
            foreach ($results as $result) {
                $this->model_sale_gift_card->sendGiftcard($result['gift_card_id']);
            }
        }
        
        if ($data['notify']) {
			$order_status_query = $this->db->query("
				SELECT * 
				FROM {$this->db->prefix}order_status 
				WHERE order_status_id = '" . (int)$data['order_status_id'] . "' 
				AND language_id = '" . (int)$order_info['language_id'] . "'
			");

			$status = $order_status_query->row['name'];
			$link   = html_entity_decode($order_info['store_url'] . 'account/order/info&order_id=' . $order_id, ENT_QUOTES, 'UTF-8');

			if ($data['comment']):
				$comment = strip_tags(html_entity_decode($data['comment'], ENT_QUOTES, 'UTF-8'));
			else:
				$comment = 'No further comments added.';
			endif;

            $callback = array(
				'customer_id' => $order_info['customer_id'],
				'order_id'    => $order_info['order_id'],
				'order'       => $order_info,
				'status'      => $status,
				'link'        => $link,
				'comment'     => $comment,
				'callback'    => array(
					'class'  => __CLASS__,
					'method' => 'admin_order_add_history'
            	)
            );

            Theme::notify('admin_order_add_history', $callback);
        }
    }
    
    public function getOrderHistories($order_id, $start = 0, $limit = 10) {
        if ($start < 0) {
            $start = 0;
        }
        
        if ($limit < 1) {
            $limit = 10;
        }
        
        $query = $this->db->query("
			SELECT 
				oh.date_added, 
				os.name AS status, 
				oh.comment, 
				oh.notify 
			FROM {$this->db->prefix}order_history oh 
			LEFT JOIN {$this->db->prefix}order_status os 
				ON oh.order_status_id = os.order_status_id 
			WHERE oh.order_id = '" . (int)$order_id . "' 
			AND os.language_id = '" . (int)Config::get('config_language_id') . "' 
			ORDER BY oh.date_added ASC LIMIT " . (int)$start . "," . (int)$limit);
        
        return $query->rows;
    }
    
    public function getTotalOrderHistories($order_id) {
        $query = $this->db->query("
			SELECT 
				COUNT(*) AS total 
			FROM {$this->db->prefix}order_history 
			WHERE order_id = '" . (int)$order_id . "'
		");
        
        return $query->row['total'];
    }
    
    public function getTotalOrderHistoriesByOrderStatusId($order_status_id) {
        $query = $this->db->query("
			SELECT 
				COUNT(*) AS total 
			FROM {$this->db->prefix}order_history 
			WHERE order_status_id = '" . (int)$order_status_id . "'
		");
        
        return $query->row['total'];
    }
    
    public function getCustomersByProductsOrdered($products, $start, $end) {
        $implode = array();
        
        foreach ($products as $product_id) {
            $implode[] = "op.product_id = '" . (int)$product_id . "'";
        }
        
        $query = $this->db->query("
			SELECT DISTINCT customer_id 
			FROM `{$this->db->prefix}order` o 
			LEFT JOIN {$this->db->prefix}order_product op 
				ON (o.order_id = op.order_id) 
			WHERE (" . implode(" OR ", $implode) . ") 
			AND o.order_status_id <> '0' 
			LIMIT " . (int)$start . "," . (int)$end);
        
        return $query->rows;
    }
    
    public function getTotalCustomersByProductsOrdered($products) {
        $implode = array();
        
        foreach ($products as $product_id) {
            $implode[] = "op.product_id = '" . (int)$product_id . "'";
        }
        
        $query = $this->db->query("
			SELECT DISTINCT customer_id 
			FROM `{$this->db->prefix}order` o 
			LEFT JOIN {$this->db->prefix}order_product op 
			ON (o.order_id = op.order_id) 
			WHERE (" . implode(" OR ", $implode) . ") 
			AND o.order_status_id <> '0'
		");
        
        return $query->row['total'];
    }

    public function getShippingModules() {
    	$modules = array();

    	Theme::model('setting/module');
    	$query = $this->model_setting_module->getAll('shipping');

    	foreach ($query as $module):
    		if ($module['status']):
	    		Theme::language('shipping/' . $module['code']);
	    		$modules[] = array(
	    			'code' => $module['code'],
	    			'name' => Lang::get('lang_heading_title')
	    		);
    		endif;
    	endforeach;

    	return $modules;
    }

    public function getPaymentModules() {
    	$modules = array();

    	Theme::model('setting/module');
    	$query = $this->model_setting_module->getAll('payment');

    	foreach ($query as $module):
    		if ($module['status']):
	    		Theme::language('payment/' . $module['code']);
	    		$modules[] = array(
	    			'code' => $module['code'],
	    			'name' => Lang::get('lang_heading_title')
	    		);
    		endif;
    	endforeach;

    	return $modules;
    }

    /*
    |--------------------------------------------------------------------------
    |   NOTIFICATIONS
    |--------------------------------------------------------------------------
    |
    |   The below methods are notification callbacks.
    |	
    */

    public function admin_order_add_history($data, $message) {
    	$search = array(
    		'!order_id!',
    		'!status!',
    		'!link!',
    		'!comment!'
    	);

    	$replace = array(
    		$data['order_id'],
    		$data['status'],
    		$data['link'],
    		$data['comment']
    	);

    	$html_replace = array(
    		$data['order_id'],
    		$data['status'],
    		$data['link'],
    		nl2br($data['comment'])
    	);

    	foreach ($message as $key => $value):
            if ($key == 'html'):
            	$message['html'] = str_replace($search, $html_replace, $value);
            else:
            	$message[$key] = str_replace($search, $replace, $value);
        	endif;
        endforeach;
        
        return $message;
    }
}
