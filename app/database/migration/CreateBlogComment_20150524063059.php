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

class CreateBlogComment_20150524063059 extends MigrationBase {

    private $prefix = 'dais_';

    public function up() {
        $table = $this->create_table("{$this->prefix}blog_comment", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('comment_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('post_id', 'integer', array('unsigned' => true));
        $table->column('customer_id', 'integer', array('unsigned' => true));
        $table->column('author', 'string', array('limit' => 64));
        $table->column('email', 'string', array('limit' => 96));
        $table->column('website', 'string', array('limit' => 96));
        $table->column('text', 'text');
        $table->column('rating', 'tinyinteger', array('unsigned' => true, 'limit' => 1));
        $table->column('status', 'tinyinteger', array('unsigned' => true, 'limit' => 1));
        $table->column('date_added', 'datetime', array('default' => '0000-00-00 00:00:00'));
        $table->column('date_modified', 'datetime', array('default' => '0000-00-00 00:00:00'));
        
        $table->finish();

        $this->add_index("{$this->prefix}blog_comment", "post_id", array('name' => 'post_id'));
    }

    public function down() {
        $this->drop_table("{$this->prefix}blog_comment");
    }
}
