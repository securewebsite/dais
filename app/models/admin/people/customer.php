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

namespace App\Models\Admin\People;

use App\Models\Model;

class Customer extends Model {
    
    public function addCustomer($data) {
        DB::query("
			INSERT INTO " . DB::prefix() . "customer 
			SET 
                username            = '" . DB::escape($data['username']) . "', 
                firstname           = '" . DB::escape($data['firstname']) . "', 
                lastname            = '" . DB::escape($data['lastname']) . "', 
                email               = '" . DB::escape($data['email']) . "', 
                telephone           = '" . DB::escape($data['telephone']) . "', 
                newsletter          = '" . (int)$data['newsletter'] . "', 
                customer_group_id   = '" . (int)$data['customer_group_id'] . "', 
                salt                = '" . DB::escape($salt = substr(md5(uniqid(rand(), true)), 0, 9)) . "', 
                password            = '" . DB::escape(sha1($salt . sha1($salt . sha1($data['password'])))) . "', 
                status              = '" . (int)$data['status'] . "', 
                date_added          = NOW()
		");
        
        $customer_id = DB::getLastId();
        
        if (isset($data['address'])):
            foreach ($data['address'] as $address):
                DB::query("
					INSERT INTO " . DB::prefix() . "address 
					SET 
                        customer_id = '" . (int)$customer_id . "', 
                        firstname   = '" . DB::escape($address['firstname']) . "', 
                        lastname    = '" . DB::escape($address['lastname']) . "', 
                        company     = '" . DB::escape($address['company']) . "', 
                        company_id  = '" . DB::escape($address['company_id']) . "', 
                        tax_id      = '" . DB::escape($address['tax_id']) . "', 
                        address_1   = '" . DB::escape($address['address_1']) . "', 
                        address_2   = '" . DB::escape($address['address_2']) . "', 
                        city        = '" . DB::escape($address['city']) . "', 
                        postcode    = '" . DB::escape($address['postcode']) . "', 
                        country_id  = '" . (int)$address['country_id'] . "', 
                        zone_id     = '" . (int)$address['zone_id'] . "'
				");
                
                if (isset($address['default'])):
                    $address_id = DB::getLastId();
                    
                    DB::query("
						UPDATE " . DB::prefix() . "customer 
						SET address_id = '" . $address_id . "' 
						WHERE customer_id = '" . (int)$customer_id . "'
					");
                endif;
            endforeach;
        endif;

        if (isset($data['affiliate'])):
            $affiliate = $data['affiliate'];

            DB::query("
                UPDATE " . DB::prefix() . "customer 
                SET 
                    affiliate_status    = '" . (int)$affiliate['affiliate_status'] . "',
                    company             = '" . DB::escape($affiliate['company']) . "',
                    website             = '" . DB::escape($affiliate['website']) . "',
                    code                = '" . DB::escape($affiliate['code']) . "',
                    commission          = '" . (float)$affiliate['commission'] . "',
                    tax_id              = '" . DB::escape($affiliate['tax_id']) . "',
                    payment_method      = '" . DB::escape($affiliate['payment_method']) . "',
                    cheque              = '" . DB::escape($affiliate['cheque']) . "',
                    paypal              = '" . DB::escape($affiliate['paypal']) . "',
                    bank_name           = '" . DB::escape($affiliate['bank_name']) . "',
                    bank_branch_number  = '" . DB::escape($affiliate['bank_branch_number']) . "',
                    bank_swift_code     = '" . DB::escape($affiliate['bank_swift_code']) . "',
                    bank_account_name   = '" . DB::escape($affiliate['bank_account_name']) . "',
                    bank_account_number = '" . DB::escape($affiliate['bank_account_number']) . "' 
                WHERE customer_id = '" . (int)$customer_id . "'");
        endif;

        Theme::trigger('admin_add_customer', array('customer_id' => $customer_id));
    }
    
    public function editCustomer($customer_id, $data) {
        DB::query("
			UPDATE " . DB::prefix() . "customer 
			SET 
                username            = '" . DB::escape($data['username']) . "', 
                firstname           = '" . DB::escape($data['firstname']) . "', 
                lastname            = '" . DB::escape($data['lastname']) . "', 
                email               = '" . DB::escape($data['email']) . "', 
                telephone           = '" . DB::escape($data['telephone']) . "', 
                newsletter          = '" . (int)$data['newsletter'] . "', 
                customer_group_id   = '" . (int)$data['customer_group_id'] . "', 
                status              = '" . (int)$data['status'] . "' 
			WHERE customer_id = '" . (int)$customer_id . "'
		");

        if (isset($data['affiliate'])):
            $affiliate = $data['affiliate'];

            DB::query("
                UPDATE " . DB::prefix() . "customer 
                SET 
                    affiliate_status    = '" . (int)$affiliate['affiliate_status'] . "',
                    company             = '" . DB::escape($affiliate['company']) . "',
                    website             = '" . DB::escape($affiliate['website']) . "',
                    code                = '" . DB::escape($affiliate['code']) . "',
                    commission          = '" . (float)$affiliate['commission'] . "',
                    tax_id              = '" . DB::escape($affiliate['tax_id']) . "',
                    payment_method      = '" . DB::escape($affiliate['payment_method']) . "',
                    cheque              = '" . DB::escape($affiliate['cheque']) . "',
                    paypal              = '" . DB::escape($affiliate['paypal']) . "',
                    bank_name           = '" . DB::escape($affiliate['bank_name']) . "',
                    bank_branch_number  = '" . DB::escape($affiliate['bank_branch_number']) . "',
                    bank_swift_code     = '" . DB::escape($affiliate['bank_swift_code']) . "',
                    bank_account_name   = '" . DB::escape($affiliate['bank_account_name']) . "',
                    bank_account_number = '" . DB::escape($affiliate['bank_account_number']) . "' 
                WHERE customer_id = '" . (int)$customer_id . "'");
        endif;
        
        if ($data['password']):
            DB::query("
				UPDATE " . DB::prefix() . "customer 
				SET 
					salt = '" . DB::escape($salt = substr(md5(uniqid(rand(), true)), 0, 9)) . "', 
					password = '" . DB::escape(sha1($salt . sha1($salt . sha1($data['password'])))) . "' 
				WHERE customer_id = '" . (int)$customer_id . "'
			");
        endif;
        
        DB::query("
			DELETE FROM " . DB::prefix() . "address 
			WHERE customer_id = '" . (int)$customer_id . "'");
        
        if (isset($data['address'])):
            foreach ($data['address'] as $address):
                DB::query("
					INSERT INTO " . DB::prefix() . "address 
					SET 
                        address_id  = '" . (int)$address['address_id'] . "', 
                        customer_id = '" . (int)$customer_id . "', 
                        firstname   = '" . DB::escape($address['firstname']) . "', 
                        lastname    = '" . DB::escape($address['lastname']) . "', 
                        company     = '" . DB::escape($address['company']) . "', 
                        company_id  = '" . DB::escape($address['company_id']) . "', 
                        tax_id      = '" . DB::escape($address['tax_id']) . "', 
                        address_1   = '" . DB::escape($address['address_1']) . "', 
                        address_2   = '" . DB::escape($address['address_2']) . "', 
                        city        = '" . DB::escape($address['city']) . "', 
                        postcode    = '" . DB::escape($address['postcode']) . "', 
                        country_id  = '" . (int)$address['country_id'] . "', 
                        zone_id     = '" . (int)$address['zone_id'] . "'
				");
                
                if (isset($address['default'])):
                    $address_id = DB::getLastId();
                    
                    DB::query("
						UPDATE " . DB::prefix() . "customer 
						SET address_id = '" . (int)$address_id . "' 
						WHERE customer_id = '" . (int)$customer_id . "'
					");
                endif;
            endforeach;
        endif;

        Theme::trigger('admin_edit_customer', array('customer_id' => $customer_id));
    }
    
    public function editToken($customer_id, $token) {
        DB::query("
			UPDATE " . DB::prefix() . "customer 
			SET token = '" . DB::escape($token) . "' 
			WHERE customer_id = '" . (int)$customer_id . "'
		");
    }
    
    public function deleteCustomer($customer_id) {
        DB::query("
			DELETE FROM " . DB::prefix() . "customer 
			WHERE customer_id = '" . (int)$customer_id . "'");
        
        DB::query("
			DELETE FROM " . DB::prefix() . "customer_reward 
			WHERE customer_id = '" . (int)$customer_id . "'");
        
        DB::query("
			DELETE FROM " . DB::prefix() . "customer_credit 
			WHERE customer_id = '" . (int)$customer_id . "'");

        DB::query("
            DELETE FROM " . DB::prefix() . "customer_commission 
            WHERE customer_id = '" . (int)$customer_id . "'");
        
        DB::query("
			DELETE FROM " . DB::prefix() . "customer_ip 
			WHERE customer_id = '" . (int)$customer_id . "'");
        
        DB::query("
			DELETE FROM " . DB::prefix() . "address 
			WHERE customer_id = '" . (int)$customer_id . "'");

        DB::query("
            DELETE FROM " . DB::prefix() . "affiliate_route 
            WHERE query = 'affiliate_id:" . (int)$customer_id . "'");

        Theme::trigger('admin_delete_customer', array('customer_id' => $customer_id));
    }
    
    public function getCustomer($customer_id) {
        $query = DB::query("
			SELECT DISTINCT * 
			FROM " . DB::prefix() . "customer 
			WHERE customer_id = '" . (int)$customer_id . "'
		");
        
        return $query->row;
    }
    
    public function getCustomerByEmail($username, $email) {
        $query = DB::query("
			SELECT DISTINCT * 
			FROM " . DB::prefix() . "customer 
			WHERE (LCASE(email) = '" . DB::escape(Encode::strtolower($email)) . "') 
			OR LCASE(username) = '" . DB::escape(Encode::strtolower($username)) . "'");
        
        return $query->row;
    }
    
    public function getCustomers($data = array()) {
        $sql = "
			SELECT *, 
			CONCAT(c.firstname, ' ', c.lastname) AS name, 
			cgd.name AS customer_group 
			FROM " . DB::prefix() . "customer c 
			LEFT JOIN " . DB::prefix() . "customer_group_description cgd 
				ON (c.customer_group_id = cgd.customer_group_id) 
			WHERE cgd.language_id = '" . (int)Config::get('config_language_id') . "'
		";
        
        $implode = array();
        
        if (!empty($data['filter_username'])):
            $implode[] = "c.username LIKE '" . DB::escape($data['filter_username']) . "%'";
        endif;
        
        if (!empty($data['filter_name'])):
            $implode[] = "CONCAT(c.firstname, ' ', c.lastname) LIKE '%" . DB::escape($data['filter_name']) . "%'";
        endif;
        
        if (!empty($data['filter_email'])):
            $implode[] = "c.email LIKE '" . DB::escape($data['filter_email']) . "%'";
        endif;
        
        if (isset($data['filter_newsletter']) && !is_null($data['filter_newsletter'])):
            $implode[] = "c.newsletter = '" . (int)$data['filter_newsletter'] . "'";
        endif;
        
        if (!empty($data['filter_customer_group_id'])):
            $implode[] = "c.customer_group_id = '" . (int)$data['filter_customer_group_id'] . "'";
        endif;
        
        if (!empty($data['filter_ip'])):
            $implode[] = "c.customer_id IN (SELECT customer_id FROM " . DB::prefix() . "customer_ip WHERE ip = '" . DB::escape($data['filter_ip']) . "')";
        endif;
        
        if (isset($data['filter_status']) && !is_null($data['filter_status'])):
            $implode[] = "c.status = '" . (int)$data['filter_status'] . "'";
        endif;

        if (isset($data['filter_affiliate']) && !is_null($data['filter_affiliate'])):
            $implode[] = "c.is_affiliate = '" . (int)$data['filter_affiliate'] . "'";
        endif;
        
        if (isset($data['filter_approved']) && !is_null($data['filter_approved'])):
            $implode[] = "c.approved = '" . (int)$data['filter_approved'] . "'";
        endif;
        
        if (!empty($data['filter_date_added'])):
            $implode[] = "DATE(c.date_added) = DATE('" . DB::escape($data['filter_date_added']) . "')";
        endif;
        
        if ($implode):
            $imp = implode(" && ", $implode);
            $sql.= " && {$imp}";
        endif;
        
        $sort_data = array(
            'c.username', 
            'name', 
            'c.email', 
            'customer_group', 
            'c.status',
            'c.is_affiliate', 
            'c.approved', 
            'c.ip', 
            'c.date_added'
        );
        
        if (isset($data['sort']) && in_array($data['sort'], $sort_data)):
            $sql.= " ORDER BY {$data['sort']}";
        else:
            $sql.= " ORDER BY name";
        endif;
        
        if (isset($data['order']) && ($data['order'] == 'desc')):
            $sql.= " DESC";
        else:
            $sql.= " ASC";
        endif;
        
        if (isset($data['start']) || isset($data['limit'])):
            if ($data['start'] < 0):
                $data['start'] = 0;
            endif;
            
            if ($data['limit'] < 1):
                $data['limit'] = 20;
            endif;
            
            $sql.= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        endif;
        
        $query = DB::query($sql);
        
        return $query->rows;
    }

    public function getAffiliateDetails($customer_id) {
        $query = DB::query("
            SELECT 
                affiliate_status, 
                company, 
                website, 
                code, 
                commission, 
                tax_id, 
                payment_method, 
                cheque, 
                paypal, 
                bank_name, 
                bank_branch_number, 
                bank_swift_code, 
                bank_account_name,
                bank_account_number 
            FROM " . DB::prefix() . "customer 
            WHERE customer_id = '" . (int)$customer_id . "' 
            AND is_affiliate = '1'
        ");

        return $query->row;
    }

    public function approve($customer_id) {
        $customer_info = $this->getCustomer($customer_id);
        
        if ($customer_info):
            DB::query("
				UPDATE " . DB::prefix() . "customer 
				SET approved = '1' 
				WHERE customer_id = '" . (int)$customer_id . "'
            ");

            Theme::notify('admin_customer_approve', array('customer_id' => $customer_id));
            Theme::trigger('admin_approve_customer', array('customer_id' => $customer_id));
        endif;
    }
    
    public function getAddress($address_id) {
        $address_query = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "address 
			WHERE address_id = '" . (int)$address_id . "'");
        
        if ($address_query->num_rows):
            $country_query = DB::query("
				SELECT * 
				FROM `" . DB::prefix() . "country` 
				WHERE country_id = '" . (int)$address_query->row['country_id'] . "'");
            
            if ($country_query->num_rows):
                $country = $country_query->row['name'];
                $iso_code_2 = $country_query->row['iso_code_2'];
                $iso_code_3 = $country_query->row['iso_code_3'];
                $address_format = $country_query->row['address_format'];
            else:
                $country = '';
                $iso_code_2 = '';
                $iso_code_3 = '';
                $address_format = '';
            endif;
            
            $zone_query = DB::query("
				SELECT * 
				FROM `" . DB::prefix() . "zone` 
				WHERE zone_id = '" . (int)$address_query->row['zone_id'] . "'");
            
            if ($zone_query->num_rows):
                $zone = $zone_query->row['name'];
                $zone_code = $zone_query->row['code'];
            else:
                $zone = '';
                $zone_code = '';
            endif;
            
            return array(
                'address_id'     => $address_query->row['address_id'], 
                'customer_id'    => $address_query->row['customer_id'], 
                'firstname'      => $address_query->row['firstname'], 
                'lastname'       => $address_query->row['lastname'], 
                'company'        => $address_query->row['company'], 
                'company_id'     => $address_query->row['company_id'], 
                'tax_id'         => $address_query->row['tax_id'], 
                'address_1'      => $address_query->row['address_1'], 
                'address_2'      => $address_query->row['address_2'], 
                'postcode'       => $address_query->row['postcode'], 
                'city'           => $address_query->row['city'], 
                'zone_id'        => $address_query->row['zone_id'], 
                'zone'           => $zone, 
                'zone_code'      => $zone_code, 
                'country_id'     => $address_query->row['country_id'], 
                'country'        => $country, 
                'iso_code_2'     => $iso_code_2, 
                'iso_code_3'     => $iso_code_3, 
                'address_format' => $address_format
            );
        endif;
    }
    
    public function getAddresses($customer_id) {
        $address_data = array();
        
        $query = DB::query("
			SELECT address_id 
			FROM " . DB::prefix() . "address 
			WHERE customer_id = '" . (int)$customer_id . "'");
        
        foreach ($query->rows as $result):
            $address_info = $this->getAddress($result['address_id']);
            
            if ($address_info):
                $address_data[$result['address_id']] = $address_info;
            endif;
        endforeach;
        
        return $address_data;
    }
    
    public function getTotalCustomers($data = array()) {
        $sql = "
            SELECT COUNT(*) AS total 
            FROM " . DB::prefix() . "customer";
        
        $implode = array();
        
        if (!empty($data['filter_username'])):
            $implode[] = "username LIKE '" . DB::escape($data['filter_username']) . "%'";
        endif;
        
        if (!empty($data['filter_name'])):
            $implode[] = "CONCAT(firstname, ' ', lastname) LIKE '%" . DB::escape($data['filter_name']) . "%'";
        endif;
        
        if (!empty($data['filter_email'])):
            $implode[] = "email LIKE '" . DB::escape($data['filter_email']) . "%'";
        endif;
        
        if (isset($data['filter_newsletter']) && !is_null($data['filter_newsletter'])):
            $implode[] = "newsletter = '" . (int)$data['filter_newsletter'] . "'";
        endif;
        
        if (!empty($data['filter_customer_group_id'])):
            $implode[] = "customer_group_id = '" . (int)$data['filter_customer_group_id'] . "'";
        endif;
        
        if (!empty($data['filter_ip'])):
            $implode[] = "customer_id IN (SELECT customer_id FROM " . DB::prefix() . "customer_ip WHERE ip = '" . DB::escape($data['filter_ip']) . "')";
        endif;
        
        if (isset($data['filter_status']) && !is_null($data['filter_status'])):
            $implode[] = "status = '" . (int)$data['filter_status'] . "'";
        endif;

         if (isset($data['filter_affiliate']) && !is_null($data['filter_affiliate'])):
            $implode[] = "is_affiliate = '" . (int)$data['filter_affiliate'] . "'";
        endif;

        if (isset($data['filter_approved']) && !is_null($data['filter_approved'])):
            $implode[] = "approved = '" . (int)$data['filter_approved'] . "'";
        endif;
        
        if (!empty($data['filter_date_added'])):
            $implode[] = "DATE(date_added) = DATE('" . DB::escape($data['filter_date_added']) . "')";
        endif;
        
        if ($implode):
            $imp = implode(" && ", $implode);
            $sql.= " WHERE {$imp}";
        endif;
        
        $query = DB::query($sql);
        
        return $query->row['total'];
    }
    
    public function getTotalCustomersAwaitingApproval() {
        $query = DB::query("
			SELECT COUNT(*) AS total 
			FROM " . DB::prefix() . "customer 
			WHERE status = '0' 
			OR approved = '0'");
        
        return $query->row['total'];
    }
    
    public function getTotalAddressesByCustomerId($customer_id) {
        $query = DB::query("
			SELECT COUNT(*) AS total 
			FROM " . DB::prefix() . "address 
			WHERE customer_id = '" . (int)$customer_id . "'");
        
        return $query->row['total'];
    }
    
    public function getTotalAddressesByCountryId($country_id) {
        $query = DB::query("
			SELECT COUNT(*) AS total 
			FROM " . DB::prefix() . "address 
			WHERE country_id = '" . (int)$country_id . "'");
        
        return $query->row['total'];
    }
    
    public function getTotalAddressesByZoneId($zone_id) {
        $query = DB::query("
			SELECT COUNT(*) AS total 
			FROM " . DB::prefix() . "address 
			WHERE zone_id = '" . (int)$zone_id . "'");
        
        return $query->row['total'];
    }
    
    public function getTotalCustomersByCustomerGroupId($customer_group_id) {
        $query = DB::query("
			SELECT COUNT(*) AS total 
			FROM " . DB::prefix() . "customer 
			WHERE customer_group_id = '" . (int)$customer_group_id . "'");
        
        return $query->row['total'];
    }
    
    public function addHistory($customer_id, $comment) {
        DB::query("
			INSERT INTO " . DB::prefix() . "customer_history 
			SET 
				customer_id = '" . (int)$customer_id . "', 
				comment = '" . DB::escape(strip_tags($comment)) . "', 
				date_added = NOW()");

        Theme::trigger('admin_add_history', array('customer_id' => $customer_id));
    }
    
    public function getHistories($customer_id, $start = 0, $limit = 10) {
        if ($start < 0):
            $start = 0;
        endif;
        
        if ($limit < 1):
            $limit = 10;
        endif;
        
        $query = DB::query("
			SELECT comment, date_added 
			FROM " . DB::prefix() . "customer_history 
			WHERE customer_id = '" . (int)$customer_id . "' 
			ORDER BY date_added 
			DESC LIMIT " . (int)$start . "," . (int)$limit);
        
        return $query->rows;
    }
    
    public function getTotalHistories($customer_id) {
        $query = DB::query("
			SELECT COUNT(*) AS total 
			FROM " . DB::prefix() . "customer_history 
			WHERE customer_id = '" . (int)$customer_id . "'");
        
        return $query->row['total'];
    }
    
    public function addCredit($customer_id, $description = '', $amount = '', $order_id = 0) {
        $customer_info = $this->getCustomer($customer_id);
        
        if ($customer_info):
            DB::query("
				INSERT INTO " . DB::prefix() . "customer_credit 
				SET 
                    customer_id = '" . (int)$customer_id . "', 
                    order_id    = '" . (int)$order_id . "', 
                    description = '" . DB::escape($description) . "', 
                    amount      = '" . (float)$amount . "', 
                    date_added  = NOW()
            ");
            
            $callback = array(
                'customer_id' => $customer_id,
                'credit'      => Currency::format($amount, Config::get('config_currency')),
                'total'       => Currency::format($this->getCreditTotal($customer_id), Config::get('config_currency')),
                'callback'    => array(
                    'class'  => __CLASS__,
                    'method' => 'admin_customer_add_credit'
                )
            );

            Theme::notify('admin_customer_add_credit', $callback);
            Theme::trigger('admin_add_customer_credit', array('customer_id' => $customer_id));
        endif;
    }
    
    public function deleteCredit($order_id) {
        DB::query("
			DELETE FROM " . DB::prefix() . "customer_credit 
			WHERE order_id = '" . (int)$order_id . "'");

        Theme::trigger('admin_delete_customer_credit', array('order_id' => $order_id));
    }
    
    public function getCredits($customer_id, $start = 0, $limit = 10) {
        if ($start < 0):
            $start = 0;
        endif;
        
        if ($limit < 1):
            $limit = 10;
        endif;
        
        $query = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "customer_credit 
			WHERE customer_id = '" . (int)$customer_id . "' 
			ORDER BY date_added 
			DESC LIMIT " . (int)$start . "," . (int)$limit);
        
        return $query->rows;
    }
    
    public function getTotalCredits($customer_id) {
        $query = DB::query("
			SELECT COUNT(*) AS total 
			FROM " . DB::prefix() . "customer_credit 
			WHERE customer_id = '" . (int)$customer_id . "'");
        
        return $query->row['total'];
    }
    
    public function getCreditTotal($customer_id) {
        $query = DB::query("
			SELECT SUM(amount) AS total 
			FROM " . DB::prefix() . "customer_credit 
			WHERE customer_id = '" . (int)$customer_id . "'");
        
        return $query->row['total'];
    }
    
    public function getTotalCreditsByOrderId($order_id) {
        $query = DB::query("
			SELECT COUNT(*) AS total 
			FROM " . DB::prefix() . "customer_credit 
			WHERE order_id = '" . (int)$order_id . "'");
        
        return $query->row['total'];
    }

    public function addCommission($customer_id, $description = '', $amount = '', $order_id = 0) {
        $customer_info = $this->getCustomer($customer_id);
        
        if ($customer_info):
            DB::query("
                INSERT INTO " . DB::prefix() . "customer_commission 
                SET 
                    customer_id = '" . (int)$customer_id . "', 
                    order_id     = '" . (float)$order_id . "', 
                    description  = '" . DB::escape($description) . "', 
                    amount       = '" . (float)$amount . "', 
                    date_added   = NOW()
            ");
            
            $customer_commission_id = DB::getLastId();
            
            $callback = array(
                'customer_id' => $customer_id,
                'commission'  => Currency::format($amount, Config::get('config_currency')),
                'total'       => Currency::format($this->getCommissionTotal($customer_id), Config::get('config_currency')),
                'days'        => '30',
                'callback'    => array(
                    'class'  => __CLASS__,
                    'method' => 'admin_affiliate_add_commission'
                )
            );

            Theme::notify('admin_affiliate_add_commission', $callback);
            Theme::trigger('admin_add_customer_commission', array('customer_commission_id' => $customer_commission_id));
        endif;
    }

    public function deleteCommission($order_id) {
        $customer_commission_id = $this->getCommissionByOrderId($order_id);
        
        DB::query("
            DELETE FROM " . DB::prefix() . "customer_commission 
            WHERE order_id = '" . (int)$order_id . "'");
        
        Theme::trigger('admin_delete_customer_commission', array('customer_commission_id' => $customer_commission_id));
    }

    public function getCommissions($customer_id, $start = 0, $limit = 10) {
        if ($start < 0):
            $start = 0;
        endif;
        
        if ($limit < 1):
            $limit = 10;
        endif;
        
        $query = DB::query("
            SELECT * 
            FROM " . DB::prefix() . "customer_commission 
            WHERE customer_id = '" . (int)$customer_id . "' 
            ORDER BY date_added DESC 
            LIMIT " . (int)$start . "," . (int)$limit);
        
        return $query->rows;
    }
    
    public function getTotalCommissions($customer_id) {
        $query = DB::query("
            SELECT COUNT(*) AS total 
            FROM " . DB::prefix() . "customer_commission 
            WHERE customer_id = '" . (int)$customer_id . "'");
        
        return $query->row['total'];
    }
    
    public function getCommissionTotal($customer_id) {
        $query = DB::query("
            SELECT SUM(amount) AS total 
            FROM " . DB::prefix() . "customer_commission 
            WHERE customer_id = '" . (int)$customer_id . "'");
        
        return $query->row['total'];
    }
    
    public function getTotalCommissionsByOrderId($order_id) {
        $query = DB::query("
            SELECT COUNT(*) AS total 
            FROM " . DB::prefix() . "customer_commission 
            WHERE order_id = '" . (int)$order_id . "'");
        
        return $query->row['total'];
    }
    
    public function getCommissionByOrderId($order_id) {
        $query = DB::query("
            SELECT customer_commission_id 
            FROM " . DB::prefix() . "customer_commission 
            WHERE order_id = '" . (int)$order_id . "'
        ");
        
        return $query->row['customer_commission_id'];
    }

    public function getTotalAffiliatesByCountryId($country_id) {
        $query = DB::query("
            SELECT COUNT(*) AS total 
            FROM " . DB::prefix() . "customer 
            WHERE country_id = '" . (int)$country_id . "' 
            AND is_affiliate = '1'
        ");
        
        return $query->row['total'];
    }
    
    public function getTotalAffiliatesByZoneId($zone_id) {
        $query = DB::query("
            SELECT COUNT(*) AS total 
            FROM " . DB::prefix() . "customer 
            WHERE zone_id = '" . (int)$zone_id . "' 
            AND is_affiliate = '1'
        ");
        
        return $query->row['total'];
    }

    public function getTotalAffiliates($data = array()) {
        $sql = "
            SELECT COUNT(*) AS total 
            FROM " . DB::prefix() . "customer";
        
        $implode = array();
        
        if (!empty($data['filter_name'])):
            $implode[] = "CONCAT(firstname, ' ', lastname) LIKE '%" . DB::escape($data['filter_name']) . "%'";
        endif;
        
        if (!empty($data['filter_email'])):
            $implode[] = "LCASE(email) = '" . DB::escape(Encode::strtolower($data['filter_email'])) . "'";
        endif;
        
        if (isset($data['filter_status']) && !is_null($data['filter_status'])):
            $implode[] = "status = '" . (int)$data['filter_status'] . "'";
        endif;
        
        if (isset($data['filter_approved']) && !is_null($data['filter_approved'])):
            $implode[] = "approved = '" . (int)$data['filter_approved'] . "'";
        endif;
        
        if (!empty($data['filter_date_added'])):
            $implode[] = "DATE(date_added) = DATE('" . DB::escape($data['filter_date_added']) . "')";
        endif;

        $implode[] = "is_affiliate = '1'";
        
        if ($implode):
            $imp  = implode(" && ", $implode);
            $sql .= " WHERE {$imp}";
        endif;
        
        $query = DB::query($sql);
        
        return $query->row['total'];
    }

    public function getAffiliates($data = array()) {
        $sql = "
            SELECT *, 
            CONCAT(c.firstname, ' ', c.lastname) AS name, 
            (SELECT SUM(cc.amount) 
                FROM " . DB::prefix() . "customer_commission cc 
                WHERE cc.customer_id = c.customer_id 
                GROUP BY cc.customer_id) AS balance 
            FROM " . DB::prefix() . "customer c";
        
        $implode = array();
        
        if (!empty($data['filter_name'])):
            $implode[] = "CONCAT(c.firstname, ' ', c.lastname) LIKE '" . DB::escape($data['filter_name']) . "%'";
        endif;
        
        if (!empty($data['filter_email'])):
            $implode[] = "LCASE(c.email) = '" . DB::escape(Encode::strtolower($data['filter_email'])) . "'";
        endif;
        
        if (!empty($data['filter_code'])):
            $implode[] = "c.code = '" . DB::escape($data['filter_code']) . "'";
        endif;
        
        if (isset($data['filter_status']) && !is_null($data['filter_status'])):
            $implode[] = "c.status = '" . (int)$data['filter_status'] . "'";
        endif;
        
        if (isset($data['filter_approved']) && !is_null($data['filter_approved'])):
            $implode[] = "c.approved = '" . (int)$data['filter_approved'] . "'";
        endif;
        
        if (!empty($data['filter_date_added'])):
            $implode[] = "DATE(c.date_added) = DATE('" . DB::escape($data['filter_date_added']) . "')";
        endif;

        $implode[] = "c.is_affiliate = '1'";
        
        if ($implode):
            $imp = implode(" && ", $implode);
            $sql.= " WHERE {$imp}";
        endif;
        
        $sort_data = array(
            'name', 
            'c.email', 
            'c.code', 
            'c.status', 
            'c.approved', 
            'c.date_added'
        );
        
        if (isset($data['sort']) && in_array($data['sort'], $sort_data)):
            $sql.= " ORDER BY {$data['sort']}";
        else:
            $sql.= " ORDER BY name";
        endif;
        
        if (isset($data['order']) && ($data['order'] == 'desc')):
            $sql.= " DESC";
        else:
            $sql.= " ASC";
        endif;
        
        if (isset($data['start']) || isset($data['limit'])):
            if ($data['start'] < 0):
                $data['start'] = 0;
            endif;
            
            if ($data['limit'] < 1):
                $data['limit'] = 20;
            endif;
            
            $sql.= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        endif;
        
        $query = DB::query($sql);
        
        return $query->rows;
    }
    
    public function addReward($customer_id, $description = '', $points = '', $order_id = 0) {
        $customer_info = $this->getCustomer($customer_id);
        
        if ($customer_info):
            DB::query("
				INSERT INTO " . DB::prefix() . "customer_reward 
				SET 
					customer_id = '" . (int)$customer_id . "', 
					order_id = '" . (int)$order_id . "', 
					points = '" . (int)$points . "', 
					description = '" . DB::escape($description) . "', 
					date_added = NOW()
			");
            
            $callback = array(
                'customer_id' => $customer_id,
                'points'      => $points,
                'total'       => $this->getRewardTotal($customer_id),
                'callback'    => array(
                    'class'  => __CLASS__,
                    'method' => 'admin_customer_add_reward'
                )
            );

            Theme::notify('admin_customer_add_reward', $callback); 
            Theme::trigger('admin_add_reward', array('customer_id' => $customer_id));
        endif;
    }
    
    public function deleteReward($order_id) {
        DB::query("
			DELETE FROM " . DB::prefix() . "customer_reward 
			WHERE order_id = '" . (int)$order_id . "'");
    }
    
    public function getRewards($customer_id, $start = 0, $limit = 10) {
        $query = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "customer_reward 
			WHERE customer_id = '" . (int)$customer_id . "' 
			ORDER BY date_added 
			DESC LIMIT " . (int)$start . "," . (int)$limit);
        
        return $query->rows;
    }
    
    public function getTotalRewards($customer_id) {
        $query = DB::query("
			SELECT COUNT(*) AS total 
			FROM " . DB::prefix() . "customer_reward 
			WHERE customer_id = '" . (int)$customer_id . "'");
        
        return $query->row['total'];
    }
    
    public function getRewardTotal($customer_id) {
        $query = DB::query("
			SELECT SUM(points) AS total 
			FROM " . DB::prefix() . "customer_reward 
			WHERE customer_id = '" . (int)$customer_id . "'");
        
        return $query->row['total'];
    }
    
    public function getTotalCustomerRewardsByOrderId($order_id) {
        $query = DB::query("
			SELECT COUNT(*) AS total 
			FROM " . DB::prefix() . "customer_reward 
			WHERE order_id = '" . (int)$order_id . "'");
        
        return $query->row['total'];
    }
    
    public function getIpsByCustomerId($customer_id) {
        $query = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "customer_ip 
			WHERE customer_id = '" . (int)$customer_id . "'");
        
        return $query->rows;
    }
    
    public function getTotalCustomersByIp($ip) {
        $query = DB::query("
			SELECT COUNT(*) AS total 
			FROM " . DB::prefix() . "customer_ip 
			WHERE ip = '" . DB::escape($ip) . "'");
        
        return $query->row['total'];
    }
    
    public function addBanIp($ip) {
        DB::query("
			INSERT INTO `" . DB::prefix() . "customer_ban_ip` 
			SET `ip` = '" . DB::escape($ip) . "'");
    }
    
    public function removeBanIp($ip) {
        DB::query("
			DELETE FROM `" . DB::prefix() . "customer_ban_ip` 
			WHERE `ip` = '" . DB::escape($ip) . "'");
    }
    
    public function getTotalBanIpsByIp($ip) {
        $query = DB::query("
			SELECT COUNT(*) AS total 
			FROM `" . DB::prefix() . "customer_ban_ip` 
			WHERE `ip` = '" . DB::escape($ip) . "'");
        
        return $query->row['total'];
    }
    
    public function getUsernameByCustomerId($customer_id) {
        $query = DB::query("
			SELECT username 
			FROM " . DB::prefix() . "customer 
			WHERE customer_id = '" . (int)$customer_id . "'");
        
        return $query->row['username'];
    }

    public function getReferrer($customer_id) {
        $query = DB::query("
            SELECT username, firstname, lastname 
            FROM " . DB::prefix() . "customer 
            WHERE customer_id = '" . (int)$customer_id . "'");

        return $query->row;
    }

    /*
    |--------------------------------------------------------------------------
    |   NOTIFICATIONS
    |--------------------------------------------------------------------------
    |
    |   The below are notification callbacks.
    */

    public function admin_customer_add_credit($data, $message) {
        $search = array(
            '!credit!',
            '!total!'
        );

        $replace = array();

        foreach($data as $key => $value):
            $replace[] = $value;
        endforeach;

        foreach ($message as $key => $value):
            $message[$key] = str_replace($search, $replace, $value);
        endforeach;

        return $message;
    }

    public function admin_affiliate_add_commission($data, $message) {
        $search = array(
            '!commission!',
            '!total!',
            '!days!'
        );

        $replace = array();

        foreach($data as $key => $value):
            $replace[] = $value;
        endforeach;

        foreach ($message as $key => $value):
            $message[$key] = str_replace($search, $replace, $value);
        endforeach;
        
        return $message;
    }

    public function admin_customer_add_reward($data, $message) {
        $search = array(
            '!points!',
            '!total!'
        );

        $replace = array();

        foreach($data as $key => $value):
            $replace[] = $value;
        endforeach;

        foreach ($message as $key => $value):
            $message[$key] = str_replace($search, $replace, $value);
        endforeach;
        
        return $message;
    }
}

