<?php

use Illuminate\Database\Seeder;

class CustomerInboxTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('customer_inbox')->delete();
        
	}

}
