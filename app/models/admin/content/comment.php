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

namespace App\Models\Admin\Content;

use App\Models\Model;

class Comment extends Model {
    
    public function addComment($data) {
        $this->db->query("
			INSERT INTO {$this->db->prefix}blog_comment 
			SET 
				author = '" . $this->db->escape($data['author']) . "', 
				post_id = '" . $this->db->escape($data['post_id']) . "', 
				text = '" . $this->db->escape(strip_tags($data['text'])) . "', 
				rating = '" . (int)$data['rating'] . "', 
				status = '" . (int)$data['status'] . "', 
				date_added = NOW()
			");
        
        $comment_id = $this->db->getLastId();
        
        $this->cache->delete('post.comment');
        $this->cache->delete('posts.comment');
        $this->cache->delete('post.average');
        
        Theme::trigger('admin_blog_add_comment', array('blog_comment_id' => $comment_id));
        
        if ($data['status']):
            Theme::trigger('admin_blog_comment_approved', array('blog_comment_id' => $comment_id));
        endif;
    }
    
    public function editComment($comment_id, $data) {
        $this->db->query("
			UPDATE {$this->db->prefix}blog_comment 
			SET 
				author = '" . $this->db->escape($data['author']) . "', 
				post_id = '" . $this->db->escape($data['post_id']) . "', 
				text = '" . $this->db->escape(strip_tags($data['text'])) . "', 
				rating = '" . (int)$data['rating'] . "', 
				status = '" . (int)$data['status'] . "', 
				date_added = NOW() 
			WHERE comment_id = '" . (int)$comment_id . "'
		");
        
        $this->cache->delete('post.comment');
        $this->cache->delete('posts.comment');
        $this->cache->delete('post.average');
        
        Theme::trigger('admin_blog_edit_comment', array('blog_comment_id' => $comment_id));
        
        if ($data['status']):
            Theme::trigger('admin_blog_comment_approved', array('blog_comment_id' => $comment_id));
        endif;
    }
    
    public function deleteComment($comment_id) {
        $this->db->query("
            DELETE FROM {$this->db->prefix}blog_comment 
            WHERE comment_id = '" . (int)$comment_id . "'");
        
        $this->cache->delete('post.comment');
        $this->cache->delete('posts.comment');
        $this->cache->delete('post.average');
        
        Theme::trigger('admin_blog_delete_comment', array('blog_comment_id' => $comment_id));
    }
    
    public function getComment($comment_id) {
        $query = $this->db->query("
			SELECT DISTINCT *, 
			(SELECT pd.name 
				FROM {$this->db->prefix}blog_post_description pd 
				WHERE pd.post_id = c.post_id 
				AND pd.language_id = '" . (int)Config::get('config_language_id') . "') AS post 
			FROM {$this->db->prefix}blog_comment c 
			WHERE c.comment_id = '" . (int)$comment_id . "'
		");
        
        return $query->row;
    }
    
    public function getComments($data = array()) {
        $sql = "
			SELECT c.comment_id, pd.name, c.author, c.rating, c.status, c.date_added 
			FROM {$this->db->prefix}blog_comment c 
			LEFT JOIN {$this->db->prefix}blog_post_description pd 
				ON (c.post_id = pd.post_id) 
			WHERE pd.language_id = '" . (int)Config::get('config_language_id') . "'
		";
        
        $sort_data = array('pd.name', 'c.author', 'c.rating', 'c.status', 'c.date_added');
        
        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql.= " ORDER BY {$data['sort']}";
        } else {
            $sql.= " ORDER BY c.date_added";
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
    
    public function getTotalComments() {
        $query = $this->db->query("
			SELECT COUNT(*) AS total 
			FROM {$this->db->prefix}blog_comment
		");
        
        return $query->row['total'];
    }
    
    public function getTotalCommentsAwaitingApproval() {
        $query = $this->db->query("
			SELECT COUNT(*) AS total 
			FROM {$this->db->prefix}blog_comment 
			WHERE status = '0'
		");
        
        return $query->row['total'];
    }
}
