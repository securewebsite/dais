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

class CreateCouponHistory_20150524063345 extends MigrationBase {

    private $prefix = 'dais_';

    public function up() {
        $table = $this->create_table("{$this->prefix}coupon_history", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('coupon_history_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('coupon_id', 'integer', array('unsigned' => true));
        $table->column('order_id', 'integer', array('unsigned' => true));
        $table->column('customer_id', 'integer', array('unsigned' => true));
        $table->column('amount', 'decimal', array('unsigned' => true, 'precision' => 15, 'scale' => 4));
        $table->column('date_added', 'datetime', array('default' => '0000-00-00 00:00:00'));
        
        $table->finish();
    }

    public function down() {
        $this->drop_table("{$this->prefix}coupon_history");
    }
}
