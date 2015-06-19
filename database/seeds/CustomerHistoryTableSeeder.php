<?php

use Illuminate\Database\Seeder;

class CustomerHistoryTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('customer_history')->delete();
        
	}

}
