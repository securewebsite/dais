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

class CreateAttributeDescription_20150524062427 extends MigrationBase {

    private $prefix = 'dais_';

    public function up() {
        $table = $this->create_table("{$this->prefix}attribute_description", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('attribute_id', 'integer', array('primary_key' => true, 'unsigned' => true));
        $table->column('language_id', 'integer', array('primary_key' => true, 'unsigned' => true));
        $table->column('name', 'string', array('limit' => 64));
        
        $table->finish();

        $sql = "INSERT INTO `{$this->prefix}attribute_description` (`attribute_id`, `language_id`, `name`) VALUES
                (1, 1, 'Description'),
                (2, 1, 'No. of Cores'),
                (3, 1, 'Clockspeed'),
                (4, 1, 'test 1'),
                (5, 1, 'test 2'),
                (6, 1, 'test 3'),
                (7, 1, 'test 4'),
                (8, 1, 'test 5'),
                (9, 1, 'test 6'),
                (10, 1, 'test 7'),
                (11, 1, 'test 8')";

        $this->execute($sql);
    }

    public function down() {
        $this->drop_table("{$this->prefix}attribute_description");
    }
}
