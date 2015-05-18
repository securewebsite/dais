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

namespace Egress\Library\Adapter;

interface AdapterInterface {

    public function get_database_name();

    public function quote($value, $column = null);

    public function supports_migrations();

    public function native_database_types();

    public function schema($output_file);

    public function execute($query);

    public function quote_string($str);

    public function database_exists($db);

    public function create_table($table_name, $options = array());

    public function drop_database($db);

    public function table_exists($tbl);

    public function drop_table($tbl);

    public function rename_table($name, $new_name);

    public function rename_column($table_name, $column_name, $new_column_name);

    public function add_column($table_name, $column_name, $type, $options = array());

    public function remove_column($table_name, $column_name);

    public function change_column($table_name, $column_name, $type, $options = array());

    public function remove_index($table_name, $column_name);

    public function add_index($table_name, $column_name, $options = array());

    public function add_timestamps($table_name, $created_column_name, $updated_column_name);

    public function remove_timestamps($table_name, $created_column_name, $updated_column_name);

    public function query($query);

    public function multi_query($queries);
}
