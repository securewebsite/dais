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

class CreateCustomerGroupDescription_20150524191342 extends MigrationBase {

    private $prefix = 'dais_';

    public function up() {
        $table = $this->create_table("{$this->prefix}customer_group_description", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('customer_group_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('language_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('name', 'string', array('limit' => 32));
        $table->column('description', 'text');
        
        $table->finish();

        $sql = "INSERT INTO `{$this->prefix}customer_group_description` (`customer_group_id`, `language_id`, `name`, `description`) VALUES
                (1, 1, 'Guest', 'This is the default group for any site visitor that isn''t logged in.'),
                (2, 1, 'Customer', 'This is the default free customer group for any customer that simply has an account.'),
                (3, 1, 'Silver', 'This is an example 1st tier paid membership group. Always ensure that the customer_group_id''s of your memberships are in ascending order otherwise the visibility and content settings will not work correctly.  This can be safely deleted if not needed.'),
                (4, 1, 'Gold', 'This is an example 2nd tier paid membership group. Always ensure that the customer_group_id''s of your memberships are in ascending order otherwise the visibility and content settings will not work correctly.  This can be safely deleted if not needed.')";

        $this->execute($sql);
    }

    public function down() {
        $this->drop_table("{$this->prefix}customer_group_description");
    }
}
