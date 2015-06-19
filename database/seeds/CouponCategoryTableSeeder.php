<?php

use Illuminate\Database\Seeder;

class CouponCategoryTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('coupon_category')->delete();
        
	}

}
