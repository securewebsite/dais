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

namespace Dais\Services\Providers\People;

class User {
    
    private $user_id;
    private $user_name;
    private $user_group_id;
    private $user_last_access;
    private $permission = array();
    private $user_token;
    
    public function __construct() {
        if (!is_null(Session::get('user_id'))):
            $this->user_id          = Session::get('user_id');
            $this->user_name        = Session::get('user_name');
            $this->user_group_id    = Session::get('user_group_id');
            $this->user_last_access = Session::get('user_last_access');
            $this->permission       = Session::get('permission');
            $this->user_token       = Response::getToken();
        else:
            $this->logout();
        endif;
    }
    
    public function login($user_name, $password, $override = false) {
        if ($override):
            $user_query = DB::query("
                SELECT * FROM " . DB::prefix() . "user 
                WHERE user_id = '" . DB::escape(Encode::strtolower($user_name)) . "' 
                AND status = '1'
            ");
        else:
            $user_query = DB::query("
    			SELECT * 
    			FROM " . DB::prefix() . "user 
    			WHERE user_name = '" . DB::escape($user_name) . "' 
    			AND (password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1('" . DB::escape($password) . "'))))) 
    			OR password = '" . DB::escape(md5($password)) . "') 
    			AND status = '1'
    		");
        endif;
        
        if ($user_query->num_rows):
            Session::set('user_id', $user_query->row['user_id']);
            Session::set('user_name', $user_query->row['user_name']);
            Session::set('user_group_id', $user_query->row['user_group_id']);
            Session::set('user_last_access', strtotime($user_query->row['last_access']));

            if (isset(Session::p()->data['token'])):
                $this->user_token = Session::p()->data['token'];
            elseif(!is_null(Response::getToken())):
                $this->user_token = Response::getToken();
            endif;
            
            DB::query("
				UPDATE " . DB::prefix() . "user 
				SET 
                    ip          = '" . DB::escape(Request::server('REMOTE_ADDR')) . "', 
                    code        = '', 
                    last_access = NOW() 
				WHERE user_id = '" . (int)$user_query->row['user_id'] . "'
			");
            
            $user_group_query = DB::query("
				SELECT permission 
				FROM " . DB::prefix() . "user_group 
				WHERE user_group_id = '" . (int)$user_query->row['user_group_id'] . "'
			");
            
            $permissions = unserialize($user_group_query->row['permission']);
            
            if (is_array($permissions)):
                foreach ($permissions as $key => $value):
                    Session::p()->data['permission'][$key] = $value;
                endforeach;
            endif;
            //var_dump(Session::p()->data['token']);exit;
            return true;
        else:
            return false;
        endif;
    }
    
    public function logout() {
        unset(Session::p()->data['user_id']);
        unset(Session::p()->data['user_name']);
        unset(Session::p()->data['user_group_id']);
        unset(Session::p()->data['user_last_access']);
        unset(Session::p()->data['permission']);
        
        $this->user_id          = '';
        $this->user_name        = '';
        $this->user_group_id    = '';
        $this->user_last_access = '';
        $this->permission       = array(null);
        $this->user_token       = '';
    }
    
    public function hasPermission($key, $value) {
        if (isset($this->permission[$key])):
            return in_array($value, $this->permission[$key]);
        else:
            return false;
        endif;
    }
    
    public function reload_permissions() {
        $query = DB::query("
			SELECT permission 
			FROM " . DB::prefix() . "user_group 
			WHERE user_group_id = '" . (int)$this->user_group_id . "'
		");
        
        $permissions = unserialize($query->row['permission']);
        
        if (is_array($permissions)):
            foreach ($permissions as $key => $value):
                Session::p()->data['permission'][$key] = $value;
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

    public function getToken() {
        return $this->user_token;
    }

    public function setToken($token) {
        $this->user_token = $token;
    }

    public function unsetToken() {
        $this->user_token = '';
    }
}
