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

class CreateBanner_20150524062744 extends MigrationBase {

    private $prefix = 'dais_';

    public function up() {
        $table = $this->create_table("{$this->prefix}banner", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('banner_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('name', 'string', array('limit' => 64));
        $table->column('status', 'tinyinteger', array('unsigned' => true, 'limit' => 1));
        
        $table->finish();

        $sql = "INSERT INTO `dais_banner` (`banner_id`, `name`, `status`) VALUES
                (6, 'HP Products', 1),
                (7, 'Samsung Tab', 1),
                (8, 'Manufacturers', 1),
                (9, 'Homepage', 1)";

        $this->execute($sql);
    }

    public function down() {
        $this->drop_table("{$this->prefix}banner");
    }
}
