<?php

use Illuminate\Database\Seeder;

class OrderStatusTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('order_status')->delete();
        
		\DB::table('order_status')->insert(array (
			0 => 
			array (
				'order_status_id' => 1,
				'language_id' => 1,
				'name' => 'Pending',
			),
			1 => 
			array (
				'order_status_id' => 2,
				'language_id' => 1,
				'name' => 'Processing',
			),
			2 => 
			array (
				'order_status_id' => 3,
				'language_id' => 1,
				'name' => 'Shipped',
			),
			3 => 
			array (
				'order_status_id' => 5,
				'language_id' => 1,
				'name' => 'Complete',
			),
			4 => 
			array (
				'order_status_id' => 7,
				'language_id' => 1,
				'name' => 'Canceled',
			),
			5 => 
			array (
				'order_status_id' => 8,
				'language_id' => 1,
				'name' => 'Denied',
			),
			6 => 
			array (
				'order_status_id' => 9,
				'language_id' => 1,
				'name' => 'Canceled Reversal',
			),
			7 => 
			array (
				'order_status_id' => 10,
				'language_id' => 1,
				'name' => 'Failed',
			),
			8 => 
			array (
				'order_status_id' => 11,
				'language_id' => 1,
				'name' => 'Refunded',
			),
			9 => 
			array (
				'order_status_id' => 12,
				'language_id' => 1,
				'name' => 'Reversed',
			),
			10 => 
			array (
				'order_status_id' => 13,
				'language_id' => 1,
				'name' => 'Chargeback',
			),
			11 => 
			array (
				'order_status_id' => 14,
				'language_id' => 1,
				'name' => 'Expired',
			),
			12 => 
			array (
				'order_status_id' => 15,
				'language_id' => 1,
				'name' => 'Processed',
			),
			13 => 
			array (
				'order_status_id' => 16,
				'language_id' => 1,
				'name' => 'Voided',
			),
		));
	}

}
