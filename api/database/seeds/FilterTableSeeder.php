<?php

use Illuminate\Database\Seeder;

class FilterTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('filter')->delete();
        
		\DB::table('filter')->insert(array (
			0 => 
			array (
				'filter_id' => 1,
				'filter_group_id' => 1,
				'sort_order' => 0,
			),
		));
	}

}
