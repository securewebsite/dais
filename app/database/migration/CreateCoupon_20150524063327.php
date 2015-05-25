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

class CreateCoupon_20150524063327 extends MigrationBase {

    private $prefix = 'dais_';

    public function up() {
        $table = $this->create_table("{$this->prefix}coupon", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('coupon_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('name', 'string', array('limit' => 128));
        $table->column('code', 'string', array('limit' => 10));
        $table->column('type', 'char', array('limit' => 1));
        $table->column('discount', 'decimal', array('unsigned' => true, 'scale' => 4, 'precision' => 15));
        $table->column('logged', 'tinyinteger', array('unsigned' => true, 'limit' => 1));
        $table->column('shipping', 'tinyinteger', array('unsigned' => true, 'limit' => 1));
        $table->column('total', 'decimal', array('unsigned' => true, 'scale' => 4, 'precision' => 15));
        $table->column('date_start', 'date', array('default' => '0000-00-00'));
        $table->column('date_end', 'date', array('default' => '0000-00-00'));
        $table->column('uses_total', 'integer', array('unsigned' => true));
        $table->column('uses_customer', 'string', array('limit' => 11));
        $table->column('status', 'tinyinteger', array('unsigned' => true, 'limit' => 1));
        $table->column('date_added', 'datetime', array('default' => '0000-00-00 00:00:00'));
        
        $table->finish();

        $sql = "INSERT INTO `{$this->prefix}coupon` (`coupon_id`, `name`, `code`, `type`, `discount`, `logged`, `shipping`, `total`, `date_start`, `date_end`, `uses_total`, `uses_customer`, `status`, `date_added`) VALUES
                (4, '-10% Discount', '2222', 'P', '10.0000', 0, 0, '0.0000', '2011-01-01', '2012-01-01', 10, '10', 1, '2009-01-27 13:55:03'),
                (5, 'Free Shipping', '3333', 'P', '0.0000', 0, 1, '100.0000', '2009-03-01', '2009-08-31', 10, '10', 1, '2009-03-14 21:13:53'),
                (6, '-10.00 Discount', '1111', 'F', '10.0000', 0, 0, '10.0000', '1970-11-01', '2020-11-01', 100000, '10000', 1, '2009-03-14 21:15:18')";

        $this->execute($sql);
    }

    public function down() {
        $this->drop_table("{$this->prefix}coupon");
    }
}
