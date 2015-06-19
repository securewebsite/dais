<?php

use Illuminate\Database\Seeder;

class OrderHistoryTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('order_history')->delete();
        
	}

}
