<?php

use Illuminate\Database\Seeder;

class CouponTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('coupon')->delete();
        
		\DB::table('coupon')->insert(array (
			0 => 
			array (
				'coupon_id' => 4,
				'name' => '-10% Discount',
				'code' => '2222',
				'type' => 'P',
				'discount' => '10.0000',
				'logged' => 0,
				'shipping' => 0,
				'total' => '0.0000',
				'date_start' => '2011-01-01',
				'date_end' => '2012-01-01',
				'uses_total' => 10,
				'uses_customer' => '10',
				'status' => 1,
				'date_added' => '2009-01-27 13:55:03',
			),
			1 => 
			array (
				'coupon_id' => 5,
				'name' => 'Free Shipping',
				'code' => '3333',
				'type' => 'P',
				'discount' => '0.0000',
				'logged' => 0,
				'shipping' => 1,
				'total' => '100.0000',
				'date_start' => '2009-03-01',
				'date_end' => '2009-08-31',
				'uses_total' => 10,
				'uses_customer' => '10',
				'status' => 1,
				'date_added' => '2009-03-14 21:13:53',
			),
			2 => 
			array (
				'coupon_id' => 6,
				'name' => '-10.00 Discount',
				'code' => '1111',
				'type' => 'F',
				'discount' => '10.0000',
				'logged' => 0,
				'shipping' => 0,
				'total' => '10.0000',
				'date_start' => '1970-11-01',
				'date_end' => '2020-11-01',
				'uses_total' => 100000,
				'uses_customer' => '10000',
				'status' => 1,
				'date_added' => '2009-03-14 21:15:18',
			),
		));
	}

}
