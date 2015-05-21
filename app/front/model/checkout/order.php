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

namespace Front\Model\Checkout;
use Dais\Engine\Model;
use Dais\Library\Template;
use Dais\Library\Text;

class Order extends Model {
    public function addOrder($data) {
        $this->db->query("
			INSERT INTO `{$this->db->prefix}order` 
			SET 
				invoice_prefix          = '" . $this->db->escape($data['invoice_prefix']) . "', 
				store_id                = '" . (int)$data['store_id'] . "', 
				store_name              = '" . $this->db->escape($data['store_name']) . "', 
				store_url               = '" . $this->db->escape($data['store_url']) . "', 
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
				payment_country         = '" . $this->db->escape($data['payment_country']) . "', 
				payment_country_id      = '" . (int)$data['payment_country_id'] . "', 
				payment_zone            = '" . $this->db->escape($data['payment_zone']) . "', 
				payment_zone_id         = '" . (int)$data['payment_zone_id'] . "', 
				payment_address_format  = '" . $this->db->escape($data['payment_address_format']) . "', 
				payment_method          = '" . $this->db->escape($data['payment_method']) . "', 
				payment_code            = '" . $this->db->escape($data['payment_code']) . "', 
				shipping_firstname      = '" . $this->db->escape($data['shipping_firstname']) . "', 
				shipping_lastname       = '" . $this->db->escape($data['shipping_lastname']) . "', 
				shipping_company        = '" . $this->db->escape($data['shipping_company']) . "', 
				shipping_address_1      = '" . $this->db->escape($data['shipping_address_1']) . "', 
				shipping_address_2      = '" . $this->db->escape($data['shipping_address_2']) . "', 
				shipping_city           = '" . $this->db->escape($data['shipping_city']) . "', 
				shipping_postcode       = '" . $this->db->escape($data['shipping_postcode']) . "', 
				shipping_country        = '" . $this->db->escape($data['shipping_country']) . "', 
				shipping_country_id     = '" . (int)$data['shipping_country_id'] . "', 
				shipping_zone           = '" . $this->db->escape($data['shipping_zone']) . "', 
				shipping_zone_id        = '" . (int)$data['shipping_zone_id'] . "', 
				shipping_address_format = '" . $this->db->escape($data['shipping_address_format']) . "', 
				shipping_method         = '" . $this->db->escape($data['shipping_method']) . "', 
				shipping_code           = '" . $this->db->escape($data['shipping_code']) . "', 
				comment                 = '" . $this->db->escape($data['comment']) . "', 
				total                   = '" . (float)$data['total'] . "', 
				affiliate_id            = '" . (int)$data['affiliate_id'] . "', 
				commission              = '" . (float)$data['commission'] . "', 
				language_id             = '" . (int)$data['language_id'] . "', 
				currency_id             = '" . (int)$data['currency_id'] . "', 
				currency_code           = '" . $this->db->escape($data['currency_code']) . "', 
				currency_value          = '" . (float)$data['currency_value'] . "', 
				ip                      = '" . $this->db->escape($data['ip']) . "', 
				forwarded_ip            = '" . $this->db->escape($data['forwarded_ip']) . "', 
				user_agent              = '" . $this->db->escape($data['user_agent']) . "', 
				accept_language         = '" . $this->db->escape($data['accept_language']) . "', 
				date_added              = NOW(), 
				date_modified           = NOW()
		");
        
        $order_id = $this->db->getLastId();
        
        foreach ($data['products'] as $product):
            $this->db->query("
				INSERT INTO {$this->db->prefix}order_product 
				SET 
					order_id   = '" . (int)$order_id . "', 
					product_id = '" . (int)$product['product_id'] . "', 
					name       = '" . $this->db->escape($product['name']) . "', 
					model      = '" . $this->db->escape($product['model']) . "', 
					quantity   = '" . (int)$product['quantity'] . "', 
					price      = '" . (float)$product['price'] . "', 
					total      = '" . (float)$product['total'] . "', 
					tax        = '" . (float)$product['tax'] . "', 
					reward     = '" . (int)$product['reward'] . "'
			");
            
            $order_product_id = $this->db->getLastId();
            
            foreach ($product['option'] as $option):
                $this->db->query("
					INSERT INTO {$this->db->prefix}order_option 
					SET 
						order_id                = '" . (int)$order_id . "', 
						order_product_id        = '" . (int)$order_product_id . "', 
						product_option_id       = '" . (int)$option['product_option_id'] . "', 
						product_option_value_id = '" . (int)$option['product_option_value_id'] . "', 
						name                    = '" . $this->db->escape($option['name']) . "', 
						`value`                 = '" . $this->db->escape($option['value']) . "', 
						`type`                  = '" . $this->db->escape($option['type']) . "'
				");
            endforeach;
            
            foreach ($product['download'] as $download):
                $this->db->query("
					INSERT INTO {$this->db->prefix}order_download 
					SET 
						order_id         = '" . (int)$order_id . "', 
						order_product_id = '" . (int)$order_product_id . "', 
						name             = '" . $this->db->escape($download['name']) . "', 
						filename         = '" . $this->db->escape($download['filename']) . "', 
						mask             = '" . $this->db->escape($download['mask']) . "', 
						remaining        = '" . (int)($download['remaining'] * $product['quantity']) . "'
				");
            endforeach;
        endforeach;
        
        foreach ($data['gift_cards'] as $gift_card):
            $this->db->query("
				INSERT INTO {$this->db->prefix}order_gift_card 
				SET 
					order_id          = '" . (int)$order_id . "', 
					description       = '" . $this->db->escape($gift_card['description']) . "', 
					code              = '" . $this->db->escape($gift_card['code']) . "', 
					from_name         = '" . $this->db->escape($gift_card['from_name']) . "', 
					from_email        = '" . $this->db->escape($gift_card['from_email']) . "', 
					to_name           = '" . $this->db->escape($gift_card['to_name']) . "', 
					to_email          = '" . $this->db->escape($gift_card['to_email']) . "', 
					gift_card_theme_id = '" . (int)$gift_card['gift_card_theme_id'] . "', 
					message           = '" . $this->db->escape($gift_card['message']) . "', 
					amount            = '" . (float)$gift_card['amount'] . "'
			");
        endforeach;
        
        foreach ($data['totals'] as $total):
            $this->db->query("
				INSERT INTO {$this->db->prefix}order_total 
				SET 
					order_id   = '" . (int)$order_id . "', 
					code       = '" . $this->db->escape($total['code']) . "', 
					title      = '" . $this->db->escape($total['title']) . "', 
					text       = '" . $this->db->escape($total['text']) . "', 
					`value`    = '" . (float)$total['value'] . "', 
					sort_order = '" . (int)$total['sort_order'] . "'
			");
        endforeach;
        
        $this->theme->trigger('front_order_add', array('order_id' => $order_id));
        
        return $order_id;
    }
    
    public function getOrder($order_id) {
        $order_query = $this->db->query("
			SELECT *, 
				(SELECT os.name 
				FROM `{$this->db->prefix}order_status` os 
				WHERE os.order_status_id = o.order_status_id 
				AND os.language_id = o.language_id) AS order_status 
			FROM `{$this->db->prefix}order` o 
			WHERE o.order_id = '" . (int)$order_id . "'
		");
        
        if ($order_query->num_rows):
            $country_query = $this->db->query("
				SELECT * 
				FROM `{$this->db->prefix}country` 
				WHERE country_id = '" . (int)$order_query->row['payment_country_id'] . "'
			");
            
            if ($country_query->num_rows):
                $payment_iso_code_2 = $country_query->row['iso_code_2'];
                $payment_iso_code_3 = $country_query->row['iso_code_3'];
            else:
                $payment_iso_code_2 = '';
                $payment_iso_code_3 = '';
            endif;
            
            $zone_query = $this->db->query("
				SELECT * 
				FROM `{$this->db->prefix}zone` 
				WHERE zone_id = '" . (int)$order_query->row['payment_zone_id'] . "'
			");
            
            if ($zone_query->num_rows):
                $payment_zone_code = $zone_query->row['code'];
            else:
                $payment_zone_code = '';
            endif;
            
            $country_query = $this->db->query("
				SELECT * 
				FROM `{$this->db->prefix}country` 
				WHERE country_id = '" . (int)$order_query->row['shipping_country_id'] . "'
			");
            
            if ($country_query->num_rows):
                $shipping_iso_code_2 = $country_query->row['iso_code_2'];
                $shipping_iso_code_3 = $country_query->row['iso_code_3'];
            else:
                $shipping_iso_code_2 = '';
                $shipping_iso_code_3 = '';
            endif;
            
            $zone_query = $this->db->query("
				SELECT * 
				FROM `{$this->db->prefix}zone` 
				WHERE zone_id = '" . (int)$order_query->row['shipping_zone_id'] . "'
			");
            
            if ($zone_query->num_rows):
                $shipping_zone_code = $zone_query->row['code'];
            else:
                $shipping_zone_code = '';
            endif;
            
            $this->theme->model('localization/language');
            
            $language_info = $this->model_localization_language->getLanguage($order_query->row['language_id']);
            
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
            if ($this->config->get('config_fraud_detection')):
                $this->theme->model('checkout/fraud');
                $risk_score = $this->model_checkout_fraud->getFraudScore($order_info);
                if ($risk_score > $this->config->get('config_fraud_score')):
                    $order_status_id = $this->config->get('config_fraud_status_id');
                endif;
            endif;
            
            // Ban IP
            $status = false;
            
            $this->theme->model('account/customer');
            
            if ($order_info['customer_id']):
                $results = $this->model_account_customer->getIps($order_info['customer_id']);
                foreach ($results as $result):
                    if ($this->model_account_customer->isBanIp($result['ip'])):
                        $status = true;
                        break;
                    endif;
                endforeach;
            else:
                $status = $this->model_account_customer->isBanIp($order_info['ip']);
            endif;
            
            if ($status):
                $order_status_id = $this->config->get('config_order_status_id');
            endif;
            
            $this->db->query("
				UPDATE `{$this->db->prefix}order` 
				SET 
					order_status_id = '" . (int)$order_status_id . "', 
					date_modified   = NOW() 
				WHERE order_id = '" . (int)$order_id . "'
			");
            
            $this->db->query("
				INSERT INTO {$this->db->prefix}order_history 
				SET 
					order_id        = '" . (int)$order_id . "', 
					order_status_id = '" . (int)$order_status_id . "', 
					notify          = '1', 
					comment         = '" . $this->db->escape(($comment) ? $comment : '') . "', 
					date_added      = NOW()
			");
            
            $order_product_query = $this->db->query("
				SELECT * 
				FROM {$this->db->prefix}order_product 
				WHERE order_id = '" . (int)$order_id . "'
			");

			$temp['products'] = array();
            
            // loop products and create an array to
            // pass to the customer class
            
            $product_ids = array();
            
            foreach ($order_product_query->rows as $row):
                $product_ids[] = $row['product_id'];
            endforeach;
            
            $this->customer->processMembership($product_ids);
            
            unset($product_ids);
            
            $product_reward = 0;
            
            foreach ($order_product_query->rows as $order_product):
                $event_query = $this->db->query("
					SELECT event_id 
					FROM {$this->db->prefix}product 
					WHERE product_id = '" . (int)$order_product['product_id'] . "'");
                
                if ($event_query->row['event_id'] > 0):
                    $roster = array();
                    
                    $rosters = $this->db->query("
						SELECT roster 
						FROM {$this->db->prefix}event_manager 
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
                    
                    $this->db->query("
						UPDATE {$this->db->prefix}event_manager 
						SET 
							filled = (filled + " . (int)$order_product['quantity'] . "), 
							roster = '" . $this->db->escape(serialize($roster)) . "' 
						WHERE event_id = '" . (int)$event_query->row['event_id'] . "'");
                    
                    $this->db->query("
						DELETE FROM {$this->db->prefix}event_wait_list 
						WHERE event_id  = '" . (int)$event_query->row['event_id'] . "' 
						AND customer_id = '" . (int)$this->customer->getId() . "'");
                endif;
                
                $product_reward += $order_product['reward'];
                
                $this->db->query("
					UPDATE {$this->db->prefix}product 
					SET 
						quantity = (quantity - " . (int)$order_product['quantity'] . ") 
					WHERE product_id = '" . (int)$order_product['product_id'] . "' 
					AND subtract = '1'
				");
                
                $order_option_query = $this->db->query("
					SELECT * 
					FROM {$this->db->prefix}order_option 
					WHERE order_id = '" . (int)$order_id . "' 
					AND order_product_id = '" . (int)$order_product['order_product_id'] . "'
				");

				$item = $order_product;
				$item['options'] = $order_option_query->rows;
				$temp['products'][] = $item;
                
                foreach ($order_option_query->rows as $option):
                    $this->db->query("
						UPDATE {$this->db->prefix}product_option_value 
						SET 
							quantity = (quantity - " . (int)$order_product['quantity'] . ") 
						WHERE product_option_value_id = '" . (int)$option['product_option_value_id'] . "' 
						AND subtract = '1'
					");
                endforeach;
            endforeach;
            
            $this->cache->delete('products.popular');
            
            // Downloads
            $order_download_query = $this->db->query("
				SELECT * 
				FROM {$this->db->prefix}order_download 
				WHERE order_id = '" . (int)$order_id . "'
			");

			$temp['downloads'] = $order_download_query->rows;
            
            // Gift Giftcard
            $this->theme->model('checkout/gift_card');
            
            $order_gift_card_query = $this->db->query("
				SELECT * 
				FROM {$this->db->prefix}order_gift_card 
				WHERE order_id = '" . (int)$order_id . "'
			");
            
            $temp['gift_cards'] = $order_gift_card_query->rows;

            foreach ($order_gift_card_query->rows as $order_gift_card):
                $gift_card_id = $this->model_checkout_gift_card->addGiftcard($order_id, $order_gift_card);
                $this->db->query("
					UPDATE {$this->db->prefix}order_gift_card 
					SET 
						gift_card_id = '" . (int)$gift_card_id . "' 
					WHERE order_gift_card_id = '" . (int)$order_gift_card['order_gift_card_id'] . "'
				");
            endforeach;
            
            // Send out any gift gift_card mails
            if ($this->config->get('config_complete_status_id') == $order_status_id):
                $this->model_checkout_gift_card->confirm($order_id);
            endif;
            
            // Order Totals
            $order_total_query = $this->db->query("
				SELECT * 
				FROM `{$this->db->prefix}order_total` 
				WHERE order_id = '" . (int)$order_id . "' 
				ORDER BY sort_order ASC
			");

			$temp['totals'] = $order_total_query->rows;
            
            foreach ($order_total_query->rows as $order_total):
                $this->theme->model('total/' . $order_total['code']);
                if (method_exists($this->{'model_total_' . $order_total['code']}, 'confirm')):
                    $this->{'model_total_' . $order_total['code']}->confirm($order_info, $order_total);
                endif;
            endforeach;
            
            $this->theme->language('checkout/order');
            
            $order_status_query = $this->db->query("
				SELECT * 
				FROM {$this->db->prefix}order_status 
				WHERE order_status_id = '" . (int)$order_status_id . "' 
				AND language_id = '" . (int)$order_info['language_id'] . "'
			");

			$temp['status'] = $order_status_query->row['name'];
            
            // Add Reward
            if ($product_reward && ($order_status_id == $this->config->get('config_order_status_id'))):
                $description = sprintf($this->language->get('lang_text_reward'), $product_reward, $order_id);
                $this->customer->addReward($order_info['customer_id'], $description, $product_reward, $order_id);
            endif;

            // Add commission
            if (isset($order_info['affiliate_id']) && isset($order_info['commission'])):
				$commission  = $this->currency->format($order_info['commission']);
				$description = sprintf($this->language->get('lang_text_commission'), $commission, $order_id);
            	$this->customer->addCommission($order_info['affiliate_id'], $order_id, $description, $order_info['commission']);
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

            $this->theme->notify('public_customer_order_confirm', $callback);

            // Admin Alert Mail
            if ($this->config->get('config_alert_mail')):
            	// Build additional emails array to Cc: these emails.
	            $cc = array();

	            if ($this->config->get('config_alert_emails')):
	                $emails = explode(',', $this->config->get('config_alert_emails'));
	                foreach ($emails as $email):
	                    if (strlen($email) > 0 && preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $email)):
	                       $cc[] = trim($email);
	                    endif;
	                endforeach;
	            endif;
	            
	            $this->theme->notify('public_admin_order_confirm', array('user_id' => $this->config->get('config_admin_email_user')), $cc);
            endif;
            
            $this->theme->trigger('front_order_confirm', array('order_id' => $order_id));
        endif;
    }
    
    public function update($order_id, $order_status_id, $comment = '') {
        $order_info = $this->getOrder($order_id);
        
        if ($order_info && $order_info['order_status_id']):
            
            // Fraud Detection
            if ($this->config->get('config_fraud_detection')):
                $this->theme->model('checkout/fraud');
                $risk_score = $this->model_checkout_fraud->getFraudScore($order_info);
                if ($risk_score > $this->config->get('config_fraud_score')):
                    $order_status_id = $this->config->get('config_fraud_status_id');
                endif;
            endif;
            
            // Ban IP
            $status = false;
            
            $this->theme->model('account/customer');
            
            if ($order_info['customer_id']):
                $results = $this->model_account_customer->getIps($order_info['customer_id']);
                foreach ($results as $result):
                    if ($this->model_account_customer->isBanIp($result['ip'])):
                        $status = true;
                        break;
                    endif;
                endforeach;
            else:
                $status = $this->model_account_customer->isBanIp($order_info['ip']);
            endif;
            
            if ($status):
                $order_status_id = $this->config->get('config_order_status_id');
            endif;
            
            $this->db->query("
				UPDATE `{$this->db->prefix}order` 
				SET 
					order_status_id = '" . (int)$order_status_id . "', 
					date_modified   = NOW() 
				WHERE order_id = '" . (int)$order_id . "'
			");
            
            $this->db->query("
				INSERT INTO {$this->db->prefix}order_history 
				SET 
					order_id        = '" . (int)$order_id . "', 
					order_status_id = '" . (int)$order_status_id . "', 
					notify          = '" . (int)$notify . "', 
					comment         = '" . $this->db->escape($comment) . "', 
					date_added      = NOW()
			");
            
            // Send out any gift gift_card mails
            if ($this->config->get('config_complete_status_id') == $order_status_id):
                $this->theme->model('checkout/gift_card');
                $this->model_checkout_gift_card->confirm($order_id);
            endif;
            
            $this->theme->trigger('front_order_update', array('order_id' => $order_id));
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

    	$data = $this->theme->language('notification/order');

    	$this->theme->model('catalog/product');
    	$this->theme->model('tool/image');

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
		$data['date_added']      = date($this->language->get('lang_date_format_short'), strtotime($order_info['date_added']));
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
            $product_data = $this->model_catalog_product->getProduct($product['product_id']);
            if (isset($product_data['image'])):
                $image = $this->model_tool_image->resize($product_data['image'], 50, 50);
            else:
                $image = '';
            endif;
            
            if ($product_data['event_id']):
                $event = $this->model_catalog_product->getEvent($product_data['event_id']);
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
                	$value = date($this->language->get('lang_date_format_short'), strtotime($option['value']));
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
				'url'              => $order_info['store_url'] . 'index.php?route=catalog/product&product_id=' . $product['product_id'], 
				'name'             => $product['name'], 
				'model'            => $product['model'], 
				'option'           => $option_data, 
				'quantity'         => $product['quantity'], 
				'price'            => $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']), 
				'total'            => $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value'])
            );
        endforeach;
        
        $data['has_link'] = $has_link;
        
        // Gift cards
		$data['gift_cards'] = array();
		$gift_cards         = $call['query']['gift_cards'];
        
        foreach ($gift_cards as $gift_card):
            $data['gift_cards'][] = array(
				'description' => $gift_card['description'], 
				'amount'      => $this->currency->format($gift_card['amount'], $order_info['currency_code'], $order_info['currency_value'])
            );
        endforeach;
        
        $data['totals'] = $call['query']['totals'];
        
        $html = new Template($this->app);
        $html->data = $data;
        $html = $html->fetch('notification/order');

    	$text = new Text($this->app);
        $text->data = $data;
        $text = $text->fetch('notification/order');

        $message['html'] = str_replace('!content!', $html, $message['html']);
        $message['text'] = str_replace('!content!', $text, $message['text']);
        
       	return $message;

	}
}
