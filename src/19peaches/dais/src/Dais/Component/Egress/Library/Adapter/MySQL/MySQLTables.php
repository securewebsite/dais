<?php

/*
|--------------------------------------------------------------------------
|   Egress
|--------------------------------------------------------------------------
|
|    This file is part of the Dais Framework package.
|    
|    Egress is a recoded version of Ruckusing Migrations for full
|    integration into the Dais Framework. For the original version and
|    details on Ruckusing Migrations see:
|    
|    https://github.com/ruckus/ruckusing-migrations
|    
|    All thanks to Cody Caughlan for the great work he did on this.
|    
|    (c) Vince Kronlein <vince@dais.io>
|    
|    For the full copyright and license information, please view the LICENSE
|    file that was distributed with this source code.
|    
*/

namespace Egress\Library\Adapter\MySQL;
use Egress\Library\Adapter\AdapterBase;
use Egress\Library\Adapter\ColumnDefinition;
use Egress\Library\Adapter\TableDefinition;
use Egress\Library\EgressException;

class MySQLTables {
    
    private $_adapter;
    private $_name;
    private $_options;
    private $_sql              = "";
    private $_initialized      = false;
    private $_columns          = array();
    private $_table_def;
    private $_primary_keys     = array();
    private $_auto_generate_id = true;

    
    public function __construct($adapter, $name, $options = array()) {
        //sanity check
        if (!($adapter instanceof AdapterBase)):
            throw new EgressException("Invalid MySQL Adapter instance.",EgressException::INVALID_ADAPTER);
        endif;
        
        if (!$name):
            throw new EgressException("Invalid 'name' parameter", EgressException::INVALID_ARGUMENT);
        endif;

        $this->_adapter   = $adapter;
        $this->_name      = $name;
        $this->_options   = $options;
        $this->init_sql($name, $options);
        $this->_table_def = new TableDefinition($this->_adapter, $this->_options);

        if (array_key_exists('id', $options)):
            if (is_bool($options['id']) && $options['id'] == false):
                $this->_auto_generate_id = false;
            endif;
            //if its a string then we want to auto-generate an integer-based
            //primary key with this name
            if (is_string($options['id'])):
                $this->_auto_generate_id = true;
                $this->_primary_keys[] = $options['id'];
            endif;
        endif;
    }

    public function column($column_name, $type, $options = array()) {
        //if there is already a column by the same name then silently fail
        //and continue
        if ($this->_table_def->included($column_name) == true):
            return;
        endif;

        $column_options = array();

        if (array_key_exists('primary_key', $options)):
            if ($options['primary_key'] == true):
                $this->_primary_keys[] = $column_name;
            endif;
        endif;

        if (array_key_exists('auto_increment', $options)):
            if ($options['auto_increment'] == true):
                $column_options['auto_increment'] = true;
            endif;
        endif;

        if (array_key_exists('null', $options)):
            if ($options['null'] == true):
                $column_options['null'] = true;
            endif;
        else:
            $column_options['null'] = false;
        endif;
        
        $column_options = array_merge($column_options, $options);
        $column         = new ColumnDefinition($this->_adapter, $column_name, $type, $column_options);

        $this->_columns[] = $column;
    }

    public function integer($name, $limit = 11, $options = array()) {
        // if limit is an array then is our options
        if (is_array($limit)):
            $options = $limit;
            // if limit is boolean add primary key and autoincrement
        elseif (is_bool($limit)):
            $options['primary_key']    = true;
            $options['auto_increment'] = true;
        else:
            $options['limit'] = $limit;
        endif;

        if (array_key_exists('unsigned', $options)):
            if ($options['unsigned'] == false):
                $options['unsigned'] = false;
            endif;
        else:
            $options['unsigned'] = true;
        endif;

        if (array_key_exists('default', $options)):
            $options['default'] = $options['default'];
        endif;

        $this->column($name, 'integer', $options);
    }

    public function string($name, $limit = 255, $options = array()) {
        if (is_array($limit)):
            $options = $limit;
            $limit   = 255;
        endif;

        $options['limit'] = $limit;

        if (array_key_exists('default', $options)):
            $options['default'] = $options['default'];
        endif;

        $this->column($name, 'string', $options);
    }

    public function timestamps($created_column_name = "created_at", $updated_column_name = "updated_at") {
        $this->column($created_column_name, "datetime");
        $this->column($updated_column_name, "timestamp", array(
            "null"    => false, 
            'default' => 'CURRENT_TIMESTAMP', 
            'extra'   => 'ON UPDATE CURRENT_TIMESTAMP')
        );
    }

    private function keys() {
        if (count($this->_primary_keys) > 0):
            $lead   = ' PRIMARY KEY (';
            $quoted = array();
            
            foreach ($this->_primary_keys as $key):
                $quoted[] = sprintf("%s", $this->_adapter->identifier($key));
            endforeach;

            $primary_key_sql = ",\n" . $lead . implode(",", $quoted) . ")";

            return($primary_key_sql);
        else:
            return '';
        endif;
    }

    public function finish($wants_sql = false) {
        if ($this->_initialized == false):
            throw new EgressException(sprintf("Table Definition: '%s' has not been initialized", $this->_name), EgressException::INVALID_TABLE_DEFINITION);
        endif;

        if (is_array($this->_options) && array_key_exists('options', $this->_options)):
            $opt_str = $this->_options['options'];
        else:
            $opt_str = null;
        endif;

        if (isset($this->_adapter->db_info['charset'])):
            $opt_str .= " DEFAULT CHARSET=".$this->_adapter->db_info['charset'];
        else:
            $opt_str .= " DEFAULT CHARSET=utf8";
        endif;

        if (isset($this->_adapter->db_info['collate'])):
            $opt_str .= " COLLATE=".$this->_adapter->db_info['collate'];
        else:
            $opt_str .= " COLLATE=utf8_unicode_ci";
        endif;

        $close_sql        = sprintf(") %s;",$opt_str);
        $create_table_sql = $this->_sql;

        if ($this->_auto_generate_id === true):
            $this->_primary_keys[] = 'id';
            $primary_id = new ColumnDefinition($this->_adapter, 'id', 'integer',
                    array('unsigned' => true, 'null' => false, 'auto_increment' => true));

            $create_table_sql .= $primary_id->to_sql() . ",\n";
        endif;

        $create_table_sql .= $this->columns_to_str();
        $create_table_sql .= $this->keys() . $close_sql;

        if ($wants_sql):
            return $create_table_sql;
        else:
            return $this->_adapter->execute_ddl($create_table_sql);
        endif;
    }

    private function columns_to_str() {
        $str    = "";
        $fields = array();
        $len    = count($this->_columns);

        for ($i = 0; $i < $len; $i++):
            $c        = $this->_columns[$i];
            $fields[] = $c->__toString();
        endfor;

        return join(",\n", $fields);
    }

    private function init_sql($name, $options) {
        //are we forcing table creation? If so, drop it first
        if (array_key_exists('force', $options) && $options['force'] == true):
            try {
                $this->_adapter->drop_table($name);
            } catch (EgressException $e) {
                if ($e->getCode() != EgressException::MISSING_TABLE):
                    throw $e;
                endif;
            }
        endif;

        $temp = "";
        
        if (array_key_exists('temporary', $options)):
            $temp = " TEMPORARY";
        endif;
        
        $create_sql  = sprintf("CREATE%s TABLE ", $temp);
        $create_sql .= sprintf("%s (\n", $this->_adapter->identifier($name));
        $this->_sql .= $create_sql;
        
        $this->_initialized = true;
    }
}
