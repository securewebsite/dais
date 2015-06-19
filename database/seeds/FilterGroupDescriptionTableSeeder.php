<?php

use Illuminate\Database\Seeder;

class FilterGroupDescriptionTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('filter_group_description')->delete();
        
		\DB::table('filter_group_description')->insert(array (
			0 => 
			array (
				'filter_group_id' => 1,
				'language_id' => 1,
				'name' => 'Manufacturer',
			),
		));
	}

}
