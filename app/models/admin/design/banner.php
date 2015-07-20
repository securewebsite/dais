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
        DB::query("
            INSERT INTO " . DB::prefix() . "banner 
            SET 
                name = '" . DB::escape($data['name']) . "', 
                status = '" . (int)$data['status'] . "'");
        
        $banner_id = DB::getLastId();
        
        if (isset($data['banner_image'])) {
            foreach ($data['banner_image'] as $banner_image) {
                DB::query("
                    INSERT INTO " . DB::prefix() . "banner_image 
                    SET 
                        banner_id = '" . (int)$banner_id . "', 
                        link = '" . DB::escape($banner_image['link']) . "', 
                        image = '" . DB::escape($banner_image['image']) . "'");
                
                $banner_image_id = DB::getLastId();
                
                foreach ($banner_image['banner_image_description'] as $language_id => $banner_image_description) {
                    DB::query("
                        INSERT INTO " . DB::prefix() . "banner_image_description 
                        SET 
                            banner_image_id = '" . (int)$banner_image_id . "', 
                            language_id = '" . (int)$language_id . "', 
                            banner_id = '" . (int)$banner_id . "', 
                            title = '" . DB::escape($banner_image_description['title']) . "'");
                }
            }
        }
        
        Theme::trigger('admin_add_banner', array('banner_id' => $banner_id));
    }
    
    public function editBanner($banner_id, $data) {
        DB::query("
            UPDATE " . DB::prefix() . "banner 
            SET 
                name = '" . DB::escape($data['name']) . "', 
                status = '" . (int)$data['status'] . "' 
            WHERE banner_id = '" . (int)$banner_id . "'");
        
        DB::query("
            DELETE FROM " . DB::prefix() . "banner_image 
            WHERE banner_id = '" . (int)$banner_id . "'");

        DB::query("
            DELETE FROM " . DB::prefix() . "banner_image_description 
            WHERE banner_id = '" . (int)$banner_id . "'");
        
        if (isset($data['banner_image'])) {
            foreach ($data['banner_image'] as $banner_image) {
                DB::query("
                    INSERT INTO " . DB::prefix() . "banner_image 
                    SET 
                        banner_id = '" . (int)$banner_id . "', 
                        link = '" . DB::escape($banner_image['link']) . "', 
                        image = '" . DB::escape($banner_image['image']) . "'");
                
                $banner_image_id = DB::getLastId();
                
                foreach ($banner_image['banner_image_description'] as $language_id => $banner_image_description) {
                    DB::query("
                        INSERT INTO " . DB::prefix() . "banner_image_description 
                        SET 
                            banner_image_id = '" . (int)$banner_image_id . "', 
                            language_id = '" . (int)$language_id . "', 
                            banner_id = '" . (int)$banner_id . "', 
                            title = '" . DB::escape($banner_image_description['title']) . "'");
                }
            }
        }
        
        Theme::trigger('admin_edit_banner', array('banner_id' => $banner_id));
    }
    
    public function deleteBanner($banner_id) {
        DB::query("
            DELETE FROM " . DB::prefix() . "banner 
            WHERE banner_id = '" . (int)$banner_id . "'");

        DB::query("
            DELETE FROM " . DB::prefix() . "banner_image 
            WHERE banner_id = '" . (int)$banner_id . "'");

        DB::query("
            DELETE FROM " . DB::prefix() . "banner_image_description 
            WHERE banner_id = '" . (int)$banner_id . "'");
        
        Theme::trigger('admin_delete_banner', array('banner_id' => $banner_id));
    }
    
    public function getBanner($banner_id) {
        $query = DB::query("
            SELECT DISTINCT * FROM " . DB::prefix() . "banner 
            WHERE banner_id = '" . (int)$banner_id . "'");
        
        return $query->row;
    }
    
    public function getBanners($data = array()) {
        $sql = "
            SELECT * 
            FROM " . DB::prefix() . "banner";
        
        $sort_data = array('name', 'status');
        
        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql.= " ORDER BY {$data['sort']}";
        } else {
            $sql.= " ORDER BY name";
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
    
    public function getBannerImages($banner_id) {
        $banner_image_data = array();
        
        $banner_image_query = DB::query("
            SELECT * 
            FROM " . DB::prefix() . "banner_image 
            WHERE banner_id = '" . (int)$banner_id . "'");
        
        foreach ($banner_image_query->rows as $banner_image) {
            $banner_image_description_data = array();
            
            $banner_image_description_query = DB::query("
                SELECT * 
                FROM " . DB::prefix() . "banner_image_description 
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
        $query = DB::query("
            SELECT COUNT(*) AS total 
            FROM " . DB::prefix() . "banner");
        
        return $query->row['total'];
    }
}
