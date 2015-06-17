<?php

use Illuminate\Database\Seeder;

class PageTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('page')->delete();
        
		\DB::table('page')->insert(array (
			0 => 
			array (
				'page_id' => 3,
				'bottom' => 1,
				'sort_order' => 3,
				'status' => 1,
				'visibility' => 1,
				'event_id' => 0,
			),
			1 => 
			array (
				'page_id' => 4,
				'bottom' => 1,
				'sort_order' => 1,
				'status' => 1,
				'visibility' => 1,
				'event_id' => 0,
			),
			2 => 
			array (
				'page_id' => 5,
				'bottom' => 1,
				'sort_order' => 4,
				'status' => 1,
				'visibility' => 1,
				'event_id' => 0,
			),
			3 => 
			array (
				'page_id' => 6,
				'bottom' => 1,
				'sort_order' => 2,
				'status' => 1,
				'visibility' => 1,
				'event_id' => 0,
			),
			4 => 
			array (
				'page_id' => 7,
				'bottom' => 0,
				'sort_order' => 0,
				'status' => 1,
				'visibility' => 1,
				'event_id' => 0,
			),
			5 => 
			array (
				'page_id' => 8,
				'bottom' => 0,
				'sort_order' => 0,
				'status' => 1,
				'visibility' => 1,
				'event_id' => 0,
			),
			6 => 
			array (
				'page_id' => 11,
				'bottom' => 0,
				'sort_order' => 0,
				'status' => 1,
				'visibility' => 1,
				'event_id' => 2,
			),
		));
	}

}
