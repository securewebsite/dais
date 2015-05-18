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

namespace Dais\Library;
use Dais\Engine\Container;
use Dais\Service\LibraryService;

class Customer extends LibraryService {
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
    
    public function __construct(Container $app) {
        parent::__construct($app);
        
        $db      = $app['db'];
        $request = $app['request'];
        $session = $app['session'];
        
        if (isset($session->data['customer_id'])):
            $this->customer_id         = $session->data['customer_id'];
            $this->username            = $session->data['username'];
            $this->firstname           = $session->data['firstname'];
            $this->lastname            = $session->data['lastname'];
            $this->email               = $session->data['email'];
            $this->telephone           = $session->data['telephone'];
            $this->newsletter          = $session->data['newsletter'];
            $this->customer_group_id   = $session->data['customer_group_id'];
            $this->customer_group_name = $session->data['customer_group_name'];
            $this->address_id          = $session->data['address_id'];
            $this->referral_id         = $session->data['referral_id'];
            $this->customer_products   = $session->data['customer_products'];
            $this->is_affiliate        = $session->data['is_affiliate'];

            if ($this->is_affiliate):
                $this->code = $session->data['code'];
            else:
                $this->code = false;
            endif;
            
            $db->query("
                UPDATE {$db->prefix}customer 
                SET 
                    cart = '" . $db->escape(isset($session->data['cart']) ? serialize($session->data['cart']) : '') . "', 
                    wishlist = '" . $db->escape(isset($session->data['wishlist']) ? serialize($session->data['wishlist']) : '') . "', 
                    ip = '" . $db->escape($request->server['REMOTE_ADDR']) . "' 
                WHERE customer_id = '" . (int)$this->customer_id . "'
            ");
        else:
            $this->logout();
        endif;
    }
    
    public function login($email, $password, $override = false) {
        $db      = parent::$app['db'];
        $session = parent::$app['session'];
        $request = parent::$app['request'];
        $encode  = parent::$app['encode'];
        
        if ($override):
            $customer_query = $db->query("
                SELECT * FROM {$db->prefix}customer 
                WHERE LOWER(email) = '" . $db->escape($encode->strtolower($email)) . "' 
                AND status = '1'
            ");
        else:
            $customer_query = $db->query("
                SELECT * FROM {$db->prefix}customer 
                WHERE (LOWER(email) = '" . $db->escape($encode->strtolower($email)) . "') 
                OR LOWER(username) = '" . $db->escape($encode->strtolower($email)) . "' 
                AND (password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1('" . $db->escape($password) . "'))))) 
                OR password = '" . $db->escape(md5($password)) . "') 
                AND status = '1' 
                AND approved = '1'
            ");
        endif;
        
        if ($customer_query->num_rows):
            $session->data['customer_id'] = $customer_query->row['customer_id'];
            
            if ($customer_query->row['cart'] && is_string($customer_query->row['cart'])):
                $cart = unserialize($customer_query->row['cart']);
                
                foreach ($cart as $key => $value):
                    if (!array_key_exists($key, $session->data['cart'])):
                        $session->data['cart'][$key] = $value;
                    else:
                        $session->data['cart'][$key]+= $value;
                    endif;
                endforeach;
            endif;
            
            if ($customer_query->row['wishlist'] && is_string($customer_query->row['wishlist'])):
                if (!isset($session->data['wishlist'])):
                    $session->data['wishlist'] = array();
                endif;
                
                $wishlist = unserialize($customer_query->row['wishlist']);
                
                foreach ($wishlist as $product_id):
                    if (!in_array($product_id, $session->data['wishlist'])):
                        $session->data['wishlist'][] = $product_id;
                    endif;
                endforeach;
            endif;
            
            $session->data['customer_id']       = $customer_query->row['customer_id'];
            $session->data['username']          = $customer_query->row['username'];
            $session->data['firstname']         = $customer_query->row['firstname'];
            $session->data['lastname']          = $customer_query->row['lastname'];
            $session->data['email']             = $customer_query->row['email'];
            $session->data['telephone']         = $customer_query->row['telephone'];
            $session->data['newsletter']        = $customer_query->row['newsletter'];
            $session->data['customer_group_id'] = $customer_query->row['customer_group_id'];
            $session->data['address_id']        = $customer_query->row['address_id'];
            $session->data['referral_id']       = $customer_query->row['referral_id'];
            $session->data['is_affiliate']      = $customer_query->row['is_affiliate'];
            $session->data['code']              = $customer_query->row['code'];

            $customer_group_query = $db->query("
                SELECT name 
                FROM {$db->prefix}customer_group_description 
                WHERE customer_group_id = '" . (int)$customer_query->row['customer_group_id'] . "' 
                AND language_id = '" . (int)parent::$app['config_language_id'] . "'");
            
            $session->data['customer_group_name'] = strtolower($customer_group_query->row['name']);
            
            $db->query("
                UPDATE {$db->prefix}customer 
                SET 
                    ip    = '" . $db->escape($request->server['REMOTE_ADDR']) . "', 
                    reset = '' 
                WHERE customer_id = '" . (int)$customer_query->row['customer_id'] . "'
            ");
            
            // get any customer specific product ids
            $query = $db->query("
                SELECT product_id 
                FROM {$db->prefix}product 
                WHERE customer_id = '" . (int)$customer_query->row['customer_id'] . "' 
                AND status = '1' 
                AND visibility <= '" . (int)$customer_query->row['customer_group_id'] . "' 
                AND date_available < NOW()");
            
            $session->data['customer_products'] = array();
            
            if ($query->num_rows):
                foreach ($query->rows as $product_id):
                    if (!in_array($product_id, $session->data['customer_products'])):
                        $session->data['customer_products'][] = $product_id;
                    endif;
                endforeach;
            endif;
            
            return true;
        else:
            return false;
        endif;
    }
    
    public function logout() {
        $db      = parent::$app['db'];
        $session = parent::$app['session'];
        
        $db->query("
            UPDATE {$db->prefix}customer 
            SET 
                cart     = '" . $db->escape(isset($session->data['cart']) ? serialize($session->data['cart']) : '') . "', 
                wishlist = '" . $db->escape(isset($session->data['wishlist']) ? serialize($session->data['wishlist']) : '') . "' 
            WHERE customer_id = '" . (int)$this->customer_id . "'
        ");
        
        unset($session->data['customer_id']);
        unset($session->data['username']);
        unset($session->data['firstname']);
        unset($session->data['lastname']);
        unset($session->data['email']);
        unset($session->data['telephone']);
        unset($session->data['newsletter']);
        unset($session->data['customer_group_id']);
        unset($session->data['customer_group_name']);
        unset($session->data['address_id']);
        unset($session->data['referral_id']);
        unset($session->data['customer_products']);
        unset($session->data['is_affiliate']);
        unset($session->data['code']);
        
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
        $this->customer_group_id = parent::$app['config_default_visibility'];
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
        $session = parent::$app['session'];
        
        $session->data['customer_group_id'] = $group_id;
        $this->customer_group_id            = $group_id;
    }
    
    public function setGroupName($name) {
        $session = parent::$app['session'];
        
        $session->data['customer_group_name'] = $name;
        $this->customer_group_name            = $name;
    }
    
    public function getAddressId() {
        return $this->address_id;
    }

    public function getReferralId() {
        return $this->referral_id;
    }

    public function setReferralId($id) {
        $session = parent::$app['session'];
        
        $session->data['referral_id'] = $id;
        $this->referral_id            = $id;
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
        $session = parent::$app['session'];

        $session->data['is_affiliate'] = 1;
        $this->is_affiliate            = 1;
    }

    public function getCode() {
        return $this->code;
    }

    public function setCode($code) {
        $session = parent::$app['session'];

        $session->data['code'] = $code;
        $this->code            = $code;
    }
    
    public function getBalance() {
        $db = parent::$app['db'];
        
        $query = $db->query("
            SELECT SUM(amount) AS total 
            FROM {$db->prefix}customer_credit 
            WHERE customer_id = '" . (int)$this->customer_id . "'
        ");
        
        return $query->row['total'];
    }
    
    public function getRewardPoints() {
        $db = parent::$app['db'];
        
        $query = $db->query("
            SELECT SUM(points) AS total 
            FROM {$db->prefix}customer_reward 
            WHERE customer_id = '" . (int)$this->customer_id . "'
        ");
        
        return $query->row['total'];
    }
    
    public function addReward($customer_id, $description, $points, $order_id = 0) {
        $db = parent::$app['db'];
        
        $db->query("
            INSERT INTO {$db->prefix}customer_reward 
            SET 
                customer_id = '" . (int)$customer_id . "', 
                order_id = '" . (int)$order_id . "', 
                points = '" . (int)$points . "', 
                description = '" . $db->escape($description) . "', 
                date_added = NOW()
        ");
    }

    public function addCommission($customer_id, $order_id, $description, $amount) {
        $db = parent::$app['db'];

        $query = $db->query("
            INSERT INTO {$db->prefix}customer_commission 
            SET 
                customer_id = '" . (int)$customer_id . "', 
                order_id    = '" . (int)$order_id . "', 
                description = '" . $db->escape($description) . "', 
                amount      = '" . (float)$amount . "', 
                date_added  = NOW()
        ");
    }
    
    public function updateCustomerGroup($group_id) {
        $db = parent::$app['db'];
        
        $db->query("
            UPDATE {$db->prefix}customer 
            SET customer_group_id = '" . (int)$group_id . "' 
            WHERE customer_id = '" . (int)$this->customer_id . "'");
    }
    
    public function processMembership($products) {
        $db = parent::$app['db'];
        
        // find all recurring products in ordered products passed in
        // should be only one but you never know
        $recurring_products = array();
        
        foreach ($products as $product_id):
            $query = $db->query("
                SELECT COUNT(recurring_id) AS total 
                FROM {$db->prefix}product_recurring 
                WHERE product_id = '" . (int)$product_id . "'");
            
            if ($query->num_rows):
                $recurring_products[] = $product_id;
            endif;
        endforeach;
        
        // now get the model name of our recurring products
        $recurring_models = array();
        
        if (!empty($recurring_products)):
            foreach ($recurring_products as $product_id):
                $query = $db->query("
                    SELECT model 
                    FROM {$db->prefix}product 
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
        $groups = $db->query("
            SELECT * 
            FROM {$db->prefix}customer_group_description 
            WHERE language_id = '" . (int)parent::$app['config_language_id'] . "'");
        
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
