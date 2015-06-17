<?php

use Illuminate\Database\Seeder;

class CustomerCommissionTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('customer_commission')->delete();
        
	}

}
