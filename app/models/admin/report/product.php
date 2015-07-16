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

namespace App\Models\Admin\Report;

use App\Models\Model;

class Product extends Model {
    
    public function getProductsViewed($data = array()) {
        $sql = "SELECT pd.name, p.model, p.viewed FROM " . DB::prefix() . "product p LEFT JOIN " . DB::prefix() . "product_description pd ON (p.product_id = pd.product_id) WHERE pd.language_id = '" . (int)Config::get('config_language_id') . "' AND p.viewed > 0 ORDER BY p.viewed DESC";
        
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
    
    public function getTotalProductsViewed() {
        $query = DB::query("SELECT COUNT(*) AS total FROM " . DB::prefix() . "product WHERE viewed > 0");
        
        return $query->row['total'];
    }
    
    public function getTotalProductViews() {
        $query = DB::query("SELECT SUM(viewed) AS total FROM " . DB::prefix() . "product");
        
        return $query->row['total'];
    }
    
    public function reset() {
        DB::query("UPDATE " . DB::prefix() . "product SET viewed = '0'");
    }
    
    public function getPurchased($data = array()) {
        $sql = "SELECT op.name, op.model, SUM(op.quantity) AS quantity, SUM(op.total + op.total * op.tax / 100) AS total FROM " . DB::prefix() . "order_product op LEFT JOIN `" . DB::prefix() . "order` o ON (op.order_id = o.order_id)";
        
        if (!empty($data['filter_order_status_id'])) {
            $sql.= " WHERE o.order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
        } else {
            $sql.= " WHERE o.order_status_id > '0'";
        }
        
        if (!empty($data['filter_date_start'])) {
            $sql.= " AND DATE(o.date_added) >= '" . DB::escape($data['filter_date_start']) . "'";
        }
        
        if (!empty($data['filter_date_end'])) {
            $sql.= " AND DATE(o.date_added) <= '" . DB::escape($data['filter_date_end']) . "'";
        }
        
        $sql.= " GROUP BY op.model ORDER BY total DESC";
        
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
    
    public function getTotalPurchased($data) {
        $sql = "SELECT COUNT(DISTINCT op.model) AS total FROM `" . DB::prefix() . "order_product` op LEFT JOIN `" . DB::prefix() . "order` o ON (op.order_id = o.order_id)";
        
        if (!empty($data['filter_order_status_id'])) {
            $sql.= " WHERE o.order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
        } else {
            $sql.= " WHERE o.order_status_id > '0'";
        }
        
        if (!empty($data['filter_date_start'])) {
            $sql.= " AND DATE(o.date_added) >= '" . DB::escape($data['filter_date_start']) . "'";
        }
        
        if (!empty($data['filter_date_end'])) {
            $sql.= " AND DATE(o.date_added) <= '" . DB::escape($data['filter_date_end']) . "'";
        }
        
        $query = DB::query($sql);
        
        return $query->row['total'];
    }
}
