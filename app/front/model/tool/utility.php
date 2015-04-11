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

namespace Front\Model\Tool;
use Dais\Engine\Model;

class Utility extends Model {
	public function getUnreadCustomerNotifications($customer_id) {
		$query = $this->db->query("
			SELECT COUNT(notification_id) AS total 
			FROM {$this->db->prefix}customer_inbox 
			WHERE customer_id = '" . (int)$customer_id . "' 
			AND is_read = '0'");

		return $query->row['total'];
	}

	public function getUnreadAffiliateNotifications($affiliate_id) {
		$query = $this->db->query("
			SELECT COUNT(notification_id) AS total 
			FROM {$this->db->prefix}affiliate_inbox 
			WHERE affiliate_id = '" . (int)$affiliate_id . "' 
			AND is_read = '0'");

		return $query->row['total'];
	}

	public function findSlugByName($slug) {
		$query = $this->db->query("
			SELECT query 
			FROM {$this->db->prefix}affiliate_route 
			WHERE slug = '" . $this->db->escape($slug) . "' 
			UNION ALL 
			SELECT query 
			FROM {$this->db->prefix}route 
			WHERE slug = '" . $this->db->escape($slug) . "' 
			UNION ALL 
			SELECT query 
			FROM {$this->db->prefix}vanity_route 
			WHERE slug = '" . $this->db->escape($slug) . "'
		");

		return ($query->num_rows) ? $query->row['query'] : false;
    }

    public function getNewCustomerDetail ($customer_id, $address_id) {
    	$user = $this->db->query("
    		SELECT username, email 
    		FROM {$this->db->prefix}customer 
    		WHERE customer_id = '" . (int)$customer_id . "'
    	");

		$username = $user->row['username'];
		$email    = $user->row['email'];

		$address_query = $this->db->query("
            SELECT DISTINCT * 
            FROM {$this->db->prefix}address 
            WHERE address_id = '" . (int)$address_id . "' 
            AND customer_id  = '" . (int)$customer_id . "'
        ");
        
        if ($address_query->num_rows):
            $country_query = $this->db->query("
                SELECT * 
                FROM `{$this->db->prefix}country` 
                WHERE country_id = '" . (int)$address_query->row['country_id'] . "'
            ");
            
            if ($country_query->num_rows):
				$country = $country_query->row['name'];
            else:
				$country = '';
            endif;
            
            $zone_query = $this->db->query("
                SELECT * 
                FROM `{$this->db->prefix}zone` 
                WHERE zone_id = '" . (int)$address_query->row['zone_id'] . "'
            ");
            
            if ($zone_query->num_rows):
				$zone = $zone_query->row['name'];
            else:
				$zone = '';
            endif;
            
            $address_data = array(
				'username'       => $username,
				'firstname'      => $address_query->row['firstname'],
				'lastname'       => $address_query->row['lastname'],
				'email'          => $email,
				'company'        => $address_query->row['company'],
				'address_1'      => $address_query->row['address_1'],
				'address_2'      => $address_query->row['address_2'],
				'postcode'       => $address_query->row['postcode'],
				'city'           => $address_query->row['city'],
				'zone'           => $zone,
				'country'        => $country
            );
            
            return $address_data;
        else:
            return false;
        endif;
    }

    /**
     * The following methods are for Email queue execution.
     */
    
    public function pruneQueue() {
    	$this->db->query("
    		DELETE FROM {$this->db->prefix}notification_queue 
    		WHERE sent = '1'");
    }

    public function getQueue($data = array()) {
    	if (isset($data['filter_status'])):
    		$status = $data['filter_status'];
    	else:
    		$status = 0;
    	endif;

    	$query = $this->db->query("
    		SELECT * 
    		FROM {$this->db->prefix}notification_queue 
    		WHERE sent = '" . (int)$status . "' LIMIT 0, 50
    	");

    	return $query->rows;
    }

    public function updateQueue($queue_id) {
    	$this->db->query("
    		UPDATE {$this->db->prefix}notification_queue 
    		SET 
				sent      = '1', 
				date_sent = NOW() 
    		WHERE queue_id = '" . (int)$queue_id . "'
    	");
    }
}
