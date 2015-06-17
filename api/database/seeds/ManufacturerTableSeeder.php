<?php

use Illuminate\Database\Seeder;

class ManufacturerTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('manufacturer')->delete();
        
		\DB::table('manufacturer')->insert(array (
			0 => 
			array (
				'manufacturer_id' => 5,
				'name' => 'HTC',
				'image' => 'data/demo/htc_logo.jpg',
				'sort_order' => 0,
			),
			1 => 
			array (
				'manufacturer_id' => 6,
				'name' => 'Palm',
				'image' => 'data/demo/palm_logo.jpg',
				'sort_order' => 0,
			),
			2 => 
			array (
				'manufacturer_id' => 7,
				'name' => 'Hewlett-Packard',
				'image' => 'data/demo/hp_logo.jpg',
				'sort_order' => 0,
			),
			3 => 
			array (
				'manufacturer_id' => 8,
				'name' => 'Apple',
				'image' => 'data/demo/apple_logo.jpg',
				'sort_order' => 0,
			),
			4 => 
			array (
				'manufacturer_id' => 9,
				'name' => 'Canon',
				'image' => 'data/demo/canon_logo.jpg',
				'sort_order' => 0,
			),
			5 => 
			array (
				'manufacturer_id' => 10,
				'name' => 'Sony',
				'image' => 'data/demo/sony_logo.jpg',
				'sort_order' => 0,
			),
			6 => 
			array (
				'manufacturer_id' => 11,
				'name' => 'Solution Labs',
				'image' => 'data/manufacturers/solution-labs.png',
				'sort_order' => 0,
			),
		));
	}

}
