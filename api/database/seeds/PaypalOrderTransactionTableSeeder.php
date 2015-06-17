<?php

use Illuminate\Database\Seeder;

class PaypalOrderTransactionTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('paypal_order_transaction')->delete();
        
	}

}
