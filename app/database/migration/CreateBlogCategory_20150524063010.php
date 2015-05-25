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

class CreateBlogCategory_20150524063010 extends MigrationBase {

    private $prefix = 'dais_';

    public function up() {
        $table = $this->create_table("{$this->prefix}blog_category", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('category_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('image', 'string');
        $table->column('parent_id', 'integer', array('unsigned' => true));
        $table->column('top', 'tinyinteger', array('unsigned' => true, 'limit' => 1));
        $table->column('columns', 'integer', array('unsigned' => true, 'limit' => 3));
        $table->column('sort_order', 'integer', array('unsigned' => true, 'limit' => 3));
        $table->column('status', 'tinyinteger', array('unsigned' => true, 'limit' => 1));
        $table->column('date_added', 'datetime', array('default' => '0000-00-00 00:00:00'));
        $table->column('date_modified', 'datetime', array('default' => '0000-00-00 00:00:00'));

        $table->finish();

        $sql = "INSERT INTO `{$this->prefix}blog_category` (`category_id`, `image`, `parent_id`, `top`, `columns`, `sort_order`, `status`, `date_added`, `date_modified`) VALUES
                (1, '', 0, 0, 0, 0, 1, '2014-08-20 04:58:59', '2014-08-24 15:59:01'),
                (2, 'data/blog/category/landscape-a.jpg', 1, 0, 0, 0, 1, '2014-08-22 17:04:52', '2014-12-28 04:50:34')";

        $this->execute($sql);
    }

    public function down() {
        $this->drop_table("{$this->prefix}blog_category");
    }
}
