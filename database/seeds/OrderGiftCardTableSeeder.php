<?php

use Illuminate\Database\Seeder;

class OrderGiftCardTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('order_gift_card')->delete();
        
	}

}
