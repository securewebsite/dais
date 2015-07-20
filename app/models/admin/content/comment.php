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
        DB::query("
			INSERT INTO " . DB::prefix() . "blog_comment 
			SET 
				author = '" . DB::escape($data['author']) . "', 
				post_id = '" . DB::escape($data['post_id']) . "', 
				text = '" . DB::escape(strip_tags($data['text'])) . "', 
				rating = '" . (int)$data['rating'] . "', 
				status = '" . (int)$data['status'] . "', 
				date_added = NOW()
			");
        
        $comment_id = DB::getLastId();
        
        Cache::delete('post.comment');
        Cache::delete('posts.comment');
        Cache::delete('post.average');
        
        Theme::trigger('admin_blog_add_comment', array('blog_comment_id' => $comment_id));
        
        if ($data['status']):
            Theme::trigger('admin_blog_comment_approved', array('blog_comment_id' => $comment_id));
        endif;
    }
    
    public function editComment($comment_id, $data) {
        DB::query("
			UPDATE " . DB::prefix() . "blog_comment 
			SET 
				author = '" . DB::escape($data['author']) . "', 
				post_id = '" . DB::escape($data['post_id']) . "', 
				text = '" . DB::escape(strip_tags($data['text'])) . "', 
				rating = '" . (int)$data['rating'] . "', 
				status = '" . (int)$data['status'] . "', 
				date_added = NOW() 
			WHERE comment_id = '" . (int)$comment_id . "'
		");
        
        Cache::delete('post.comment');
        Cache::delete('posts.comment');
        Cache::delete('post.average');
        
        Theme::trigger('admin_blog_edit_comment', array('blog_comment_id' => $comment_id));
        
        if ($data['status']):
            Theme::trigger('admin_blog_comment_approved', array('blog_comment_id' => $comment_id));
        endif;
    }
    
    public function deleteComment($comment_id) {
        DB::query("
            DELETE FROM " . DB::prefix() . "blog_comment 
            WHERE comment_id = '" . (int)$comment_id . "'");
        
        Cache::delete('post.comment');
        Cache::delete('posts.comment');
        Cache::delete('post.average');
        
        Theme::trigger('admin_blog_delete_comment', array('blog_comment_id' => $comment_id));
    }
    
    public function getComment($comment_id) {
        $query = DB::query("
			SELECT DISTINCT *, 
			(SELECT pd.name 
				FROM " . DB::prefix() . "blog_post_description pd 
				WHERE pd.post_id = c.post_id 
				AND pd.language_id = '" . (int)Config::get('config_language_id') . "') AS post 
			FROM " . DB::prefix() . "blog_comment c 
			WHERE c.comment_id = '" . (int)$comment_id . "'
		");
        
        return $query->row;
    }
    
    public function getComments($data = array()) {
        $sql = "
			SELECT c.comment_id, pd.name, c.author, c.rating, c.status, c.date_added 
			FROM " . DB::prefix() . "blog_comment c 
			LEFT JOIN " . DB::prefix() . "blog_post_description pd 
				ON (c.post_id = pd.post_id) 
			WHERE pd.language_id = '" . (int)Config::get('config_language_id') . "'
		";
        
        $sort_data = array('pd.name', 'c.author', 'c.rating', 'c.status', 'c.date_added');
        
        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql.= " ORDER BY {$data['sort']}";
        } else {
            $sql.= " ORDER BY c.date_added";
        }
        
        if (isset($data['order']) && ($data['order'] == 'desc')) {
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
    
    public function getTotalComments() {
        $query = DB::query("
			SELECT COUNT(*) AS total 
			FROM " . DB::prefix() . "blog_comment
		");
        
        return $query->row['total'];
    }
    
    public function getTotalCommentsAwaitingApproval() {
        $query = DB::query("
			SELECT COUNT(*) AS total 
			FROM " . DB::prefix() . "blog_comment 
			WHERE status = '0'
		");
        
        return $query->row['total'];
    }
}
