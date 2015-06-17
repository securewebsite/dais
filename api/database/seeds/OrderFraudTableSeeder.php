<?php

use Illuminate\Database\Seeder;

class OrderFraudTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('order_fraud')->delete();
        
	}

}
