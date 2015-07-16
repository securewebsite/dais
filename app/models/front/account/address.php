<?php

/*
|--------------------------------------------------------------------------
|   Dais
|--------------------------------------------------------------------------
|
|   This file is part of the Dais Framework package.
|   
|   (c) Vince Kronlein <vince@dais.io>
|   
|   For the full copyright and license information, please view the LICENSE
|   file that was distributed with this source code.
|   
*/

namespace App\Models\Front\Account;
use App\Models\Model;

class Address extends Model {
    public function addAddress($data) {
        DB::query("
            INSERT INTO " . DB::prefix() . "address 
            SET 
                customer_id = '" . (int)\Customer::getId() . "', 
                firstname   = '" . DB::escape($data['firstname']) . "', 
                lastname    = '" . DB::escape($data['lastname']) . "', 
                company     = '" . DB::escape($data['company']) . "', 
                company_id  = '" . DB::escape(isset($data['company_id']) ? $data['company_id'] : '') . "', 
                tax_id      = '" . DB::escape(isset($data['tax_id']) ? $data['tax_id'] : '') . "', 
                address_1   = '" . DB::escape($data['address_1']) . "', 
                address_2   = '" . DB::escape($data['address_2']) . "', 
                postcode    = '" . DB::escape($data['postcode']) . "', 
                city        = '" . DB::escape($data['city']) . "', 
                zone_id     = '" . (int)$data['zone_id'] . "', 
                country_id  = '" . (int)$data['country_id'] . "'
        ");
        
        $address_id = DB::getLastId();
        
        if (!empty($data['default'])) {
            DB::query("
                UPDATE " . DB::prefix() . "customer 
                SET 
                    address_id = '" . (int)$address_id . "' 
                WHERE customer_id = '" . (int)\Customer::getId() . "'
            ");
        }
        
        Theme::trigger('front_customer_add_address', array('address_id' => $address_id));
        
        return $address_id;
    }
    
    public function editAddress($address_id, $data) {
        DB::query("
            UPDATE " . DB::prefix() . "address 
            SET 
                firstname = '" . DB::escape($data['firstname']) . "', 
                lastname = '" . DB::escape($data['lastname']) . "', 
                company = '" . DB::escape($data['company']) . "', 
                company_id = '" . DB::escape(isset($data['company_id']) ? $data['company_id'] : '') . "', 
                tax_id = '" . DB::escape(isset($data['tax_id']) ? $data['tax_id'] : '') . "', 
                address_1 = '" . DB::escape($data['address_1']) . "', 
                address_2 = '" . DB::escape($data['address_2']) . "', 
                postcode = '" . DB::escape($data['postcode']) . "', 
                city = '" . DB::escape($data['city']) . "', 
                zone_id = '" . (int)$data['zone_id'] . "', 
                country_id = '" . (int)$data['country_id'] . "' 
            WHERE address_id  = '" . (int)$address_id . "' 
            AND customer_id = '" . (int)\Customer::getId() . "'
        ");
        
        if (!empty($data['default'])) {
            DB::query("
                UPDATE " . DB::prefix() . "customer 
                SET address_id = '" . (int)$address_id . "' 
                WHERE customer_id = '" . (int)\Customer::getId() . "'
            ");
        }
        
        Theme::trigger('front_customer_edit_address', array('address_id' => $address_id));
    }
    
    public function deleteAddress($address_id) {
        DB::query("
            DELETE FROM " . DB::prefix() . "address 
            WHERE address_id = '" . (int)$address_id . "' 
            AND customer_id = '" . (int)\Customer::getId() . "'
        ");
        
        Theme::trigger('front_customer_delete_address', array('address_id' => $address_id));
    }
    
    public function getAddress($address_id) {
        $address_query = DB::query("
            SELECT DISTINCT * 
            FROM " . DB::prefix() . "address 
            WHERE address_id = '" . (int)$address_id . "' 
            AND customer_id = '" . (int)\Customer::getId() . "'
        ");
        
        if ($address_query->num_rows) {
            $country_query = DB::query("
                SELECT * 
                FROM `" . DB::prefix() . "country` 
                WHERE country_id = '" . (int)$address_query->row['country_id'] . "'
            ");
            
            if ($country_query->num_rows) {
                $country = $country_query->row['name'];
                $iso_code_2 = $country_query->row['iso_code_2'];
                $iso_code_3 = $country_query->row['iso_code_3'];
                $address_format = $country_query->row['address_format'];
            } else {
                $country = '';
                $iso_code_2 = '';
                $iso_code_3 = '';
                $address_format = '';
            }
            
            $zone_query = DB::query("
                SELECT * 
                FROM `" . DB::prefix() . "zone` 
                WHERE zone_id = '" . (int)$address_query->row['zone_id'] . "'
            ");
            
            if ($zone_query->num_rows) {
                $zone = $zone_query->row['name'];
                $zone_code = $zone_query->row['code'];
            } else {
                $zone = '';
                $zone_code = '';
            }
            
            $address_data = array(
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
            
            return $address_data;
        } else {
            return false;
        }
    }
    
    public function getAddresses() {
        $address_data = array();
        
        $query = DB::query("
            SELECT * 
            FROM " . DB::prefix() . "address 
            WHERE customer_id = '" . (int)\Customer::getId() . "'
        ");
        
        foreach ($query->rows as $result) {
            $country_query = DB::query("
                SELECT * 
                FROM `" . DB::prefix() . "country` 
                WHERE country_id = '" . (int)$result['country_id'] . "'
            ");
            
            if ($country_query->num_rows) {
                $country = $country_query->row['name'];
                $iso_code_2 = $country_query->row['iso_code_2'];
                $iso_code_3 = $country_query->row['iso_code_3'];
                $address_format = $country_query->row['address_format'];
            } else {
                $country = '';
                $iso_code_2 = '';
                $iso_code_3 = '';
                $address_format = '';
            }
            
            $zone_query = DB::query("
                SELECT * 
                FROM `" . DB::prefix() . "zone` 
                WHERE zone_id = '" . (int)$result['zone_id'] . "'
            ");
            
            if ($zone_query->num_rows) {
                $zone = $zone_query->row['name'];
                $zone_code = $zone_query->row['code'];
            } else {
                $zone = '';
                $zone_code = '';
            }
            
            $address_data[$result['address_id']] = array(
                'address_id'     => $result['address_id'],
                'firstname'      => $result['firstname'],
                'lastname'       => $result['lastname'],
                'company'        => $result['company'],
                'company_id'     => $result['company_id'],
                'tax_id'         => $result['tax_id'],
                'address_1'      => $result['address_1'],
                'address_2'      => $result['address_2'],
                'postcode'       => $result['postcode'],
                'city'           => $result['city'],
                'zone_id'        => $result['zone_id'],
                'zone'           => $zone,
                'zone_code'      => $zone_code,
                'country_id'     => $result['country_id'],
                'country'        => $country,
                'iso_code_2'     => $iso_code_2,
                'iso_code_3'     => $iso_code_3,
                'address_format' => $address_format
            );
        }
        
        return $address_data;
    }
    
    public function getTotalAddresses() {
        $query = DB::query("
            SELECT COUNT(*) AS total 
            FROM " . DB::prefix() . "address 
            WHERE customer_id = '" . (int)\Customer::getId() . "'
        ");
        
        return $query->row['total'];
    }
}
