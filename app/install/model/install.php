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

namespace Install\Model;
use Dais\Engine\Model;
use Dais\Library\Db;

class Install extends Model {
    public function database($data) {
        $driver = 'Dais\Driver\Database\\' . 'Db' . $data['db_driver'];
        $db = new Db(new $driver($data['db_host'], $data['db_user'], $data['db_password'], $data['db_name'], $data['db_prefix']) , $this->app);
        
        $file = $this->app['path.application'] . 'dais.sql';
        
        if (!file_exists($file)):
            trigger_error('Could not load sql file: ' . $file);
        endif;
        
        $lines = file($file);
        
        if ($lines):
            $sql = '';
            foreach ($lines as $line):
                if ($line && (substr($line, 0, 2) != '--') && (substr($line, 0, 1) != '#')):
                    $sql.= $line;
                    if (preg_match('/;\s*$/', $line)):
                        $sql = str_replace("DROP TABLE IF EXISTS `dais_", "DROP TABLE IF EXISTS `" . $data['db_prefix'], $sql);
                        $sql = str_replace("CREATE TABLE `dais_", "CREATE TABLE `" . $data['db_prefix'], $sql);
                        $sql = str_replace("INSERT INTO `dais_", "INSERT INTO `" . $data['db_prefix'], $sql);
                        $db->query($sql);
                        $sql = '';
                    endif;
                endif;
            endforeach;
            
            $db->query("SET CHARACTER SET utf8");
            $db->query("SET @@session.sql_mode = 'MYSQL40'");
            $db->query("
				DELETE FROM {$data['db_prefix']}user 
				WHERE user_id = '1'
			");
            
            $db->query("
				INSERT INTO `" . $data['db_prefix'] . "user` 
				SET 
					user_id       = '1', 
					user_group_id = '1', 
					user_name     = '" . $db->escape($data['user_name']) . "', 
					salt          = '" . $db->escape($salt = substr(md5(uniqid(rand() , true)) , 0, 9)) . "', 
					password      = '" . $db->escape(sha1($salt . sha1($salt . sha1($data['password'])))) . "', 
					status        = '1', 
					email         = '" . $db->escape($data['email']) . "', 
					date_added    = NOW()
			");
            
            $db->query("
				DELETE FROM {$data['db_prefix']}setting 
				WHERE `key` = 'config_email'
			");
            
            $db->query("
				INSERT INTO {$data['db_prefix']}setting 
				SET 
					`group` = 'config', 
					`key` = 'config_email', 
					value = '" . $db->escape($data['email']) . "'
			");
            
            $db->query("
				DELETE FROM {$data['db_prefix']}setting 
				WHERE `key` = 'config_encryption'
			");
            
            $db->query("
				INSERT INTO {$data['db_prefix']}setting 
				SET 
					`group` = 'config', 
					`key` = 'config_encryption', 
					value = '" . $db->escape(md5(mt_rand())) . "'
			");
            
            $db->query("
				UPDATE {$data['db_prefix']}product 
				SET `viewed` = '0'
			");
        endif;
    }
}
