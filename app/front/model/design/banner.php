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

namespace Front\Model\Design;
use Dais\Engine\Model;

class Banner extends Model {
    public function getBanner($banner_id) {
        $key = 'banner.' . $banner_id;
        $cachefile = $this->cache->get($key);
        
        if (is_bool($cachefile)):
            $query = $this->db->query("
				SELECT * 
				FROM {$this->db->prefix}banner_image bi 
				LEFT JOIN {$this->db->prefix}banner_image_description bid 
				ON (bi.banner_image_id  = bid.banner_image_id) 
				WHERE bi.banner_id = '" . (int)$banner_id . "' 
				AND bid.language_id = '" . (int)$this->config->get('config_language_id') . "'
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
}
