<?php

use Illuminate\Database\Seeder;

class CustomerOnlineTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('customer_online')->delete();
        
	}

}
