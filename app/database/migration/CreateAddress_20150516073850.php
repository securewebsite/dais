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
|   Your table prefix has been included so that you can easily write your 
|   migrations to include the proper prefix.
|   
|   $users = $this->create_table("{$this->prefix}users");
|
|   Obviously if you have no table prefix, this variable will be empty.
|   
*/

namespace Database\Migration;
use Egress\Library\Migration\MigrationBase;

class CreateAddress_20150516073850 extends MigrationBase {

    private $prefix = 'dais_';

    public function up() {

        $table = $this->create_table("{$this->prefix}address", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('address_id', 'integer', array('primary_key' => true, 'unsigned' => true, 'auto_increment' => true));
        $table->column('customer_id', 'integer', array('unsigned' => true));
        $table->column('firstname', 'string', array('limit' => 32));
        $table->column('lastname', 'string', array('limit' => 32));
        $table->column('company', 'string', array('limit' => 32));
        $table->column('company_id', 'string', array('limit' => 32));
        $table->column('tax_id', 'string', array('limit' => 32));
        $table->column('address_1', 'string', array('limit' => 128));
        $table->column('address_2', 'string', array('limit' => 128));
        $table->column('city', 'string', array('limit' => 128));
        $table->column('postcode', 'string', array('limit' => 10));
        $table->column('country_id', 'integer', array('unsigned' => true));
        $table->column('zone_id', 'integer', array('unsigned' => true));

        $table->finish();

        $this->add_index("{$this->prefix}address", "customer_id", array('name' => 'customer_id'));
    }

    public function down() {
    	$this->drop_table("{$this->prefix}address");
    }
}
