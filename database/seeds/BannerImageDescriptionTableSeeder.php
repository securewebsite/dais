<?php

use Illuminate\Database\Seeder;

class BannerImageDescriptionTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('banner_image_description')->delete();
        
		\DB::table('banner_image_description')->insert(array (
			0 => 
			array (
				'banner_image_id' => 84,
				'language_id' => 1,
				'banner_id' => 6,
				'title' => 'HP Banner',
			),
			1 => 
			array (
				'banner_image_id' => 85,
				'language_id' => 1,
				'banner_id' => 8,
				'title' => 'Sony',
			),
			2 => 
			array (
				'banner_image_id' => 86,
				'language_id' => 1,
				'banner_id' => 8,
				'title' => 'Palm',
			),
			3 => 
			array (
				'banner_image_id' => 87,
				'language_id' => 1,
				'banner_id' => 8,
				'title' => 'Apple',
			),
			4 => 
			array (
				'banner_image_id' => 88,
				'language_id' => 1,
				'banner_id' => 8,
				'title' => 'Canon',
			),
			5 => 
			array (
				'banner_image_id' => 89,
				'language_id' => 1,
				'banner_id' => 8,
				'title' => 'HTC',
			),
			6 => 
			array (
				'banner_image_id' => 90,
				'language_id' => 1,
				'banner_id' => 8,
				'title' => 'Hewlett-Packard',
			),
			7 => 
			array (
				'banner_image_id' => 91,
				'language_id' => 1,
				'banner_id' => 7,
				'title' => 'Samsung Tab 10.1',
			),
			8 => 
			array (
				'banner_image_id' => 92,
				'language_id' => 1,
				'banner_id' => 9,
				'title' => 'Hatch Premium Fly Reels',
			),
			9 => 
			array (
				'banner_image_id' => 93,
				'language_id' => 1,
				'banner_id' => 9,
				'title' => 'Yeti Containers',
			),
			10 => 
			array (
				'banner_image_id' => 94,
				'language_id' => 1,
				'banner_id' => 9,
				'title' => 'Louisiana Salt Water Series',
			),
		));
	}

}
