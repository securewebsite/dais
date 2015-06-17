<?php

use Illuminate\Database\Seeder;

class FilterDescriptionTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('filter_description')->delete();
        
		\DB::table('filter_description')->insert(array (
			0 => 
			array (
				'filter_id' => 1,
				'language_id' => 1,
				'filter_group_id' => 1,
				'name' => 'Apple',
			),
		));
	}

}
