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

namespace App\Models\Front\Content;
use App\Models\Model;

class Post extends Model {
    public function updateViewed($post_id) {
        $this->db->query("
			UPDATE {$this->db->prefix}blog_post 
			SET viewed = (viewed + 1) 
			WHERE post_id = '" . (int)$post_id . "'
		");
        
        Theme::trigger('front_post_update_viewed', array('post_id' => $post_id));
    }
    
    public function getPost($post_id) {
        Theme::model('content/author');
        
        $key = 'post.' . $post_id;
        $cachefile = $this->cache->get($key);
        
        if (is_bool($cachefile)):
            $query = $this->db->query("
				SELECT DISTINCT *, 
					pd.name AS name, 
					p.image, 
					(SELECT AVG(rating) AS total 
						FROM {$this->db->prefix}blog_comment c1 
						WHERE c1.post_id = p.post_id 
						AND c1.status = '1' 
						GROUP BY c1.post_id) AS rating, 
					(SELECT COUNT(*) AS total 
						FROM {$this->db->prefix}blog_comment c2 
						WHERE c2.post_id = p.post_id AND c2.status = '1' 
						GROUP BY c2.post_id) AS comments, 
					p.sort_order 
				FROM {$this->db->prefix}blog_post p 
				LEFT JOIN {$this->db->prefix}blog_post_description pd 
					ON (p.post_id = pd.post_id) 
				LEFT JOIN {$this->db->prefix}blog_post_to_store p2s 
					ON (p.post_id = p2s.post_id) 
				WHERE p.post_id = '" . (int)$post_id . "' 
				AND pd.language_id = '" . (int)Config::get('config_language_id') . "' 
				AND p.status = '1' 
				AND p.date_available <= NOW() 
				AND p2s.store_id = '" . (int)Config::get('config_store_id') . "'
			");
            
            if ($query->num_rows):
                $post = array(
                    'post_id'          => $query->row['post_id'], 
                    'name'             => $query->row['name'], 
                    'description'      => $query->row['description'], 
                    'meta_description' => $query->row['meta_description'], 
                    'meta_keyword'     => $query->row['meta_keyword'], 
                    'tag'              => $this->getPostTags($query->row['post_id']), 
                    'image'            => $query->row['image'], 
                    'author_id'        => $query->row['author_id'], 
                    'author_name'      => $this->model_content_author->getPostAuthor($query->row['author_id']), 
                    'date_available'   => $query->row['date_available'], 
                    'rating'           => round($query->row['rating']), 
                    'comments'         => $query->row['comments'], 
                    'sort_order'       => $query->row['sort_order'], 
                    'status'           => $query->row['status'], 
                    'date_added'       => $query->row['date_added'], 
                    'date_modified'    => $query->row['date_modified'], 
                    'viewed'           => $query->row['viewed'], 
                    'visibility'       => $query->row['visibility']
                );
                
                $cachefile = $post;
                $this->cache->set($key, $cachefile);
            else:
                $cachefile = false;
            endif;
        endif;
        
        return $cachefile;
    }
    
    public function getPostTags($post_id) {
        $query = $this->db->query("
            SELECT tag 
            FROM {$this->db->prefix}tag 
            WHERE section   = 'post' 
            AND element_id  = '" . (int)$post_id . "' 
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

    public function getPosts($data = array()) {
        $key = 'posts.all.' . (int)Config::get('config_store_id');
        $cachefile = $this->cache->get($key);
        
        if (is_bool($cachefile)) {
            $sql = "
				SELECT p.post_id, 
				(SELECT AVG(rating) AS total 
					FROM {$this->db->prefix}blog_comment c1 
					WHERE c1.post_id = p.post_id 
					AND c1.status = '1' 
					GROUP BY c1.post_id) AS rating 
				FROM {$this->db->prefix}blog_post p 
				LEFT JOIN {$this->db->prefix}blog_post_description pd 
					ON (p.post_id = pd.post_id) 
				LEFT JOIN {$this->db->prefix}blog_post_to_store p2s 
					ON (p.post_id = p2s.post_id)
			";
            
            if (!empty($data['filter_category_id'])) {
                $sql.= " LEFT JOIN {$this->db->prefix}blog_post_to_category p2c 
							ON (p.post_id = p2c.post_id)";
            }
            
            $sql.= " WHERE pd.language_id = '" . (int)Config::get('config_language_id') . "' 
					  AND p.status = '1' 
					  AND p.date_available <= NOW() 
					  AND p2s.store_id = '" . (int)Config::get('config_store_id') . "'";
            
            if (!empty($data['filter_name'])) {
                $sql.= " AND (";
                
                if (!empty($data['filter_name'])) {
                    if (!empty($data['filter_description'])) {
                        $sql.= "LCASE(pd.name) 
								 LIKE '%" . $this->db->escape($this->encode->strtolower($data['filter_name'])) . "%' 
								 OR MATCH(pd.description) 
								 AGAINST('" . $this->db->escape($this->encode->strtolower($data['filter_name'])) . "')";
                    } else {
                        $sql.= "LCASE(pd.name) LIKE '%" . $this->db->escape($this->encode->strtolower($data['filter_name'])) . "%'";
                    }
                }
                
                $sql.= ")";
            }
            
            if (!empty($data['filter_category_id'])) {
                if (!empty($data['filter_sub_category'])) {
                    $implode_data = array();
                    
                    $implode_data[] = (int)$data['filter_category_id'];
                    
                    Theme::model('content/category');
                    
                    $categories = $this->model_content_category->getCategoriesByParentId($data['filter_category_id']);
                    
                    foreach ($categories as $category_id) {
                        $implode_data[] = (int)$category_id;
                    }
                    
                    $sql.= " AND p2c.category_id IN (" . implode(', ', $implode_data) . ")";
                } else {
                    $sql.= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
                }
            }
            
            if (!empty($data['filter_author_id'])) {
                $sql.= " AND p.author_id = '" . (int)$data['filter_author_id'] . "'";
            }
            
            $sql.= " GROUP BY p.post_id";
            
            $sort_data = array('pd.name', 'rating', 'p.sort_order', 'p.date_added');
            
            if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
                if ($data['sort'] == 'pd.name' || $data['sort'] == 'p.model') {
                    $sql.= " ORDER BY LCASE({$data['sort']})";
                } else {
                    $sql.= " ORDER BY {$data['sort']}";
                }
            } else {
                $sql.= " ORDER BY p.date_added";
            }
            
            if (isset($data['order']) && ($data['order'] == 'DESC')) {
                $sql.= " DESC, LCASE(pd.name) DESC";
            } else {
                $sql.= " ASC, LCASE(pd.name) ASC";
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
            
            $post_data = array();
            
            $query = $this->db->query($sql);
            
            foreach ($query->rows as $result) {
                $post_data[$result['post_id']] = $this->getPost($result['post_id']);
            }
            
            $cachefile = $post_data;
            $this->cache->set($key, $cachefile);
        }
        
        return $cachefile;
    }
    
    public function getLatestPosts($limit) {
        $key = 'posts.latest.' . (int)Config::get('config_store_id');
        $cachefile = $this->cache->get($key);
        
        if (is_bool($cachefile)) {
            $post_data = array();
            
            $query = $this->db->query("
				SELECT p.post_id 
				FROM {$this->db->prefix}blog_post p 
				LEFT JOIN {$this->db->prefix}blog_post_to_store p2s 
					ON (p.post_id = p2s.post_id) 
				WHERE p.status = '1' 
				AND p.date_available <= NOW() 
				AND p2s.store_id = '" . (int)Config::get('config_store_id') . "' 
				ORDER BY p.date_added DESC LIMIT " . (int)$limit);
            
            foreach ($query->rows as $result):
                $post_data[$result['post_id']] = $this->getPost($result['post_id']);
            endforeach;
            
            $cachefile = $post_data;
            $this->cache->set($key, $cachefile);
        }
        
        return $cachefile;
    }
    
    public function getPopularPosts($limit) {
        $key = 'posts.popular.' . (int)Config::get('config_store_id');
        $cachefile = $this->cache->get($key);
        
        if (is_bool($cachefile)):
            $post_data = array();
            
            $query = $this->db->query("
				SELECT p.post_id 
				FROM {$this->db->prefix}blog_post p 
				LEFT JOIN {$this->db->prefix}blog_post_to_store p2s 
				ON (p.post_id = p2s.post_id) 
				WHERE p.status = '1' 
				AND p.date_available <= NOW() 
				AND p2s.store_id = '" . (int)Config::get('config_store_id') . "' 
				ORDER BY p.viewed DESC, p.date_added DESC LIMIT " . (int)$limit);
            
            foreach ($query->rows as $result):
                $post_data[$result['post_id']] = $this->getPost($result['post_id']);
            endforeach;
            
            $cachefile = $post_data;
            $this->cache->set($key, $cachefile);
        endif;
        
        return $cachefile;
    }
    
    public function getMostCommentedPosts($limit) {
        $key = 'posts.most.commented.' . (int)Config::get('config_store_id');
        $cachefile = $this->cache->get($key);
        
        if (is_bool($cachefile)):
            $post_data = array();
            
            $query = $this->db->query("
				SELECT 
					c.post_id, 
					COUNT(c.post_id) AS comments 
				FROM {$this->db->prefix}blog_comment c 
				LEFT JOIN {$this->db->prefix}blog_post p 
					ON (c.post_id = p.post_id) 
				LEFT JOIN {$this->db->prefix}blog_post_to_store p2s 
					ON (p.post_id = p2s.post_id) 
				WHERE p.status = '1' 
				AND p.date_available <= NOW() 
				AND c.status = 1 
				AND p2s.store_id = '" . (int)Config::get('config_store_id') . "' 
				GROUP BY c.post_id 
				ORDER BY COUNT(c.post_id) DESC LIMIT " . (int)$limit);
            
            foreach ($query->rows as $result):
                $post_data[$result['post_id']] = $this->getPost($result['post_id']);
            endforeach;
            
            $cachefile = $post_data;
            $this->cache->set($key, $cachefile);
        endif;
        
        return $cachefile;
    }
    
    public function getPostImages($post_id) {
        $key = 'post.images.' . $post_id;
        $cachefile = $this->cache->get($key);
        
        if (is_bool($cachefile)):
            $query = $this->db->query("
				SELECT * 
				FROM {$this->db->prefix}blog_post_image 
				WHERE post_id = '" . (int)$post_id . "' 
				ORDER BY sort_order ASC
			");
            
            if ($query->num_rows):
                $cachefile = $query->rows;
                $this->cache->set($key, $cachefile);
            else:
                $this->cache->set($key, array());
                return array();
            endif;
        endif;
        
        return $cachefile;
    }
    
    public function getPostRelated($post_id) {
        $key = 'post.related.' . $post_id;
        $cachefile = $this->cache->get($key);
        
        if (is_bool($cachefile)):
            $post_data = array();
            
            $query = $this->db->query("
				SELECT * 
				FROM {$this->db->prefix}blog_post_related pr 
				LEFT JOIN {$this->db->prefix}blog_post p 
					ON (pr.related_id = p.post_id) 
				LEFT JOIN {$this->db->prefix}blog_post_to_store p2s 
					ON (p.post_id = p2s.post_id) 
				WHERE pr.post_id = '" . (int)$post_id . "' 
				AND p.status = '1' 
				AND p.date_available <= NOW() 
				AND p2s.store_id = '" . (int)Config::get('config_store_id') . "' 
				ORDER BY pr.related_id DESC
			");
            
            foreach ($query->rows as $result):
                $post_data[$result['related_id']] = $this->getPost($result['related_id']);
            endforeach;
            
            $cachefile = $post_data;
            $this->cache->set($key, $cachefile);
        endif;
        
        return $cachefile;
    }
    
    public function getPostLayoutId($post_id) {
        $key = 'post.layoutid.' . $post_id;
        $cachefile = $this->cache->get($key);
        
        if (is_bool($cachefile)):
            $query = $this->db->query("
				SELECT * 
				FROM {$this->db->prefix}blog_post_to_layout 
				WHERE post_id = '" . (int)$post_id . "' 
				AND store_id = '" . (int)Config::get('config_store_id') . "'
			");
            
            if ($query->num_rows):
                $cachefile = $query->row['layout_id'];
                $this->cache->set($key, $cachefile);
            else:
                $cachefile = Config::get('config_layout_product');
                 /// this needs to be checked, should be blog post id
                
            endif;
        endif;
        
        return $cachefile;
    }
    
    public function getCategories($post_id) {
        $key = 'posts.categories.' . $post_id;
        $cachefile = $this->cache->get($key);
        
        if (is_bool($cachefile)):
            $query = $this->db->query("
				SELECT * 
				FROM {$this->db->prefix}blog_post_to_category 
				WHERE post_id = '" . (int)$post_id . "'
			");
            
            if ($query->num_rows):
                $cachefile = $query->rows;
                $this->cache->set($key, $cachefile);
            else:
                $this->cache->set($key, array());
                return array();
            endif;
        endif;
        
        return $cachefile;
    }
    
    public function getNextPostId($current_post_id) {
        $key = 'post.next.post.id.' . $current_post_id;
        $cachefile = $this->cache->get($key);
        
        if (is_bool($cachefile)):
            $query = $this->db->query("
				SELECT post_id 
				FROM {$this->db->prefix}blog_post 
				WHERE post_id > " . (int)$current_post_id . " 
				AND status = 1 
				ORDER BY post_id ASC LIMIT 0,1
			");
            
            if ($query->num_rows):
                $cachefile = $query->row['post_id'];
                $this->cache->set($key, $cachefile);
            else:
                $this->cache->set($key, (int)0);
                return 0;
            endif;
        endif;
        
        return $cachefile;
    }
    
    public function getPrevPostId($current_post_id) {
        $key = 'post.previous.post.id.' . $current_post_id;
        $cachefile = $this->cache->get($key);
        
        if (is_bool($cachefile)):
            $query = $this->db->query("
				SELECT post_id 
				FROM {$this->db->prefix}blog_post 
				WHERE post_id < " . (int)$current_post_id . " 
				AND status = 1 
				ORDER BY post_id DESC LIMIT 0,1
			");
            
            if ($query->num_rows):
                $cachefile = $query->row['post_id'];
                $this->cache->set($key, $cachefile);
            else:
                $this->cache->set($key, (int)0);
                return 0;
            endif;
        endif;
        
        return $cachefile;
    }
    
    public function getTotalPosts($data = array()) {
        $key = 'posts.total.' . (int)Config::get('config_store_id');
        $cachefile = $this->cache->get($key);
        
        if (is_bool($cachefile)) {
            $sql = "
                SELECT COUNT(DISTINCT p.post_id) AS total 
    			FROM {$this->db->prefix}blog_post p 
    			LEFT JOIN {$this->db->prefix}blog_post_description pd 
    				ON (p.post_id = pd.post_id) 
    			LEFT JOIN {$this->db->prefix}blog_post_to_store p2s 
    				ON (p.post_id = p2s.post_id)";
            
            if (!empty($data['filter_category_id'])) {
                $sql.= " LEFT JOIN {$this->db->prefix}blog_post_to_category p2c 
							ON (p.post_id = p2c.post_id)";
            }
            
            $sql.= " WHERE pd.language_id = '" . (int)Config::get('config_language_id') . "' 
					  AND p.status = '1' 
					  AND p.date_available <= NOW() 
					  AND p2s.store_id = '" . (int)Config::get('config_store_id') . "'";
            
            if (!empty($data['filter_name'])) {
                $sql.= " AND (";
                
                if (!empty($data['filter_name'])) {
                    if (!empty($data['filter_description'])) {
                        $sql.= "LCASE(pd.name) 
								 LIKE '%" . $this->db->escape($this->encode->strtolower($data['filter_name'])) . "%' 
								 OR MATCH(pd.description) 
								 AGAINST('" . $this->db->escape($this->encode->strtolower($data['filter_name'])) . "')";
                    } else {
                        $sql.= "LCASE(pd.name) LIKE '%" . $this->db->escape($this->encode->strtolower($data['filter_name'])) . "%'";
                    }
                }
                
                $sql.= ")";
            }
            
            if (!empty($data['filter_category_id'])) {
                if (!empty($data['filter_sub_category'])) {
                    $implode_data = array();
                    
                    $implode_data[] = (int)$data['filter_category_id'];
                    
                    Theme::model('content/category');
                    
                    $categories = $this->model_content_category->getCategoriesByParentId($data['filter_category_id']);
                    
                    foreach ($categories as $category_id) {
                        $implode_data[] = (int)$category_id;
                    }
                    
                    $sql.= " AND p2c.category_id IN (" . implode(', ', $implode_data) . ")";
                } else {
                    $sql.= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
                }
            }
            
            if (!empty($data['filter_author_id'])) {
                $sql.= " AND p.author_id = '" . (int)$data['filter_author_id'] . "'";
            }
            
            $query = $this->db->query($sql);
            
            $cachefile = $query->row['total'];
            $this->cache->set($key, $cachefile);
        }
        
        return $cachefile;
    }
    
    public function getPostParentCategory($post_id, $category_id = 0, $run = true) {
        if ($run):
            $result = $this->db->query("
				SELECT category_id 
				FROM {$this->db->prefix}blog_post_to_category 
				WHERE post_id = '" . (int)$post_id . " ' 
				ORDER BY post_id ASC LIMIT 1");
            $category_id = $result->row['category_id'];
        endif;
        
        $query = $this->db->query("
            SELECT parent_id 
            FROM {$this->db->prefix}blog_category 
            WHERE category_id = '" . (int)$category_id . "'
        ");
        
        if ($query->row['parent_id'] == 0):
            return $category_id;
        else:
            return $this->getPostParentCategory($post_id, $query->row['parent_id'], false);
        endif;
    }
}
