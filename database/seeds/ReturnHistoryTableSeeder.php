<?php

use Illuminate\Database\Seeder;

class ReturnHistoryTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('return_history')->delete();
        
	}

}
