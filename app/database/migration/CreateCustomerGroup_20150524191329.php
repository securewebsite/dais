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

class CreateCustomerGroup_20150524191329 extends MigrationBase {

    private $prefix = 'dais_';

    public function up() {
        $table = $this->create_table("{$this->prefix}customer_group", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('customer_group_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('approval', 'tinyinteger', array('unsigned' => true, 'limit' => 1));
        $table->column('company_id_display', 'tinyinteger', array('unsigned' => true, 'limit' => 1));
        $table->column('company_id_required', 'tinyinteger', array('unsigned' => true, 'limit' => 1));
        $table->column('tax_id_display', 'tinyinteger', array('unsigned' => true, 'limit' => 1));
        $table->column('tax_id_required', 'tinyinteger', array('unsigned' => true, 'limit' => 1));
        $table->column('sort_order', 'integer', array('unsigned' => true, 'limit' => 3));
        
        $table->finish();

        $sql = "INSERT INTO `{$this->prefix}customer_group` (`customer_group_id`, `approval`, `company_id_display`, `company_id_required`, `tax_id_display`, `tax_id_required`, `sort_order`) VALUES
                (1, 0, 0, 0, 0, 0, 1),
                (2, 0, 0, 0, 0, 0, 2),
                (3, 0, 0, 0, 0, 0, 3),
                (4, 0, 0, 0, 0, 0, 4)";

        $this->execute($sql);
    }

    public function down() {
        $this->drop_table("{$this->prefix}customer_group");
    }
}
