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
namespace App\Models\Admin\People;

use App\Models\Model;

class User extends Model {
    
    public function addUser($data) {
        DB::query("
            INSERT INTO `" . DB::prefix() . "user` 
            SET 
                user_name     = '" . DB::escape($data['user_name']) . "', 
                salt          = '" . DB::escape($salt = substr(md5(uniqid(rand(), true)), 0, 9)) . "', 
                password      = '" . DB::escape(sha1($salt . sha1($salt . sha1($data['password'])))) . "', 
                firstname     = '" . DB::escape($data['firstname']) . "', 
                lastname      = '" . DB::escape($data['lastname']) . "', 
                email         = '" . DB::escape($data['email']) . "', 
                user_group_id = '" . (int)$data['user_group_id'] . "', 
                status        = '" . (int)$data['status'] . "', 
                date_added    = NOW()
        ");
    }
    
    public function editUser($user_id, $data) {
        DB::query("
            UPDATE `" . DB::prefix() . "user` 
            SET 
                user_name     = '" . DB::escape($data['user_name']) . "', 
                firstname     = '" . DB::escape($data['firstname']) . "', 
                lastname      = '" . DB::escape($data['lastname']) . "', 
                email         = '" . DB::escape($data['email']) . "', 
                user_group_id = '" . (int)$data['user_group_id'] . "', 
                status        = '" . (int)$data['status'] . "' 
            WHERE user_id = '" . (int)$user_id . "'");
        
        if ($data['password']) {
            DB::query("
                UPDATE `" . DB::prefix() . "user` 
                SET 
                    salt = '" . DB::escape($salt = substr(md5(uniqid(rand(), true)), 0, 9)) . "', 
                    password = '" . DB::escape(sha1($salt . sha1($salt . sha1($data['password'])))) . "' 
                WHERE user_id = '" . (int)$user_id . "'
            ");
        }
    }
    
    public function editPassword($user_id, $password) {
        DB::query("
            UPDATE `" . DB::prefix() . "user` 
            SET 
                salt = '" . DB::escape($salt = substr(md5(uniqid(rand(), true)), 0, 9)) . "', 
                password = '" . DB::escape(sha1($salt . sha1($salt . sha1($password)))) . "', 
                code = '' 
            WHERE user_id = '" . (int)$user_id . "'
        ");
    }
    
    public function editCode($email, $code) {
        $user = $this->getUserByEmail($email);

        $user_id = $user['user_id'];

        DB::query("
            UPDATE `" . DB::prefix() . "user` 
            SET 
                code = '" . DB::escape($code) . "' 
            WHERE user_id = '" . (int)$user_id . "'
        ");

        return $user_id;
    }
    
    public function deleteUser($user_id) {
        DB::query("
            DELETE FROM `" . DB::prefix() . "user` 
            WHERE user_id = '" . (int)$user_id . "'");
    }
    
    public function getUser($user_id) {
        $query = DB::query("
            SELECT * FROM `" . DB::prefix() . "user` 
            WHERE user_id = '" . (int)$user_id . "'");
        
        return $query->row;
    }
    
    public function getUserByUsername($user_name) {
        $query = DB::query("
            SELECT * 
            FROM `" . DB::prefix() . "user` 
            WHERE user_name = '" . DB::escape($user_name) . "'");
        
        return $query->row;
    }

    public function getUserByEmail($email) {
        $query = DB::query("
            SELECT * 
            FROM `" . DB::prefix() . "user` 
            WHERE email = '" . DB::escape($email) . "'");
        
        return $query->row;
    }
    
    public function getUserByCode($code) {
        $query = DB::query("
            SELECT * 
            FROM `" . DB::prefix() . "user` 
            WHERE code = '" . DB::escape($code) . "' AND code != ''");
        
        return $query->row;
    }
    
    public function getUsers($data = array()) {
        if (!empty($data['status'])):
            $status = $data['status'];
        else:
            $status = 1;
        endif;

        $sql = "
            SELECT * FROM `" . DB::prefix() . "user` WHERE status = '" . (int)$status . "'";
        
        $implode = array();
        
        if (!empty($data['filter_user_name'])):
            $implode[] = "user_name LIKE '" . DB::escape($data['filter_user_name']) . "%'";
        endif;
        
        if (!empty($data['filter_name'])):
            $implode[] = "CONCAT(firstname, ' ', lastname) LIKE '%" . DB::escape($data['filter_name']) . "%'";
        endif;

        if ($implode):
            $imp = implode(" && ", $implode);
            $sql.= " && {$imp}";
        endif;

        $sort_data = array(
            'user_name', 
            'status', 
            'date_added'
        );
        
        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql.= " ORDER BY {$data['sort']}";
        } else {
            $sql.= " ORDER BY user_name";
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
    }
    
    public function getTotalUsers() {
        $query = DB::query("
            SELECT COUNT(*) AS total 
            FROM `" . DB::prefix() . "user`");
        
        return $query->row['total'];
    }
    
    public function getTotalUsersByGroupId($user_group_id) {
        $query = DB::query("
            SELECT COUNT(*) AS total 
            FROM `" . DB::prefix() . "user` 
            WHERE user_group_id = '" . (int)$user_group_id . "'");
        
        return $query->row['total'];
    }
    
    public function getTotalUsersByEmail($email) {
        $query = DB::query("
            SELECT COUNT(*) AS total 
            FROM `" . DB::prefix() . "user` 
            WHERE LCASE(email) = '" . DB::escape(Encode::strtolower($email)) . "'");
        
        return $query->row['total'];
    }
}
