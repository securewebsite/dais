<?php

use Illuminate\Database\Seeder;

class LayoutTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('layout')->delete();
        
		\DB::table('layout')->insert(array (
			0 => 
			array (
				'layout_id' => 1,
				'name' => 'Default',
			),
			1 => 
			array (
				'layout_id' => 2,
				'name' => 'Shop Home',
			),
			2 => 
			array (
				'layout_id' => 3,
				'name' => 'Shop Product',
			),
			3 => 
			array (
				'layout_id' => 4,
				'name' => 'Shop Category',
			),
			4 => 
			array (
				'layout_id' => 5,
				'name' => 'Shop Manufacturer',
			),
			5 => 
			array (
				'layout_id' => 6,
				'name' => 'Account',
			),
			6 => 
			array (
				'layout_id' => 7,
				'name' => 'Checkout',
			),
			7 => 
			array (
				'layout_id' => 8,
				'name' => 'Contact',
			),
			8 => 
			array (
				'layout_id' => 9,
				'name' => 'Sitemap',
			),
			9 => 
			array (
				'layout_id' => 11,
				'name' => 'Content Page',
			),
			10 => 
			array (
				'layout_id' => 13,
				'name' => 'Error 404',
			),
			11 => 
			array (
				'layout_id' => 14,
				'name' => 'Content Home',
			),
			12 => 
			array (
				'layout_id' => 15,
				'name' => 'Content Category',
			),
			13 => 
			array (
				'layout_id' => 16,
				'name' => 'Content Post',
			),
			14 => 
			array (
				'layout_id' => 17,
				'name' => 'Search',
			),
			15 => 
			array (
				'layout_id' => 18,
				'name' => 'Register',
			),
			16 => 
			array (
				'layout_id' => 19,
				'name' => 'Calendar',
			),
			17 => 
			array (
				'layout_id' => 20,
				'name' => 'Shop Compare',
			),
			18 => 
			array (
				'layout_id' => 21,
				'name' => 'Event Page',
			),
			19 => 
			array (
				'layout_id' => 22,
				'name' => 'Error Permission',
			),
		));
	}

}
