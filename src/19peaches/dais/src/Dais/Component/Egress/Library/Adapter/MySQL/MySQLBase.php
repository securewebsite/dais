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
use Egress\Library\Adapter\AdapterInterface;
use Egress\Library\Adapter\ColumnDefinition;
use Egress\Library\Adapter\MySQL\MySQLTables;
use Egress\Library\Utility\Naming;
use Egress\Library\EgressException;
use Mysqli;

define('MYSQL_MAX_IDENTIFIER_LENGTH', 64);

class MySQLBase extends AdapterBase implements AdapterInterface {
    
    private $_name          = "MySQL";
    private $_tables        = array();
    private $_tables_loaded = false;
    private $_version       = '1.0';
    private $_in_trx        = false;

    public function __construct($dsn, $logger) {
        parent::__construct($dsn);

        $this->connect($dsn);
        $this->set_logger($logger);
    }

    public function get_database_name() {
        return($this->db_info['database']);
    }

    public function supports_migrations() {
        return true;
    }

    public function native_database_types() {
        $types = array(
            'primary_key'   => array('name' => 'integer', 'limit' => 11, 'null' => false),
            'string'        => array('name' => "varchar", 'limit' => 255),
            'text'          => array('name' => "text"),
            'tinytext'      => array('name' => "tinytext"),
            'mediumtext'    => array('name' => 'mediumtext'),
            'integer'       => array('name' => "int", 'limit' => 11),
            'tinyinteger'  	=> array('name' => "tinyint"),
            'smallinteger'  => array('name' => "smallint"),
            'mediuminteger'	=> array('name' => "mediumint"),
            'biginteger'    => array('name' => "bigint"),
            'float'         => array('name' => "float"),
            'decimal'       => array('name' => "decimal", 'scale' => 0, 'precision' => 10),
            'datetime'      => array('name' => "datetime"),
            'timestamp'     => array('name' => "timestamp"),
            'time'          => array('name' => "time"),
            'date'          => array('name' => "date"),
            'binary'        => array('name' => "blob"),
            'tinybinary'    => array('name' => "tinyblob"),
            'mediumbinary'  => array('name' => "mediumblob"),
            'longbinary'    => array('name' => "longblob"),
            'boolean'       => array('name' => "tinyint", 'limit' => 1),
            'enum'          => array('name' => "enum", 'values' => array()),
            'uuid'          => array('name' => "char", 'limit' => 36),
            'char'          => array('name' => "char"),
        );

        return $types;
    }

    public function create_schema_version_table() {
        if (!$this->has_table(EGRESS_TS_SCHEMA_TBL_NAME)):
            $t = $this->create_table(EGRESS_TS_SCHEMA_TBL_NAME, array('id' => false));
            $t->column('version', 'string');
            $t->finish();
            $this->add_index(EGRESS_TS_SCHEMA_TBL_NAME, 'version', array('unique' => true));
        endif;
    }

    public function start_transaction() {
        if ($this->inTransaction() === false):
            $this->beginTransaction();
        endif;
    }

    public function commit_transaction() {
        if ($this->inTransaction()):
            $this->commit();
        endif;
    }

    public function rollback_transaction() {
        if ($this->inTransaction()):
            $this->rollback();
        endif;
    }

    public function quote_table($str) {
        return "`" . $str . "`";
    }

    public function column_definition($column_name, $type, $options = null) {
        $col = new ColumnDefinition($this, $column_name, $type, $options);

        return $col->__toString();
    }

    public function database_exists($db) {
        $ddl    = "SHOW DATABASES";
        $result = $this->select_all($ddl);

        if (count($result) == 0):
            return false;
        endif;

        foreach ($result as $dbrow):
            if ($dbrow['Database'] == $db):
                return true;
            endif;
        endforeach;

        return false;
    }

    public function create_database($db) {
        if ($this->database_exists($db)):
            return false;
        endif;

        $ddl    = sprintf("CREATE DATABASE %s", $this->identifier($db));
        $result = $this->query($ddl);

        return($result === true);
    }

    public function drop_database($db) {
        if (!$this->database_exists($db)):
            return false;
        endif;

        $ddl    = sprintf("DROP DATABASE IF EXISTS %s", $this->identifier($db));
        $result = $this->query($ddl);

        return ($result === true);
    }

    public function schema($output_file) {
        $final = "";
        $views = '';

        $this->load_tables(true);
        
        foreach ($this->_tables as $tbl => $idx):
            if ($tbl == 'schema_info'):
                continue;
            endif;

            $stmt   = sprintf("SHOW CREATE TABLE %s", $this->identifier($tbl));
            $result = $this->query($stmt);

            if (is_array($result) && count($result) == 1):
                $row = $result[0];
                
                if (count($row) == 2):
                    if (isset($row['Create Table'])):
                        $final .= $row['Create Table'] . ";\n\n";
                    elseif (isset($row['Create View'])):
                        $views .= $row['Create View'] . ";\n\n";
                    endif;
                endif;
            endif;
        endforeach;

        $data = $final . $views;

        return file_put_contents($output_file, $data, LOCK_EX);
    }

    public function table_exists($tbl, $reload_tables = false) {
        $this->load_tables($reload_tables);

        return array_key_exists($tbl, $this->_tables);
    }

    public function execute($query) {
        return $this->query($query);
    }

    public function query($query) {
        $this->logger->log($query);

        $query_type = $this->determine_query_type($query);
        $data       = array();
        
        if ($query_type == SQL_SELECT || $query_type == SQL_SHOW):
            $res = $this->conn->query($query);
            
            if ($this->isError($res)):
                throw new EgressException(
                    sprintf("Error executing 'query' with:\n%s\n\nReason: %s\n\n", $query, $this->conn->error), EgressException::QUERY_ERROR);
            endif;

            while ($row = $res->fetch_assoc()):
                $data[] = $row;
            endwhile;

            return $data;

        else:
            // INSERT, DELETE, etc...
            $res = $this->conn->query($query);
            
            if ($this->isError($res)):
                throw new EgressException(
                    sprintf("Error executing 'query' with:\n%s\n\nReason: %s\n\n", $query, $this->conn->error), EgressException::QUERY_ERROR);
            endif;

            if ($query_type == SQL_INSERT):
                return $this->conn->insert_id;
            endif;

            return true;
        endif;
    }

    public function multi_query($queries) {
        $res = $this->conn->multi_query($queries);

        if ($result = $this->conn->store_result()):
            $result->free();
        endif;

        if ($this->isError($res)):
            throw new EgressException(
                sprintf("Error executing 'query' with:\n%s\n\nReason: %s\n\n", $queries, $this->conn->error), EgressException::QUERY_ERROR);
        endif;

        while ($this->conn->more_results()):
            $res = $this->conn->next_result();

            if ($result = $this->conn->store_result()):
                $result->free();
            endif;

            if ($this->isError($res)):
                throw new EgressException(
                    sprintf("Error executing 'query' with:\n%s\n\nReason: %s\n\n", $queries, $this->conn->error), EgressException::QUERY_ERROR);
            endif;
        endwhile;

        return true;
    }

    public function select_one($query) {
        $this->logger->log($query);
        
        $query_type = $this->determine_query_type($query);
        
        if ($query_type == SQL_SELECT || $query_type == SQL_SHOW):
            $res = $this->conn->query($query);
            if ($this->isError($res)):
                throw new EgressException(
                    sprintf("Error executing 'query' with:\n%s\n\nReason: %s\n\n", $query, $this->conn->error), EgressException::QUERY_ERROR);
            endif;

            return $res->fetch_assoc();
        else:
            throw new EgressException("Query for select_one() is not one of SELECT or SHOW: $query", EgressException::QUERY_ERROR);
        endif;
    }

    public function select_all($query) {
        return $this->query($query);
    }

    public function execute_ddl($ddl) {
        $result = $this->query($ddl);

        return true;
    }

    public function drop_table($tbl) {
        $ddl    = sprintf("DROP TABLE IF EXISTS %s", $this->identifier($tbl));
        $result = $this->query($ddl);

        return true;
    }

    public function create_table($table_name, $options = array()) {
        return new MySQLTables($this, $table_name, $options);
    }

    public function quote_string($str) {
        return $this->conn->real_escape_string($str);
    }

    public function identifier($str) {
        return "`" . $str . "`";
    }

    public function quote($value, $column = null) {
        return $this->quote_string($value);
    }

    public function rename_table($name, $new_name) {
        if (empty($name)):
            throw new EgressException("Missing original column name parameter", EgressException::INVALID_ARGUMENT);
        endif;

        if (empty($new_name)):
            throw new EgressException("Missing new column name parameter", EgressException::INVALID_ARGUMENT);
        endif;

        $sql = sprintf("RENAME TABLE %s TO %s", $this->identifier($name), $this->identifier($new_name));

        return $this->execute_ddl($sql);
    }

    public function add_column($table_name, $column_name, $type, $options = array()) {
        if (empty($table_name)):
            throw new EgressException("Missing table name parameter",EgressException::INVALID_ARGUMENT);
        endif;

        if (empty($column_name)):
            throw new EgressException("Missing column name parameter", EgressException::INVALID_ARGUMENT);
        endif;
        
        if (empty($type)):
            throw new EgressException("Missing type parameter", EgressException::INVALID_ARGUMENT);
        endif;
        
        if (!array_key_exists('limit', $options)):
            $options['limit'] = null;
        endif;
        
        if (!array_key_exists('precision', $options)):
            $options['precision'] = null;
        endif;
        
        if (!array_key_exists('scale', $options)):
            $options['scale'] = null;
        endif;
        
        $sql  = sprintf("ALTER TABLE %s ADD `%s` %s", $this->identifier($table_name), $column_name, $this->type_to_sql($type,$options));
        $sql .= $this->add_column_options($type, $options);

        return $this->execute_ddl($sql);
    }

    public function remove_column($table_name, $column_name) {
        $sql = sprintf("ALTER TABLE %s DROP COLUMN %s", $this->identifier($table_name), $this->identifier($column_name));

        return $this->execute_ddl($sql);
    }

    public function rename_column($table_name, $column_name, $new_column_name) {
        if (empty($table_name)):
            throw new EgressException("Missing table name parameter", EgressException::INVALID_ARGUMENT);
        endif;

        if (empty($column_name)):
            throw new EgressException("Missing original column name parameter", EgressException::INVALID_ARGUMENT);
        endif;
        
        if (empty($new_column_name)):
            throw new EgressException("Missing new column name parameter", EgressException::INVALID_ARGUMENT);
        endif;
        
        $column_info  = $this->column_info($table_name, $column_name);
        $current_type = $column_info['type'];
        
        $sql = sprintf("ALTER TABLE %s CHANGE %s %s %s",
                $this->identifier($table_name),
                $this->identifier($column_name),
                $this->identifier($new_column_name), $current_type);
        
        $sql .= $this->add_column_options($current_type, $column_info);

        return $this->execute_ddl($sql);
    }

    public function change_column($table_name, $column_name, $type, $options = array()) {
        if (empty($table_name)):
            throw new EgressException("Missing table name parameter", EgressException::INVALID_ARGUMENT);
        endif;

        if (empty($column_name)):
            throw new EgressException("Missing original column name parameter", EgressException::INVALID_ARGUMENT);
        endif;
        
        if (empty($type)):
            throw new EgressException("Missing type parameter", EgressException::INVALID_ARGUMENT);
        endif;
        
        $column_info = $this->column_info($table_name, $column_name);

        if (!array_key_exists('limit', $options)):
            $options['limit'] = null;
        endif;
        
        if (!array_key_exists('precision', $options)):
            $options['precision'] = null;
        endif;
        
        if (!array_key_exists('scale', $options)):
            $options['scale'] = null;
        endif;
        
        $sql  = sprintf("ALTER TABLE `%s` CHANGE `%s` `%s` %s", $table_name, $column_name, $column_name,  $this->type_to_sql($type,$options));
        $sql .= $this->add_column_options($type, $options);

        return $this->execute_ddl($sql);
    }

    public function column_info($table, $column) {
        if (empty($table)):
            throw new EgressException("Missing table name parameter", EgressException::INVALID_ARGUMENT);
        endif;

        if (empty($column)):
            throw new EgressException("Missing original column name parameter", EgressException::INVALID_ARGUMENT);
        endif;
        
        try {
            $sql    = sprintf("SHOW FULL COLUMNS FROM %s LIKE '%s'", $this->identifier($table), $column);
            $result = $this->select_one($sql);

            if (is_array($result)):
                //lowercase key names
                $result = array_change_key_case($result, CASE_LOWER);
            endif;

            return $result;
        } catch (Exception $e) {
            return null;
        }
    }

    public function add_index($table_name, $column_name, $options = array()) {
        if (empty($table_name)):
            throw new EgressException("Missing table name parameter", EgressException::INVALID_ARGUMENT);
        endif;

        if (empty($column_name)):
            throw new EgressException("Missing column name parameter", EgressException::INVALID_ARGUMENT);
        endif;
        
        //unique index?
        if (is_array($options) && array_key_exists('unique', $options) && $options['unique'] === true):
            $unique = true;
        else:
            $unique = false;
        endif;
        
        //did the user specify an index name?
        if (is_array($options) && array_key_exists('name', $options)):
            $index_name = $options['name'];
        else:
            $index_name = Naming::index_name($table_name, $column_name);
        endif;

        if (strlen($index_name) > MYSQL_MAX_IDENTIFIER_LENGTH):
            $msg  = "The auto-generated index name is too long for MySQL (max is 64 chars). ";
            $msg .= "Considering using 'name' option parameter to specify a custom name for this index.";
            $msg .= " Note: you will also need to specify";
            $msg .= " this custom name in a drop_index() - if you have one.";
            throw new EgressException($msg, EgressException::INVALID_INDEX_NAME);
        endif;

        if (!is_array($column_name)):
            $column_names = array($column_name);
        else:
            $column_names = $column_name;
        endif;
        
        $cols = array();
        
        foreach ($column_names as $name):
            $cols[] = $this->identifier($name);
        endforeach;
        
        $sql = sprintf("CREATE %sINDEX %s ON %s(%s)",
                $unique ? "UNIQUE " : "",
                $this->identifier($index_name),
                $this->identifier($table_name),
                join(", ", $cols));

        return $this->execute_ddl($sql);
    }

    public function remove_index($table_name, $column_name, $options = array()) {
        if (empty($table_name)):
            throw new EgressException("Missing table name parameter", EgressException::INVALID_ARGUMENT);
        endif;

        if (empty($column_name)):
            throw new EgressException("Missing column name parameter", EgressException::INVALID_ARGUMENT);
        endif;
        
        //did the user specify an index name?
        if (is_array($options) && array_key_exists('name', $options)):
            $index_name = $options['name'];
        else:
            $index_name = Naming::index_name($table_name, $column_name);
        endif;
        
        $sql = sprintf("DROP INDEX %s ON %s", $this->identifier($index_name), $this->identifier($table_name));

        return $this->execute_ddl($sql);
    }

    public function add_timestamps($table_name, $created_column_name, $updated_column_name) {
        if (empty($table_name)):
            throw new EgressException("Missing table name parameter", EgressException::INVALID_ARGUMENT);
        endif;
        
        if (empty($created_column_name)):
            throw new EgressException("Missing created at column name parameter", EgressException::INVALID_ARGUMENT);
        endif;
        
        if (empty($updated_column_name)):
            throw new EgressException("Missing updated at column name parameter", EgressException::INVALID_ARGUMENT);
        endif;
        
        $created_at = $this->add_column($table_name, $created_column_name, "datetime");
        $updated_at = $this->add_column($table_name, $updated_column_name, "timestamp", array(
            "null"    => false, 
            'default' => 'CURRENT_TIMESTAMP', 
            'extra'   => 'ON UPDATE CURRENT_TIMESTAMP')
        );

        return $created_at && $updated_at;
    }

    public function remove_timestamps($table_name, $created_column_name, $updated_column_name) {
        if (empty($table_name)):
            throw new EgressException("Missing table name parameter", EgressException::INVALID_ARGUMENT);
        endif;
        
        if (empty($created_column_name)):
            throw new EgressException("Missing created at column name parameter", EgressException::INVALID_ARGUMENT);
        endif;
        
        if (empty($updated_column_name)):
            throw new EgressException("Missing updated at column name parameter", EgressException::INVALID_ARGUMENT);
        endif;
        
        $updated_at = $this->remove_column($table_name, $created_column_name);
        $created_at = $this->remove_column($table_name, $updated_column_name);

        return $created_at && $updated_at;
    }

    public function has_index($table_name, $column_name, $options = array()) {
        if (empty($table_name)):
            throw new EgressException("Missing table name parameter", EgressException::INVALID_ARGUMENT);
        endif;
        
        if (empty($column_name)):
            throw new EgressException("Missing column name parameter", EgressException::INVALID_ARGUMENT);
        endif;
        
        //did the user specify an index name?
        if (is_array($options) && array_key_exists('name', $options)):
            $index_name = $options['name'];
        else:
            $index_name = Naming::index_name($table_name, $column_name);
        endif;
        
        $indexes = $this->indexes($table_name);
        
        foreach ($indexes as $idx):
            if ($idx['name'] == $index_name):
                return true;
            endif;
        endforeach;

        return false;
    }

    public function indexes($table_name) {
        $sql     = sprintf("SHOW KEYS FROM %s", $this->identifier($table_name));
        $result  = $this->select_all($sql);
        $indexes = array();
        $cur_idx = null;

        foreach ($result as $row):
            //skip primary
            if ($row['Key_name'] == 'PRIMARY'):
                continue;
            endif;
            
            $cur_idx   = $row['Key_name'];
            $indexes[] = array('name' => $row['Key_name'], 'unique' => (int) $row['Non_unique'] == 0 ? true : false);
        endforeach;

        return $indexes;
    }

    public function type_to_sql($type, $options = array()) {
        $natives = $this->native_database_types();

        if (!array_key_exists($type, $natives)):
            $error  = sprintf("Error:I dont know what column type of '%s' maps to for MySQL.", $type);
            $error .= "\nYou provided: {$type}\n";
            $error .= "Valid types are: \n";
            $types  = array_keys($natives);

            foreach ($types as $t):
                if ($t == 'primary_key'):
                    continue;
                endif;

                $error .= "\t{$t}\n";
            endforeach;
            
            throw new EgressException($error, EgressException::INVALID_ARGUMENT);
        endif;

        $scale     = null;
        $precision = null;
        $limit     = null;

        if (isset($options['precision'])):
            $precision = $options['precision'];
        endif;
        
        if (isset($options['scale'])):
            $scale = $options['scale'];
        endif;
        
        if (isset($options['limit'])):
            $limit = $options['limit'];
        endif;
        
        if (isset($options['values'])):
            $values = $options['values'];
        endif;

        $native_type = $natives[$type];
        
        if ( is_array($native_type) && array_key_exists('name', $native_type)):
            $column_type_sql = $native_type['name'];
        else:
            return $native_type;
        endif;
        
        if ($type == "decimal"):
            //ignore limit, use precison and scale
            if ( $precision == null && array_key_exists('precision', $native_type)):
                $precision = $native_type['precision'];
            endif;
            
            if ( $scale == null && array_key_exists('scale', $native_type)):
                $scale = $native_type['scale'];
            endif;
            
            if ($precision != null):
                if (is_int($scale)):
                    $column_type_sql .= sprintf("(%d, %d)", $precision, $scale);
                else:
                    $column_type_sql .= sprintf("(%d)", $precision);
                endif;
            else:
                if ($scale):
                    throw new EgressException("Error adding decimal column: precision cannot be empty if scale is specified", EgressException::INVALID_ARGUMENT);
                endif;
            endif;
        elseif ($type == "float"):
            //ignore limit, use precison and scale
            if ($precision == null && array_key_exists('precision', $native_type)):
                $precision = $native_type['precision'];
            endif;
            
            if ($scale == null && array_key_exists('scale', $native_type)):
                $scale = $native_type['scale'];
            endif;
            
            if ($precision != null):
                if (is_int($scale)):
                    $column_type_sql .= sprintf("(%d, %d)", $precision, $scale);
                else:
                    $column_type_sql .= sprintf("(%d)", $precision);
                endif;
            else:
                if ($scale):
                    throw new EgressException("Error adding float column: precision cannot be empty if scale is specified", EgressException::INVALID_ARGUMENT);
                endif;
            endif;
        elseif ($type == "enum"):
            if (empty($values)):
                throw new EgressException("Error adding enum column: there must be at least one value defined", EgressException::INVALID_ARGUMENT);
            else:
                $column_type_sql .= sprintf("('%s')", implode("','", array_map(array($this, 'quote_string'), $values)));
            endif;
        else:
            //not a decimal column
            if ($limit == null && array_key_exists('limit', $native_type)):
                $limit = $native_type['limit'];
            endif;

            if ($limit):
                $column_type_sql .= sprintf("(%d)", $limit);
            endif;
        endif;

        return $column_type_sql;
    }

    public function add_column_options($type, $options) {
        $sql = "";

        if (!is_array($options)) return $sql;

        if (array_key_exists('unsigned', $options) && $options['unsigned'] === true):
            $sql .= ' UNSIGNED';
        endif;

        if (array_key_exists('character', $options)):
        	$sql .= sprintf(" CHARACTER SET %s", $this->identifier($options['character']));
        endif;
        
        if (array_key_exists('collate', $options)):
            $sql .= sprintf(" COLLATE %s", $this->identifier($options['collate']));
        endif;

        if (array_key_exists('auto_increment', $options) && $options['auto_increment'] === true):
            $sql .= ' auto_increment';
        endif;

        if (array_key_exists('default', $options) && $options['default'] !== null):
            if ($this->is_sql_method_call($options['default'])):
                throw new EgressException("MySQL does not support function calls as default values, constants only.", EgressException::INVALID_ARGUMENT);
            endif;

            if (is_int($options['default'])):
                $default_format = '%d';
            elseif (is_bool($options['default'])):
                $default_format = "'%d'";
            elseif ($options['default'] == 'CURRENT_TIMESTAMP'):
                $default_format = "%s";
            else:
                $default_format = "'%s'";
            endif;

            $default_value = sprintf($default_format, $options['default']);
            $sql          .= sprintf(" DEFAULT %s", $default_value);
        endif;

        if (array_key_exists('null', $options) && ($options['null'] === false || $options['null'] === 'NO')):
            $sql .= " NOT NULL";
        endif;
        
        if (array_key_exists('comment', $options)):
            $sql .= sprintf(" COMMENT '%s'", $this->quote_string($options['comment']));
        endif;
        
        if (array_key_exists('extra', $options)):
            $sql .= sprintf(" %s", $this->quote_string($options['extra']));
        endif;
        
        if (array_key_exists('after', $options)):
            $sql .= sprintf(" AFTER %s", $this->identifier($options['after']));
        endif;

        return $sql;
    }

    public function set_current_version($version) {
        $sql = sprintf("INSERT INTO %s (version) VALUES ('%s')", EGRESS_TS_SCHEMA_TBL_NAME, $version);

        return $this->execute_ddl($sql);
    }

    public function remove_version($version) {
        $sql = sprintf("DELETE FROM %s WHERE version = '%s'", EGRESS_TS_SCHEMA_TBL_NAME, $version);

        return $this->execute_ddl($sql);
    }

    public function __toString() {
        return "Egress MySQLBase, version " . $this->_version;
    }

    private function connect($dsn) {
        $this->db_connect($dsn);
    }

    private function db_connect($dsn) {
        $db_info = $this->get_dsn();
        
        if ($db_info):
            $this->db_info = $db_info;
            //we might have a port
            if (empty($db_info['port'])):
                $db_info['port'] = 3306;
            endif;
            
            if (empty($db_info['socket'])):
                $db_info['socket'] = @ini_get('mysqli.default_socket');
            endif;
            
            if (empty($db_info['charset'])):
                $db_info['charset'] = "utf8";
            endif;
            
            $this->conn = new mysqli($db_info['host'], $db_info['user'], $db_info['password'], '', $db_info['port'], $db_info['socket']); //db name leaved for selection
            
            if ($this->conn->connect_error):
                throw new EgressException("\n\nCould not connect to the DB, check host / user / password\n\n", EgressException::INVALID_CONFIG);
            endif;
            
            if (!$this->conn->select_db($db_info['database'])):
                throw new EgressException("\n\nCould not select the DB " . $db_info['database'] . ", check permissions on host " . $db_info['host'] . " \n\n", EgressException::INVALID_CONFIG);
            endif;
            
            if (!$this->conn->set_charset($db_info['charset'])):
                throw new EgressException("\n\nCould not set charset " . $db_info['charset'] . " \n\n", EgressException::INVALID_CONFIG);
            endif;

            $this->conn->query("SET CHARACTER SET '{$db_info['charset']}'");
            $this->conn->query("SET character_set_results = '{$db_info['charset']}'");
            $this->conn->query("SET character_set_server = '{$db_info['charset']}'");
            $this->conn->query("SET character_set_client = '{$db_info['charset']}'");

            return true;
        else:
            throw new EgressException("\n\nCould not extract DB connection information from: " . implode(' ', $dsn) . "\n\n", EgressException::INVALID_CONFIG);
        endif;
    }

    private function isError($o) {
        return $o === FALSE;
    }

    private function load_tables($reload = true) {
        if ($this->_tables_loaded == false || $reload):
            $this->_tables = array(); //clear existing structure
            
            $query = "SHOW TABLES";
            $res   = $this->conn->query($query);

            // check for errors
            if ($this->isError($res)):
                throw new EgressException(
                    sprintf("Error executing 'query' with:\n%s\n\nReason: %s\n\n", $query, $this->conn->error), EgressException::QUERY_ERROR);
            endif;

            while ($row = $res->fetch_row()):
                $table = $row[0];
                $this->_tables[$table] = true;
            endwhile;
        endif;
    }

    private function determine_query_type($query) {
        $query = strtolower(trim($query));
        $match = array();
        
        preg_match('/^(\w)*/i', $query, $match);
        
        $type = $match[0];

        switch ($type):
            case 'select':
                return SQL_SELECT;
            case 'update':
                return SQL_UPDATE;
            case 'delete':
                return SQL_DELETE;
            case 'insert':
                return SQL_INSERT;
            case 'alter':
                return SQL_ALTER;
            case 'drop':
                return SQL_DROP;
            case 'create':
                return SQL_CREATE;
            case 'show':
                return SQL_SHOW;
            case 'rename':
                return SQL_RENAME;
            case 'set':
                return SQL_SET;
            default:
                return SQL_UNKNOWN_QUERY_TYPE;
        endswitch;
    }

    private function is_select($query_type) {
        if ($query_type == SQL_SELECT):
            return true;
        endif;

        return false;
    }

    private function is_sql_method_call($str) {
        $str = trim($str);

        if (substr($str, -2, 2) == "()"):
            return true;
        else:
            return false;
        endif;
    }

    private function inTransaction() {
        return $this->_in_trx;
    }

    private function beginTransaction() {
        if ($this->_in_trx === true):
            throw new EgressException('Transaction already started', EgressException::QUERY_ERROR);
        endif;

        $this->conn->autocommit(FALSE);
        $this->_in_trx = true;
    }

    private function commit() {
        if ($this->_in_trx === false):
            throw new EgressException('Transaction not started', EgressException::QUERY_ERROR);
        endif;

        $this->conn->commit();
        $this->_in_trx = false;
    }

    private function rollback() {
        if ($this->_in_trx === false):
            throw new EgressException('Transaction not started', EgressException::QUERY_ERROR);
        endif;

        $this->conn->rollback();
        $this->_in_trx = false;
    }
}
