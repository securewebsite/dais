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

namespace Admin\Model\Catalog;
use Dais\Engine\Model;

class Review extends Model {
    public function addReview($data) {
        $this->db->query("
			INSERT INTO {$this->db->prefix}review 
			SET 
				author = '" . $this->db->escape($data['author']) . "', 
				product_id = '" . $this->db->escape($data['product_id']) . "', 
				text = '" . $this->db->escape(strip_tags($data['text'])) . "', 
				rating = '" . (int)$data['rating'] . "', 
				status = '" . (int)$data['status'] . "', 
				date_added = NOW()
		");
        
        $review_id = $this->db->getLastId();
        
        $this->cache->delete('reviews.product');
        
        Theme::trigger('admin_add_review', array('review_id' => $review_id));
    }
    
    public function editReview($review_id, $data) {
        $this->db->query("
			UPDATE {$this->db->prefix}review 
			SET 
				author = '" . $this->db->escape($data['author']) . "', 
				product_id = '" . $this->db->escape($data['product_id']) . "', 
				text = '" . $this->db->escape(strip_tags($data['text'])) . "', 
				rating = '" . (int)$data['rating'] . "', 
				status = '" . (int)$data['status'] . "', 
				date_added = NOW() 
			WHERE review_id = '" . (int)$review_id . "'
		");
        
        $this->cache->delete('reviews.product');
        
        Theme::trigger('admin_edit_review', array('review_id' => $review_id));
    }
    
    public function deleteReview($review_id) {
        $this->db->query("DELETE FROM {$this->db->prefix}review WHERE review_id = '" . (int)$review_id . "'");
        
        $this->cache->delete('reviews.product');
        
        Theme::trigger('admin_delete_review', array('review_id' => $review_id));
    }
    
    public function getReview($review_id) {
        $query = $this->db->query("
			SELECT DISTINCT *, 
			(SELECT pd.name 
				FROM {$this->db->prefix}product_description pd 
				WHERE pd.product_id = r.product_id 
				AND pd.language_id = '" . (int)Config::get('config_language_id') . "') AS product 
			FROM {$this->db->prefix}review r 
			WHERE r.review_id = '" . (int)$review_id . "'
		");
        
        return $query->row;
    }
    
    public function getReviews($data = array()) {
        $sql = "
			SELECT 
				r.review_id, 
				pd.name, 
				r.author, 
				r.rating, 
				r.status, 
				r.date_added 
			FROM {$this->db->prefix}review r 
			LEFT JOIN {$this->db->prefix}product_description pd 
			ON (r.product_id = pd.product_id) 
			WHERE pd.language_id = '" . (int)Config::get('config_language_id') . "'
		";
        
        if (isset($data['filter_status'])):
            $sql.= " AND r.status = '" . (int)$data['filter_status'] . "'";
        endif;
        
        $sort_data = array('pd.name', 'r.author', 'r.rating', 'r.status', 'r.date_added');
        
        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql.= " ORDER BY {$data['sort']}";
        } else {
            $sql.= " ORDER BY r.date_added";
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
    
    public function getTotalReviews($data = array()) {
        $sql = "
			SELECT COUNT(*) AS total FROM {$this->db->prefix}review";
        
        if (isset($data['filter_status'])):
            $sql.= " WHERE status = '" . (int)$data['filter_status'] . "'";
        endif;
        
        $query = $this->db->query($sql);
        
        return $query->row['total'];
    }
    
    public function getTotalReviewsAwaitingApproval() {
        $query = $this->db->query("
			SELECT COUNT(*) AS total 
			FROM {$this->db->prefix}review 
			WHERE status = '0'
		");
        
        return $query->row['total'];
    }
}
