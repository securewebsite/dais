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

namespace Dais\Library;
use Dais\Engine\Container;
use Dais\Service\LibraryService;

class User extends LibraryService {
    private $user_id;
    private $user_name;
    private $user_group_id;
    private $user_last_access;
    private $permission = array();
    
    public function __construct(Container $app) {
        parent::__construct($app);

        $session = $app['session'];
        
        if (isset($session->data['user_id'])):
            $this->user_id          = $session->data['user_id'];
            $this->user_name        = $session->data['user_name'];
            $this->user_group_id    = $session->data['user_group_id'];
            $this->user_last_access = $session->data['user_last_access'];
            $this->permission       = $session->data['permission'];
        else:
            $this->logout();
        endif;
    }
    
    public function login($user_name, $password, $override = false) {
        $db      = parent::$app['db'];
        $request = parent::$app['request'];
        $session = parent::$app['session'];
        $encode  = parent::$app['encode'];
        
        if ($override):
            $user_query = $db->query("
                SELECT * FROM {$db->prefix}user 
                WHERE user_id = '" . $db->escape($encode->strtolower($user_name)) . "' 
                AND status = '1'
            ");
        else:
            $user_query = $db->query("
    			SELECT * 
    			FROM {$db->prefix}user 
    			WHERE user_name = '" . $db->escape($user_name) . "' 
    			AND (password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1('" . $db->escape($password) . "'))))) 
    			OR password = '" . $db->escape(md5($password)) . "') 
    			AND status = '1'
    		");
        endif;
        
        if ($user_query->num_rows):
            $session->data['user_id']          = $user_query->row['user_id'];
            $session->data['user_name']        = $user_query->row['user_name'];
            $session->data['user_group_id']    = $user_query->row['user_group_id'];
            $session->data['user_last_access'] = strtotime($user_query->row['last_access']);
            
            $db->query("
				UPDATE {$db->prefix}user 
				SET 
                    ip          = '" . $db->escape($request->server['REMOTE_ADDR']) . "', 
                    code        = '', 
                    last_access = NOW() 
				WHERE user_id = '" . (int)$user_query->row['user_id'] . "'
			");
            
            $user_group_query = $db->query("
				SELECT permission 
				FROM {$db->prefix}user_group 
				WHERE user_group_id = '" . (int)$user_query->row['user_group_id'] . "'
			");
            
            $permissions = unserialize($user_group_query->row['permission']);
            
            if (is_array($permissions)):
                foreach ($permissions as $key => $value):
                    $session->data['permission'][$key] = $value;
                endforeach;
            endif;
            
            return true;
        else:
            return false;
        endif;
    }
    
    public function logout() {
        $session = parent::$app['session'];
        
        unset($session->data['user_id']);
        unset($session->data['user_name']);
        unset($session->data['user_group_id']);
        unset($session->data['user_last_access']);
        unset($session->data['permission']);
        
        $this->user_id          = '';
        $this->user_name        = '';
        $this->user_group_id    = '';
        $this->user_last_access = '';
        $this->permission       = array(null);
    }
    
    public function hasPermission($key, $value) {
        if (isset($this->permission[$key])):
            return in_array($value, $this->permission[$key]);
        else:
            return false;
        endif;
    }
    
    public function reload_permissions() {
        $db      = parent::$app['db'];
        $session = parent::$app['session'];
        
        $query = $db->query("
			SELECT permission 
			FROM {$db->prefix}user_group 
			WHERE user_group_id = '" . (int)$this->user_group_id . "'
		");
        
        $permissions = unserialize($query->row['permission']);
        
        if (is_array($permissions)):
            foreach ($permissions as $key => $value):
                $session->data['permission'][$key] = $value;
            endforeach;
        endif;
        
        return true;
    }
    
    public function isLogged() {
        return $this->user_id;
    }
    
    public function getId() {
        return $this->user_id;
    }
    
    public function getUserName() {
        return $this->user_name;
    }
    
    public function getGroupId() {
        return $this->user_group_id;
    }
    
    public function getLastAccess() {
        return $this->user_last_access;
    }
}
