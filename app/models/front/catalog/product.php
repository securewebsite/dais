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

namespace App\Models\Front\Catalog;
use App\Models\Model;
use Dais\Library\Template;
use Dais\Library\Text;

class Product extends Model {
    public function updateViewed($product_id) {
        DB::query("
			UPDATE " . DB::prefix() . "product 
			SET viewed = (viewed + 1) 
			WHERE product_id = '" . (int)$product_id . "'
		");
    }
    
    public function getProduct($product_id) {
        if (Customer::isLogged()):
            $customer_group_id = Customer::getGroupId();
        else:
            $customer_group_id = Config::get('config_default_visibility');
        endif;
        
        $key = 'product.' . $product_id;
        $cachefile = Cache::get($key);
        
        if (is_bool($cachefile)):
            $query = DB::query("
				SELECT DISTINCT *, 
					pd.name AS name, 
					p.image, 
					m.name AS manufacturer, 
					(SELECT price 
						FROM " . DB::prefix() . "product_discount pd2 
						WHERE pd2.product_id = p.product_id 
						AND pd2.customer_group_id = '" . (int)$customer_group_id . "' 
						AND pd2.quantity = '1' 
						AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) 
						AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) 
						ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, 
					(SELECT price 
						FROM " . DB::prefix() . "product_special ps 
						WHERE ps.product_id = p.product_id 
						AND ps.customer_group_id = '" . (int)$customer_group_id . "' 
						AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) 
						AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) 
						ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special, 
					(SELECT points 
						FROM " . DB::prefix() . "product_reward pr 
						WHERE pr.product_id = p.product_id 
						AND customer_group_id = '" . (int)$customer_group_id . "') AS reward, 
					(SELECT ss.name 
						FROM " . DB::prefix() . "stock_status ss 
						WHERE ss.stock_status_id = p.stock_status_id 
						AND ss.language_id = '" . (int)Config::get('config_language_id') . "') AS stock_status, 
					(SELECT wcd.unit 
						FROM " . DB::prefix() . "weight_class_description wcd 
						WHERE p.weight_class_id = wcd.weight_class_id 
						AND wcd.language_id = '" . (int)Config::get('config_language_id') . "') AS weight_class, 
					(SELECT lcd.unit 
						FROM " . DB::prefix() . "length_class_description lcd 
						WHERE p.length_class_id = lcd.length_class_id 
						AND lcd.language_id = '" . (int)Config::get('config_language_id') . "') AS length_class, 
					(SELECT AVG(rating) AS total 
						FROM " . DB::prefix() . "review r1 
						WHERE r1.product_id = p.product_id 
						AND r1.status = '1' 
						GROUP BY r1.product_id) AS rating, 
					(SELECT COUNT(*) AS total 
						FROM " . DB::prefix() . "review r2 
						WHERE r2.product_id = p.product_id 
						AND r2.status = '1' 
						GROUP BY r2.product_id) AS reviews, 
					p.sort_order 
				FROM " . DB::prefix() . "product p 
				LEFT JOIN " . DB::prefix() . "product_description pd 
					ON (p.product_id = pd.product_id) 
				LEFT JOIN " . DB::prefix() . "product_to_store p2s 
					ON (p.product_id = p2s.product_id) 
				LEFT JOIN " . DB::prefix() . "manufacturer m 
					ON (p.manufacturer_id = m.manufacturer_id) 
				WHERE p.product_id = '" . (int)$product_id . "' 
				AND pd.language_id = '" . (int)Config::get('config_language_id') . "' 
				AND p.status = '1' 
				AND p.date_available <= NOW() 
				AND p.visibility <= '" . (int)$customer_group_id . "' 
				AND p.customer_id = '0' 
				AND p2s.store_id = '" . (int)Config::get('config_store_id') . "'
			");
            
            if ($query->num_rows):
                $product = array(
                    'product_id'       => $query->row['product_id'], 
                    'name'             => $query->row['name'], 
                    'description'      => $query->row['description'], 
                    'meta_description' => $query->row['meta_description'], 
                    'meta_keyword'     => $query->row['meta_keyword'], 
                    'tag'              => $this->getProductTags($query->row['product_id']), 
                    'model'            => $query->row['model'], 
                    'sku'              => $query->row['sku'], 
                    'upc'              => $query->row['upc'], 
                    'ean'              => $query->row['ean'], 
                    'jan'              => $query->row['jan'], 
                    'isbn'             => $query->row['isbn'], 
                    'mpn'              => $query->row['mpn'], 
                    'location'         => $query->row['location'], 
                    'visibility'       => $query->row['visibility'], 
                    'quantity'         => $query->row['quantity'], 
                    'stock_status'     => $query->row['stock_status'], 
                    'image'            => $query->row['image'], 
                    'manufacturer_id'  => $query->row['manufacturer_id'], 
                    'manufacturer'     => $query->row['manufacturer'], 
                    'price'            => ($query->row['discount'] ? $query->row['discount'] : $query->row['price']), 
                    'special'          => $query->row['special'], 
                    'reward'           => $query->row['reward'], 
                    'points'           => $query->row['points'], 
                    'tax_class_id'     => $query->row['tax_class_id'], 
                    'date_available'   => $query->row['date_available'], 
                    'weight'           => $query->row['weight'], 
                    'weight_class_id'  => $query->row['weight_class_id'], 
                    'length'           => $query->row['length'], 
                    'width'            => $query->row['width'], 
                    'height'           => $query->row['height'], 
                    'length_class_id'  => $query->row['length_class_id'], 
                    'subtract'         => $query->row['subtract'], 
                    'rating'           => round($query->row['rating']), 
                    'reviews'          => $query->row['reviews'] ? $query->row['reviews'] : 0, 
                    'minimum'          => $query->row['minimum'], 
                    'sort_order'       => $query->row['sort_order'], 
                    'status'           => $query->row['status'], 
                    'date_added'       => $query->row['date_added'], 
                    'event_id'         => (isset($query->row['event_id']) ? $query->row['event_id'] : 0), 
                    'date_modified'    => $query->row['date_modified'], 
                    'viewed'           => $query->row['viewed'], 
                    'customer_id'      => $query->row['customer_id'],
                    'paths'            => $this->buildPaths($query->row['product_id'])
                );
                
                $cachefile = $product;
                Cache::set($key, $cachefile);
            else:
                Cache::set($key, 0);
                return false;
            endif;
        endif;
        
        return $cachefile;
    }
    
    public function getProducts($data = array()) {
        if (Customer::isLogged()):
            $customer_group_id = Customer::getGroupId();
        else:
            $customer_group_id = Config::get('config_default_visibility');
        endif;
        
        if (!empty($data)):
            $key = 'products.all.' . md5(serialize($data));
            $cachefile = Cache::get($key);
            
            if (is_bool($cachefile)):
                if (!empty($data['filter_tag'])):
                    return $this->getProductsByTag($data['filter_tag']);
                endif;
                $sql = "
					SELECT p.product_id, 
						(SELECT AVG(rating) AS total 
							FROM " . DB::prefix() . "review r1 
							WHERE r1.product_id = p.product_id 
							AND r1.status = '1' 
							GROUP BY r1.product_id) AS rating, 
						(SELECT price 
							FROM " . DB::prefix() . "product_discount pd2 
							WHERE pd2.product_id = p.product_id 
							AND pd2.customer_group_id = '" . (int)$customer_group_id . "' 
							AND pd2.quantity = '1' 
							AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) 
							AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) 
							ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, 
						(SELECT price 
							FROM " . DB::prefix() . "product_special ps 
							WHERE ps.product_id = p.product_id 
							AND ps.customer_group_id = '" . (int)$customer_group_id . "' 
							AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) 
							AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) 
							ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special";
                
                if (!empty($data['filter_category_id'])):
                    
                    if (!empty($data['filter_sub_category'])):
                        $sql.= " FROM " . DB::prefix() . "category_path cp 
								  LEFT JOIN " . DB::prefix() . "product_to_category p2c 
									ON (cp.category_id = p2c.category_id)";
                    else:
                        $sql.= " FROM " . DB::prefix() . "product_to_category p2c";
                    endif;
                    
                    if (!empty($data['filter_filter'])):
                        $sql.= " LEFT JOIN " . DB::prefix() . "product_filter pf 
									ON (p2c.product_id = pf.product_id) 
								  LEFT JOIN " . DB::prefix() . "product p 
									ON (pf.product_id = p.product_id)";
                    else:
                        $sql.= " LEFT JOIN " . DB::prefix() . "product p 
									ON (p2c.product_id = p.product_id)";
                    endif;
                else:
                    $sql.= " FROM " . DB::prefix() . "product p";
                endif;
                
                $sql.= " LEFT JOIN " . DB::prefix() . "product_description pd 
							ON (p.product_id = pd.product_id) 
						  LEFT JOIN " . DB::prefix() . "product_to_store p2s 
							ON (p.product_id = p2s.product_id) 
						  WHERE pd.language_id = '" . (int)Config::get('config_language_id') . "' 
						  AND (p.end_date = '0000-00-00 00:00:00' OR p.end_date > NOW()) 
						  AND p.status = '1' 
						  AND p.visibility <= '" . (int)$customer_group_id . "' 
						  AND p.customer_id = '0' 
						  AND p.date_available <= NOW() 
						  AND p2s.store_id = '" . (int)Config::get('config_store_id') . "'";
                
                if (!empty($data['filter_category_id'])):
                    if (!empty($data['filter_sub_category'])):
                        $sql.= " AND cp.path_id = '" . (int)$data['filter_category_id'] . "'";
                    else:
                        $sql.= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
                    endif;
                    
                    if (!empty($data['filter_filter'])):
                        $implode = array();
                        $filters = explode(',', $data['filter_filter']);
                        
                        foreach ($filters as $filter_id):
                            $implode[] = (int)$filter_id;
                        endforeach;
                        
                        $sql.= " AND pf.filter_id IN (" . implode(',', $implode) . ")";
                    endif;
                endif;
                
                if (!empty($data['filter_name'])):
                    $sql.= " AND (";
                    
                    if (!empty($data['filter_name'])):
                        $implode = array();
                        $words = explode(' ', trim(preg_replace('/\s\s+/', ' ', $data['filter_name'])));
                        
                        foreach ($words as $word):
                            $implode[] = "pd.name LIKE '%" . DB::escape($word) . "%'";
                        endforeach;
                        
                        if ($implode):
                            $imp = implode(" && ", $implode);
                            $sql.= " {$imp}";
                        endif;
                        
                        if (!empty($data['filter_description'])):
                            $sql.= " OR pd.description LIKE '%" . DB::escape($data['filter_name']) . "%'";
                        endif;
                    endif;
                    
                    if (!empty($data['filter_name'])):
                        $sql.= " OR LCASE(p.model) = '" . DB::escape(Encode::strtolower($data['filter_name'])) . "'";
                    endif;
                    
                    if (!empty($data['filter_name'])):
                        $sql.= " OR LCASE(p.sku) = '" . DB::escape(Encode::strtolower($data['filter_name'])) . "'";
                    endif;
                    
                    if (!empty($data['filter_name'])):
                        $sql.= " OR LCASE(p.upc) = '" . DB::escape(Encode::strtolower($data['filter_name'])) . "'";
                    endif;
                    
                    if (!empty($data['filter_name'])):
                        $sql.= " OR LCASE(p.ean) = '" . DB::escape(Encode::strtolower($data['filter_name'])) . "'";
                    endif;
                    
                    if (!empty($data['filter_name'])):
                        $sql.= " OR LCASE(p.jan) = '" . DB::escape(Encode::strtolower($data['filter_name'])) . "'";
                    endif;
                    
                    if (!empty($data['filter_name'])):
                        $sql.= " OR LCASE(p.isbn) = '" . DB::escape(Encode::strtolower($data['filter_name'])) . "'";
                    endif;
                    
                    if (!empty($data['filter_name'])):
                        $sql.= " OR LCASE(p.mpn) = '" . DB::escape(Encode::strtolower($data['filter_name'])) . "'";
                    endif;
                    
                    $sql.= ")";
                endif;
                
                if (!empty($data['filter_manufacturer_id'])):
                    $sql.= " AND p.manufacturer_id = '" . (int)$data['filter_manufacturer_id'] . "'";
                endif;
                
                $sql.= " GROUP BY p.product_id";
                
                $sort_data = array('pd.name', 'p.model', 'p.quantity', 'p.price', 'rating', 'p.sort_order', 'p.date_added');
                
                if (isset($data['sort']) && in_array($data['sort'], $sort_data)):
                    if ($data['sort'] == 'pd.name' || $data['sort'] == 'p.model'):
                        $sql.= " ORDER BY LCASE({$data['sort']})";
                    elseif ($data['sort'] == 'p.price'):
                        $sql.= " ORDER BY (CASE WHEN special IS NOT NULL THEN special WHEN discount IS NOT NULL THEN discount ELSE p.price END)";
                    else:
                        $sql.= " ORDER BY {$data['sort']}";
                    endif;
                else:
                    $sql.= " ORDER BY p.sort_order";
                endif;
                
                if (isset($data['order']) && ($data['order'] == 'desc')):
                    $sql.= " DESC, LCASE(pd.name) DESC";
                else:
                    $sql.= " ASC, LCASE(pd.name) ASC";
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
                
                $product_data = array();
                
                $query = DB::query($sql);
                
                foreach ($query->rows as $result):
                    $product_data[$result['product_id']] = $this->getProduct($result['product_id']);
                endforeach;
                
                $cachefile = $product_data;
                Cache::set($key, $cachefile);
            endif;
            unset($key);
        else:
            $key = 'products.all.' . (int)Config::get('config_store_id');
            $cachefile = Cache::get($key);
            
            if (is_bool($cachefile)):
                $query = DB::query("
					SELECT p.product_id, 
						(SELECT AVG(rating) AS total 
							FROM " . DB::prefix() . "review r1 
							WHERE r1.product_id = p.product_id 
							AND r1.status = '1' 
							GROUP BY r1.product_id) AS rating, 
						(SELECT price 
							FROM " . DB::prefix() . "product_discount pd2 
							WHERE pd2.product_id = p.product_id 
							AND pd2.customer_group_id = '" . (int)$customer_group_id . "' 
							AND pd2.quantity = '1' 
							AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) 
							AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) 
							ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, 
						(SELECT price 
							FROM " . DB::prefix() . "product_special ps 
							WHERE ps.product_id = p.product_id 
							AND ps.customer_group_id = '" . (int)$customer_group_id . "' 
							AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) 
							AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) 
							ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special 
					FROM " . DB::prefix() . "product p 
					LEFT JOIN " . DB::prefix() . "product_description pd 
						ON (p.product_id = pd.product_id) 
					LEFT JOIN " . DB::prefix() . "product_to_store p2s 
						ON (p.product_id = p2s.product_id) 
					WHERE pd.language_id = '" . (int)Config::get('config_language_id') . "' 
					AND (p.end_date = '0000-00-00 00:00:00' OR p.end_date > NOW()) 
					AND p.status = '1' 
					AND p.visibility <= '" . (int)$customer_group_id . "' 
					AND p.customer_id = '0' 
					AND p.date_available <= NOW() 
					AND p2s.store_id = '" . (int)Config::get('config_store_id') . "' 
					GROUP BY p.product_id 
					ORDER BY p.sort_order ASC, LCASE(pd.name) ASC
				");
                
                $product_data = array();
                
                foreach ($query->rows as $result):
                    $product_data[$result['product_id']] = $this->getProduct($result['product_id']);
                endforeach;
                
                $cachefile = $product_data;
                Cache::set($key, $cachefile);
            endif;
        endif;
        
        return $cachefile;
    }

    public function getProductTags($product_id) {
        $query = DB::query("
            SELECT tag 
            FROM " . DB::prefix() . "tag 
            WHERE section   = 'product' 
            AND element_id  = '" . (int)$product_id . "' 
            AND language_id = '" . (int)Config::get('config_language_id') . "'
        ");
        
        if ($query->num_rows):
            $tags = array();
            foreach($query->rows as $row):
                $tags[] = $row['tag'];
            endforeach;
            return implode(', ', $tags);
        else:
            return false;
        endif;
    }
    
    public function getProductSpecials($data = array()) {
        if (Customer::isLogged()):
            $customer_group_id = Customer::getGroupId();
        else:
            $customer_group_id = Config::get('config_default_visibility');
        endif;
        
        if (!empty($data)):
            $key = 'products.special' . md5(serialize($data));
            $cachefile = Cache::get($key);
            
            if (is_bool($cachefile)):
                $sql = "
					SELECT DISTINCT 
						ps.product_id, 
						(SELECT AVG(rating) 
							FROM " . DB::prefix() . "review r1 
							WHERE r1.product_id = ps.product_id 
							AND r1.status = '1' 
							GROUP BY r1.product_id) AS rating 
					FROM " . DB::prefix() . "product_special ps 
					LEFT JOIN " . DB::prefix() . "product p 
						ON (ps.product_id = p.product_id) 
					LEFT JOIN " . DB::prefix() . "product_description pd 
						ON (p.product_id = pd.product_id) 
					LEFT JOIN " . DB::prefix() . "product_to_store p2s 
						ON (p.product_id = p2s.product_id) 
					WHERE p.status = '1' 
					AND p.visibility <= '" . (int)$customer_group_id . "' 
					AND p.customer_id = '0' 
					AND p.date_available <= NOW() 
					AND p2s.store_id = '" . (int)Config::get('config_store_id') . "' 
					AND ps.customer_group_id = '" . (int)$customer_group_id . "' 
					AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) 
					AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) 
					GROUP BY ps.product_id";
                
                $sort_data = array('pd.name', 'p.model', 'ps.price', 'rating', 'p.sort_order');
                
                if (isset($data['sort']) && in_array($data['sort'], $sort_data)):
                    if ($data['sort'] == 'pd.name' || $data['sort'] == 'p.model'):
                        $sql.= " ORDER BY LCASE({$data['sort']})";
                    else:
                        $sql.= " ORDER BY {$data['sort']}";
                    endif;
                else:
                    $sql.= " ORDER BY p.sort_order";
                endif;
                
                if (isset($data['order']) && ($data['order'] == 'desc')):
                    $sql.= " DESC, LCASE(pd.name) DESC";
                else:
                    $sql.= " ASC, LCASE(pd.name) ASC";
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
                
                $product_data = array();
                
                $query = DB::query($sql);
                
                foreach ($query->rows as $result):
                    $product_data[$result['product_id']] = $this->getProduct($result['product_id']);
                endforeach;
                
                $cachefile = $product_data;
                Cache::set($key, $cachefile);
            endif;
            unset($key);
        else:
            $key = 'products.special.' . (int)Config::get('config_store_id');
            $cachefile = Cache::get($key);
            
            if (is_bool($cachefile)):
                $query = DB::query("
					SELECT DISTINCT 
						ps.product_id, 
						(SELECT AVG(rating) 
							FROM " . DB::prefix() . "review r1 
							WHERE r1.product_id = ps.product_id 
							AND r1.status = '1' 
							GROUP BY r1.product_id) AS rating 
					FROM " . DB::prefix() . "product_special ps 
					LEFT JOIN " . DB::prefix() . "product p 
						ON (ps.product_id = p.product_id) 
					LEFT JOIN " . DB::prefix() . "product_description pd 
						ON (p.product_id = pd.product_id) 
					LEFT JOIN " . DB::prefix() . "product_to_store p2s 
						ON (p.product_id = p2s.product_id) 
					WHERE p.status = '1' 
					AND p.visibility <= '" . (int)$customer_group_id . "' 
					AND p.customer_id = '0' 
					AND p.date_available <= NOW() 
					AND p2s.store_id = '" . (int)Config::get('config_store_id') . "' 
					AND ps.customer_group_id = '" . (int)$customer_group_id . "' 
					AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) 
					AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) 
					GROUP BY ps.product_id 
					ORDER BY p.sort_order ASC, LCASE(pd.name) ASC
				");
                
                $product_data = array();
                
                foreach ($query->rows as $result):
                    $product_data[$result['product_id']] = $this->getProduct($result['product_id']);
                endforeach;
                
                $cachefile = $product_data;
                Cache::set($key, $cachefile);
            endif;
        endif;
        
        return $cachefile;
    }
    
    public function getLatestProducts($limit) {
        if (Customer::isLogged()):
            $customer_group_id = Customer::getGroupId();
        else:
            $customer_group_id = Config::get('config_default_visibility');
        endif;
        
        $key = 'products.latest.' . (int)Config::get('config_store_id');
        $cachefile = Cache::get($key);
        
        if (is_bool($cachefile)):
            $product_data = array();
            
            $query = DB::query("
				SELECT p.product_id 
				FROM " . DB::prefix() . "product p 
				LEFT JOIN " . DB::prefix() . "product_to_store p2s 
				ON (p.product_id = p2s.product_id) 
				WHERE p.status = '1' 
				AND p.visibility <= '" . (int)$customer_group_id . "' 
				AND p.customer_id = '0' 
				AND p.date_available <= NOW() 
				AND p2s.store_id = '" . (int)Config::get('config_store_id') . "' 
				ORDER BY p.date_added DESC LIMIT " . (int)$limit);
            
            foreach ($query->rows as $result):
                $product_data[$result['product_id']] = $this->getProduct($result['product_id']);
            endforeach;
            
            $cachefile = $product_data;
            Cache::set($key, $cachefile);
        endif;
        
        return $cachefile;
    }
    
    public function getPopularProducts($limit) {
        if (Customer::isLogged()):
            $customer_group_id = Customer::getGroupId();
        else:
            $customer_group_id = Config::get('config_default_visibility');
        endif;
        
        $key = 'products.popular.' . (int)Config::get('config_store_id');
        $cachefile = Cache::get($key);
        
        if (is_bool($cachefile)):
            $product_data = array();
            
            $query = DB::query("
				SELECT p.product_id 
				FROM " . DB::prefix() . "product p 
				LEFT JOIN " . DB::prefix() . "product_to_store p2s 
					ON (p.product_id = p2s.product_id) 
				WHERE p.status = '1' 
				AND p.visibility <= '" . (int)$customer_group_id . "' 
				AND p.customer_id = '0' 
				AND p.date_available <= NOW() 
				AND p2s.store_id = '" . (int)Config::get('config_store_id') . "' 
				ORDER BY p.viewed, p.date_added DESC LIMIT " . (int)$limit);
            
            foreach ($query->rows as $result):
                $product_data[$result['product_id']] = $this->getProduct($result['product_id']);
            endforeach;
            
            $cachefile = $product_data;
            Cache::set($key, $cachefile);
        endif;
        
        return $product_data;
    }
    
    public function getBestSellerProducts($limit) {
        if (Customer::isLogged()):
            $customer_group_id = Customer::getGroupId();
        else:
            $customer_group_id = Config::get('config_default_visibility');
        endif;
        
        $key = 'products.best_seller.' . (int)Config::get('config_store_id');
        $cachefile = Cache::get($key);
        
        if (is_bool($cachefile)):
            $product_data = array();
            
            $query = DB::query("
				SELECT op.product_id, 
					COUNT(*) AS total 
				FROM " . DB::prefix() . "order_product op 
				LEFT JOIN `" . DB::prefix() . "order` o 
					ON (op.order_id = o.order_id) 
				LEFT JOIN `" . DB::prefix() . "product` p 
					ON (op.product_id = p.product_id) 
				LEFT JOIN " . DB::prefix() . "product_to_store p2s 
					ON (p.product_id = p2s.product_id) 
				WHERE o.order_status_id > '0' 
				AND p.status = '1' 
				AND p.visibility <= '" . (int)$customer_group_id . "' 
				AND p.customer_id = '0' 
				AND p.date_available <= NOW() 
				AND p2s.store_id = '" . (int)Config::get('config_store_id') . "' 
				AND (p.end_date = '0000-00-00' OR p.end_date > NOW()) 
				GROUP BY op.product_id 
				ORDER BY total DESC LIMIT " . (int)$limit);
            
            foreach ($query->rows as $result):
                $product_data[$result['product_id']] = $this->getProduct($result['product_id']);
            endforeach;
            
            $cachefile = $product_data;
            Cache::set($key, $cachefile);
        endif;
        
        return $cachefile;
    }
    
    public function getProductAttributes($product_id) {
        $key = 'product.attributes.' . $product_id;
        $cachefile = Cache::get($key);
        
        if (is_bool($cachefile)):
            $product_attribute_group_data = array();
            
            $product_attribute_group_query = DB::query("
				SELECT 
					ag.attribute_group_id, 
					agd.name 
				FROM " . DB::prefix() . "product_attribute pa 
				LEFT JOIN " . DB::prefix() . "attribute a 
					ON (pa.attribute_id = a.attribute_id) 
				LEFT JOIN " . DB::prefix() . "attribute_group ag 
					ON (a.attribute_group_id = ag.attribute_group_id) 
				LEFT JOIN " . DB::prefix() . "attribute_group_description agd 
					ON (ag.attribute_group_id = agd.attribute_group_id) 
				WHERE pa.product_id = '" . (int)$product_id . "' 
				AND agd.language_id = '" . (int)Config::get('config_language_id') . "' 
				GROUP BY ag.attribute_group_id 
				ORDER BY ag.sort_order, agd.name
			");
            
            foreach ($product_attribute_group_query->rows as $product_attribute_group):
                $product_attribute_data = array();
                
                $product_attribute_query = DB::query("
					SELECT 
						a.attribute_id, 
						ad.name, 
						pa.text 
					FROM " . DB::prefix() . "product_attribute pa 
					LEFT JOIN " . DB::prefix() . "attribute a 
						ON (pa.attribute_id = a.attribute_id) 
					LEFT JOIN " . DB::prefix() . "attribute_description ad 
						ON (a.attribute_id = ad.attribute_id) 
					WHERE pa.product_id = '" . (int)$product_id . "' 
					AND a.attribute_group_id = '" . (int)$product_attribute_group['attribute_group_id'] . "' 
					AND ad.language_id = '" . (int)Config::get('config_language_id') . "' 
					AND pa.language_id = '" . (int)Config::get('config_language_id') . "' 
					ORDER BY a.sort_order, ad.name
				");
                
                foreach ($product_attribute_query->rows as $product_attribute):
                    $product_attribute_data[] = array('attribute_id' => $product_attribute['attribute_id'], 'name' => $product_attribute['name'], 'text' => $product_attribute['text']);
                endforeach;
                
                $product_attribute_group_data[] = array('attribute_group_id' => $product_attribute_group['attribute_group_id'], 'name' => $product_attribute_group['name'], 'attribute' => $product_attribute_data);
            endforeach;
            
            $cachefile = $product_attribute_group_data;
            Cache::set($key, $cachefile);
        endif;
        
        return $cachefile;
    }
    
    public function getProductOptions($product_id) {
        $key = 'product.options.' . $product_id;
        $cachefile = Cache::get($key);
        
        if (is_bool($cachefile)):
            $product_option_data = array();
            
            $product_option_query = DB::query("
				SELECT * 
				FROM " . DB::prefix() . "product_option po 
				LEFT JOIN `" . DB::prefix() . "option` o 
				ON (po.option_id = o.option_id) 
				LEFT JOIN " . DB::prefix() . "option_description od 
				ON (o.option_id = od.option_id) 
				WHERE po.product_id = '" . (int)$product_id . "' 
				AND od.language_id = '" . (int)Config::get('config_language_id') . "' 
				ORDER BY o.sort_order
			");
            
            foreach ($product_option_query->rows as $product_option):
                if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image'):
                    $product_option_value_data = array();
                    
                    $product_option_value_query = DB::query("
						SELECT * 
						FROM " . DB::prefix() . "product_option_value pov 
						LEFT JOIN " . DB::prefix() . "option_value ov 
						ON (pov.option_value_id = ov.option_value_id) 
						LEFT JOIN " . DB::prefix() . "option_value_description ovd 
						ON (ov.option_value_id = ovd.option_value_id) 
						WHERE pov.product_id = '" . (int)$product_id . "' 
						AND pov.product_option_id = '" . (int)$product_option['product_option_id'] . "' 
						AND ovd.language_id = '" . (int)Config::get('config_language_id') . "' 
						ORDER BY ov.sort_order
					");
                    
                    foreach ($product_option_value_query->rows as $product_option_value):
                        $product_option_value_data[] = array('product_option_value_id' => $product_option_value['product_option_value_id'], 'option_value_id' => $product_option_value['option_value_id'], 'name' => $product_option_value['name'], 'image' => $product_option_value['image'], 'quantity' => $product_option_value['quantity'], 'subtract' => $product_option_value['subtract'], 'price' => $product_option_value['price'], 'price_prefix' => $product_option_value['price_prefix'], 'weight' => $product_option_value['weight'], 'weight_prefix' => $product_option_value['weight_prefix']);
                    endforeach;
                    
                    $product_option_data[] = array('product_option_id' => $product_option['product_option_id'], 'option_id' => $product_option['option_id'], 'name' => $product_option['name'], 'type' => $product_option['type'], 'option_value' => $product_option_value_data, 'required' => $product_option['required']);
                else:
                    $product_option_data[] = array('product_option_id' => $product_option['product_option_id'], 'option_id' => $product_option['option_id'], 'name' => $product_option['name'], 'type' => $product_option['type'], 'option_value' => $product_option['option_value'], 'required' => $product_option['required']);
                endif;
            endforeach;
            
            $cachefile = $product_option_data;
            Cache::set($key, $cachefile);
        endif;
        
        return $cachefile;
    }
    
    public function getProductDiscounts($product_id) {
        if (Customer::isLogged()):
            $customer_group_id = Customer::getGroupId();
        else:
            $customer_group_id = Config::get('config_default_visibility');
        endif;
        
        $key = 'product.discounts.' . $product_id;
        $cachefile = Cache::get($key);
        
        if (is_bool($cachefile)):
            $query = DB::query("
				SELECT * 
				FROM " . DB::prefix() . "product_discount 
				WHERE product_id = '" . (int)$product_id . "' 
				AND customer_group_id = '" . (int)$customer_group_id . "' 
				AND quantity > 1 
				AND ((date_start = '0000-00-00' OR date_start < NOW()) 
				AND (date_end = '0000-00-00' OR date_end > NOW())) 
				ORDER BY quantity ASC, priority ASC, price ASC
			");
            
            if ($query->num_rows):
                $cachefile = $query->rows;
                Cache::set($key, $cachefile);
            else:
                Cache::set($key, array());
                return array();
            endif;
        endif;
        
        return $cachefile;
    }
    
    public function getProductImages($product_id) {
        $key = 'product.images.' . $product_id;
        $cachefile = Cache::get($key);
        
        if (is_bool($cachefile)):
            $query = DB::query("
				SELECT * 
				FROM " . DB::prefix() . "product_image 
				WHERE product_id = '" . (int)$product_id . "' 
				ORDER BY sort_order ASC
			");
            
            if ($query->num_rows):
                $cachefile = $query->rows;
                Cache::set($key, $cachefile);
            else:
                Cache::set($key, array());
                return array();
            endif;
        endif;
        
        return $cachefile;
    }
    
    public function getProductRelated($product_id) {
        if (Customer::isLogged()):
            $customer_group_id = Customer::getGroupId();
        else:
            $customer_group_id = Config::get('config_default_visibility');
        endif;
        
        $key = 'product.related.' . $product_id;
        $cachefile = Cache::get($key);
        
        if (is_bool($cachefile)):
            $product_data = array();
            
            $query = DB::query("
				SELECT * 
				FROM " . DB::prefix() . "product_related pr 
				LEFT JOIN " . DB::prefix() . "product p 
					ON (pr.related_id = p.product_id) 
				LEFT JOIN " . DB::prefix() . "product_to_store p2s 
					ON (p.product_id = p2s.product_id) 
				WHERE pr.product_id = '" . (int)$product_id . "' 
				AND p.status = '1' 
				AND p.visibility <= '" . (int)$customer_group_id . "' 
				AND p.customer_id = '0' 
				AND p.date_available <= NOW() 
				AND p2s.store_id = '" . (int)Config::get('config_store_id') . "'
			");
            
            foreach ($query->rows as $result):
                $product_data[$result['related_id']] = $this->getProduct($result['related_id']);
            endforeach;
            
            $cachefile = $product_data;
            Cache::set($key, $cachefile);
        endif;
        
        return $cachefile;
    }
    
    public function getProductLayoutId($product_id) {
        $key = 'product.layoutid.' . $product_id;
        $cachefile = Cache::get($key);
        
        if (is_bool($cachefile)):
            $query = DB::query("
				SELECT * 
				FROM " . DB::prefix() . "product_to_layout 
				WHERE product_id = '" . (int)$product_id . "' 
				AND store_id = '" . (int)Config::get('config_store_id') . "'
			");
            
            if ($query->num_rows):
                $cachefile = $query->row['layout_id'];
                Cache::set($key, $cachefile);
            else:
                $cachefile = 0;
                Cache::set($key, $cachefile);
            endif;
        endif;
        
        return $cachefile;
    }
    
    public function getCategories($product_id) {
        $key = 'product.categories.' . $product_id;
        $cachefile = Cache::get($key);
        
        if (is_bool($cachefile)):
            $query = DB::query("
				SELECT * 
				FROM " . DB::prefix() . "product_to_category 
				WHERE product_id = '" . (int)$product_id . "' 
                ORDER BY category_id ASC
            ");
            
            if ($query->num_rows):
                $cachefile = $query->rows;
                Cache::set($key, $cachefile);
            else:
                Cache::set($key, array());
                return array();
            endif;
        endif;
        
        return $cachefile;
    }
    
    public function getProductParentCategory($product_id, $category_id = 0, $run = true) {
        if ($run):
            $result = DB::query("
				SELECT category_id 
				FROM " . DB::prefix() . "product_to_category 
				WHERE product_id = '" . (int)$product_id . "' 
				ORDER BY product_id ASC LIMIT 1");
            $category_id = $result->row['category_id'];
        endif;
        
        $query = DB::query("
			SELECT parent_id 
			FROM " . DB::prefix() . "category 
			WHERE category_id = '" . (int)$category_id . "'");
        
        if ($query->row['parent_id'] == 0):
            return $category_id;
        else:
            return $this->getProductParentCategory($product_id, $query->row['parent_id'], false);
        endif;
    }

    public function buildPaths($product_id) {
        $query = DB::query("
            SELECT category_id 
            FROM " . DB::prefix() . "product_to_category 
            WHERE product_id ='" . (int)$product_id . "' 
            ORDER BY category_id ASC
        ");

        $segments = [];

        if ($query->num_rows):
            foreach($query->rows as $category):
                $segments[] = $category['category_id'];
            endforeach;
        endif;

        return implode('_', $segments);
    }
    
    public function getTotalProducts($data = array()) {
        if (Customer::isLogged()):
            $customer_group_id = Customer::getGroupId();
        else:
            $customer_group_id = Config::get('config_default_visibility');
        endif;
        
        if (!empty($data)):
            $key = 'products.total.' . md5(serialize($data));
            $cachefile = Cache::get($key);
            
            if (is_bool($cachefile)):
                
                if (!empty($data['filter_tag'])):
                    return $this->getTotalProductsByTag($data['filter_tag']);
                endif;

                $sql = "SELECT COUNT(DISTINCT p.product_id) AS total";
                
                if (!empty($data['filter_category_id'])):
                    if (!empty($data['filter_sub_category'])):
                        $sql.= " FROM " . DB::prefix() . "category_path cp 
								  LEFT JOIN " . DB::prefix() . "product_to_category p2c 
									ON (cp.category_id = p2c.category_id)";
                    else:
                        $sql.= " FROM " . DB::prefix() . "product_to_category p2c";
                    endif;
                    
                    if (!empty($data['filter_filter'])):
                        $sql.= " LEFT JOIN " . DB::prefix() . "product_filter pf 
									ON (p2c.product_id = pf.product_id) 
								  LEFT JOIN " . DB::prefix() . "product p 
									ON (pf.product_id = p.product_id)";
                    else:
                        $sql.= " LEFT JOIN " . DB::prefix() . "product p 
									ON (p2c.product_id = p.product_id)";
                    endif;
                else:
                    $sql.= " FROM " . DB::prefix() . "product p";
                endif;
                
                $sql.= " LEFT JOIN " . DB::prefix() . "product_description pd 
							ON (p.product_id = pd.product_id) 
						  LEFT JOIN " . DB::prefix() . "product_to_store p2s 
							ON (p.product_id = p2s.product_id) 
						  WHERE pd.language_id = '" . (int)Config::get('config_language_id') . "' 
						  AND p.status = '1' 
						  AND p.visibility <= '" . (int)$customer_group_id . "' 
						  AND p.customer_id = '0' 
						  AND p.date_available <= NOW() 
						  AND p2s.store_id = '" . (int)Config::get('config_store_id') . "'";
                
                if (!empty($data['filter_category_id'])):
                    if (!empty($data['filter_sub_category'])):
                        $sql.= " AND cp.path_id = '" . (int)$data['filter_category_id'] . "'";
                    else:
                        $sql.= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
                    endif;
                    
                    if (!empty($data['filter_filter'])):
                        $implode = array();
                        
                        $filters = explode(',', $data['filter_filter']);
                        
                        foreach ($filters as $filter_id):
                            $implode[] = (int)$filter_id;
                        endforeach;
                        
                        $sql.= " AND pf.filter_id IN (" . implode(',', $implode) . ")";
                    endif;
                endif;
                
                if (!empty($data['filter_name'])):
                    $sql.= " AND (";
                    
                    if (!empty($data['filter_name'])):
                        $implode = array();
                        
                        $words = explode(' ', trim(preg_replace('/\s\s+/', ' ', $data['filter_name'])));
                        
                        foreach ($words as $word) {
                            $implode[] = "pd.name LIKE '%" . DB::escape($word) . "%'";
                        }
                        
                        if ($implode):
                            $imp = implode(" && ", $implode);
                            $sql.= " {$imp}";
                        endif;
                        
                        if (!empty($data['filter_description'])):
                            $sql.= " OR pd.description LIKE '%" . DB::escape($data['filter_name']) . "%'";
                        endif;
                    endif;
                    
                    if (!empty($data['filter_name'])):
                        $sql.= " OR LCASE(p.model) = '" . DB::escape(Encode::strtolower($data['filter_name'])) . "'";
                    endif;
                    
                    if (!empty($data['filter_name'])):
                        $sql.= " OR LCASE(p.sku) = '" . DB::escape(Encode::strtolower($data['filter_name'])) . "'";
                    endif;
                    
                    if (!empty($data['filter_name'])):
                        $sql.= " OR LCASE(p.upc) = '" . DB::escape(Encode::strtolower($data['filter_name'])) . "'";
                    endif;
                    
                    if (!empty($data['filter_name'])):
                        $sql.= " OR LCASE(p.ean) = '" . DB::escape(Encode::strtolower($data['filter_name'])) . "'";
                    endif;
                    
                    if (!empty($data['filter_name'])):
                        $sql.= " OR LCASE(p.jan) = '" . DB::escape(Encode::strtolower($data['filter_name'])) . "'";
                    endif;
                    
                    if (!empty($data['filter_name'])):
                        $sql.= " OR LCASE(p.isbn) = '" . DB::escape(Encode::strtolower($data['filter_name'])) . "'";
                    endif;
                    
                    if (!empty($data['filter_name'])):
                        $sql.= " OR LCASE(p.mpn) = '" . DB::escape(Encode::strtolower($data['filter_name'])) . "'";
                    endif;
                    
                    $sql.= ")";
                endif;
                
                if (!empty($data['filter_manufacturer_id'])):
                    $sql.= " AND p.manufacturer_id = '" . (int)$data['filter_manufacturer_id'] . "'";
                endif;
                
                $query = DB::query($sql);
                
                $cachefile = $query->row['total'];
                Cache::set($key, (int)$cachefile);
            endif;
            unset($key);
        else:
            $key = 'products.total.' . (int)Config::get('config_store_id');
            $cachefile = Cache::get($key);
            
            if (is_bool($cachefile)):
                $query = DB::query("
					SELECT COUNT(DISTINCT p.product_id) AS total 
					FROM " . DB::prefix() . "product p 
					LEFT JOIN " . DB::prefix() . "product_description pd 
						ON (p.product_id = pd.product_id) 
					LEFT JOIN " . DB::prefix() . "product_to_store p2s 
						ON (p.product_id = p2s.product_id) 
					WHERE pd.language_id = '" . (int)Config::get('config_language_id') . "' 
					AND p.status = '1' 
					AND p.visibility <= '" . (int)$customer_group_id . "' 
					AND p.customer_id = '0' 
					AND p.date_available <= NOW() 
					AND p2s.store_id = '" . (int)Config::get('config_store_id') . "'
				");
                
                $cachefile = $query->row['total'];
                Cache::set($key, (int)$cachefile);
            endif;
        endif;
        
        return $cachefile;
    }

    public function getTotalProductsByTag($tag) {
        $query = DB::query("
            SELECT COUNT(tag_id) AS total, element_id 
            FROM " . DB::prefix() . "tag 
            WHERE section = 'product' 
            AND language_id = '" . (int)Config::get('config_language_id') . "' 
            AND tag LIKE '%" . DB::escape($tag) . "%' GROUP BY element_id ASC");
        
        return $query->num_rows;
    }

    public function getProductsByTag($tag) {
        $query = DB::query("
            SELECT element_id 
            FROM " . DB::prefix() . "tag 
            WHERE section = 'product' 
            AND language_id = '" . (int)Config::get('config_language_id') . "' 
            AND tag LIKE '%" . DB::escape($tag) . "%' GROUP BY element_id ASC");
        
        if ($query->num_rows):
            $product_data = array();
            foreach($query->rows as $row):
                $product_data[] = $this->getProduct($row['element_id']);
            endforeach;
            return $product_data;
        else:
            return false;
        endif;
    }
    
    public function getAllRecurring($product_id) {
        if (Customer::isLogged()):
            $customer_group_id = Customer::getGroupId();
        else:
            $customer_group_id = Config::get('config_default_visibility');
        endif;
        
        $key = 'product.recurring.all.' . $product_id;
        $cachefile = Cache::get($key);
        
        if (is_bool($cachefile)):
            $query = DB::query("
				SELECT `pd`.* 
				FROM `" . DB::prefix() . "product_recurring` `pp` 
				JOIN `" . DB::prefix() . "recurring_description` `pd` 
					ON `pd`.`language_id` = " . (int)Config::get('config_language_id') . " 
				AND `pd`.`recurring_id` = `pp`.`recurring_id` 
				JOIN `" . DB::prefix() . "recurring` `p` 
					ON `p`.`recurring_id` = `pd`.`recurring_id` 
				WHERE `product_id` = " . (int)$product_id . " 
				AND `status` = 1 
				AND `customer_group_id` = " . (int)$customer_group_id . " 
				ORDER BY `sort_order` ASC");
            
            if ($query->num_rows):
                $cachefile = $query->rows;
                Cache::set($key, $cachefile);
            else:
                Cache::set($key, array());
                return array();
            endif;
        endif;
        
        return $cachefile;
    }
    
    public function getRecurring($product_id, $recurring_id) {
        if (Customer::isLogged()):
            $customer_group_id = Customer::getGroupId();
        else:
            $customer_group_id = Config::get('config_default_visibility');
        endif;
        
        $key = 'product.recurring.' . $product_id . ':' . $recurring_id;
        $cachefile = Cache::get($key);
        
        if (is_bool($cachefile)):
            $query = DB::query("
				SELECT * 
				FROM `" . DB::prefix() . "recurring` `p` 
				JOIN `" . DB::prefix() . "product_recurring` `pp` 
				ON `pp`.`recurring_id` = `p`.`recurring_id` 
				AND `pp`.`product_id` = " . (int)$product_id . " 
				WHERE `pp`.`recurring_id` = " . (int)$recurring_id . " 
				AND `status` = 1 
				AND `pp`.`customer_group_id` = " . (int)$customer_group_id);
            
            if ($query->num_rows):
                $cachefile = $query->row;
                Cache::set($key, $cachefile);
            else:
                Cache::set($key, array());
                return array();
            endif;
        endif;
        
        return $cachefile;
    }
    
    public function getTotalProductSpecials() {
        if (Customer::isLogged()):
            $customer_group_id = Customer::getGroupId();
        else:
            $customer_group_id = Config::get('config_default_visibility');
        endif;
        
        $key = 'product.specials.total.' . (int)Config::get('config_store_id');
        $cachefile = Cache::get($key);
        
        if (is_bool($cachefile)):
            $query = DB::query("
				SELECT COUNT(DISTINCT ps.product_id) AS total 
				FROM " . DB::prefix() . "product_special ps 
				LEFT JOIN " . DB::prefix() . "product p 
					ON (ps.product_id = p.product_id) 
				LEFT JOIN " . DB::prefix() . "product_to_store p2s 
					ON (p.product_id = p2s.product_id) 
				WHERE p.status = '1' 
				AND p.visibility <= '" . (int)$customer_group_id . "' 
				AND p.customer_id = '0' 
				AND p.date_available <= NOW() 
				AND p2s.store_id = '" . (int)Config::get('config_store_id') . "' 
				AND ps.customer_group_id = '" . (int)$customer_group_id . "' 
				AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) 
				AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW()))
			");
            
            if (isset($query->row['total'])):
                $cachefile = $query->row['total'];
                Cache::set($key, $cachefile);
            else:
                $cachefile = 0;
            endif;
        endif;
        
        return $cachefile;
    }
    
    public function getProductByModel($model) {
        $query = DB::query("
			SELECT DISTINCT product_id 
			FROM " . DB::prefix() . "product 
			WHERE model = '" . DB::escape($model) . "'");
        
        if ($query->num_rows) return $this->getProduct($query->row['product_id']);
        
        return false;
    }
    
    public function joinWaitList($event_id, $customer_id) {
        DB::query("
			INSERT INTO " . DB::prefix() . "event_wait_list 
			SET 
				event_id = '" . (int)$event_id . "', 
				customer_id = '" . (int)$customer_id . "'");
        
        $event = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "event_manager 
			WHERE event_id = '" . (int)$event_id . "'");

        $event_info = $event->row;

        $callback = array(
            'customer_id' => $customer_id,
            'event'       => $event_info,
            'callback'    => array(
                'class'  => __CLASS__,
                'method' => 'public_waitlist_join'
            )
        );

        Theme::notify('public_waitlist_join', $callback);

        return 1;
    }
    
    public function getEvents() {
        $query = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "event_manager");
        
        return $query->rows;
    }

    public function getEventsByGroupId() {
        $query = DB::query("
            SELECT * 
            FROM " . DB::prefix() . "event_manager 
            WHERE visibility <= '" . (int)Customer::getGroupId() . "'");
        
        return $query->rows;
    }
    
    public function getEvent($event_id) {
        $query = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "event_manager 
			WHERE event_id = '" . (int)$event_id . "'");
        
        return $query->row;
    }
    
    public function buildEventPaths($product_id) {
        $category_id = $this->getProductParentCategory($product_id);
        $path = $category_id;
        $categories = $this->getCategories($product_id);
        
        foreach ($categories as $category):
            if ($category['category_id'] != $category_id):
                $path.= '_' . (int)$category['category_id'];
            endif;
        endforeach;
        
        return $path;
    }
    
    public function getPresenterName($presenter_id) {
        $query = DB::query("
			SELECT presenter_name 
			FROM " . DB::prefix() . "presenter 
			WHERE presenter_id = '" . (int)$presenter_id . "'");
        
        if ($query->num_rows) {
            return $query->row['presenter_name'];
        } else {
            return;
        }
    }
    
    public function getPresenterBio($presenter_id) {
        $query = DB::query("
			SELECT bio 
			FROM " . DB::prefix() . "presenter 
			WHERE presenter_id = '" . (int)$presenter_id . "'");
        
        return $query->row['bio'];
    }
    
    public function getRoster($event_id, $customer_id) {
        $registered = false;
        
        $query = DB::query("
			SELECT roster 
			FROM " . DB::prefix() . "event_manager 
			WHERE event_id = '" . (int)$event_id . "'");
        
        if ($query->num_rows && !empty($query->row['roster'])) {
            foreach (unserialize($query->row['roster']) as $row) {
                if ($row['attendee_id'] == $customer_id) {
                    $registered = true;
                    break;
                }
            }
        }
        
        return $registered;
    }
    
    public function checkWaitList($event_id, $customer_id) {
        $registered = false;
        
        $query = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "event_wait_list 
			WHERE event_id = '" . (int)$event_id . "' 
			AND customer_id = '" . (int)$customer_id . "'");
        
        if ($query->num_rows) {
            $registered = true;
        } else {
            $registered = $this->getRoster($event_id, $customer_id);
        }
        
        return $registered;
    }
    
    public function getEventImage($product_id) {
        $query = DB::query("
			SELECT image 
			FROM " . DB::prefix() . "product 
			WHERE product_id = '" . (int)$product_id . "'");
        
        if ($query->num_rows):
            return $query->row['image'];
        else:
            return 'placeholder.png';
        endif;
    }

    public function public_waitlist_join($data, $message) {
        $call = $data['event'];
        unset($data);

        $data = Theme::language('notification/event');

        $data['event_name'] = $call['event_name'];
        $data['event_date'] = date(Lang::get('lang_date_format_short'), strtotime($call['date_time']));
        $data['event_time'] = date(Lang::get('lang_time_format'), strtotime($call['date_time']));

        $data['event_location']  = false;
        $data['event_telephone'] = false;

        if ($call['location']):
            $data['event_location'] = $call['location'];
        endif;

        if ($call['telephone']):
            $data['event_telephone'] = $call['telephone'];
        endif;

        $html = new Template;
        $text = new Text;

        $html->data = $data;
        $text->data = $data;

        $html = $html->fetch('notification/event');
        $text = $text->fetch('notification/event');

        $message['text'] = str_replace('!content!', $text, $message['text']);
        $message['html'] = str_replace('!content!', $html, $message['html']);

        return $message;
    }
}
