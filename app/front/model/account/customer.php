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

namespace Front\Model\Account;
use Dais\Base\Model;

class Customer extends Model {
    public function addCustomer($data) {
        if (isset($data['customer_group_id']) && is_array($this->config->get('config_customer_group_display')) && in_array($data['customer_group_id'], $this->config->get('config_customer_group_display'))) {
            $customer_group_id = $data['customer_group_id'];
        } else {
            $customer_group_id = $this->config->get('config_customer_group_id');
        }
        
        $this->theme->model('account/customer_group');
        
        $customer_group_info = $this->model_account_customer_group->getCustomerGroup($customer_group_id);
        
        $this->db->query("
			INSERT INTO {$this->db->prefix}customer 
			SET 
                store_id          = '" . (int)$this->config->get('config_store_id') . "', 
                username          = '" . $this->db->escape($data['username']) . "', 
                firstname         = '" . $this->db->escape($data['firstname']) . "', 
                lastname          = '" . $this->db->escape($data['lastname']) . "', 
                email             = '" . $this->db->escape($data['email']) . "', 
                telephone         = '" . $this->db->escape($data['telephone']) . "', 
                salt              = '" . $this->db->escape($salt = substr(md5(uniqid(rand(), true)), 0, 9)) . "', 
                password          = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($data['password'])))) . "', 
                newsletter        = '" . (isset($data['newsletter']) ? (int)$data['newsletter'] : 0) . "', 
                customer_group_id = '" . (int)$customer_group_id . "', 
                referral_id       = '" . (isset($this->request->cookie['referrer']) ? $this->request->cookie['referrer'] : 0) . "', 
                ip                = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', 
                status            = '1', 
                approved          = '" . (int)!$customer_group_info['approval'] . "', 
                date_added        = NOW()
		");
        
        $customer_id = $this->db->getLastId();

        // add customer to customer_ips table for each new account
        $this->db->query("
            INSERT INTO {$this->db->prefix}customer_ip 
            SET 
                customer_id = '" . (int)$customer_id . "', 
                ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', 
                date_added = NOW()
        ");
        
        $this->db->query("
			INSERT INTO {$this->db->prefix}address 
			SET 
                customer_id = '" . (int)$customer_id . "', 
                firstname   = '" . $this->db->escape($data['firstname']) . "', 
                lastname    = '" . $this->db->escape($data['lastname']) . "', 
                company     = '" . $this->db->escape($data['company']) . "', 
                company_id  = '" . $this->db->escape($data['company_id']) . "', 
                tax_id      = '" . $this->db->escape($data['tax_id']) . "', 
                address_1   = '" . $this->db->escape($data['address_1']) . "', 
                address_2   = '" . $this->db->escape($data['address_2']) . "', 
                city        = '" . $this->db->escape($data['city']) . "', 
                postcode    = '" . $this->db->escape($data['postcode']) . "', 
                country_id  = '" . (int)$data['country_id'] . "', 
                zone_id     = '" . (int)$data['zone_id'] . "'
		");
        
        $address_id = $this->db->getLastId();
        
        $this->db->query("
			UPDATE {$this->db->prefix}customer 
			SET address_id = '" . (int)$address_id . "' 
			WHERE customer_id = '" . (int)$customer_id . "'
		");

        /**
         * Add affiliate settings if posted
         */
        
        if (isset($data['affiliate']) && $data['affiliate']['status'] == 1):
            $aff = $data['affiliate'];

            $this->db->query("
                UPDATE {$this->db->prefix}customer 
                SET 
                  is_affiliate        = '" . (int)1 . "', 
                  affiliate_status    = '" . (int)1 . "', 
                  company             = '" . $this->db->escape($data['company']) . "', 
                  website             = '" . $this->db->escape($aff['website']) . "', 
                  code                = '" . uniqid() . "', 
                  commission          = '" . (float)$this->config->get('config_commission') . "', 
                  tax_id              = '" . $this->db->escape($aff['tax']) . "', 
                  payment_method      = '" . $this->db->escape($aff['payment_method']) . "', 
                  cheque              = '" . $this->db->escape($aff['cheque']) . "', 
                  paypal              = '" . $this->db->escape($aff['paypal']) . "', 
                  bank_name           = '" . $this->db->escape($aff['bank_name']) . "', 
                  bank_branch_number  = '" . $this->db->escape($aff['bank_branch_number']) . "', 
                  bank_swift_code     = '" . $this->db->escape($aff['bank_swift_code']) . "', 
                  bank_account_name   = '" . $this->db->escape($aff['bank_account_name']) . "',
                  bank_account_number = '" . $this->db->escape($aff['bank_account_number']) . "' 
                WHERE customer_id = '" . (int)$customer_id . "'
            ");
            
            /**
             * Add affiliate vanity url slug
             */
            if ($aff['slug']):
                $this->db->query("
                    INSERT INTO {$this->db->prefix}affiliate_route 
                    SET 
                        route = '" . Theme::getstyle() . "/home', 
                        query = 'affiliate_id:" . (int)$customer_id . "', 
                        slug  = '" . $this->db->escape($aff['slug']) . "'
                ");
            endif;
        endif;

        /**
         * Add default notification settings
         */
        $this->theme->model('account/notification');
        $emails = $this->model_account_notification->getConfigurableNotifications();

        $notify = array();

        foreach ($emails as $email):
            $notify[$email['email_id']] = array(
                'email'    => 1,
                'internal' => 1
            );
        endforeach;

        $notify = serialize($notify);

        $this->db->query("
            INSERT INTO {$this->db->prefix}customer_notification 
            SET 
                customer_id = '" . (int)$customer_id . "', 
                settings    = '" . $this->db->escape($notify) . "'
        ");

        $callback = array(
            'customer_id' => $customer_id,
            'percent'     => number_format($this->config->get('config_commission')),
            'callback'    => array(
                'class'  => __CLASS__,
                'method' => 'public_register_customer'
            )
        );
        
        $this->theme->notify('public_register_customer', $callback);

        unset($callback);
        
        // Send to main admin email if new account email is enabled
        if ($this->config->get('config_account_mail')):

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
            
            $callback = array(
                'user_id'    => $this->config->get('config_admin_email_user'),
                'customer'   => $customer_id,
                'address_id' => $address_id,
                'callback'   => array(
                    'class'  => __CLASS__,
                    'method' => 'public_register_admin'
                )
            );
            
            $this->theme->notify('public_register_admin', $callback, $cc);   
        endif;
        
        $this->theme->trigger('front_add_customer', array('customer_id' => $customer_id));
    }
    
    public function editCustomer($data) {
        $this->db->query("
			UPDATE {$this->db->prefix}customer 
			SET 
                firstname = '" . $this->db->escape($data['firstname']) . "', 
                lastname  = '" . $this->db->escape($data['lastname']) . "', 
                email     = '" . $this->db->escape($data['email']) . "', 
                telephone = '" . $this->db->escape($data['telephone']) . "' 
			WHERE customer_id = '" . (int)$this->customer->getId() . "'
		");
        
        $this->theme->trigger('front_edit_customer', array('customer_id' => $customer_id));
    }
    
    public function editPassword($customer_id, $password) {
        $this->db->query("
			UPDATE {$this->db->prefix}customer 
			SET 
                salt     = '" . $this->db->escape($salt = substr(md5(uniqid(rand(), true)), 0, 9)) . "', 
                password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($password)))) . "', 
                reset    = '' 
			WHERE customer_id = '" . (int)$customer_id . "'
		");
        
        $this->theme->trigger('front_customer_edit_password', array('customer_id' => $customer_id));
    }
    
    public function editNewsletter($newsletter) {
        $this->db->query("
			UPDATE {$this->db->prefix}customer 
			SET newsletter = '" . (int)$newsletter . "' 
			WHERE customer_id = '" . (int)$this->customer->getId() . "'
		");
        
        $this->theme->trigger('front_customer_edit_newsletter', array('customer_id' => $this->customer->getId()));
    }
    
    public function getCustomer($customer_id) {
        $query = $this->db->query("
			SELECT * 
			FROM {$this->db->prefix}customer 
			WHERE customer_id = '" . (int)$customer_id . "'
		");
        
        return $query->row;
    }

    public function editCode($email, $code) {
        $customer = $this->getCustomerByEmail($email);

        $customer_id = $customer['customer_id'];

        $this->db->query("
            UPDATE {$this->db->prefix}customer 
            SET 
                reset = '" . $this->db->escape($code) . "' 
            WHERE customer_id = '" . (int)$customer_id . "'
        ");

        return $customer_id;
    }

    public function getCustomerByCode($code) {
        $query = $this->db->query("
            SELECT * 
            FROM {$this->db->prefix}customer 
            WHERE reset = '" . $this->db->escape($code) . "' AND reset != ''");
        
        return $query->row;
    }
    
    public function getCustomerByEmail($email) {
        $query = $this->db->query("
			SELECT * 
			FROM {$this->db->prefix}customer 
			WHERE LOWER(email) = '" . $this->db->escape($this->encode->strtolower($email)) . "'
		");
        
        return $query->row;
    }
    
    public function getCustomerByToken($token) {
        $query = $this->db->query("
			SELECT * 
			FROM {$this->db->prefix}customer 
			WHERE token = '" . $this->db->escape($token) . "' 
			AND token != ''
		");
        
        $this->db->query("
			UPDATE {$this->db->prefix}customer 
			SET token = ''");
        
        return $query->row;
    }
    
    public function getCustomers($data = array()) {
        $sql = "
			SELECT *, 
			CONCAT(c.firstname, ' ', c.lastname) AS name, 
			cg.name AS customer_group 
			FROM {$this->db->prefix}customer c 
			LEFT JOIN {$this->db->prefix}customer_group cg 
				ON (c.customer_group_id = cg.customer_group_id) 
		";
        
        $implode = array();
        
        if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
            $implode[] = "LCASE(CONCAT(c.firstname, ' ', c.lastname)) LIKE '" . $this->db->escape($this->encode->strtolower($data['filter_name'])) . "%'";
        }
        
        if (isset($data['filter_email']) && !is_null($data['filter_email'])) {
            $implode[] = "LCASE(c.email) = '" . $this->db->escape($this->encode->strtolower($data['filter_email'])) . "'";
        }
        
        if (isset($data['filter_customer_group_id']) && !is_null($data['filter_customer_group_id'])) {
            $implode[] = "cg.customer_group_id = '" . $this->db->escape($data['filter_customer_group_id']) . "'";
        }
        
        if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
            $implode[] = "c.status = '" . (int)$data['filter_status'] . "'";
        }
        
        if (isset($data['filter_approved']) && !is_null($data['filter_approved'])) {
            $implode[] = "c.approved = '" . (int)$data['filter_approved'] . "'";
        }
        
        if (isset($data['filter_ip']) && !is_null($data['filter_ip'])) {
            $implode[] = "c.customer_id IN (SELECT customer_id FROM {$this->db->prefix}customer_ip WHERE ip = '" . $this->db->escape($data['filter_ip']) . "')";
        }
        
        if (isset($data['filter_date_added']) && !is_null($data['filter_date_added'])) {
            $implode[] = "DATE(c.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
        }
        
        if ($implode) {
            $imp = implode(" && ", $implode);
            $sql.= " WHERE {$imp}";
        }
        
        $sort_data = array('name', 'c.email', 'customer_group', 'c.status', 'c.ip', 'c.date_added');
        
        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql.= " ORDER BY {$data['sort']}";
        } else {
            $sql.= " ORDER BY name";
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
    
    public function getTotalCustomersByEmail($email) {
        $query = $this->db->query("
			SELECT COUNT(*) AS total 
			FROM {$this->db->prefix}customer 
			WHERE LOWER(email) = '" . $this->db->escape($this->encode->strtolower($email)) . "'
		");
        
        return $query->row['total'];
    }
    
    public function getTotalCustomersByUsername($username) {
        $query = $this->db->query("
			SELECT COUNT(*) AS total 
			FROM {$this->db->prefix}customer 
			WHERE LOWER(username) = '" . $this->db->escape($this->encode->strtolower($username)) . "'
		");
        
        return $query->row['total'];
    }
    
    public function getIps($customer_id) {
        $query = $this->db->query("
			SELECT * 
			FROM `{$this->db->prefix}customer_ip` 
			WHERE customer_id = '" . (int)$customer_id . "'
		");
        
        return $query->rows;
    }
    
    public function isBanIp($ip) {
        $query = $this->db->query("
			SELECT * 
			FROM `{$this->db->prefix}customer_ban_ip` 
			WHERE ip = '" . $this->db->escape($ip) . "'
		");
        
        return $query->num_rows;
    }

    public function public_register_customer($data, $message) {
        $search  = array('!percent!');
        $replace = array();

        foreach($data as $key => $value):
            $replace[] = $value;
        endforeach;

        foreach ($message as $key => $value):
            $message[$key] = str_replace($search, $replace, $value);
        endforeach;

        return $message;
    }

    public function public_register_admin($data, $message) {
        $this->theme->model('tool/utility');
        $customer = $this->model_tool_utility->getNewCustomerDetail ($data['customer'], $data['address_id']);

        $format = 
            '{username}' . "\n" . 
            '{firstname} {lastname}' . "\n" . 
            '{email}' . "\n" . 
            '{company}' . "\n" . 
            '{address_1}' . "\n" . 
            '{address_2}' . "\n" . 
            '{city}, {zone} {postcode}' . "\n" .  
            '{country}';

        $find = array(
            '{username}', 
            '{firstname}', 
            '{lastname}', 
            '{email}', 
            '{company}', 
            '{address_1}', 
            '{address_2}', 
            '{city}', 
            '{postcode}', 
            '{zone}',  
            '{country}'
        );
            
        $replace = array(
            'username'  => $customer['username'],
            'firstname' => $customer['firstname'], 
            'lastname'  => $customer['lastname'], 
            'email'     => $customer['email'],
            'company'   => $customer['company'], 
            'address_1' => $customer['address_1'], 
            'address_2' => $customer['address_2'], 
            'city'      => $customer['city'], 
            'postcode'  => $customer['postcode'], 
            'zone'      => $customer['zone'], 
            'country'   => $customer['country']
        );

        $text = preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), "\n", trim(str_replace($find, $replace, $format)));
        $html = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

        foreach ($message as $key => $value):
            if ($key == 'html'):
                $message[$key] = str_replace('!customer_details!', $html, $value);
            else:
                $message[$key] = str_replace('!customer_details!', $text, $value);
            endif;
        endforeach;

        return $message;
    }
}
