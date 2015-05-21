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

class CreateAttribute_20150517070902 extends MigrationBase {

    private $prefix = 'dais_';

    public function up() {

    	$table = $this->create_table("{$this->prefix}attribute", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->integer('attribute_id', true);
		$table->integer('attribute_group_id');
		$table->integer('sort_order');
		$table->finish();
    }

    public function down() {
    	$this->drop_table("{$this->prefix}attribute");
    }
}
