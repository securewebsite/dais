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

namespace App\Models\Admin\Design;

use App\Models\Model;

class Banner extends Model {
    
    public function addBanner($data) {
        $this->db->query("
            INSERT INTO {$this->db->prefix}banner 
            SET 
                name = '" . $this->db->escape($data['name']) . "', 
                status = '" . (int)$data['status'] . "'");
        
        $banner_id = $this->db->getLastId();
        
        if (isset($data['banner_image'])) {
            foreach ($data['banner_image'] as $banner_image) {
                $this->db->query("
                    INSERT INTO {$this->db->prefix}banner_image 
                    SET 
                        banner_id = '" . (int)$banner_id . "', 
                        link = '" . $this->db->escape($banner_image['link']) . "', 
                        image = '" . $this->db->escape($banner_image['image']) . "'");
                
                $banner_image_id = $this->db->getLastId();
                
                foreach ($banner_image['banner_image_description'] as $language_id => $banner_image_description) {
                    $this->db->query("
                        INSERT INTO {$this->db->prefix}banner_image_description 
                        SET 
                            banner_image_id = '" . (int)$banner_image_id . "', 
                            language_id = '" . (int)$language_id . "', 
                            banner_id = '" . (int)$banner_id . "', 
                            title = '" . $this->db->escape($banner_image_description['title']) . "'");
                }
            }
        }
        
        Theme::trigger('admin_add_banner', array('banner_id' => $banner_id));
    }
    
    public function editBanner($banner_id, $data) {
        $this->db->query("
            UPDATE {$this->db->prefix}banner 
            SET 
                name = '" . $this->db->escape($data['name']) . "', 
                status = '" . (int)$data['status'] . "' 
            WHERE banner_id = '" . (int)$banner_id . "'");
        
        $this->db->query("
            DELETE FROM {$this->db->prefix}banner_image 
            WHERE banner_id = '" . (int)$banner_id . "'");

        $this->db->query("
            DELETE FROM {$this->db->prefix}banner_image_description 
            WHERE banner_id = '" . (int)$banner_id . "'");
        
        if (isset($data['banner_image'])) {
            foreach ($data['banner_image'] as $banner_image) {
                $this->db->query("
                    INSERT INTO {$this->db->prefix}banner_image 
                    SET 
                        banner_id = '" . (int)$banner_id . "', 
                        link = '" . $this->db->escape($banner_image['link']) . "', 
                        image = '" . $this->db->escape($banner_image['image']) . "'");
                
                $banner_image_id = $this->db->getLastId();
                
                foreach ($banner_image['banner_image_description'] as $language_id => $banner_image_description) {
                    $this->db->query("
                        INSERT INTO {$this->db->prefix}banner_image_description 
                        SET 
                            banner_image_id = '" . (int)$banner_image_id . "', 
                            language_id = '" . (int)$language_id . "', 
                            banner_id = '" . (int)$banner_id . "', 
                            title = '" . $this->db->escape($banner_image_description['title']) . "'");
                }
            }
        }
        
        Theme::trigger('admin_edit_banner', array('banner_id' => $banner_id));
    }
    
    public function deleteBanner($banner_id) {
        $this->db->query("
            DELETE FROM {$this->db->prefix}banner 
            WHERE banner_id = '" . (int)$banner_id . "'");

        $this->db->query("
            DELETE FROM {$this->db->prefix}banner_image 
            WHERE banner_id = '" . (int)$banner_id . "'");

        $this->db->query("
            DELETE FROM {$this->db->prefix}banner_image_description 
            WHERE banner_id = '" . (int)$banner_id . "'");
        
        Theme::trigger('admin_delete_banner', array('banner_id' => $banner_id));
    }
    
    public function getBanner($banner_id) {
        $query = $this->db->query("
            SELECT DISTINCT * FROM {$this->db->prefix}banner 
            WHERE banner_id = '" . (int)$banner_id . "'");
        
        return $query->row;
    }
    
    public function getBanners($data = array()) {
        $sql = "
            SELECT * 
            FROM {$this->db->prefix}banner";
        
        $sort_data = array('name', 'status');
        
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
        
        $query = $this->db->query($sql);
        
        return $query->rows;
    }
    
    public function getBannerImages($banner_id) {
        $banner_image_data = array();
        
        $banner_image_query = $this->db->query("
            SELECT * 
            FROM {$this->db->prefix}banner_image 
            WHERE banner_id = '" . (int)$banner_id . "'");
        
        foreach ($banner_image_query->rows as $banner_image) {
            $banner_image_description_data = array();
            
            $banner_image_description_query = $this->db->query("
                SELECT * 
                FROM {$this->db->prefix}banner_image_description 
                WHERE banner_image_id = '" . (int)$banner_image['banner_image_id'] . "' 
                AND banner_id = '" . (int)$banner_id . "'");
            
            foreach ($banner_image_description_query->rows as $banner_image_description) {
                $banner_image_description_data[$banner_image_description['language_id']] = array('title' => $banner_image_description['title']);
            }
            
            $banner_image_data[] = array(
                'banner_image_description' => $banner_image_description_data, 
                'link'                     => $banner_image['link'], 
                'image'                    => $banner_image['image']
            );
        }
        
        return $banner_image_data;
    }
    
    public function getTotalBanners() {
        $query = $this->db->query("
            SELECT COUNT(*) AS total 
            FROM {$this->db->prefix}banner");
        
        return $query->row['total'];
    }
}
