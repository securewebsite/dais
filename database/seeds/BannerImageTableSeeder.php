<?php

use Illuminate\Database\Seeder;

class BannerImageTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('banner_image')->delete();
        
		\DB::table('banner_image')->insert(array (
			0 => 
			array (
				'banner_image_id' => 84,
				'banner_id' => 6,
				'link' => 'hewlett-packard',
				'image' => 'data/demo/hp_banner.jpg',
			),
			1 => 
			array (
				'banner_image_id' => 85,
				'banner_id' => 8,
				'link' => 'sony',
				'image' => 'data/demo/sony_logo.jpg',
			),
			2 => 
			array (
				'banner_image_id' => 86,
				'banner_id' => 8,
				'link' => 'palm',
				'image' => 'data/demo/palm_logo.jpg',
			),
			3 => 
			array (
				'banner_image_id' => 87,
				'banner_id' => 8,
				'link' => 'apple',
				'image' => 'data/demo/apple_logo.jpg',
			),
			4 => 
			array (
				'banner_image_id' => 88,
				'banner_id' => 8,
				'link' => 'canon',
				'image' => 'data/demo/canon_logo.jpg',
			),
			5 => 
			array (
				'banner_image_id' => 89,
				'banner_id' => 8,
				'link' => 'htc',
				'image' => 'data/demo/htc_logo.jpg',
			),
			6 => 
			array (
				'banner_image_id' => 90,
				'banner_id' => 8,
				'link' => 'hewlett-packard',
				'image' => 'data/demo/hp_logo.jpg',
			),
			7 => 
			array (
				'banner_image_id' => 91,
				'banner_id' => 7,
				'link' => 'tablets',
				'image' => 'data/demo/samsung_banner.jpg',
			),
			8 => 
			array (
				'banner_image_id' => 92,
				'banner_id' => 9,
				'link' => 'apple',
				'image' => 'data/banner/1.jpg',
			),
			9 => 
			array (
				'banner_image_id' => 93,
				'banner_id' => 9,
				'link' => 'samsung',
				'image' => 'data/banner/2.jpg',
			),
			10 => 
			array (
				'banner_image_id' => 94,
				'banner_id' => 9,
				'link' => 'hewlett-packard',
				'image' => 'data/banner/3.jpg',
			),
		));
	}

}
