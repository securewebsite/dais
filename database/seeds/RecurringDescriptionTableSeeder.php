<?php

use Illuminate\Database\Seeder;

class RecurringDescriptionTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('recurring_description')->delete();
        
		\DB::table('recurring_description')->insert(array (
			0 => 
			array (
				'recurring_id' => 1,
				'language_id' => 1,
				'name' => '10.00 Per Month',
			),
		));
	}

}
