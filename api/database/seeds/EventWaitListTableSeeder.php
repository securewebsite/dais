<?php

use Illuminate\Database\Seeder;

class EventWaitListTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('event_wait_list')->delete();
        
	}

}
