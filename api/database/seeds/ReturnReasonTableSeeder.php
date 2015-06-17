<?php

use Illuminate\Database\Seeder;

class ReturnReasonTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('return_reason')->delete();
        
		\DB::table('return_reason')->insert(array (
			0 => 
			array (
				'return_reason_id' => 1,
				'language_id' => 1,
				'name' => 'Dead On Arrival',
			),
			1 => 
			array (
				'return_reason_id' => 2,
				'language_id' => 1,
				'name' => 'Received Wrong Item',
			),
			2 => 
			array (
				'return_reason_id' => 3,
				'language_id' => 1,
				'name' => 'Order Error',
			),
			3 => 
			array (
				'return_reason_id' => 4,
				'language_id' => 1,
				'name' => 'Faulty, please supply details',
			),
			4 => 
			array (
				'return_reason_id' => 5,
				'language_id' => 1,
				'name' => 'Other, please supply details',
			),
		));
	}

}
