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

class CreateCategoryToStore_20150524063311 extends MigrationBase {

    private $prefix = 'dais_';

    public function up() {
        $table = $this->create_table("{$this->prefix}category_to_store", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('category_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('store_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        
        $table->finish();

        $sql = "INSERT INTO `{$this->prefix}category_to_store` (`category_id`, `store_id`) VALUES
                (17, 0),
                (18, 0),
                (20, 0),
                (24, 0),
                (25, 0),
                (26, 0),
                (27, 0),
                (28, 0),
                (29, 0),
                (30, 0),
                (31, 0),
                (32, 0),
                (33, 0),
                (34, 0),
                (35, 0),
                (36, 0),
                (37, 0),
                (38, 0),
                (39, 0),
                (40, 0),
                (41, 0),
                (42, 0),
                (43, 0),
                (44, 0),
                (45, 0),
                (46, 0),
                (47, 0),
                (48, 0),
                (49, 0),
                (50, 0),
                (51, 0),
                (52, 0),
                (53, 0),
                (54, 0),
                (55, 0),
                (56, 0),
                (57, 0),
                (58, 0)";

        $this->execute($sql);
    }

    public function down() {
        $this->drop_table("{$this->prefix}category_to_store");
    }
}
