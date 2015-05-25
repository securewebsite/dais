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

class CreateBlogPostToCategory_20150524063148 extends MigrationBase {

    private $prefix = 'dais_';

    public function up() {
        $table = $this->create_table("{$this->prefix}blog_post_to_category", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('post_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('category_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        
        $table->finish();

        $sql = "INSERT INTO `{$this->prefix}blog_post_to_category` (`post_id`, `category_id`) VALUES
                (1, 1),
                (1, 2)";

        $this->execute($sql);
    }

    public function down() {
        $this->drop_table("{$this->prefix}blog_post_to_category");
    }
}
