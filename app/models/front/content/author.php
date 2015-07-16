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

namespace App\Models\Front\Content;
use App\Models\Model;

class Author extends Model {
    public function getPostAuthor($author_id) {
        $key = 'author.' . $author_id;
        $cachefile = $this->cache->get($key);
        
        if (is_bool($cachefile)):
            $query = DB::query("
                SELECT * 
                FROM " . DB::prefix() . "user 
                WHERE user_id = '" . (int)$author_id . "' LIMIT 0,1
            ");
            
            if ($query->num_rows):
                $cachefile = $this->getAuthorNameRelatedToPostedBy($query->row);
                $this->cache->set($key, $cachefile);
            else:
                $cachefile = '';
            endif;
        endif;
        
        return $cachefile;
    }
    
    public function getAuthorNameRelatedToPostedBy($user_info) {
        $posted_by = $user_info['firstname'] . ' ' . $user_info['lastname'];
        
        if (Config::get('blog_posted_by') == 'firstname lastname'):
            $posted_by = $user_info['firstname'] . ' ' . $user_info['lastname'];
        elseif (Config::get('blog_posted_by') == 'lastname firstname'):
            $posted_by = $user_info['lastname'] . ' ' . $user_info['firstname'];
        elseif (Config::get('blog_posted_by') == 'user_name'):
            $posted_by = $user_info['user_name'];
        endif;
        
        return $posted_by;
    }
    
    public function getTotalPostsByAuthorId($author_id) {
        $key = 'author.total.' . $author_id;
        $cachefile = $this->cache->get($key);
        
        if (is_bool($cachefile)):
            $query = DB::query("
                SELECT COUNT(*) AS total 
                FROM " . DB::prefix() . "blog_post 
                WHERE author_id = '" . (int)$author_id . "' 
                AND status=1
            ");
            
            $cachefile = $query->row['total'];
            $this->cache->set($cachefile);
        endif;
        
        return $cachefile;
    }
}
