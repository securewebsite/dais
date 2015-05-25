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

class CreateBannerImage_20150524062749 extends MigrationBase {

    private $prefix = 'dais_';

    public function up() {
        $table = $this->create_table("{$this->prefix}banner_image", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('banner_image_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('banner_id', 'integer', array('unsigned' => true));
        $table->column('link', 'string');
        $table->column('image', 'string');
        
        $table->finish();

        $sql = "INSERT INTO `{$this->prefix}banner_image` (`banner_image_id`, `banner_id`, `link`, `image`) VALUES
                (84, 6, 'hewlett-packard', 'data/demo/hp_banner.jpg'),
                (85, 8, 'sony', 'data/demo/sony_logo.jpg'),
                (86, 8, 'palm', 'data/demo/palm_logo.jpg'),
                (87, 8, 'apple', 'data/demo/apple_logo.jpg'),
                (88, 8, 'canon', 'data/demo/canon_logo.jpg'),
                (89, 8, 'htc', 'data/demo/htc_logo.jpg'),
                (90, 8, 'hewlett-packard', 'data/demo/hp_logo.jpg'),
                (91, 7, 'tablets', 'data/demo/samsung_banner.jpg'),
                (92, 9, 'apple', 'data/banner/1.jpg'),
                (93, 9, 'samsung', 'data/banner/2.jpg'),
                (94, 9, 'hewlett-packard', 'data/banner/3.jpg')";

        $this->execute($sql);
    }

    public function down() {
        $this->drop_table("{$this->prefix}banner_image");
    }
}
