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

        $table->column('attribute_id', 'integer', array('primary_key' => true, 'unsigned' => true, 'auto_increment' => true));
        $table->column('attribute_group_id', 'integer', array('unsigned' => true));
        $table->column('sort_order', 'tinyinteger', array('limit' =>  3, 'unsigned' => true));
        
		$table->finish();

        $sql = "INSERT INTO `{$this->prefix}attribute` (`attribute_id`, `attribute_group_id`, `sort_order`) VALUES
                (1, 6, 1),
                (2, 6, 5),
                (3, 6, 3),
                (4, 3, 1),
                (5, 3, 2),
                (6, 3, 3),
                (7, 3, 4),
                (8, 3, 5),
                (9, 3, 6),
                (10, 3, 7),
                (11, 3, 8)";

        $this->execute($sql);
    }

    public function down() {
    	$this->drop_table("{$this->prefix}attribute");
    }
}
