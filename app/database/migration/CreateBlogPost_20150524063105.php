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

class CreateBlogPost_20150524063105 extends MigrationBase {

    private $prefix = 'dais_';

    public function up() {
        $table = $this->create_table("{$this->prefix}blog_post", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('post_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('image', 'string', array('null' => true));
        $table->column('author_id', 'integer', array('unsigned' => true));
        $table->column('date_available', 'date');
        $table->column('sort_order', 'integer', array('unsigned' => true));
        $table->column('status', 'tinyinteger', array('unsigned' => true, 'limit' => 1));
        $table->column('visibility', 'tinyinteger', array('unsigned' => true, 'limit' => 3, 'default' => '1'));
        $table->column('date_added', 'datetime', array('default' => '0000-00-00 00:00:00'));
        $table->column('date_modified', 'datetime', array('default' => '0000-00-00 00:00:00'));
        $table->column('viewed', 'integer', array('unsigned' => true));

        $table->finish();

        $sql = "INSERT INTO `{$this->prefix}blog_post` (`post_id`, `image`, `author_id`, `date_available`, `sort_order`, `status`, `visibility`, `date_added`, `date_modified`, `viewed`) VALUES
                (1, 'data/blog/post/landscape-b.jpg', 1, '2014-08-19', 1, 1, 1, '2014-08-20 06:34:50', '2014-12-28 04:51:04', 228)";

        $this->execute($sql);
    }

    public function down() {
        $this->drop_table("{$this->prefix}blog_post");
    }
}
