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

namespace Dais\Service;
use Dais\Engine\Model;

class PluginServiceModel extends Model {
    
    public function getPlugins() {
        $module_data = array();
        
        $query = $this->db->query("
            SELECT * 
            FROM {$this->db->prefix}module 
            WHERE `type` = 'plugin'
        ");
        
        foreach ($query->rows as $result):
            $module_data[] = $result['code'];
        endforeach;
        
        return $module_data;
    }
    
    public function getEventHandlers($store_id = 0) {
        $key = 'plugin.event.handlers' . $store_id;
        $cachefile = $this->cache->get($key);
        
        if (is_bool($cachefile)):
            $query = $this->db->query("
                SELECT * 
                FROM {$this->db->prefix}event 
                WHERE store_id = '" . (int)$store_id . "'
            ");
            
            $cachefile = $query->rows;
            $this->cache->set($key, $cachefile);
        endif;
        
        return $cachefile;
    }
    
    public function setEventHandler($event, $handler, $store_id = 0) {
        if (empty($handler['plugin']) || empty($handler['file']) || empty($handler['method'])) {
            return false;
        }
        
        $handler = $handler['plugin'] . '/' . $handler['file'] . '/' . $handler['method'];
        
        $query = $this->db->query("
            SELECT * 
            FROM {$this->db->prefix}event 
            WHERE store_id = '" . (int)$store_id . "' 
            AND event = '" . $this->db->escape($event) . "'
        ");
        
        $handlers = !empty($query->row['handlers']) ? unserialize($query->row['handlers']) : array();
        $handlers[] = $handler;
        
        $this->db->query("
            DELETE 
            FROM {$this->db->prefix}event 
            WHERE store_id = '" . (int)$store_id . "' 
            AND event = '" . $this->db->escape($event) . "'
        ");
        
        $this->db->query("
            INSERT INTO {$this->db->prefix}event 
            SET 
                store_id = '" . (int)$store_id . "', 
                event = '" . $this->db->escape($event) . "', 
                handlers = '" . $this->db->escape(serialize($handlers)) . "'
        ");
        
        $this->cache->delete('plugin.event.handlers');
        
        return true;
    }
    
    public function removeEventHandler($event, $handler, $store_id = 0) {
        if (empty($handler['plugin']) || empty($handler['file']) || empty($handler['method'])) {
            return false;
        }
        
        $handler = $handler['plugin'] . '/' . $handler['file'] . '/' . $handler['method'];
        
        $query = $this->db->query("
            SELECT * 
            FROM {$this->db->prefix}event 
            WHERE store_id = '" . (int)$store_id . "' 
            AND event = '" . $this->db->escape($event) . "'
        ");
        
        $handlers = !empty($query->row['handlers']) ? unserialize($query->row['handlers']) : array();
        
        if (!in_array($handler, $handlers)) {
            return true;
        }
        
        $key = array_search($handler, $handlers);
        
        unset($handlers[$key]);
        
        $this->db->query("
            DELETE 
            FROM {$this->db->prefix}event 
            WHERE store_id = '" . (int)$store_id . "' 
            AND event = '" . $this->db->escape($event) . "'
        ");
        
        $this->db->query("
            INSERT INTO {$this->db->prefix}event 
            SET 
                store_id = '" . (int)$store_id . "', 
                event = '" . $this->db->escape($event) . "', 
                handlers = '" . $this->db->escape(serialize($handlers)) . "'
        ");
        
        $this->cache->delete('plugin.event.handlers');
        
        return true;
    }
    
    /**
     *  Methods for handling hooks
     */
    public function getHookHandlers($store_id = 0) {
        $key = 'plugin.hook.handlers' . $store_id;
        $cachefile = $this->cache->get($key);
        
        if (is_bool($cachefile)):
            $query = $this->db->query("
                SELECT * 
                FROM {$this->db->prefix}hook 
                WHERE store_id = '" . (int)$store_id . "'
            ");
            
            $cachefile = $query->rows;
            $this->cache->set($key, $cachefile);
        endif;
        
        return $cachefile;
    }
    
    public function setHookHandler($hook, $handler, $store_id = 0) {
        if (empty($handler['class']) || empty($handler['method']) || empty($handler['plugin']) || empty($handler['file']) || empty($handler['callback'])):
            return false;
        endif;
        
        $query = $this->db->query("
            SELECT * 
            FROM {$this->db->prefix}hook 
            WHERE store_id = '" . (int)$store_id . "' 
            AND hook = '" . $this->db->escape($hook) . "'
        ");
        
        $handlers = !empty($query->row['handlers']) ? unserialize($query->row['handlers']) : array();
        $handlers[] = $handler;
        
        $this->db->query("
            DELETE 
            FROM {$this->db->prefix}hook 
            WHERE store_id = '" . (int)$store_id . "' 
            AND hook = '" . $this->db->escape($hook) . "'
        ");
        
        $this->db->query("
            INSERT INTO {$this->db->prefix}hook 
            SET 
                store_id = '" . (int)$store_id . "', 
                hook = '" . $this->db->escape($hook) . "', 
                handlers = '" . $this->db->escape(serialize($handlers)) . "'
        ");
        
        $this->cache->delete('plugin.hook.handlers');
        
        return true;
    }
    
    public function removeHookHandler($hook, $handler, $store_id = 0) {
        if (empty($handler['class']) || empty($handler['method']) || empty($handler['plugin']) || empty($handler['file']) || empty($handler['callback'])):
            return false;
        endif;
        
        $query = $this->db->query("
            SELECT * 
            FROM {$this->db->prefix}hook 
            WHERE store_id = '" . (int)$store_id . "' 
            AND hook = '" . $this->db->escape($hook) . "'
        ");
        
        $handlers = !empty($query->row['handlers']) ? unserialize($query->row['handlers']) : array();
        
        if (!in_array($handler, $handlers)) {
            return true;
        }
        
        $key = array_search($handler, $handlers);
        
        unset($handlers[$key]);
        
        $this->db->query("
            DELETE 
            FROM {$this->db->prefix}hook 
            WHERE store_id = '" . (int)$store_id . "' 
            AND hook = '" . $this->db->escape($hook) . "'
        ");
        
        $this->db->query("
            INSERT INTO {$this->db->prefix}hook 
            SET 
                store_id = '" . (int)$store_id . "', 
                hook = '" . $this->db->escape($hook) . "', 
                handlers = '" . $this->db->escape(serialize($handlers)) . "'
        ");
        
        $this->cache->delete('plugin.hook.handlers');
        
        return true;
    }
}
