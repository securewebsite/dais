<?php

use Illuminate\Database\Seeder;

class BannerTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('banner')->delete();
        
		\DB::table('banner')->insert(array (
			0 => 
			array (
				'banner_id' => 6,
				'name' => 'HP Products',
				'status' => 1,
			),
			1 => 
			array (
				'banner_id' => 7,
				'name' => 'Samsung Tab',
				'status' => 1,
			),
			2 => 
			array (
				'banner_id' => 8,
				'name' => 'Manufacturers',
				'status' => 1,
			),
			3 => 
			array (
				'banner_id' => 9,
				'name' => 'Homepage',
				'status' => 1,
			),
		));
	}

}
