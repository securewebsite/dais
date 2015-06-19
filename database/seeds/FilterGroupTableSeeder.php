<?php

use Illuminate\Database\Seeder;

class FilterGroupTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('filter_group')->delete();
        
		\DB::table('filter_group')->insert(array (
			0 => 
			array (
				'filter_group_id' => 1,
				'sort_order' => 0,
			),
		));
	}

}
