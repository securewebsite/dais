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

class CreateCurrency_20150524063415 extends MigrationBase {

    private $prefix = 'dais_';

    public function up() {
        $table = $this->create_table("{$this->prefix}currency", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('currency_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('title', 'string', array('limit' => 32));
        $table->column('code', 'string', array('limit' => 3));
        $table->column('symbol_left', 'string', array('limit' => 12));
        $table->column('symbol_right', 'string', array('limit' => 12));
        $table->column('decimal_place', 'char', array('limit' => 1));
        $table->column('value', 'float', array('unsigned' => true, 'precision' => 15, 'scale' => 8));
        $table->column('status', 'tinyinteger', array('unsigned' => true, 'limit' => 1));
        $table->column('date_modified', 'datetime', array('default' => '0000-00-00 00:00:00'));
        
        $table->finish();

        $sql = "INSERT INTO `{$this->prefix}currency` (`currency_id`, `title`, `code`, `symbol_left`, `symbol_right`, `decimal_place`, `value`, `status`, `date_modified`) VALUES
                (1, 'Pound Sterling', 'GBP', '£', '', '2', 0.67979997, 1, '2015-04-09 20:10:25'),
                (2, 'US Dollar', 'USD', '$', '', '2', 1.00000000, 1, '2015-04-09 20:33:29'),
                (3, 'Euro', 'EUR', '', '€', '2', 0.93730003, 1, '2015-04-09 20:10:25')";

        $this->execute($sql);
    }

    public function down() {
        $this->drop_table("{$this->prefix}currency");
    }
}
