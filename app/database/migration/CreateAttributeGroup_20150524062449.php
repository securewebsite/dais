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

class CreateAttributeGroup_20150524062449 extends MigrationBase {

    private $prefix = 'dais_';

    public function up() {
        $table = $this->create_table("{$this->prefix}attribute_group", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('attribute_group_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('sort_order', 'tinyinteger', array('unsigned' => true, 'limit' => 3));
        
        $table->finish();

        $sql = "INSERT INTO `{$this->prefix}attribute_group` (`attribute_group_id`, `sort_order`) VALUES
                (3, 2),
                (4, 1),
                (5, 3),
                (6, 4)";

        $this->execute($sql);
    }

    public function down() {
        $this->drop_table("{$this->prefix}attribute_group");
    }
}
