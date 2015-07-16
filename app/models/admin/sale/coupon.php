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

class Coupon extends Model {
    
    public function addCoupon($data) {
        DB::query("
            INSERT INTO " . DB::prefix() . "coupon 
            SET 
                name = '" . DB::escape($data['name']) . "', 
                code = '" . DB::escape($data['code']) . "', 
                discount = '" . (float)$data['discount'] . "', 
                type = '" . DB::escape($data['type']) . "', 
                total = '" . (float)$data['total'] . "', 
                logged = '" . (int)$data['logged'] . "', 
                shipping = '" . (int)$data['shipping'] . "', 
                date_start = '" . DB::escape($data['date_start']) . "', 
                date_end = '" . DB::escape($data['date_end']) . "', 
                uses_total = '" . (int)$data['uses_total'] . "', 
                uses_customer = '" . (int)$data['uses_customer'] . "', 
                status = '" . (int)$data['status'] . "', 
                date_added = NOW()
        ");
        
        $coupon_id = DB::getLastId();
        
        if (isset($data['coupon_product'])) {
            foreach ($data['coupon_product'] as $product_id) {
                DB::query("
                    INSERT INTO " . DB::prefix() . "coupon_product 
                    SET 
                        coupon_id = '" . (int)$coupon_id . "', 
                        product_id = '" . (int)$product_id . "'
                ");
            }
        }
        
        if (isset($data['coupon_category'])) {
            foreach ($data['coupon_category'] as $category_id) {
                DB::query("
                    INSERT INTO " . DB::prefix() . "coupon_category 
                    SET 
                        coupon_id = '" . (int)$coupon_id . "', 
                        category_id = '" . (int)$category_id . "'
                ");
            }
        }
        
        Theme::trigger('admin_add_coupon', array('coupon_id' => $coupon_id));
    }
    
    public function editCoupon($coupon_id, $data) {
        DB::query("
            UPDATE " . DB::prefix() . "coupon 
            SET 
                name = '" . DB::escape($data['name']) . "', 
                code = '" . DB::escape($data['code']) . "', 
                discount = '" . (float)$data['discount'] . "', 
                type = '" . DB::escape($data['type']) . "', 
                total = '" . (float)$data['total'] . "', 
                logged = '" . (int)$data['logged'] . "', 
                shipping = '" . (int)$data['shipping'] . "', 
                date_start = '" . DB::escape($data['date_start']) . "', 
                date_end = '" . DB::escape($data['date_end']) . "', 
                uses_total = '" . (int)$data['uses_total'] . "', 
                uses_customer = '" . (int)$data['uses_customer'] . "', 
                status = '" . (int)$data['status'] . "' 
            WHERE coupon_id = '" . (int)$coupon_id . "'
        ");
        
        DB::query("
            DELETE FROM " . DB::prefix() . "coupon_product 
            WHERE coupon_id = '" . (int)$coupon_id . "'");
        
        if (isset($data['coupon_product'])) {
            foreach ($data['coupon_product'] as $product_id) {
                DB::query("
                    INSERT INTO " . DB::prefix() . "coupon_product 
                    SET 
                        coupon_id = '" . (int)$coupon_id . "', 
                        product_id = '" . (int)$product_id . "'
                ");
            }
        }
        
        DB::query("
            DELETE FROM " . DB::prefix() . "coupon_category 
            WHERE coupon_id = '" . (int)$coupon_id . "'");
        
        if (isset($data['coupon_category'])) {
            foreach ($data['coupon_category'] as $category_id) {
                DB::query("
                    INSERT INTO " . DB::prefix() . "coupon_category 
                    SET 
                        coupon_id = '" . (int)$coupon_id . "', 
                        category_id = '" . (int)$category_id . "'
                ");
            }
        }
        
        Theme::trigger('admin_edit_coupon', array('coupon_id' => $coupon_id));
    }
    
    public function deleteCoupon($coupon_id) {
        DB::query("
            DELETE FROM " . DB::prefix() . "coupon 
            WHERE coupon_id = '" . (int)$coupon_id . "'");

        DB::query("
            DELETE FROM " . DB::prefix() . "coupon_product 
            WHERE coupon_id = '" . (int)$coupon_id . "'");

        DB::query("
            DELETE FROM " . DB::prefix() . "coupon_category 
            WHERE coupon_id = '" . (int)$coupon_id . "'");

        DB::query("
            DELETE FROM " . DB::prefix() . "coupon_history 
            WHERE coupon_id = '" . (int)$coupon_id . "'");
        
        Theme::trigger('admin_delete_coupon', array('coupon_id' => $coupon_id));
    }
    
    public function getCoupon($coupon_id) {
        $query = DB::query("
            SELECT DISTINCT * 
            FROM " . DB::prefix() . "coupon 
            WHERE coupon_id = '" . (int)$coupon_id . "'");
        
        return $query->row;
    }
    
    public function getCouponByCode($code) {
        $query = DB::query("
            SELECT DISTINCT * 
            FROM " . DB::prefix() . "coupon 
            WHERE code = '" . DB::escape($code) . "'");
        
        return $query->row;
    }
    
    public function getCoupons($data = array()) {
        $sql = "
            SELECT 
                coupon_id, 
                name, 
                code, 
                discount, 
                date_start, 
                date_end, 
                status 
            FROM " . DB::prefix() . "coupon";
        
        $sort_data = array(
            'name', 
            'code', 
            'discount', 
            'date_start', 
            'date_end', 
            'status'
        );
        
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
        
        $query = DB::query($sql);
        
        return $query->rows;
    }
    
    public function getCouponProducts($coupon_id) {
        $coupon_product_data = array();
        
        $query = DB::query("
            SELECT * 
            FROM " . DB::prefix() . "coupon_product 
            WHERE coupon_id = '" . (int)$coupon_id . "'");
        
        foreach ($query->rows as $result) {
            $coupon_product_data[] = $result['product_id'];
        }
        
        return $coupon_product_data;
    }
    
    public function getCouponCategories($coupon_id) {
        $coupon_category_data = array();
        
        $query = DB::query("
            SELECT * 
            FROM " . DB::prefix() . "coupon_category 
            WHERE coupon_id = '" . (int)$coupon_id . "'");
        
        foreach ($query->rows as $result) {
            $coupon_category_data[] = $result['category_id'];
        }
        
        return $coupon_category_data;
    }
    
    public function getTotalCoupons() {
        $query = DB::query("
            SELECT COUNT(*) AS total 
            FROM " . DB::prefix() . "coupon");
        
        return $query->row['total'];
    }
    
    public function getCouponHistories($coupon_id, $start = 0, $limit = 10) {
        if ($start < 0) {
            $start = 0;
        }
        
        if ($limit < 1) {
            $limit = 10;
        }
        
        $query = DB::query("
            SELECT 
                ch.order_id, 
                CONCAT(c.firstname, ' ', c.lastname) AS customer, 
                ch.amount, 
                ch.date_added 
            FROM " . DB::prefix() . "coupon_history ch 
            LEFT JOIN " . DB::prefix() . "customer c 
            ON (ch.customer_id = c.customer_id) 
            WHERE ch.coupon_id = '" . (int)$coupon_id . "' 
            ORDER BY ch.date_added ASC 
            LIMIT " . (int)$start . "," . (int)$limit);
        
        return $query->rows;
    }
    
    public function getTotalCouponHistories($coupon_id) {
        $query = DB::query("
            SELECT COUNT(*) AS total 
            FROM " . DB::prefix() . "coupon_history 
            WHERE coupon_id = '" . (int)$coupon_id . "'");
        
        return $query->row['total'];
    }
}
