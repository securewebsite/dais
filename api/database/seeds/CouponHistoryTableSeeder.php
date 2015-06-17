<?php

use Illuminate\Database\Seeder;

class CouponHistoryTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('coupon_history')->delete();
        
	}

}
