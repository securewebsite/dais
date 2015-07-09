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

namespace Dais\Services\Providers;

class PluginModel {
    
    public function getPlugins() {
        $module_data = array();
        
        $query = \DB::query("
            SELECT * 
            FROM " . \DB::p()->prefix . "module 
            WHERE `type` = 'plugin'
        ");
        
        foreach ($query->rows as $result):
            $module_data[] = $result['code'];
        endforeach;
        
        return $module_data;
    }
    
    public function getEventHandlers($store_id = 0) {
        $key = 'plugin.event.handlers' . $store_id;
        $cachefile = \Cache::get($key);
        
        if (is_bool($cachefile)):
            $query = \DB::query("
                SELECT * 
                FROM " . \DB::p()->prefix . "event 
                WHERE store_id = '" . (int)$store_id . "'
            ");
            
            $cachefile = $query->rows;
            \Cache::set($key, $cachefile);
        endif;
        
        return $cachefile;
    }
    
    public function setEventHandler($event, $handler, $store_id = 0) {
        if (empty($handler['plugin']) || empty($handler['file']) || empty($handler['method'])) {
            return false;
        }
        
        $handler = $handler['plugin'] . '/' . $handler['file'] . '/' . $handler['method'];
        
        $query = \DB::query("
            SELECT * 
            FROM " . \DB::p()->prefix . "event 
            WHERE store_id = '" . (int)$store_id . "' 
            AND event = '" . \DB::escape($event) . "'
        ");
        
        $handlers = !empty($query->row['handlers']) ? unserialize($query->row['handlers']) : array();
        $handlers[] = $handler;
        
        \DB::query("
            DELETE 
            FROM " . \DB::p()->prefix . "event 
            WHERE store_id = '" . (int)$store_id . "' 
            AND event = '" . \DB::escape($event) . "'
        ");
        
        \DB::query("
            INSERT INTO " . \DB::p()->prefix . "event 
            SET 
                store_id = '" . (int)$store_id . "', 
                event = '" . \DB::escape($event) . "', 
                handlers = '" . \DB::escape(serialize($handlers)) . "'
        ");
        
        \Cache::delete('plugin.event.handlers');
        
        return true;
    }
    
    public function removeEventHandler($event, $handler, $store_id = 0) {
        if (empty($handler['plugin']) || empty($handler['file']) || empty($handler['method'])) {
            return false;
        }
        
        $handler = $handler['plugin'] . '/' . $handler['file'] . '/' . $handler['method'];
        
        $query = \DB::query("
            SELECT * 
            FROM " . \DB::p()->prefix . "event 
            WHERE store_id = '" . (int)$store_id . "' 
            AND event = '" . \DB::escape($event) . "'
        ");
        
        $handlers = !empty($query->row['handlers']) ? unserialize($query->row['handlers']) : array();
        
        if (!in_array($handler, $handlers)) {
            return true;
        }
        
        $key = array_search($handler, $handlers);
        
        unset($handlers[$key]);
        
        \DB::query("
            DELETE 
            FROM " . \DB::p()->prefix . "event 
            WHERE store_id = '" . (int)$store_id . "' 
            AND event = '" . \DB::escape($event) . "'
        ");
        
        \DB::query("
            INSERT INTO " . \DB::p()->prefix . "event 
            SET 
                store_id = '" . (int)$store_id . "', 
                event = '" . \DB::escape($event) . "', 
                handlers = '" . \DB::escape(serialize($handlers)) . "'
        ");
        
        \Cache::delete('plugin.event.handlers');
        
        return true;
    }
    
    /**
     *  Methods for handling hooks
     */
    public function getHookHandlers($store_id = 0) {
        $key = 'plugin.hook.handlers' . $store_id;
        $cachefile = \Cache::get($key);
        
        if (is_bool($cachefile)):
            $query = \DB::query("
                SELECT * 
                FROM " . \DB::p()->prefix . "hook 
                WHERE store_id = '" . (int)$store_id . "'
            ");
            
            $cachefile = $query->rows;
            \Cache::set($key, $cachefile);
        endif;
        
        return $cachefile;
    }
    
    public function setHookHandler($hook, $handler, $store_id = 0) {
        if (empty($handler['class']) || empty($handler['method']) || empty($handler['plugin']) || empty($handler['file']) || empty($handler['callback'])):
            return false;
        endif;
        
        $query = \DB::query("
            SELECT * 
            FROM " . \DB::p()->prefix . "hook 
            WHERE store_id = '" . (int)$store_id . "' 
            AND hook = '" . \DB::escape($hook) . "'
        ");
        
        $handlers = !empty($query->row['handlers']) ? unserialize($query->row['handlers']) : array();
        $handlers[] = $handler;
        
        \DB::query("
            DELETE 
            FROM " . \DB::p()->prefix . "hook 
            WHERE store_id = '" . (int)$store_id . "' 
            AND hook = '" . \DB::escape($hook) . "'
        ");
        
        \DB::query("
            INSERT INTO " . \DB::p()->prefix . "hook 
            SET 
                store_id = '" . (int)$store_id . "', 
                hook = '" . \DB::escape($hook) . "', 
                handlers = '" . \DB::escape(serialize($handlers)) . "'
        ");
        
        \Cache::delete('plugin.hook.handlers');
        
        return true;
    }
    
    public function removeHookHandler($hook, $handler, $store_id = 0) {
        if (empty($handler['class']) || empty($handler['method']) || empty($handler['plugin']) || empty($handler['file']) || empty($handler['callback'])):
            return false;
        endif;
        
        $query = \DB::query("
            SELECT * 
            FROM " . \DB::p()->prefix . "hook 
            WHERE store_id = '" . (int)$store_id . "' 
            AND hook = '" . \DB::escape($hook) . "'
        ");
        
        $handlers = !empty($query->row['handlers']) ? unserialize($query->row['handlers']) : array();
        
        if (!in_array($handler, $handlers)) {
            return true;
        }
        
        $key = array_search($handler, $handlers);
        
        unset($handlers[$key]);
        
        \DB::query("
            DELETE 
            FROM " . \DB::p()->prefix . "hook 
            WHERE store_id = '" . (int)$store_id . "' 
            AND hook = '" . \DB::escape($hook) . "'
        ");
        
        \DB::query("
            INSERT INTO " . \DB::p()->prefix . "hook 
            SET 
                store_id = '" . (int)$store_id . "', 
                hook = '" . \DB::escape($hook) . "', 
                handlers = '" . \DB::escape(serialize($handlers)) . "'
        ");
        
        \Cache::delete('plugin.hook.handlers');
        
        return true;
    }
}
