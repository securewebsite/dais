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

namespace App\Models\Front\Checkout;
use App\Models\Model;
use Dais\Library\Template;
use Dais\Library\Text;

class Order extends Model {
    public function addOrder($data) {
        DB::query("
			INSERT INTO `" . DB::prefix() . "order` 
			SET 
				invoice_prefix          = '" . DB::escape($data['invoice_prefix']) . "', 
				store_id                = '" . (int)$data['store_id'] . "', 
				store_name              = '" . DB::escape($data['store_name']) . "', 
				store_url               = '" . DB::escape($data['store_url']) . "', 
				customer_id             = '" . (int)$data['customer_id'] . "', 
				customer_group_id       = '" . (int)$data['customer_group_id'] . "', 
				firstname               = '" . DB::escape($data['firstname']) . "', 
				lastname                = '" . DB::escape($data['lastname']) . "', 
				email                   = '" . DB::escape($data['email']) . "', 
				telephone               = '" . DB::escape($data['telephone']) . "', 
				payment_firstname       = '" . DB::escape($data['payment_firstname']) . "', 
				payment_lastname        = '" . DB::escape($data['payment_lastname']) . "', 
				payment_company         = '" . DB::escape($data['payment_company']) . "', 
				payment_company_id      = '" . DB::escape($data['payment_company_id']) . "', 
				payment_tax_id          = '" . DB::escape($data['payment_tax_id']) . "', 
				payment_address_1       = '" . DB::escape($data['payment_address_1']) . "', 
				payment_address_2       = '" . DB::escape($data['payment_address_2']) . "', 
				payment_city            = '" . DB::escape($data['payment_city']) . "', 
				payment_postcode        = '" . DB::escape($data['payment_postcode']) . "', 
				payment_country         = '" . DB::escape($data['payment_country']) . "', 
				payment_country_id      = '" . (int)$data['payment_country_id'] . "', 
				payment_zone            = '" . DB::escape($data['payment_zone']) . "', 
				payment_zone_id         = '" . (int)$data['payment_zone_id'] . "', 
				payment_address_format  = '" . DB::escape($data['payment_address_format']) . "', 
				payment_method          = '" . DB::escape($data['payment_method']) . "', 
				payment_code            = '" . DB::escape($data['payment_code']) . "', 
				shipping_firstname      = '" . DB::escape($data['shipping_firstname']) . "', 
				shipping_lastname       = '" . DB::escape($data['shipping_lastname']) . "', 
				shipping_company        = '" . DB::escape($data['shipping_company']) . "', 
				shipping_address_1      = '" . DB::escape($data['shipping_address_1']) . "', 
				shipping_address_2      = '" . DB::escape($data['shipping_address_2']) . "', 
				shipping_city           = '" . DB::escape($data['shipping_city']) . "', 
				shipping_postcode       = '" . DB::escape($data['shipping_postcode']) . "', 
				shipping_country        = '" . DB::escape($data['shipping_country']) . "', 
				shipping_country_id     = '" . (int)$data['shipping_country_id'] . "', 
				shipping_zone           = '" . DB::escape($data['shipping_zone']) . "', 
				shipping_zone_id        = '" . (int)$data['shipping_zone_id'] . "', 
				shipping_address_format = '" . DB::escape($data['shipping_address_format']) . "', 
				shipping_method         = '" . DB::escape($data['shipping_method']) . "', 
				shipping_code           = '" . DB::escape($data['shipping_code']) . "', 
				comment                 = '" . DB::escape($data['comment']) . "', 
				total                   = '" . (float)$data['total'] . "', 
				affiliate_id            = '" . (int)$data['affiliate_id'] . "', 
				commission              = '" . (float)$data['commission'] . "', 
				language_id             = '" . (int)$data['language_id'] . "', 
				currency_id             = '" . (int)$data['currency_id'] . "', 
				currency_code           = '" . DB::escape($data['currency_code']) . "', 
				currency_value          = '" . (float)$data['currency_value'] . "', 
				ip                      = '" . DB::escape($data['ip']) . "', 
				forwarded_ip            = '" . DB::escape($data['forwarded_ip']) . "', 
				user_agent              = '" . DB::escape($data['user_agent']) . "', 
				accept_language         = '" . DB::escape($data['accept_language']) . "', 
				date_added              = NOW(), 
				date_modified           = NOW()
		");
        
        $order_id = DB::getLastId();
        
        foreach ($data['products'] as $product):
            DB::query("
				INSERT INTO " . DB::prefix() . "order_product 
				SET 
					order_id   = '" . (int)$order_id . "', 
					product_id = '" . (int)$product['product_id'] . "', 
					name       = '" . DB::escape($product['name']) . "', 
					model      = '" . DB::escape($product['model']) . "', 
					quantity   = '" . (int)$product['quantity'] . "', 
					price      = '" . (float)$product['price'] . "', 
					total      = '" . (float)$product['total'] . "', 
					tax        = '" . (float)$product['tax'] . "', 
					reward     = '" . (int)$product['reward'] . "'
			");
            
            $order_product_id = DB::getLastId();
            
            foreach ($product['option'] as $option):
                DB::query("
					INSERT INTO " . DB::prefix() . "order_option 
					SET 
						order_id                = '" . (int)$order_id . "', 
						order_product_id        = '" . (int)$order_product_id . "', 
						product_option_id       = '" . (int)$option['product_option_id'] . "', 
						product_option_value_id = '" . (int)$option['product_option_value_id'] . "', 
						name                    = '" . DB::escape($option['name']) . "', 
						`value`                 = '" . DB::escape($option['value']) . "', 
						`type`                  = '" . DB::escape($option['type']) . "'
				");
            endforeach;
            
            foreach ($product['download'] as $download):
                DB::query("
					INSERT INTO " . DB::prefix() . "order_download 
					SET 
						order_id         = '" . (int)$order_id . "', 
						order_product_id = '" . (int)$order_product_id . "', 
						name             = '" . DB::escape($download['name']) . "', 
						filename         = '" . DB::escape($download['filename']) . "', 
						mask             = '" . DB::escape($download['mask']) . "', 
						remaining        = '" . (int)($download['remaining'] * $product['quantity']) . "'
				");
            endforeach;
        endforeach;
        
        foreach ($data['gift_cards'] as $gift_card):
            DB::query("
				INSERT INTO " . DB::prefix() . "order_gift_card 
				SET 
					order_id          = '" . (int)$order_id . "', 
					description       = '" . DB::escape($gift_card['description']) . "', 
					code              = '" . DB::escape($gift_card['code']) . "', 
					from_name         = '" . DB::escape($gift_card['from_name']) . "', 
					from_email        = '" . DB::escape($gift_card['from_email']) . "', 
					to_name           = '" . DB::escape($gift_card['to_name']) . "', 
					to_email          = '" . DB::escape($gift_card['to_email']) . "', 
					gift_card_theme_id = '" . (int)$gift_card['gift_card_theme_id'] . "', 
					message           = '" . DB::escape($gift_card['message']) . "', 
					amount            = '" . (float)$gift_card['amount'] . "'
			");
        endforeach;
        
        foreach ($data['totals'] as $total):
            DB::query("
				INSERT INTO " . DB::prefix() . "order_total 
				SET 
					order_id   = '" . (int)$order_id . "', 
					code       = '" . DB::escape($total['code']) . "', 
					title      = '" . DB::escape($total['title']) . "', 
					text       = '" . DB::escape($total['text']) . "', 
					`value`    = '" . (float)$total['value'] . "', 
					sort_order = '" . (int)$total['sort_order'] . "'
			");
        endforeach;
        
        Theme::trigger('front_order_add', array('order_id' => $order_id));
        
        return $order_id;
    }
    
    public function getOrder($order_id) {
        $order_query = DB::query("
			SELECT *, 
				(SELECT os.name 
				FROM `" . DB::prefix() . "order_status` os 
				WHERE os.order_status_id = o.order_status_id 
				AND os.language_id = o.language_id) AS order_status 
			FROM `" . DB::prefix() . "order` o 
			WHERE o.order_id = '" . (int)$order_id . "'
		");
        
        if ($order_query->num_rows):
            $country_query = DB::query("
				SELECT * 
				FROM `" . DB::prefix() . "country` 
				WHERE country_id = '" . (int)$order_query->row['payment_country_id'] . "'
			");
            
            if ($country_query->num_rows):
                $payment_iso_code_2 = $country_query->row['iso_code_2'];
                $payment_iso_code_3 = $country_query->row['iso_code_3'];
            else:
                $payment_iso_code_2 = '';
                $payment_iso_code_3 = '';
            endif;
            
            $zone_query = DB::query("
				SELECT * 
				FROM `" . DB::prefix() . "zone` 
				WHERE zone_id = '" . (int)$order_query->row['payment_zone_id'] . "'
			");
            
            if ($zone_query->num_rows):
                $payment_zone_code = $zone_query->row['code'];
            else:
                $payment_zone_code = '';
            endif;
            
            $country_query = DB::query("
				SELECT * 
				FROM `" . DB::prefix() . "country` 
				WHERE country_id = '" . (int)$order_query->row['shipping_country_id'] . "'
			");
            
            if ($country_query->num_rows):
                $shipping_iso_code_2 = $country_query->row['iso_code_2'];
                $shipping_iso_code_3 = $country_query->row['iso_code_3'];
            else:
                $shipping_iso_code_2 = '';
                $shipping_iso_code_3 = '';
            endif;
            
            $zone_query = DB::query("
				SELECT * 
				FROM `" . DB::prefix() . "zone` 
				WHERE zone_id = '" . (int)$order_query->row['shipping_zone_id'] . "'
			");
            
            if ($zone_query->num_rows):
                $shipping_zone_code = $zone_query->row['code'];
            else:
                $shipping_zone_code = '';
            endif;
            
            Theme::model('locale/language');
            
            $language_info = LocaleLanguage::getLanguage($order_query->row['language_id']);
            
            if ($language_info):
				$language_code      = $language_info['code'];
				$language_filename  = $language_info['filename'];
				$language_directory = $language_info['directory'];
            else:
				$language_code      = '';
				$language_filename  = '';
				$language_directory = '';
            endif;
            
            return array(
				'order_id'                => $order_query->row['order_id'], 
				'invoice_no'              => $order_query->row['invoice_no'], 
				'invoice_prefix'          => $order_query->row['invoice_prefix'], 
				'store_id'                => $order_query->row['store_id'], 
				'store_name'              => $order_query->row['store_name'], 
				'store_url'               => $order_query->row['store_url'], 
				'customer_id'             => $order_query->row['customer_id'], 
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
				'affiliate_id'            => $order_query->row['affiliate_id'], 
				'commission'              => $order_query->row['commission'], 
				'order_status_id'         => $order_query->row['order_status_id'], 
				'order_status'            => $order_query->row['order_status'], 
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
				'date_modified'           => $order_query->row['date_modified'], 
				'date_added'              => $order_query->row['date_added']
            );
        else:
            return false;
        endif;
    }
    
    public function confirm($order_id, $order_status_id, $comment = '', $notify = true) {
        $order_info = $this->getOrder($order_id);
        
        if ($order_info/* && !$order_info['order_status_id']*/):
            
            // Create an array to hold queries so we can pass them
            // to our notification callback.

        	$temp = array();

            // Fraud Detection
            if (Config::get('config_fraud_detection')):
                Theme::model('checkout/fraud');
                $risk_score = CheckoutFraud::getFraudScore($order_info);
                if ($risk_score > Config::get('config_fraud_score')):
                    $order_status_id = Config::get('config_fraud_status_id');
                endif;
            endif;
            
            // Ban IP
            $status = false;
            
            Theme::model('account/customer');
            
            if ($order_info['customer_id']):
                $results = AccountCustomer::getIps($order_info['customer_id']);
                foreach ($results as $result):
                    if (AccountCustomer::isBanIp($result['ip'])):
                        $status = true;
                        break;
                    endif;
                endforeach;
            else:
                $status = AccountCustomer::isBanIp($order_info['ip']);
            endif;
            
            if ($status):
                $order_status_id = Config::get('config_order_status_id');
            endif;
            
            DB::query("
				UPDATE `" . DB::prefix() . "order` 
				SET 
					order_status_id = '" . (int)$order_status_id . "', 
					date_modified   = NOW() 
				WHERE order_id = '" . (int)$order_id . "'
			");
            
            DB::query("
				INSERT INTO " . DB::prefix() . "order_history 
				SET 
					order_id        = '" . (int)$order_id . "', 
					order_status_id = '" . (int)$order_status_id . "', 
					notify          = '1', 
					comment         = '" . DB::escape(($comment) ? $comment : '') . "', 
					date_added      = NOW()
			");
            
            $order_product_query = DB::query("
				SELECT * 
				FROM " . DB::prefix() . "order_product 
				WHERE order_id = '" . (int)$order_id . "'
			");

			$temp['products'] = array();
            
            // loop products and create an array to
            // pass to the customer class
            
            $product_ids = array();
            
            foreach ($order_product_query->rows as $row):
                $product_ids[] = $row['product_id'];
            endforeach;
            
            Customer::processMembership($product_ids);
            
            unset($product_ids);
            
            $product_reward = 0;
            
            foreach ($order_product_query->rows as $order_product):
                $event_query = DB::query("
					SELECT event_id 
					FROM " . DB::prefix() . "product 
					WHERE product_id = '" . (int)$order_product['product_id'] . "'");
                
                if ($event_query->row['event_id'] > 0):
                    $roster = array();
                    
                    $rosters = DB::query("
						SELECT roster 
						FROM " . DB::prefix() . "event_manager 
						WHERE event_id = '" . (int)$event_query->row['event_id'] . "'");
                    
                    if (!empty($rosters->row['roster'])):
                        foreach (unserialize($rosters->row['roster']) as $row):
                            $roster[] = array(
                            	'attendee_id' => $row['attendee_id'], 
                            	'date_added'  => $row['date_added']
                            );
                        endforeach;
                        
                        $roster[] = array(
                        	'attendee_id' => $order_info['customer_id'], 
                        	'date_added'  => time()
                        );
                    else:
                        $roster[] = array(
                        	'attendee_id' => $order_info['customer_id'], 
                        	'date_added'  => time()
                        );
                    endif;
                    
                    DB::query("
						UPDATE " . DB::prefix() . "event_manager 
						SET 
							filled = (filled + " . (int)$order_product['quantity'] . "), 
							roster = '" . DB::escape(serialize($roster)) . "' 
						WHERE event_id = '" . (int)$event_query->row['event_id'] . "'");
                    
                    DB::query("
						DELETE FROM " . DB::prefix() . "event_wait_list 
						WHERE event_id  = '" . (int)$event_query->row['event_id'] . "' 
						AND customer_id = '" . (int)Customer::getId() . "'");
                endif;
                
                $product_reward += $order_product['reward'];
                
                DB::query("
					UPDATE " . DB::prefix() . "product 
					SET 
						quantity = (quantity - " . (int)$order_product['quantity'] . ") 
					WHERE product_id = '" . (int)$order_product['product_id'] . "' 
					AND subtract = '1'
				");
                
                $order_option_query = DB::query("
					SELECT * 
					FROM " . DB::prefix() . "order_option 
					WHERE order_id = '" . (int)$order_id . "' 
					AND order_product_id = '" . (int)$order_product['order_product_id'] . "'
				");

				$item = $order_product;
				$item['options'] = $order_option_query->rows;
				$temp['products'][] = $item;
                
                foreach ($order_option_query->rows as $option):
                    DB::query("
						UPDATE " . DB::prefix() . "product_option_value 
						SET 
							quantity = (quantity - " . (int)$order_product['quantity'] . ") 
						WHERE product_option_value_id = '" . (int)$option['product_option_value_id'] . "' 
						AND subtract = '1'
					");
                endforeach;
            endforeach;
            
            $this->cache->delete('products.popular');
            
            // Downloads
            $order_download_query = DB::query("
				SELECT * 
				FROM " . DB::prefix() . "order_download 
				WHERE order_id = '" . (int)$order_id . "'
			");

			$temp['downloads'] = $order_download_query->rows;
            
            // Gift Giftcard
            Theme::model('checkout/gift_card');
            
            $order_gift_card_query = DB::query("
				SELECT * 
				FROM " . DB::prefix() . "order_gift_card 
				WHERE order_id = '" . (int)$order_id . "'
			");
            
            $temp['gift_cards'] = $order_gift_card_query->rows;

            foreach ($order_gift_card_query->rows as $order_gift_card):
                $gift_card_id = CheckoutGiftCard::addGiftcard($order_id, $order_gift_card);
                DB::query("
					UPDATE " . DB::prefix() . "order_gift_card 
					SET 
						gift_card_id = '" . (int)$gift_card_id . "' 
					WHERE order_gift_card_id = '" . (int)$order_gift_card['order_gift_card_id'] . "'
				");
            endforeach;
            
            // Send out any gift gift_card mails
            if (Config::get('config_complete_status_id') == $order_status_id):
                CheckoutGiftCard::confirm($order_id);
            endif;
            
            // Order Totals
            $order_total_query = DB::query("
				SELECT * 
				FROM `" . DB::prefix() . "order_total` 
				WHERE order_id = '" . (int)$order_id . "' 
				ORDER BY sort_order ASC
			");

			$temp['totals'] = $order_total_query->rows;
            
            foreach ($order_total_query->rows as $order_total):
                Theme::model('total/' . $order_total['code']);
                if (method_exists($this->{'model_total_' . $order_total['code']}, 'confirm')):
                    $this->{'model_total_' . $order_total['code']}->confirm($order_info, $order_total);
                endif;
            endforeach;
            
            Theme::language('checkout/order');
            
            $order_status_query = DB::query("
				SELECT * 
				FROM " . DB::prefix() . "order_status 
				WHERE order_status_id = '" . (int)$order_status_id . "' 
				AND language_id = '" . (int)$order_info['language_id'] . "'
			");

			$temp['status'] = $order_status_query->row['name'];
            
            // Add Reward
            if ($product_reward && ($order_status_id == Config::get('config_order_status_id'))):
                $description = sprintf(Lang::get('lang_text_reward'), $product_reward, $order_id);
                Customer::addReward($order_info['customer_id'], $description, $product_reward, $order_id);
            endif;

            // Add commission
            if (isset($order_info['affiliate_id']) && isset($order_info['commission'])):
				$commission  = Currency::format($order_info['commission']);
				$description = sprintf(Lang::get('lang_text_commission'), $commission, $order_id);
            	Customer::addCommission($order_info['affiliate_id'], $order_id, $description, $order_info['commission']);
            endif;
            
            $callback = array(
				'customer_id' => $order_info['customer_id'],
				'order_id'    => $order_id,
				'order'       => $order_info,
				'query'       => $temp,
				'callback'    => array(
					'class'  => __CLASS__,
					'method' => 'public_customer_order_confirm'
            	)
            );

            Theme::notify('public_customer_order_confirm', $callback);

            // Admin Alert Mail
            if (Config::get('config_alert_mail')):
            	// Build additional emails array to Cc: these emails.
	            $cc = array();

	            if (Config::get('config_alert_emails')):
	                $emails = explode(',', Config::get('config_alert_emails'));
	                foreach ($emails as $email):
	                    if (strlen($email) > 0 && preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $email)):
	                       $cc[] = trim($email);
	                    endif;
	                endforeach;
	            endif;
	            
	            Theme::notify('public_admin_order_confirm', array('user_id' => Config::get('config_admin_email_user')), $cc);
            endif;
            
            Theme::trigger('front_order_confirm', array('order_id' => $order_id));
        endif;
    }
    
    public function update($order_id, $order_status_id, $comment = '') {
        $order_info = $this->getOrder($order_id);
        
        if ($order_info && $order_info['order_status_id']):
            
            // Fraud Detection
            if (Config::get('config_fraud_detection')):
                Theme::model('checkout/fraud');
                $risk_score = CheckoutFraud::getFraudScore($order_info);
                if ($risk_score > Config::get('config_fraud_score')):
                    $order_status_id = Config::get('config_fraud_status_id');
                endif;
            endif;
            
            // Ban IP
            $status = false;
            
            Theme::model('account/customer');
            
            if ($order_info['customer_id']):
                $results = AccountCustomer::getIps($order_info['customer_id']);
                foreach ($results as $result):
                    if (AccountCustomer::isBanIp($result['ip'])):
                        $status = true;
                        break;
                    endif;
                endforeach;
            else:
                $status = AccountCustomer::isBanIp($order_info['ip']);
            endif;
            
            if ($status):
                $order_status_id = Config::get('config_order_status_id');
            endif;
            
            DB::query("
				UPDATE `" . DB::prefix() . "order` 
				SET 
					order_status_id = '" . (int)$order_status_id . "', 
					date_modified   = NOW() 
				WHERE order_id = '" . (int)$order_id . "'
			");
            
            DB::query("
				INSERT INTO " . DB::prefix() . "order_history 
				SET 
					order_id        = '" . (int)$order_id . "', 
					order_status_id = '" . (int)$order_status_id . "', 
					notify          = '" . (int)$notify . "', 
					comment         = '" . DB::escape($comment) . "', 
					date_added      = NOW()
			");
            
            // Send out any gift gift_card mails
            if (Config::get('config_complete_status_id') == $order_status_id):
                Theme::model('checkout/gift_card');
                CheckoutGiftCard::confirm($order_id);
            endif;
            
            Theme::trigger('front_order_update', array('order_id' => $order_id));
        endif;
    }

    /*
    |--------------------------------------------------------------------------
    |   NOTIFICATIONS
    |--------------------------------------------------------------------------
    |
    |   Below are notification callbacks.
    |
    */

    public function public_customer_order_confirm($data, $message) {
    	$call = $data;
    	unset ($data);
    	
    	$order_info = $call['order'];

    	$data = Theme::language('notification/order');

    	Theme::model('catalog/product');
    	Theme::model('tool/image');

		$data['store_name']  = $order_info['store_name'];
		$data['store_url']   = $order_info['store_url'];
		$data['customer_id'] = $order_info['customer_id'];
		$data['link']        = $order_info['store_url'] . 'account/order/info&order_id=' . $call['order_id'];
            
        if ($call['query']['downloads']):
            $data['download'] = $order_info['store_url'] . 'account/download';
        else:
            $data['download'] = '';
        endif;
        
		$data['order_id']        = $call['order_id'];
		$data['date_added']      = date(Lang::get('lang_date_format_short'), strtotime($order_info['date_added']));
		$data['payment_method']  = $order_info['payment_method'];
		$data['shipping_method'] = $order_info['shipping_method'];
		$data['email']           = $order_info['email'];
		$data['telephone']       = $order_info['telephone'];
		$data['ip']              = $order_info['ip'];
		$data['table_quantity']  = true;
        
        $data['order_status'] = $call['query']['status'];
		

	    if ($order_info['comment']):
            $data['comment'] = strip_tags(html_entity_decode($order_info['comment'], ENT_QUOTES, 'UTF-8'));
        else:
            $data['comment'] = '';
        endif;
        
        if ($order_info['payment_address_format']):
            $format = $order_info['payment_address_format'];
        else:
            $format = 
        		'{firstname} {lastname}' . "\n" . 
        		'{company}' . "\n" . 
        		'{address_1}' . "\n" . 
        		'{address_2}' . "\n" . 
        		'{city} {postcode}' . "\n" . 
        		'{zone}' . "\n" . 
        		'{country}';
        endif;
        
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
        
        $data['html_payment_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', 
        		preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', 
        			trim(str_replace($find, $replace, $format))));

        $data['text_payment_address'] = preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), "\n", trim(str_replace($find, $replace, $format)));
        
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
        
        $data['html_shipping_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', 
        	preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', 
        		trim(str_replace($find, $replace, $format))));

        $data['text_shipping_address'] = preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), "\n", trim(str_replace($find, $replace, $format)));

        // Products
		$data['products'] = array();
		$products         = $call['query']['products'];

        $has_link = false;
        
        foreach ($products as $product):
            $product_data = CatalogProduct::getProduct($product['product_id']);
            if (isset($product_data['image'])):
                $image = ToolImage::resize($product_data['image'], 50, 50);
            else:
                $image = '';
            endif;
            
            if ($product_data['event_id']):
                $event = CatalogProduct::getEvent($product_data['event_id']);
                if ($event['link']):
                    $has_link = true;
                    $link = sprintf($language->get('text_online_link'), $event['link']);
                else:
                    $link = '';
                endif;
            else:
                $link = '';
            endif;
            
            $option_data = array();
            
            foreach ($product['options'] as $option):
                if ($option['type'] == 'file'):
                	$value = $this->encode->substr($option['value'], 0, $this->encode->strrpos($option['value'], '.'));
                elseif ($option['type'] == 'date' || $option['type'] == 'time' || $option['type'] == 'datetime'):
                	$value = date(Lang::get('lang_date_format_short'), strtotime($option['value']));
                else:
                    $value = $option['value'];
                endif;
                
                $option_data[] = array(
                	'name'  => $option['name'], 
                	'value' => ($this->encode->strlen($value) > 20 ? $this->encode->substr($value, 0, 20) . '..' : $value)
                );
            endforeach;
            
            $data['products'][] = array(
				'image'            => $image, 
				'order_product_id' => $product['order_product_id'], 
				'link'             => $link, 
				'product_id'       => $product['product_id'], 
				'weight'           => $product_data['weight'], 
				'weight_fvalue'    => $this->weight->format($product_data['weight'], $product_data['weight_class_id']), 
				'sku'              => $product_data['sku'], 
				'stock_quantity'   => $product_data['quantity'], 
				'stock_status'     => $product_data['stock_status'], 
				'url'              => Url::link('catalog/product', 'product_id=' . $product['product_id'], 'SSL'), 
				'name'             => $product['name'], 
				'model'            => $product['model'], 
				'option'           => $option_data, 
				'quantity'         => $product['quantity'], 
				'price'            => Currency::format($product['price'] + (Config::get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']), 
				'total'            => Currency::format($product['total'] + (Config::get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value'])
            );
        endforeach;
        
        $data['has_link'] = $has_link;
        
        // Gift cards
		$data['gift_cards'] = array();
		$gift_cards         = $call['query']['gift_cards'];
        
        foreach ($gift_cards as $gift_card):
            $data['gift_cards'][] = array(
				'description' => $gift_card['description'], 
				'amount'      => Currency::format($gift_card['amount'], $order_info['currency_code'], $order_info['currency_value'])
            );
        endforeach;
        
        $data['totals'] = $call['query']['totals'];
        
        $html = new Template;
        $html->data = $data;
        $html = $html->fetch('notification/order');

    	$text = new Text;
        $text->data = $data;
        $text = $text->fetch('notification/order');

        $message['html'] = str_replace('!content!', $html, $message['html']);
        $message['text'] = str_replace('!content!', $text, $message['text']);
        
       	return $message;

	}
}
