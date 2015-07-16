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

namespace App\Models\Admin\Setting;

use App\Models\Model;

class Module extends Model {
    
    public function getInstalled($type) {
        $module_data = array();
        
        $query = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "module 
			WHERE `type` = '" . DB::escape($type) . "'
		");
        
        foreach ($query->rows as $result):
            $module_data[] = $result['code'];
        endforeach;
        
        return $module_data;
    }

    public function getAll($type) {
        $modules = array();

        $query = DB::query("
            SELECT * 
            FROM " . DB::prefix() . "module 
            WHERE `type` = '" . DB::escape($type) . "'
        ");
        
        if ($query->num_rows):
            foreach($query->rows as $key => $row):
                $modules[$key] = $row;
                $q = DB::query("
                    SELECT data 
                    FROM " . DB::prefix() . "setting 
                    WHERE section = '" . DB::escape($row['code']) . "' 
                    AND item = '" . DB::escape($row['code'] . '_status') . "'
                ");
                if ($q->num_rows):
                    $modules[$key]['status'] = $q->row['data'];
                else:
                    $modules[$key]['status'] = 0;
                endif;
            endforeach;
        endif;

        return $modules;
    }
    
    public function install($type, $code) {
        DB::query("
			INSERT INTO " . DB::prefix() . "module 
			SET 
				`type` = '" . DB::escape($type) . "', 
				`code` = '" . DB::escape($code) . "'
		");
    }
    
    public function uninstall($type, $code) {
        DB::query("
			DELETE 
			FROM " . DB::prefix() . "module 
			WHERE `type` = '" . DB::escape($type) . "' 
			AND `code` = '" . DB::escape($code) . "'
		");
    }
    
    public function sql($sql) {
        $query = '';
        
        foreach ($lines as $line):
            if ($line && (substr($line, 0, 2) != '--') && (substr($line, 0, 1) != '#')):
                $query.= $line;
                
                if (preg_match('/;\s*$/', $line)):
                    $query = str_replace("DROP TABLE IF EXISTS `dais_", "DROP TABLE IF EXISTS `" . DB_PREFIX, $query);
                    $query = str_replace("CREATE TABLE `dais_", "CREATE TABLE `" . DB_PREFIX, $query);
                    $query = str_replace("INSERT INTO `dais_", "INSERT INTO `" . DB_PREFIX, $query);
                    
                    $result = mysql_query($query, $connection);
                    
                    if (!$result):
                        trigger_error(mysql_error());
                    endif;
                    
                    $query = '';
                endif;
            endif;
        endforeach;
    }
}
