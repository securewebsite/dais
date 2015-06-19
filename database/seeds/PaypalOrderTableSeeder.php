<?php

use Illuminate\Database\Seeder;

class PaypalOrderTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('paypal_order')->delete();
        
	}

}
