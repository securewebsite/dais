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

class CreateBlogCategoryDescription_20150524063021 extends MigrationBase {

    private $prefix = 'dais_';

    public function up() {
        $table = $this->create_table("{$this->prefix}blog_category_description", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('category_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('language_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('name', 'string');
        $table->column('description', 'text');
        $table->column('meta_description', 'string');
        $table->column('meta_keyword', 'string');
        
        $table->finish();

        $this->add_index("{$this->prefix}blog_category_description", "name", array('name' => 'name'));

        $sql = "INSERT INTO `{$this->prefix}blog_category_description` (`category_id`, `language_id`, `name`, `description`, `meta_description`, `meta_keyword`) VALUES
                (1, 1, 'General', '&lt;p&gt;This is the general category for all things general.&lt;/p&gt;', '', ''),
                (2, 1, 'Latest Product News', '&lt;p&gt;\r\n    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n&lt;/p&gt;', '', '')";

        $this->execute($sql);
    }

    public function down() {
        $this->drop_table("{$this->prefix}blog_category_description");
    }
}
