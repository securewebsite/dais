<?php

use Illuminate\Database\Seeder;

class ManufacturerToStoreTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('manufacturer_to_store')->delete();
        
		\DB::table('manufacturer_to_store')->insert(array (
			0 => 
			array (
				'manufacturer_id' => 5,
				'store_id' => 0,
			),
			1 => 
			array (
				'manufacturer_id' => 6,
				'store_id' => 0,
			),
			2 => 
			array (
				'manufacturer_id' => 7,
				'store_id' => 0,
			),
			3 => 
			array (
				'manufacturer_id' => 8,
				'store_id' => 0,
			),
			4 => 
			array (
				'manufacturer_id' => 9,
				'store_id' => 0,
			),
			5 => 
			array (
				'manufacturer_id' => 10,
				'store_id' => 0,
			),
			6 => 
			array (
				'manufacturer_id' => 11,
				'store_id' => 0,
			),
		));
	}

}
