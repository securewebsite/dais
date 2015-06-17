<?php

use Illuminate\Database\Seeder;

class RecurringTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('recurring')->delete();
        
		\DB::table('recurring')->insert(array (
			0 => 
			array (
				'recurring_id' => 1,
				'price' => '10.0000',
				'frequency' => 'month',
				'duration' => 0,
				'cycle' => 1,
				'trial_status' => 0,
				'trial_price' => '0.0000',
				'trial_frequency' => 'day',
				'trial_duration' => 0,
				'trial_cycle' => 1,
				'status' => 1,
				'sort_order' => 0,
			),
		));
	}

}
