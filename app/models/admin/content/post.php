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

class Post extends Model {
    
    public function addPost($data) {
        DB::query("
			INSERT INTO " . DB::prefix() . "blog_post 
			SET 
				date_available = '" . DB::escape($data['date_available']) . "', 
				author_id = '" . (int)$data['author_id'] . "', 
				status = '" . (int)$data['status'] . "', 
				sort_order = '" . (int)$data['sort_order'] . "', 
				date_added = NOW()
		");
        
        $post_id = DB::getLastId();
        
        if (isset($data['image'])) {
            DB::query("
				UPDATE " . DB::prefix() . "blog_post 
				SET 
					image = '" . DB::escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' 
				WHERE post_id = '" . (int)$post_id . "'
			");
        }
        
        foreach ($data['post_description'] as $language_id => $value) {
            DB::query("
				INSERT INTO " . DB::prefix() . "blog_post_description 
				SET 
                    post_id          = '" . (int)$post_id . "', 
                    language_id      = '" . (int)$language_id . "', 
                    name             = '" . DB::escape($value['name']) . "', 
                    meta_keyword     = '" . DB::escape($value['meta_keyword']) . "', 
                    meta_description = '" . DB::escape($value['meta_description']) . "', 
                    description      = '" . DB::escape($value['description']) . "'
			");

            // process tags
            if (isset($value['tag'])):
                $tags = explode(',', $value['tag']);
                foreach ($tags as $tag):
                    $tag = trim($tag);
                    DB::query("
                        INSERT INTO " . DB::prefix() . "tag 
                        SET 
                            section     = 'post', 
                            element_id  = '" . (int)$post_id . "', 
                            language_id = '" . (int)$language_id . "', 
                            tag         = '" . DB::escape($tag) . "'
                    ");
                endforeach;
            endif;

            $this->search->add($language_id, 'post', $post_id, $value['name']);
            $this->search->add($language_id, 'post', $post_id, $value['description']);
        }
        
        if (isset($data['post_store'])) {
            foreach ($data['post_store'] as $store_id) {
                DB::query("
					INSERT INTO " . DB::prefix() . "blog_post_to_store 
					SET 
						post_id = '" . (int)$post_id . "', 
						store_id = '" . (int)$store_id . "'
				");
            }
        }
        
        if (isset($data['post_image'])) {
            foreach ($data['post_image'] as $post_image) {
                DB::query("
					INSERT INTO " . DB::prefix() . "blog_post_image 
					SET 
						post_id = '" . (int)$post_id . "', 
						image = '" . DB::escape(html_entity_decode($post_image['image'], ENT_QUOTES, 'UTF-8')) . "', 
						sort_order = '" . (int)$post_image['sort_order'] . "'
				");
            }
        }
        
        if (isset($data['post_category'])) {
            foreach ($data['post_category'] as $category_id) {
                DB::query("
					INSERT INTO " . DB::prefix() . "blog_post_to_category 
					SET 
						post_id = '" . (int)$post_id . "', 
						category_id = '" . (int)$category_id . "'
				");
            }
        }
        
        if (isset($data['post_related'])) {
            foreach ($data['post_related'] as $related_id) {
                DB::query("
                    DELETE FROM " . DB::prefix() . "blog_post_related 
                    WHERE post_id = '" . (int)$post_id . "' 
                    AND related_id = '" . (int)$related_id . "'");
                
                DB::query("
					INSERT INTO " . DB::prefix() . "blog_post_related 
					SET 
						post_id = '" . (int)$post_id . "', 
						related_id = '" . (int)$related_id . "'
				");
                
                DB::query("
                    DELETE FROM " . DB::prefix() . "blog_post_related 
                    WHERE post_id = '" . (int)$related_id . "' 
                    AND related_id = '" . (int)$post_id . "'");
                
                DB::query("
					INSERT INTO " . DB::prefix() . "blog_post_related 
					SET 
						post_id = '" . (int)$related_id . "', 
						related_id = '" . (int)$post_id . "'
				");
            }
        }
        
        if (isset($data['post_layout'])) {
            foreach ($data['post_layout'] as $store_id => $layout) {
                if ($layout['layout_id']) {
                    DB::query("
						INSERT INTO " . DB::prefix() . "blog_post_to_layout 
						SET 
							post_id = '" . (int)$post_id . "', 
							store_id = '" . (int)$store_id . "', 
							layout_id = '" . (int)$layout['layout_id'] . "'
					");
                }
            }
        }
        
        if ($data['slug']) {
            DB::query("
				INSERT INTO " . DB::prefix() . "route 
				SET 
					route = 'content/post', 
					query = 'post_id:" . (int)$post_id . "', 
					slug = '" . DB::escape($data['slug']) . "'
			");
        }
        
        Cache::delete('post');
        Cache::delete('posts');
        Cache::delete('author');
        
        Theme::trigger('admin_blog_add_post', array('blog_post_id' => $post_id));
    }
    
    public function editPost($post_id, $data) {
        DB::query("
			UPDATE " . DB::prefix() . "blog_post 
			SET 
				date_available = '" . DB::escape($data['date_available']) . "', 
				author_id = '" . (int)$data['author_id'] . "', 
				status = '" . (int)$data['status'] . "', 
				sort_order = '" . (int)$data['sort_order'] . "', 
				date_modified = NOW() 
			WHERE post_id = '" . (int)$post_id . "'
		");
        
        if (isset($data['image'])) {
            DB::query("
				UPDATE " . DB::prefix() . "blog_post 
				SET 
					image = '" . DB::escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' 
					WHERE post_id = '" . (int)$post_id . "'
			");
        }
        
        DB::query("
            DELETE FROM " . DB::prefix() . "blog_post_description 
            WHERE post_id = '" . (int)$post_id . "'");
        
        foreach ($data['post_description'] as $language_id => $value) {
            DB::query("
				INSERT INTO " . DB::prefix() . "blog_post_description 
				SET 
					post_id = '" . (int)$post_id . "', 
					language_id = '" . (int)$language_id . "', 
					name = '" . DB::escape($value['name']) . "', 
					meta_keyword = '" . DB::escape($value['meta_keyword']) . "', 
					meta_description = '" . DB::escape($value['meta_description']) . "', 
					description = '" . DB::escape($value['description']) . "'
			");

            DB::query("
                DELETE FROM " . DB::prefix() . "tag 
                WHERE section   = 'post' 
                AND element_id  = '" . (int)$post_id . "' 
                AND language_id = '" . (int)$language_id . "'
            ");

            // process tags
            if (isset($value['tag'])):
                $tags = explode(',', $value['tag']);
                foreach ($tags as $tag):
                    $tag = trim($tag);
                    DB::query("
                        INSERT INTO " . DB::prefix() . "tag 
                        SET 
                            section     = 'post', 
                            element_id  = '" . (int)$post_id . "', 
                            language_id = '" . (int)$language_id . "', 
                            tag         = '" . DB::escape($tag) . "'
                    ");
                endforeach;
            endif;

            $this->search->delete('post', $post_id);

            $this->search->add($language_id, 'post', $post_id, $value['name']);
            $this->search->add($language_id, 'post', $post_id, $value['description']);
        }
        
        DB::query("
            DELETE FROM " . DB::prefix() . "blog_post_to_store 
            WHERE post_id = '" . (int)$post_id . "'");
        
        if (isset($data['post_store'])) {
            foreach ($data['post_store'] as $store_id) {
                DB::query("
					INSERT INTO " . DB::prefix() . "blog_post_to_store 
					SET 
						post_id = '" . (int)$post_id . "', 
						store_id = '" . (int)$store_id . "'
				");
            }
        }
        
        DB::query("
            DELETE FROM " . DB::prefix() . "blog_post_image 
            WHERE post_id = '" . (int)$post_id . "'");
        
        if (isset($data['post_image'])) {
            foreach ($data['post_image'] as $post_image) {
                DB::query("
					INSERT INTO " . DB::prefix() . "blog_post_image 
					SET 
						post_id = '" . (int)$post_id . "', 
						image = '" . DB::escape(html_entity_decode($post_image['image'], ENT_QUOTES, 'UTF-8')) . "', 
						sort_order = '" . (int)$post_image['sort_order'] . "'
				");
            }
        }
        
        DB::query("
            DELETE FROM " . DB::prefix() . "blog_post_to_category 
            WHERE post_id = '" . (int)$post_id . "'");
        
        if (isset($data['post_category'])) {
            foreach ($data['post_category'] as $category_id) {
                DB::query("
					INSERT INTO " . DB::prefix() . "blog_post_to_category 
					SET 
						post_id = '" . (int)$post_id . "', 
						category_id = '" . (int)$category_id . "'
				");
            }
        }
        
        DB::query("
            DELETE FROM " . DB::prefix() . "blog_post_related 
            WHERE post_id = '" . (int)$post_id . "'");

        DB::query("
            DELETE FROM " . DB::prefix() . "blog_post_related 
            WHERE related_id = '" . (int)$post_id . "'");
        
        if (isset($data['post_related'])) {
            foreach ($data['post_related'] as $related_id) {
                DB::query("
                    DELETE FROM " . DB::prefix() . "blog_post_related 
                    WHERE post_id = '" . (int)$post_id . "' 
                    AND related_id = '" . (int)$related_id . "'");
                
                DB::query("
					INSERT INTO " . DB::prefix() . "blog_post_related 
					SET 
						post_id = '" . (int)$post_id . "', 
						related_id = '" . (int)$related_id . "'
				");
                
                DB::query("
                    DELETE FROM " . DB::prefix() . "blog_post_related 
                    WHERE post_id = '" . (int)$related_id . "' 
                    AND related_id = '" . (int)$post_id . "'");
                
                DB::query("
					INSERT INTO " . DB::prefix() . "blog_post_related 
					SET 
						post_id = '" . (int)$related_id . "', 
						related_id = '" . (int)$post_id . "'
				");
            }
        }
        
        DB::query("
            DELETE FROM " . DB::prefix() . "blog_post_to_layout 
            WHERE post_id = '" . (int)$post_id . "'");
        
        if (isset($data['post_layout'])) {
            foreach ($data['post_layout'] as $store_id => $layout) {
                if ($layout['layout_id']) {
                    DB::query("
						INSERT INTO " . DB::prefix() . "blog_post_to_layout 
						SET 
							post_id = '" . (int)$post_id . "', 
							store_id = '" . (int)$store_id . "', 
							layout_id = '" . (int)$layout['layout_id'] . "'
					");
                }
            }
        }
        
        DB::query("
            DELETE FROM " . DB::prefix() . "route 
            WHERE query = 'post_id:" . (int)$post_id . "'");
        
        if ($data['slug']) {
            DB::query("
				INSERT INTO " . DB::prefix() . "route 
				SET 
					route = 'content/post', 
					query = 'post_id:" . (int)$post_id . "', 
					slug = '" . DB::escape($data['slug']) . "'
			");
        }
        
        Cache::delete('post');
        Cache::delete('posts');
        Cache::delete('author');
        
        Theme::trigger('admin_blog_edit_post', array('blog_post_id' => $post_id));
    }
    
    public function deletePost($post_id) {
        DB::query("
            DELETE FROM " . DB::prefix() . "blog_post 
            WHERE post_id = '" . (int)$post_id . "'");

        DB::query("
            DELETE FROM " . DB::prefix() . "blog_post_description 
            WHERE post_id = '" . (int)$post_id . "'");

        DB::query("
            DELETE FROM " . DB::prefix() . "blog_post_image 
            WHERE post_id = '" . (int)$post_id . "'");

        DB::query("
            DELETE FROM " . DB::prefix() . "blog_post_related 
            WHERE post_id = '" . (int)$post_id . "'");

        DB::query("
            DELETE FROM " . DB::prefix() . "blog_post_related 
            WHERE related_id = '" . (int)$post_id . "'");

        DB::query("
            DELETE FROM " . DB::prefix() . "blog_post_to_category 
            WHERE post_id = '" . (int)$post_id . "'");

        DB::query("
            DELETE FROM " . DB::prefix() . "blog_post_to_layout 
            WHERE post_id = '" . (int)$post_id . "'");

        DB::query("
            DELETE FROM " . DB::prefix() . "blog_post_to_store 
            WHERE post_id = '" . (int)$post_id . "'");

        DB::query("
            DELETE FROM " . DB::prefix() . "blog_comment 
            WHERE post_id = '" . (int)$post_id . "'");
        
        DB::query("
            DELETE FROM " . DB::prefix() . "route 
            WHERE query = 'post_id:" . (int)$post_id . "'");

        DB::query("
            DELETE FROM " . DB::prefix() . "tag 
            WHERE section  = 'post' 
            AND element_id = '" . (int)$post_id . "'");
        
        $this->search->delete('post', $post_id);
        
        Cache::delete('post');
        Cache::delete('posts');
        Cache::delete('author');
        
        Theme::trigger('admin_blog_delete_post', array('blog_post_id' => $post_id));
    }
    
    public function getPost($post_id) {
        $query = DB::query("
			SELECT DISTINCT *, 
			(SELECT slug FROM " . DB::prefix() . "route WHERE query = 'post_id:" . (int)$post_id . "') AS slug 
			FROM " . DB::prefix() . "blog_post p 
			LEFT JOIN " . DB::prefix() . "blog_post_description pd 
				ON (p.post_id = pd.post_id) 
			WHERE p.post_id = '" . (int)$post_id . "' 
			AND pd.language_id = '" . (int)Config::get('config_language_id') . "'
		");

        if ($query->num_rows):
            $query->row['tag'] = $this->getPostTags($post_id);
        endif;

        return $query->row;
    }

    public function getPostTags($post_id) {
        $query = DB::query("
            SELECT tag 
            FROM " . DB::prefix() . "tag 
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
        if ($data) {
            $sql = "
				SELECT * 
				FROM " . DB::prefix() . "blog_post p 
				LEFT JOIN " . DB::prefix() . "blog_post_description pd 
				ON (p.post_id = pd.post_id) ";
            
            if (!empty($data['filter_category_id'])) {
                $sql.= " LEFT JOIN " . DB::prefix() . "blog_post_to_category p2c ON (p.post_id = p2c.post_id)";
            }
            
            $sql.= " WHERE pd.language_id = '" . (int)Config::get('config_language_id') . "'";
            
            if (!empty($data['filter_name'])) {
                $sql.= " AND LCASE(pd.name) LIKE '" . DB::escape(Encode::strtolower($data['filter_name'])) . "%'";
            }
            
            if (!empty($data['filter_author_id'])) {
                $authors = $this->getAuthors();
                
                foreach($authors as $author):
                    if ($author['name'] == $data['filter_author_id']):
                        $data['filter_author_id'] = $author['author_id'];
                    endif;
                endforeach;
                
                $sql.= " AND p.author_id= '" . (int)$data['filter_author_id'] . "'";
            }
            
            if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
                $sql.= " AND p.status = '" . (int)$data['filter_status'] . "'";
            }
            
            if (!empty($data['filter_date_added'])) {
                $sql.= " AND DATE(p.date_added) = DATE('" . DB::escape($data['filter_date_added']) . "')";
            }
            
            if (!empty($data['filter_date_modified'])) {
                $sql.= " AND DATE(p.date_modified) = DATE('" . DB::escape($data['filter_date_modified']) . "')";
            }
            
            if (!empty($data['filter_category_id'])) {
                if (!empty($data['filter_sub_category'])) {
                    $implode_data = array();
                    
                    $implode_data[] = "category_id = '" . (int)$data['filter_category_id'] . "'";
                    
                    Theme::model('content/category');
                    
                    $categories = ContentCategory::getCategories($data['filter_category_id']);
                    
                    foreach ($categories as $category) {
                        $implode_data[] = "p2c.category_id = '" . (int)$category['category_id'] . "'";
                    }
                    
                    $sql.= " AND (" . implode(' OR ', $implode_data) . ")";
                } else {
                    $sql.= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
                }
            }
            
            if (User::getGroupId() != Config::get('blog_admin_group_id')) {
                $sql.= " AND p.author_id ='" . (int)User::getId() . "'";
            }
            
            $sql.= " GROUP BY p.post_id";
            
            $sort_data = array('pd.name', 'p.author_id', 'p.status', 'p.sort_order');
            
            if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
                $sql.= " ORDER BY {$data['sort']}";
            } else {
                $sql.= " ORDER BY pd.post_id";
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
        } else {
            $post_data = Cache::get('post.' . (int)Config::get('config_language_id') . '.' . (int)Config::get('config_store_id'));
            
            if (!$post_data) {
                $sql = "
						SELECT * FROM " . DB::prefix() . "blog_post p 
						 LEFT JOIN " . DB::prefix() . "blog_post_description pd 
						 	ON (p.post_id = pd.post_id) 
						 WHERE pd.language_id = '" . (int)Config::get('config_language_id') . "'";
                
                if (User::getGroupId() != Config::get('blog_admin_group_id')) {
                    $sql.= " AND p.author_id ='" . (int)User::getId() . "'";
                }
                
                $sql.= " ORDER BY pd.name ASC";
                
                $query = DB::query($sql);
                
                $post_data = $query->rows;
                
                Cache::set('post.' . (int)Config::get('config_language_id') . '.' . (int)Config::get('config_store_id'), $post_data);
            }
            
            return $post_data;
        }
    }
    
    public function getPostsByCategoryId($category_id) {
        $query = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "blog_post p 
			LEFT JOIN " . DB::prefix() . "blog_post_description pd 
				ON (p.post_id = pd.post_id) 
			LEFT JOIN " . DB::prefix() . "blog_post_to_category p2c 
				ON (p.post_id = p2c.post_id) 
			WHERE pd.language_id = '" . (int)Config::get('config_language_id') . "' 
			AND p2c.category_id = '" . (int)$category_id . "' 
			ORDER BY pd.name ASC
		");
        
        return $query->rows;
    }
    
    public function getPostDescriptions($post_id) {
        $post_description_data = array();
        
        $query = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "blog_post_description 
			WHERE post_id = '" . (int)$post_id . "'
		");
        
        foreach ($query->rows as $result) {
            $post_description_data[$result['language_id']] = array(
                'name'             => $result['name'], 
                'description'      => $result['description'], 
                'meta_keyword'     => $result['meta_keyword'], 
                'meta_description' => $result['meta_description'], 
                'tag'              => $this->getPostTags($post_id)
            );
        }
        
        return $post_description_data;
    }
    
    public function getPostAuthor($author_id) {
        Theme::model('people/user');
        
        $user_info = PeopleUser::getUser($author_id);
        
        return $this->getAuthorNameRelatedToPostedBy($user_info);
    }
    
    public function getAuthors() {
        $authors_data = array();
        
        Theme::model('people/user');
        
        $authors = PeopleUser::getUsers();
        
        if ($authors) {
            foreach ($authors as $author) {
                $authors_data[] = array(
                    'author_id' => $author['user_id'], 
                    'name'      => $this->getAuthorNameRelatedToPostedBy($author), 
                    'firstname' => $author['firstname'], 
                    'lastname'  => $author['lastname'], 
                    'user_name' => $author['user_name']
                );
            }
        }
        
        return $authors_data;
    }
    
    public function getAuthorNameRelatedToPostedBy($user_info) {
        
        $posted_by = $user_info['firstname'] . ' ' . $user_info['lastname'];
        
        if (Config::get('blog_posted_by') == 'firstname lastname') {
            $posted_by = $user_info['firstname'] . ' ' . $user_info['lastname'];
        } elseif (Config::get('blog_posted_by') == 'lastname firstname') {
            $posted_by = $user_info['lastname'] . ' ' . $user_info['firstname'];
        } elseif (Config::get('blog_posted_by') == 'user_name') {
            $posted_by = $user_info['user_name'];
        }
        
        return $posted_by;
    }
    
    public function getPostImages($post_id) {
        $query = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "blog_post_image 
			WHERE post_id = '" . (int)$post_id . "'
		");
        
        return $query->rows;
    }
    
    public function getPostStores($post_id) {
        $post_store_data = array();
        
        $query = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "blog_post_to_store 
			WHERE post_id = '" . (int)$post_id . "'
		");
        
        foreach ($query->rows as $result) {
            $post_store_data[] = $result['store_id'];
        }
        
        return $post_store_data;
    }
    
    public function getPostLayouts($post_id) {
        $post_layout_data = array();
        
        $query = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "blog_post_to_layout 
			WHERE post_id = '" . (int)$post_id . "'
		");
        
        foreach ($query->rows as $result) {
            $post_layout_data[$result['store_id']] = $result['layout_id'];
        }
        
        return $post_layout_data;
    }
    
    public function getPostCategories($post_id) {
        $post_category_data = array();
        
        $query = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "blog_post_to_category 
			WHERE post_id = '" . (int)$post_id . "'
		");
        
        foreach ($query->rows as $result) {
            $post_category_data[] = $result['category_id'];
        }
        
        return $post_category_data;
    }
    
    public function getPostCategoriesNames($post_id) {
        $post_category_data = array();
        
        $query = DB::query("
			SELECT cd.* 
			FROM " . DB::prefix() . "blog_post_to_category p2c 
			LEFT JOIN " . DB::prefix() . "blog_category_description cd 
				ON (p2c.category_id = cd.category_id) 
			WHERE p2c.post_id = '" . (int)$post_id . "' 
			AND cd.language_id='" . (int)Config::get('config_language_id') . "'
		");
        
        foreach ($query->rows as $result) {
            $post_category_data[] = $result['name'];
        }
        
        return $post_category_data;
    }
    
    public function getPostRelated($post_id) {
        $post_related_data = array();
        
        $query = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "blog_post_related 
			WHERE post_id = '" . (int)$post_id . "'
		");
        
        foreach ($query->rows as $result) {
            $post_related_data[] = $result['related_id'];
        }
        
        return $post_related_data;
    }
    
    public function getTotalPosts($data = array()) {
        
        $sql = "
            SELECT COUNT(DISTINCT p.post_id) AS total 
			FROM " . DB::prefix() . "blog_post p 
			LEFT JOIN " . DB::prefix() . "blog_post_description pd 
			ON (p.post_id = pd.post_id)";
        
        if (!empty($data['filter_category_id'])) {
            $sql.= " LEFT JOIN " . DB::prefix() . "blog_post_to_category p2c ON (p.post_id = p2c.post_id)";
        }
        
        $sql.= " WHERE pd.language_id = '" . (int)Config::get('config_language_id') . "'";
        
        if (!empty($data['filter_name'])) {
            $sql.= " AND LCASE(pd.name) LIKE '" . DB::escape(Encode::strtolower($data['filter_name'])) . "%'";
        }
        
        if (!empty($data['filter_author_id'])) {
            $authors = $this->getAuthors();

            foreach($authors as $author):
                if ($author['name'] == $data['filter_author_id']):
                    $data['filter_author_id'] = $author['author_id'];
                endif;
            endforeach;

            $sql.= " AND p.author_id = '" . (int)$data['filter_author_id'] . "'";
        }
        
        if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
            $sql.= " AND p.status = '" . (int)$data['filter_status'] . "'";
        }
        
        if (!empty($data['filter_date_added'])) {
            $sql.= " AND DATE(p.date_added) = DATE('" . DB::escape($data['filter_date_added']) . "')";
        }
        
        if (!empty($data['filter_date_modified'])) {
            $sql.= " AND DATE(p.date_modified) = DATE('" . DB::escape($data['filter_date_modified']) . "')";
        }
        
        if (!empty($data['filter_category_id'])) {
            if (!empty($data['filter_sub_category'])) {
                $implode_data = array();
                
                $implode_data[] = "p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
                
                Theme::model('content/category');
                
                $categories = ContentCategory::getCategories($data['filter_category_id']);
                
                foreach ($categories as $category) {
                    $implode_data[] = "p2c.category_id = '" . (int)$category['category_id'] . "'";
                }
                
                $sql.= " AND (" . implode(' OR ', $implode_data) . ")";
            } else {
                $sql.= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
            }
        }
        
        if (User::getGroupId() != Config::get('blog_admin_group_id')) {
            $sql.= " AND p.author_id ='" . (int)User::getId() . "'";
        }
        
        $query = DB::query($sql);
        
        return $query->row['total'];
    }
    
    public function getTotalPostsByAuthorId($author_id) {
        $query = DB::query("
			SELECT COUNT(*) AS total 
			FROM " . DB::prefix() . "blog_post 
			WHERE author_id = '" . (int)$author_id . "'
		");
        
        return $query->row['total'];
    }
    
    public function getTotalPostsByLayoutId($layout_id) {
        $query = DB::query("
			SELECT COUNT(*) AS total 
			FROM " . DB::prefix() . "blog_post_to_layout 
			WHERE layout_id = '" . (int)$layout_id . "'
		");
        
        return $query->row['total'];
    }
}
