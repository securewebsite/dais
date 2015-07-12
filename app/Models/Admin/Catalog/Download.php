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

namespace App\Models\Admin\Catalog;

use App\Models\Model;

class Download extends Model {
    public function addDownload($data) {
        $this->db->query("
			INSERT INTO {$this->db->prefix}download 
			SET 
				filename = '" . $this->db->escape($data['filename']) . "', 
				mask = '" . $this->db->escape($data['mask']) . "', 
				remaining = '" . (int)$data['remaining'] . "', 
				date_added = NOW()");
        
        $download_id = $this->db->getLastId();
        
        foreach ($data['download_description'] as $language_id => $value) {
            $this->db->query("
				INSERT INTO {$this->db->prefix}download_description 
				SET 
					download_id = '" . (int)$download_id . "', 
					language_id = '" . (int)$language_id . "', 
					name = '" . $this->db->escape($value['name']) . "'");
        }
        
        Theme::trigger('admin_add_download', array('download_id' => $download_id));
    }
    
    public function editDownload($download_id, $data) {
        if (!empty($data['update'])) {
            $download_info = $this->getDownload($download_id);
            
            if ($download_info) {
                
                // delete the old file
                if ($download_info['filename'] != $data['filename']):
                    unlink(Config::get('path.download') . $download_info['filename']);
                endif;
                
                $this->db->query("
					UPDATE {$this->db->prefix}order_download 
					SET 
						`filename` = '" . $this->db->escape($data['filename']) . "', 
						mask = '" . $this->db->escape($data['mask']) . "', 
						remaining = '" . (int)$data['remaining'] . "' 
					WHERE `filename` = '" . $this->db->escape($download_info['filename']) . "'");
            }
        }
        
        $this->db->query("
			UPDATE {$this->db->prefix}download 
			SET 
				filename = '" . $this->db->escape($data['filename']) . "', 
				mask = '" . $this->db->escape($data['mask']) . "', 
				remaining = '" . (int)$data['remaining'] . "' 
			WHERE download_id = '" . (int)$download_id . "'");
        
        $this->db->query("
			DELETE 
			FROM {$this->db->prefix}download_description 
			WHERE download_id = '" . (int)$download_id . "'");
        
        foreach ($data['download_description'] as $language_id => $value) {
            $this->db->query("
				INSERT INTO {$this->db->prefix}download_description 
				SET 
					download_id = '" . (int)$download_id . "', 
					language_id = '" . (int)$language_id . "', 
					name = '" . $this->db->escape($value['name']) . "'");
        }
        
        Theme::trigger('admin_edit_download', array('download_id' => $download_id));
    }
    
    public function deleteDownload($download_id) {
        
        // delete the download file
        $download = $this->getDownload($download_id);
        
        unlink(Config::get('path.download') . $download['filename']);
        
        $this->db->query("
			DELETE FROM {$this->db->prefix}download 
			WHERE download_id = '" . (int)$download_id . "'");
        
        $this->db->query("
			DELETE FROM {$this->db->prefix}download_description 
			WHERE download_id = '" . (int)$download_id . "'");
        
        Theme::trigger('admin_delete_download', array('download_id' => $download_id));
    }
    
    public function getDownload($download_id) {
        $query = $this->db->query("
			SELECT DISTINCT * 
			FROM {$this->db->prefix}download d 
			LEFT JOIN {$this->db->prefix}download_description dd 
				ON (d.download_id = dd.download_id) 
			WHERE d.download_id = '" . (int)$download_id . "' 
			AND dd.language_id = '" . (int)Config::get('config_language_id') . "'");
        
        return $query->row;
    }
    
    public function getDownloads($data = array()) {
        $sql = "
			SELECT * 
			FROM {$this->db->prefix}download d 
			LEFT JOIN {$this->db->prefix}download_description dd 
				ON (d.download_id = dd.download_id) 
			WHERE dd.language_id = '" . (int)Config::get('config_language_id') . "'";
        
        if (!empty($data['filter_name'])) {
            $sql.= " AND dd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
        }
        
        $sort_data = array('dd.name', 'd.remaining');
        
        if (!empty($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql.= " ORDER BY {$data['sort']}";
        } else {
            $sql.= " ORDER BY dd.name";
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
    
    public function getDownloadDescriptions($download_id) {
        $download_description_data = array();
        
        $query = $this->db->query("
			SELECT * 
			FROM {$this->db->prefix}download_description 
			WHERE download_id = '" . (int)$download_id . "'");
        
        foreach ($query->rows as $result) {
            $download_description_data[$result['language_id']] = array('name' => $result['name']);
        }
        
        return $download_description_data;
    }
    
    public function getTotalDownloads() {
        $query = $this->db->query("
			SELECT COUNT(*) AS total 
			FROM {$this->db->prefix}download");
        
        return $query->row['total'];
    }
}
