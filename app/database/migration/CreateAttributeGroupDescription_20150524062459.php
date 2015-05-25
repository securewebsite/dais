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

class CreateAttributeGroupDescription_20150524062459 extends MigrationBase {

    private $prefix = 'dais_';

    public function up() {
        $table = $this->create_table("{$this->prefix}attribute_group_description", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('attribute_group_id', 'integer', array('primary_key' => true, 'unsigned' => true));
        $table->column('language_id', 'integer', array('primary_key' => true, 'unsigned' => true));
        $table->column('name', 'string', array('limit' => 64));
        
        $table->finish();

        $sql = "INSERT INTO `{$this->prefix}attribute_group_description` (`attribute_group_id`, `language_id`, `name`) VALUES
                (3, 1, 'Memory'),
                (4, 1, 'Technical'),
                (5, 1, 'Motherboard'),
                (6, 1, 'Processor')";

        $this->execute($sql);
    }

    public function down() {
        $this->drop_table("{$this->prefix}attribute_group_description");
    }
}
