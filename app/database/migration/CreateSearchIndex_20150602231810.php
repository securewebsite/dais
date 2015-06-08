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

class CreateSearchIndex_20150602231810 extends MigrationBase {

    private $prefix = 'dais_';

    public function up() {
        $table = $this->create_table("{$this->prefix}search_index", array(
            'id'      => false,
            'options' => 'Engine=' . SERVER_VERSION
        ));

        $table->column('id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('language_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('type', 'string', array('limit' => 24));
        $table->column('object_id', 'integer', array('unsigned' => true));
        $table->column('text', 'text');
        
        $table->finish();

        $this->add_index("{$this->prefix}search_index", "text", array('name' => 'text_idx', 'fulltext' => true));
    }

    public function down() {
        $this->drop_table("{$this->prefix}search_index");
    }
}
