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

class CreateCustomerInbox_20150524191436 extends MigrationBase {

    private $prefix = 'dais_';

    public function up() {
        $table = $this->create_table("{$this->prefix}customer_inbox", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));
        
        $table->column('notification_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'limit' => 13));
        $table->column('customer_id', 'integer', array('unsigned' => true));
        $table->column('subject', 'string', array('limit' => 64));
        $table->column('message', 'text');
        $table->column('is_read', 'tinyinteger', array('unsigned' => true, 'limit' => 1, 'default' => 0));
        
        $table->finish();

        $this->add_index("{$this->prefix}customer_inbox", "customer_id", array('name' => 'customer_id'));
    }

    public function down() {
        $this->drop_table("{$this->prefix}customer_inbox");
    }
}
