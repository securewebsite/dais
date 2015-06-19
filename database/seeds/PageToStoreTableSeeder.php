<?php

use Illuminate\Database\Seeder;

class PageToStoreTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('page_to_store')->delete();
        
		\DB::table('page_to_store')->insert(array (
			0 => 
			array (
				'page_id' => 3,
				'store_id' => 0,
			),
			1 => 
			array (
				'page_id' => 4,
				'store_id' => 0,
			),
			2 => 
			array (
				'page_id' => 5,
				'store_id' => 0,
			),
			3 => 
			array (
				'page_id' => 6,
				'store_id' => 0,
			),
			4 => 
			array (
				'page_id' => 7,
				'store_id' => 0,
			),
			5 => 
			array (
				'page_id' => 8,
				'store_id' => 0,
			),
			6 => 
			array (
				'page_id' => 11,
				'store_id' => 0,
			),
		));
	}

}
