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

class CreateAddress extends MigrationBase {

    private $prefix = 'dais_';

    public function up() {

        $table = $this->create_table("{$this->prefix}address", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->integer('address_id', true);
        $table->integer('customer_id', 11);
        $table->string('firstname', 32);
        $table->string('lastname', 32);
        $table->string('company', 32);
        $table->string('company_id', 32);
        $table->string('tax_id', 32);
        $table->string('address_1', 128);
        $table->string('address_2', 128);
        $table->string('city', 128);
        $table->string('postcode', 10);
        $table->integer('country_id');
        $table->integer('zone_id');
        $table->finish();

        $this->add_index("{$this->prefix}address", "customer_id", array('name' => 'customer_id'));
    }

    public function down() {
    	$this->drop_table("{$this->prefix}address");
    }
}
