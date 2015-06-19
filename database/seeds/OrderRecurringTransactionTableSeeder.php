<?php

use Illuminate\Database\Seeder;

class OrderRecurringTransactionTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('order_recurring_transaction')->delete();
        
	}

}
