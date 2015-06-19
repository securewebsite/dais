<?php

use Illuminate\Database\Seeder;

class OrderRecurringTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('order_recurring')->delete();
        
	}

}
