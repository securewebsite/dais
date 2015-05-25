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

class CreateCustomer_20150524191235 extends MigrationBase {

    private $prefix = 'dais_';

    public function up() {
        $table = $this->create_table("{$this->prefix}customer", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('customer_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('store_id', 'integer', array('unsigned' => true));
        $table->column('username', 'string', array('primary_key' => true, 'limit' => 16));
        $table->column('firstname', 'string', array('limit' => 32));
        $table->column('lastname', 'string', array('limit' => 32));
        $table->column('email', 'string', array('limit' => 96));
        $table->column('telephone', 'string', array('limit' => 32));
        $table->column('password', 'string', array('limit' => 40));
        $table->column('salt', 'string', array('limit' => 9));
        $table->column('reset', 'string', array('limit' => 40));
        $table->column('cart', 'text', array('null' => true));
        $table->column('wishlist', 'text', array('null' => true));
        $table->column('newsletter', 'tinyinteger', array('unsigned' => true, 'limit' => 1));
        $table->column('address_id', 'integer', array('unsigned' => true));
        $table->column('customer_group_id', 'integer', array('unsigned' => true));
        $table->column('referral_id', 'integer', array('unsigned' => true, 'default' => 0));
        $table->column('is_affiliate', 'tinyinteger', array('unsigned' => true, 'limit' => 1, 'default' => 0));
        $table->column('affiliate_status', 'tinyinteger', array('unsigned' => true, 'limit' => 1));
        $table->column('company', 'string', array('limit' => 32));
        $table->column('website', 'string');
        $table->column('code', 'string', array('limit' => 64));
        $table->column('commission', 'decimal', array('unsigned' => true, 'precision' => 4, 'scale' => 2, 'default' => '0.00'));
        $table->column('tax_id', 'string', array('limit' => 64));
        $table->column('payment_method', 'string', array('limit' => 6));
        $table->column('cheque', 'string', array('limit' => 100));
        $table->column('paypal', 'string', array('limit' => 64));
        $table->column('bank_name', 'string', array('limit' => 64));
        $table->column('bank_branch_number', 'string', array('limit' => 64));
        $table->column('bank_swift_code', 'string', array('limit' => 64));
        $table->column('bank_account_name', 'string', array('limit' => 64));
        $table->column('bank_account_number', 'string', array('limit' => 64));
        $table->column('ip', 'string', array('limit' => 40, 'default' => '0'));
        $table->column('status', 'tinyinteger', array('unsigned' => true, 'limit' => 1));
        $table->column('approved', 'tinyinteger', array('unsigned' => true, 'limit' => 1));
        $table->column('token', 'string');
        $table->column('date_added', 'datetime', array('default' => '0000-00-00 00:00:00'));
        
        $table->finish();
    }

    public function down() {
        $this->drop_table("{$this->prefix}customer");
    }
}
