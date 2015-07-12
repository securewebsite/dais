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

namespace Dais\Services\Providers\People;

class Customer {
    
    private $customer_id;
    private $username;
    private $firstname;
    private $lastname;
    private $email;
    private $telephone;
    private $newsletter;
    private $address_id;
    private $customer_products;
    private $code;
    private $is_affiliate;
    private $referral_id;
    
    public $customer_group_id;
    public $customer_group_name;
    
    public function __construct() {
        
        if (!is_null(Session::get('customer_id'))):
            $this->customer_id         = Session::get('customer_id');
            $this->username            = Session::get('username');
            $this->firstname           = Session::get('firstname');
            $this->lastname            = Session::get('lastname');
            $this->email               = Session::get('email');
            $this->telephone           = Session::get('telephone');
            $this->newsletter          = Session::get('newsletter');
            $this->customer_group_id   = Session::get('customer_group_id');
            $this->customer_group_name = Session::get('customer_group_name');
            $this->address_id          = Session::get('address_id');
            $this->referral_id         = Session::get('referral_id');
            $this->customer_products   = Session::get('customer_products');
            $this->is_affiliate        = Session::get('is_affiliate');

            if ($this->is_affiliate):
                $this->code = Session::get('code');
            else:
                $this->code = false;
            endif;
            
            DB::query("
                UPDATE " . DB::prefix() . "customer 
                SET 
                    cart = '" . DB::escape(!is_null(Session::get('cart')) ? serialize(Session::get('cart')) : '') . "', 
                    wishlist = '" . DB::escape(!is_null(Session::get('wishlist')) ? serialize(Session::get('wishlist')) : '') . "', 
                    ip = '" . DB::escape(Request::server('REMOTE_ADDR')) . "' 
                WHERE customer_id = '" . (int)$this->customer_id . "'
            ");
        else:
            $this->logout();
        endif;
    }
    
    public function login($email, $password, $override = false) {
        if ($override):
            $customer_query = DB::query("
                SELECT * FROM " . DB::prefix() . "customer 
                WHERE LOWER(email) = '" . DB::escape(Encode::strtolower($email)) . "' 
                AND status = '1'
            ");
        else:
            $customer_query = DB::query("
                SELECT * FROM " . DB::prefix() . "customer 
                WHERE (LOWER(email) = '" . DB::escape(Encode::strtolower($email)) . "') 
                OR LOWER(username) = '" . DB::escape(Encode::strtolower($email)) . "' 
                AND (password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1('" . DB::escape($password) . "'))))) 
                OR password = '" . DB::escape(md5($password)) . "') 
                AND status = '1' 
                AND approved = '1'
            ");
        endif;
        
        if ($customer_query->num_rows):
            Session::set('customer_id', $customer_query->row['customer_id']);
            
            if ($customer_query->row['cart'] && is_string($customer_query->row['cart'])):
                $cart = unserialize($customer_query->row['cart']);
                
                foreach ($cart as $key => $value):
                    if (!array_key_exists($key, Session::get('cart'))):
                        Session::p()->data['cart'][$key] = $value;
                    else:
                        Session::p()->data['cart'][$key] += $value;
                    endif;
                endforeach;
            endif;
            
            if ($customer_query->row['wishlist'] && is_string($customer_query->row['wishlist'])):
                if (is_null(Session::get('wishlist'))):
                    Session::set('wishlist', array());
                endif;
                
                $wishlist = unserialize($customer_query->row['wishlist']);
                
                foreach ($wishlist as $product_id):
                    if (!in_array($product_id, Session::get('wishlist'))):
                        Session::p()->data['wishlist'][] = $product_id;
                    endif;
                endforeach;
            endif;
            
            Session::set('customer_id', $customer_query->row['customer_id']);
            Session::set('username', $customer_query->row['username']);
            Session::set('firstname', $customer_query->row['firstname']);
            Session::set('lastname', $customer_query->row['lastname']);
            Session::set('email', $customer_query->row['email']);
            Session::set('telephone', $customer_query->row['telephone']);
            Session::set('newsletter', $customer_query->row['newsletter']);
            Session::set('customer_group_id', $customer_query->row['customer_group_id']);
            Session::set('address_id', $customer_query->row['address_id']);
            Session::set('referral_id', $customer_query->row['referral_id']);
            Session::set('is_affiliate', $customer_query->row['is_affiliate']);
            Session::set('code', $customer_query->row['code']);

            $customer_group_query = DB::query("
                SELECT name 
                FROM " . DB::prefix() . "customer_group_description 
                WHERE customer_group_id = '" . (int)$customer_query->row['customer_group_id'] . "' 
                AND language_id = '" . (int)Config::get('config_language_id') . "'");
            
            Session::get('customer_group_name', strtolower($customer_group_query->row['name']));
            
            DB::query("
                UPDATE " . DB::prefix() . "customer 
                SET 
                    ip    = '" . DB::escape(Request::server('REMOTE_ADDR')) . "', 
                    reset = '' 
                WHERE customer_id = '" . (int)$customer_query->row['customer_id'] . "'
            ");
            
            // get any customer specific product ids
            $query = DB::query("
                SELECT product_id 
                FROM " . DB::prefix() . "product 
                WHERE customer_id = '" . (int)$customer_query->row['customer_id'] . "' 
                AND status = '1' 
                AND visibility <= '" . (int)$customer_query->row['customer_group_id'] . "' 
                AND date_available < NOW()");
            
            Session::set('customer_products', array());
            
            if ($query->num_rows):
                foreach ($query->rows as $product_id):
                    if (!in_array($product_id, Session::get('customer_products'))):
                        Session::p()->data['customer_products'][] = $product_id;
                    endif;
                endforeach;
            endif;
            
            return true;
        else:
            return false;
        endif;
    }
    
    public function logout() {
        DB::query("
            UPDATE " . DB::prefix() . "customer 
            SET 
                cart     = '" . DB::escape(!is_null(Session::get('cart')) ? serialize(Session::get('cart')) : '') . "', 
                wishlist = '" . DB::escape(!is_null(Session::get('wishlist')) ? serialize(Session::get('wishlist')) : '') . "' 
            WHERE customer_id = '" . (int)$this->customer_id . "'
        ");
        
        unset(Session::p()->data['customer_id']);
        unset(Session::p()->data['username']);
        unset(Session::p()->data['firstname']);
        unset(Session::p()->data['lastname']);
        unset(Session::p()->data['email']);
        unset(Session::p()->data['telephone']);
        unset(Session::p()->data['newsletter']);
        unset(Session::p()->data['customer_group_id']);
        unset(Session::p()->data['customer_group_name']);
        unset(Session::p()->data['address_id']);
        unset(Session::p()->data['referral_id']);
        unset(Session::p()->data['customer_products']);
        unset(Session::p()->data['is_affiliate']);
        unset(Session::p()->data['code']);
        
        $this->customer_id         = '';
        $this->username            = '';
        $this->firstname           = '';
        $this->lastname            = '';
        $this->email               = '';
        $this->telephone           = '';
        $this->newsletter          = '';
        $this->customer_group_name = '';
        $this->address_id          = '';
        $this->referral_id         = '';
        $this->customer_products   = false;
        $this->is_affiliate        = false;
        $this->code                = false;

        // set group id to publically visible
        $this->customer_group_id = Config::get('config_default_visibility');
    }
    
    public function isLogged() {
        return $this->customer_id;
    }
    
    public function getId() {
        return $this->customer_id;
    }
    
    public function getUsername() {
        return $this->username;
    }
    
    public function getFirstName() {
        return $this->firstname;
    }
    
    public function getLastName() {
        return $this->lastname;
    }
    
    public function getEmail() {
        return $this->email;
    }
    
    public function getTelephone() {
        return $this->telephone;
    }
    
    public function getNewsletter() {
        return $this->newsletter;
    }
    
    public function getGroupId() {
        return $this->customer_group_id;
    }
    
    public function getGroupName() {
        return $this->customer->customer_group_name;
    }
    
    public function setGroupId($group_id) {
        Session::set('customer_group_id', $group_id);
        $this->customer_group_id = $group_id;
    }
    
    public function setGroupName($name) {    
        Session::set('customer_group_name', $name);
        $this->customer_group_name = $name;
    }
    
    public function getAddressId() {
        return $this->address_id;
    }

    public function getReferralId() {
        return $this->referral_id;
    }

    public function setReferralId($id) {
        Session::set('referral_id', $id);
        $this->referral_id = $id;
    }
    
    public function getUploadPath() {
        return $this->upload_path;
    }
    
    public function getCustomerProducts() {
        return $this->customer_products;
    }

    public function isAffiliate() {
        return $this->is_affiliate;
    }

    public function setAffiliate() {
        Session::set('is_affiliate', 1);
        $this->is_affiliate = 1;
    }

    public function getCode() {
        return $this->code;
    }

    public function setCode($code) {
        Session::set('code', $code);
        $this->code = $code;
    }
    
    public function getBalance() {
        $query = DB::query("
            SELECT SUM(amount) AS total 
            FROM " . DB::prefix() . "customer_credit 
            WHERE customer_id = '" . (int)$this->customer_id . "'
        ");
        
        return $query->row['total'];
    }
    
    public function getRewardPoints() { 
        $query = DB::query("
            SELECT SUM(points) AS total 
            FROM " . DB::prefix() . "customer_reward 
            WHERE customer_id = '" . (int)$this->customer_id . "'
        ");
        
        return $query->row['total'];
    }
    
    public function addReward($customer_id, $description, $points, $order_id = 0) {
        DB::query("
            INSERT INTO " . DB::prefix() . "customer_reward 
            SET 
                customer_id = '" . (int)$customer_id . "', 
                order_id    = '" . (int)$order_id . "', 
                points      = '" . (int)$points . "', 
                description = '" . DB::escape($description) . "', 
                date_added  = NOW()
        ");
    }

    public function addCommission($customer_id, $order_id, $description, $amount) {
        DB::query("
            INSERT INTO " . DB::prefix() . "customer_commission 
            SET 
                customer_id = '" . (int)$customer_id . "', 
                order_id    = '" . (int)$order_id . "', 
                description = '" . DB::escape($description) . "', 
                amount      = '" . (float)$amount . "', 
                date_added  = NOW()
        ");
    }
    
    public function updateCustomerGroup($group_id) { 
        DB::query("
            UPDATE " . DB::prefix() . "customer 
            SET customer_group_id = '" . (int)$group_id . "' 
            WHERE customer_id = '" . (int)$this->customer_id . "'");
    }
    
    public function processMembership($products) {
        // find all recurring products in ordered products passed in
        // should be only one but you never know
        $recurring_products = array();
        
        foreach ($products as $product_id):
            $query = DB::query("
                SELECT COUNT(recurring_id) AS total 
                FROM " . DB::prefix() . "product_recurring 
                WHERE product_id = '" . (int)$product_id . "'");
            
            if ($query->num_rows):
                $recurring_products[] = $product_id;
            endif;
        endforeach;
        
        // now get the model name of our recurring products
        $recurring_models = array();
        
        if (!empty($recurring_products)):
            foreach ($recurring_products as $product_id):
                $query = DB::query("
                    SELECT model 
                    FROM " . DB::prefix() . "product 
                    WHERE product_id = '" . (int)$product_id . "'");
                
                foreach ($query->rows as $row):
                    $recurring_models[] = strtolower($row['model']);
                endforeach;
            endforeach;
        else:
            
            // no recurring products let's bail.
            return;
        endif;
        
        $group_names = array();
        
        // fetch an array of our customer groups
        $groups = DB::query("
            SELECT * 
            FROM " . DB::prefix() . "customer_group_description 
            WHERE language_id = '" . (int)Config::get('config_language_id') . "'");
        
        foreach ($groups->rows as $group):
            $group_names[strtolower($group['name']) ] = $group['customer_group_id'];
        endforeach;
        
        // recurring_models should not be empty since we bailed
        // if there were no recurring products, iterating the loop should not error
        foreach ($recurring_models as $key => $value):
            if (array_key_exists($value, $group_names)):
                $group_id = $group_names[$value];
                
                if ($value == $this->customer->customer_group_name):
                    // our customer is already this member type
                    // nothing to do but bail.
                    return;
                else:
                    // update session, update class, update db
                    $this->setGroupId($group_id);
                    $this->updateCustomerGroup($group_id);
                    $this->setGroupName($value);
                endif;
            endif;
        endforeach;
    }
}
