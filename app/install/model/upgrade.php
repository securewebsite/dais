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

namespace Install\Model;
use Dais\Engine\Model;
use Dais\Library\Db;

class Upgrade extends Model {
    public function mysql() {
        
        // Upgrade script to upgrade Dais to the latest version.
        // Oldest version supported is 1.0.0.0
        
        // Load the sql file
        $file = $this->app['path.application'] . 'dais.sql';
        
        if (!file_exists($file)):
            trigger_error('Could not load sql file: ' . $file);
        endif;
        
        $string = '';
        
        $lines = file($file);
        
        $status = false;
        
        // Get only the create statements
        foreach ($lines as $line):
            
            // Set any prefix
            $line = str_replace("CREATE TABLE IF NOT EXISTS `dais_", "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX, $line);
            
            // If line begins with create table we want to start recording
            if (substr($line, 0, 12) == 'CREATE TABLE'):
                $status = true;
            endif;
            
            if ($status):
                $string.= $line;
            endif;
            
            // If line contains with ; we want to stop recording
            if (preg_match('/;/', $line)):
                $status = false;
            endif;
        endforeach;
        
        $table_new_data = array();
        
        // Trim any spaces
        $string = trim($string);
        
        // Trim any ;
        $string = trim($string, ';');
        
        // Start reading each create statement
        $statements = explode(';', $string);
        
        foreach ($statements as $sql) {
            
            // Get all fields
            $field_data = array();
            
            preg_match_all('#`(\w[\w\d]*)`\s+((tinyint|smallint|mediumint|bigint|int|tinytext|text|mediumtext|longtext|tinyblob|blob|mediumblob|longblob|varchar|char|datetime|date|float|double|decimal|timestamp|time|year|enum|set|binary|varbinary)(\((.*)\))?){1}\s*(collate (\w+)\s*)?(unsigned\s*)?((NOT\s*NULL\s*)|(NULL\s*))?(auto_increment\s*)?(default \'([^\']*)\'\s*)?#i', $sql, $match);
            
            foreach (array_keys($match[0]) as $key):
                $field_data[] = array(
                    'name'          => trim($match[1][$key]) ,
                    'type'          => strtoupper(trim($match[3][$key])) ,
                    'size'          => str_replace(array('(', ')') , '', trim($match[4][$key])) ,
                    'sizeext'       => trim($match[6][$key]) ,
                    'collation'     => trim($match[7][$key]) ,
                    'unsigned'      => trim($match[8][$key]) ,
                    'notnull'       => trim($match[9][$key]) ,
                    'autoincrement' => trim($match[12][$key]) ,
                    'default'       => trim($match[14][$key]) ,
                );
            endforeach;
            
            // Get primary keys
            $primary_data = array();
            
            preg_match('#primary\s*key\s*\([^)]+\)#i', $sql, $match);
            
            if (isset($match[0])):
                preg_match_all('#`(\w[\w\d]*)`#', $match[0], $match);
            else:
                $match = array();
            endif;
            
            if ($match):
                foreach ($match[1] as $primary):
                    $primary_data[] = $primary;
                endforeach;
            endif;
            
            // Get indexes
            $index_data = array();
            
            $indexes = array();
            
            preg_match_all('#key\s*`\w[\w\d]*`\s*\(.*\)#i', $sql, $match);
            
            foreach ($match[0] as $key):
                preg_match_all('#`(\w[\w\d]*)`#', $key, $match);
                $indexes[] = $match;
            endforeach;
            
            foreach ($indexes as $index):
                $key = '';
                foreach ($index[1] as $field):
                    if ($key == ''):
                        $key = $field;
                    else:
                        $index_data[$key][] = $field;
                    endif;
                endforeach;
            endforeach;
            
            // Table options
            $option_data = array();
            
            preg_match_all('#(\w+)=(\w+)#', $sql, $option);
            
            foreach (array_keys($option[0]) as $key):
                $option_data[$option[1][$key]] = $option[2][$key];
            endforeach;
            
            // Get Table Name
            preg_match_all('#create\s*table\s*if\s*not\s*exists\s*`(\w+)`#i', $sql, $table);
            
            if (isset($table[1][0])):
                $table_new_data[] = array(
                    'sql'     => $sql,
                    'name'    => $table[1][0],
                    'field'   => $field_data,
                    'primary' => $primary_data,
                    'index'   => $index_data,
                    'option'  => $option_data
                );
            endif;
        }
        
        $driver = 'Dais\Driver\Database\\' . DB_DRIVER;
        $this->db = new Db(new $driver(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PREFIX) , $this->app);
        
        // Get all current tables, fields, type, size, etc..
        $table_old_data = array();
        
        $table_query = $this->db->query("
            SHOW TABLES FROM `" . DB_DATABASE . "`
        ");
        
        foreach ($table_query->rows as $table):
            if ($this->encode->substr($table['Tables_in_' . DB_DATABASE], 0, strlen(DB_PREFIX)) == DB_PREFIX):
                $field_data = array();
                $field_query = $this->db->query("
                    SHOW COLUMNS 
                    FROM `" . $table['Tables_in_' . DB_DATABASE] . "`
                ");
                
                foreach ($field_query->rows as $field):
                    $field_data[] = $field['Field'];
                endforeach;
                
                $table_old_data[$table['Tables_in_' . DB_DATABASE]] = $field_data;
            endif;
        endforeach;
        
        foreach ($table_new_data as $table):
            
            // If table is not found create it
            if (!isset($table_old_data[$table['name']])):
                $this->db->query($table['sql']);
            else:
                
                // DB Engine
                if (isset($table['option']['ENGINE'])):
                    $this->db->query("
                        ALTER TABLE `" . $table['name'] . "` 
                        ENGINE = `" . $table['option']['ENGINE'] . "`
                    ");
                endif;
                
                // Charset
                if (isset($table['option']['CHARSET']) && isset($table['option']['COLLATE'])):
                    $this->db->query("
                        ALTER TABLE `" . $table['name'] . "` 
                        DEFAULT CHARACTER SET `" . $table['option']['CHARSET'] . "` 
                        COLLATE `" . $table['option']['COLLATE'] . "`
                    ");
                endif;
                
                $i = 0;
                
                foreach ($table['field'] as $field):
                    
                    // If field is not found create it
                    if (!in_array($field['name'], $table_old_data[$table['name']])):
                        $sql = "
                            ALTER TABLE `" . $table['name'] . "` 
                            ADD `" . $field['name'] . "` " . $field['type'];
                        
                        if ($field['size']):
                            $sql.= "(" . $field['size'] . ")";
                        endif;
                        
                        if ($field['collation']):
                            $sql.= " " . $field['collation'];
                        endif;
                        
                        if ($field['notnull']):
                            $sql.= " " . $field['notnull'];
                        endif;
                        
                        if ($field['default']):
                            $sql.= " DEFAULT '" . $field['default'] . "'";
                        endif;
                        
                        if (isset($table['field'][$i - 1])):
                            $sql.= " AFTER `" . $table['field'][$i - 1]['name'] . "`";
                        else:
                            $sql.= " FIRST";
                        endif;
                        
                        $this->db->query($sql);
                    else:
                        
                        // Remove auto increment from all fields
                        $sql = "
                            ALTER TABLE `" . $table['name'] . "` 
                            CHANGE `" . $field['name'] . "` `" . $field['name'] . "` " . strtoupper($field['type']);
                        
                        if ($field['size']):
                            $sql.= "(" . $field['size'] . ")";
                        endif;
                        
                        if ($field['collation']):
                            $sql.= " " . $field['collation'];
                        endif;
                        
                        if ($field['notnull']):
                            $sql.= " " . $field['notnull'];
                        endif;
                        
                        if ($field['default']):
                            $sql.= " DEFAULT '" . $field['default'] . "'";
                        endif;
                        
                        if (isset($table['field'][$i - 1])):
                            $sql.= " AFTER `" . $table['field'][$i - 1]['name'] . "`";
                        else:
                            $sql.= " FIRST";
                        endif;
                        
                        $this->db->query($sql);
                    endif;
                    
                    $i++;
                endforeach;
                
                $status = false;
                
                // Drop primary keys and indexes.
                $query = $this->db->query("
                    SHOW INDEXES FROM `" . $table['name'] . "`
                ");
                
                foreach ($query->rows as $result):
                    if ($result['Key_name'] != 'PRIMARY'):
                        $this->db->query("
                            ALTER TABLE `" . $table['name'] . "` 
                            DROP INDEX `" . $result['Key_name'] . "`
                        ");
                    else:
                        $status = true;
                    endif;
                endforeach;
                
                if ($status):
                    $this->db->query("
                        ALTER TABLE `" . $table['name'] . "` 
                        DROP PRIMARY KEY
                    ");
                endif;
                
                // Add a new primary key.
                $primary_data = array();
                
                foreach ($table['primary'] as $primary):
                    $primary_data[] = "`" . $primary . "`";
                endforeach;
                
                if ($primary_data):
                    $this->db->query("
                        ALTER TABLE `" . $table['name'] . "` 
                        ADD PRIMARY KEY(" . implode(',', $primary_data) . ")
                    ");
                endif;
                
                // Add the new indexes
                foreach ($table['index'] as $index):
                    $index_data = array();
                    
                    foreach ($index as $key):
                        $index_data[] = '`' . $key . '`';
                    endforeach;
                    
                    if ($index_data):
                        $this->db->query("
                            ALTER TABLE `" . $table['name'] . "` 
                            ADD INDEX (" . implode(',', $index_data) . ")
                        ");
                    endif;
                endforeach;
                
                // Add auto increment to primary keys again
                foreach ($table['field'] as $field):
                    if ($field['autoincrement']):
                        $sql = "
                            ALTER TABLE `" . $table['name'] . "` 
                            CHANGE `" . $field['name'] . "` `" . $field['name'] . "` " . strtoupper($field['type']);
                        
                        if ($field['size']):
                            $sql.= "(" . $field['size'] . ")";
                        endif;
                        
                        if ($field['collation']):
                            $sql.= " " . $field['collation'];
                        endif;
                        
                        if ($field['notnull']):
                            $sql.= " " . $field['notnull'];
                        endif;
                        
                        if ($field['default']):
                            $sql.= " DEFAULT '" . $field['default'] . "'";
                        endif;
                        
                        if ($field['autoincrement']):
                            $sql.= " AUTO_INCREMENT";
                        endif;
                        
                        $this->db->query($sql);
                    endif;
                endforeach;
            endif;
        endforeach;
        
        // Update any additional sql thats required
        
        // Settings
        $query = $this->db->query("
            SELECT * 
            FROM `{$this->db->prefix}setting` 
            WHERE `store_id` = '0' 
            ORDER BY `store_id` ASC
        ");
        
        foreach ($query->rows as $setting):
            if (!$setting['serialized']):
                $settings[$setting['key']] = $setting['value'];
            else:
                $settings[$setting['key']] = unserialize($setting['value']);
            endif;
        endforeach;
        
        // Set defaults for new giftcard min/max fields if not set
        if (empty($settings['config_giftcard_min'])):
            $this->db->query("
                INSERT INTO `{$this->db->prefix}setting` 
                SET 
                    `value` = '1', 
                    `key` = 'config_giftcard_min', 
                    `group` = 'config', 
                    `store_id` = 0
            ");
        endif;
        
        if (empty($settings['config_giftcard_max'])):
            $this->db->query("
                INSERT INTO `{$this->db->prefix}setting` 
                SET 
                    `value` = '1000', 
                    `key` = 'config_giftcard_max', 
                    `group` = 'config', 
                    `store_id` = 0
            ");
        endif;
        
        // Update the customer group table
        if (in_array('name', $table_old_data[DB_PREFIX . 'customer_group'])):
            
            // Customer Group 'name' field moved to new customer_group_description table. Need to loop through and move over.
            $customer_group_query = $this->db->query("SELECT * FROM `{$this->db->prefix}customer_group`");
            
            foreach ($customer_group_query->rows as $customer_group):
                $language_query = $this->db->query("
                    SELECT `language_id` 
                    FROM `{$this->db->prefix}language`
                ");
                
                foreach ($language_query->rows as $language):
                    $this->db->query("
                        REPLACE INTO `{$this->db->prefix}customer_group_description` 
                        SET 
                            `customer_group_id` = '" . (int)$customer_group['customer_group_id'] . "', 
                            `language_id` = '" . (int)$language['language_id'] . "', 
                            `name` = '" . $this->db->escape($customer_group['name']) . "'
                    ");
                endforeach;
            endforeach;
            
            $this->db->query("ALTER TABLE `{$this->db->prefix}customer_group` DROP `name`");
        endif;
        
        // Move blacklisted ip to ban ip table
        
        $query = $this->db->query("
            SHOW TABLES LIKE '{$this->db->prefix}customer_ip_blacklist'
        ");
        
        if ($query->num_rows):
            $query = $this->db->query("
                SELECT * FROM {$this->db->prefix}customer_ip_blacklist
            ");
            
            foreach ($query->rows as $result):
                $this->db->query("
                    INSERT INTO {$this->db->prefix}customer_ban_ip 
                    SET ip = '" . $this->db->escape($result['ip']) . "'
                ");
            endforeach;
            
            // drop unused table
            $this->db->query("
                DROP TABLE IF EXISTS `{$this->db->prefix}customer_ip_blacklist`
            ");
        endif;
        
        // Sort the categories to take advantage of the nested set model
        $this->repairCategories(0);
    }
    
    // Function to repair any erroneous categories that are not in the category path table.
    public function repairCategories($parent_id = 0) {
        $query = $this->db->query("
            SELECT * FROM `{$this->db->prefix}category` 
            WHERE `parent_id` = '" . (int)$parent_id . "'
        ");
        
        foreach ($query->rows as $category) {
            
            // Delete the path below the current one
            $this->db->query("
                DELETE FROM `{$this->db->prefix}category_path` 
                WHERE `category_id` = '" . (int)$category['category_id'] . "'
            ");
            
            // Fix for records with no paths
            $level = 0;
            
            $query = $this->db->query("
                SELECT * 
                FROM `{$this->db->prefix}category_path` 
                WHERE `category_id` = '" . (int)$parent_id . "' 
                ORDER BY `level` ASC
            ");
            
            foreach ($query->rows as $result):
                $this->db->query("
                    INSERT INTO `{$this->db->prefix}category_path` 
                    SET 
                        `category_id` = '" . (int)$category['category_id'] . "', 
                        `path_id` = '" . (int)$result['path_id'] . "', 
                        `level` = '" . (int)$level . "'
                ");
                
                $level++;
            endforeach;
            
            $this->db->query("
                REPLACE INTO `{$this->db->prefix}category_path` 
                SET 
                    `category_id` = '" . (int)$category['category_id'] . "', 
                    `path_id` = '" . (int)$category['category_id'] . "', 
                    `level` = '" . (int)$level . "'
            ");
            
            $this->repairCategories($category['category_id']);
        }
    }
}
