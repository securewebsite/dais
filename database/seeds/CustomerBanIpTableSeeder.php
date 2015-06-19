<?php

use Illuminate\Database\Seeder;

class CustomerBanIpTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('customer_ban_ip')->delete();
        
	}

}
