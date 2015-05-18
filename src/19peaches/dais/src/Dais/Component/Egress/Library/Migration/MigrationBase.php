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

namespace Egress\Library\Migration;
use Egress\Library\EgressException;
use Egress\Library\Adapter\AdapterBase;

class MigrationBase {
    
    private $_adapter;

    public function __construct($adapter) {
        $this->set_adapter($adapter);
    }

    public function __call($name, $args) {
        throw new EgressException('Method unknown (' . $name . ')', EgressException::INVALID_MIGRATION_METHOD);
    }

    public function set_adapter($adapter) {
        if (!($adapter instanceof AdapterBase)):
            throw new EgressException('Adapter must implement AdapterBase!', EgressException::INVALID_ADAPTER);
        endif;

        $this->_adapter = $adapter;

        return $this;
    }

    public function get_adapter() {
        return $this->_adapter;
    }

    public function create_database($name, $options = null) {
        return $this->_adapter->create_database($name, $options);
    }

    public function drop_database($name) {
        return $this->_adapter->drop_database($name);
    }

    public function drop_table($tbl) {
        return $this->_adapter->drop_table($tbl);
    }

    public function rename_table($name, $new_name) {
        return $this->_adapter->rename_table($name, $new_name);
    }

    public function rename_column($tbl_name, $column_name, $new_column_name) {
        return $this->_adapter->rename_column($tbl_name, $column_name, $new_column_name);
    }

    public function add_column($table_name, $column_name, $type, $options = array()) {
        return $this->_adapter->add_column($table_name, $column_name, $type, $options);
    }

    public function remove_column($table_name, $column_name) {
        return $this->_adapter->remove_column($table_name, $column_name);
    }

    public function change_column($table_name, $column_name, $type, $options = array()) {
        return $this->_adapter->change_column($table_name, $column_name, $type, $options);
    }

    public function add_index($table_name, $column_name, $options = array()) {
        return $this->_adapter->add_index($table_name, $column_name, $options);
    }

    public function remove_index($table_name, $column_name, $options = array()) {
        return $this->_adapter->remove_index($table_name, $column_name, $options);
    }

    public function add_timestamps($table_name, $created_column_name = "created_at", $updated_column_name = "updated_at") {
        return $this->_adapter->add_timestamps($table_name, $created_column_name, $updated_column_name);
    }

    public function remove_timestamps($table_name, $created_column_name = "created_at", $updated_column_name = "updated_at") {
        return $this->_adapter->remove_timestamps($table_name, $created_column_name, $updated_column_name);
    }

    public function create_table($table_name, $options = array()) {
        return $this->_adapter->create_table($table_name, $options);
    }

    public function execute($query) {
        return $this->_adapter->multi_query($query);
    }

    public function select_one($sql) {
        return $this->_adapter->select_one($sql);
    }

    public function select_all($sql) {
        return $this->_adapter->select_all($sql);
    }

    public function query($sql) {
        return $this->_adapter->query($sql);
    }

    public function quote_string($str) {
        return $this->_adapter->quote_string($str);
    }
}
