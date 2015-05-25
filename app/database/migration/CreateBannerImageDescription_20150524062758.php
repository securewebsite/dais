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

class CreateBannerImageDescription_20150524062758 extends MigrationBase {

    private $prefix = 'dais_';

    public function up() {
        $table = $this->create_table("{$this->prefix}banner_image_description", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('banner_image_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('language_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('banner_id', 'integer', array('unsigned' => true));
        $table->column('title', 'string', array('limit' => 64));
        
        $table->finish();

        $sql = "INSERT INTO `{$this->prefix}banner_image_description` (`banner_image_id`, `language_id`, `banner_id`, `title`) VALUES
                (84, 1, 6, 'HP Banner'),
                (85, 1, 8, 'Sony'),
                (86, 1, 8, 'Palm'),
                (87, 1, 8, 'Apple'),
                (88, 1, 8, 'Canon'),
                (89, 1, 8, 'HTC'),
                (90, 1, 8, 'Hewlett-Packard'),
                (91, 1, 7, 'Samsung Tab 10.1'),
                (92, 1, 9, 'Hatch Premium Fly Reels'),
                (93, 1, 9, 'Yeti Containers'),
                (94, 1, 9, 'Louisiana Salt Water Series')";

        $this->execute($sql);
    }

    public function down() {
        $this->drop_table("{$this->prefix}banner_image_description");
    }
}
