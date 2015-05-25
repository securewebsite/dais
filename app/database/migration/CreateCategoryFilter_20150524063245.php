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

class CreateCategoryFilter_20150524063245 extends MigrationBase {

    private $prefix = 'dais_';

    public function up() {
        $table = $this->create_table("{$this->prefix}category_filter", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('category_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('filter_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        
        $table->finish();
    }

    public function down() {
        $this->drop_table("{$this->prefix}category_filter");
    }
}
