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

namespace App\Models\Front\Tool;
use App\Models\Model;

class Utility extends Model {
	public function getUnreadCustomerNotifications($customer_id) {
		$query = DB::query("
			SELECT COUNT(notification_id) AS total 
			FROM " . DB::prefix() . "customer_inbox 
			WHERE customer_id = '" . (int)$customer_id . "' 
			AND is_read = '0'");

		return $query->row['total'];
	}

	public function getUnreadAffiliateNotifications($affiliate_id) {
		$query = DB::query("
			SELECT COUNT(notification_id) AS total 
			FROM " . DB::prefix() . "affiliate_inbox 
			WHERE affiliate_id = '" . (int)$affiliate_id . "' 
			AND is_read = '0'");

		return $query->row['total'];
	}

	public function findSlugByName($slug) {
		$query = DB::query("
			SELECT query 
			FROM " . DB::prefix() . "affiliate_route 
			WHERE slug = '" . DB::escape($slug) . "' 
			UNION ALL 
			SELECT query 
			FROM " . DB::prefix() . "route 
			WHERE slug = '" . DB::escape($slug) . "' 
			UNION ALL 
			SELECT query 
			FROM " . DB::prefix() . "vanity_route 
			WHERE slug = '" . DB::escape($slug) . "'
		");

		return ($query->num_rows) ? $query->row['query'] : false;
    }

    public function getNewCustomerDetail ($customer_id, $address_id) {
    	$user = DB::query("
    		SELECT username, email 
    		FROM " . DB::prefix() . "customer 
    		WHERE customer_id = '" . (int)$customer_id . "'
    	");

		$username = $user->row['username'];
		$email    = $user->row['email'];

		$address_query = DB::query("
            SELECT DISTINCT * 
            FROM " . DB::prefix() . "address 
            WHERE address_id = '" . (int)$address_id . "' 
            AND customer_id  = '" . (int)$customer_id . "'
        ");
        
        if ($address_query->num_rows):
            $country_query = DB::query("
                SELECT * 
                FROM `" . DB::prefix() . "country` 
                WHERE country_id = '" . (int)$address_query->row['country_id'] . "'
            ");
            
            if ($country_query->num_rows):
				$country = $country_query->row['name'];
            else:
				$country = '';
            endif;
            
            $zone_query = DB::query("
                SELECT * 
                FROM `" . DB::prefix() . "zone` 
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
    	DB::query("
    		DELETE FROM " . DB::prefix() . "notification_queue 
    		WHERE sent = '1'");
    }

    public function getQueue($data = array()) {
    	if (isset($data['filter_status'])):
    		$status = $data['filter_status'];
    	else:
    		$status = 0;
    	endif;

    	$query = DB::query("
    		SELECT * 
    		FROM " . DB::prefix() . "notification_queue 
    		WHERE sent = '" . (int)$status . "' LIMIT 0, 50
    	");

    	return $query->rows;
    }

    public function updateQueue($queue_id) {
    	DB::query("
    		UPDATE " . DB::prefix() . "notification_queue 
    		SET 
				sent      = '1', 
				date_sent = NOW() 
    		WHERE queue_id = '" . (int)$queue_id . "'
    	");
    }
}
