<?php

use Illuminate\Database\Seeder;

class ProductDiscountTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('product_discount')->delete();
        
		\DB::table('product_discount')->insert(array (
			0 => 
			array (
				'product_discount_id' => 567,
				'product_id' => 42,
				'customer_group_id' => 1,
				'quantity' => 10,
				'priority' => 1,
				'price' => '88.0000',
				'date_start' => '0000-00-00',
				'date_end' => '0000-00-00',
			),
			1 => 
			array (
				'product_discount_id' => 568,
				'product_id' => 42,
				'customer_group_id' => 1,
				'quantity' => 20,
				'priority' => 1,
				'price' => '77.0000',
				'date_start' => '0000-00-00',
				'date_end' => '0000-00-00',
			),
			2 => 
			array (
				'product_discount_id' => 569,
				'product_id' => 42,
				'customer_group_id' => 1,
				'quantity' => 30,
				'priority' => 1,
				'price' => '66.0000',
				'date_start' => '0000-00-00',
				'date_end' => '0000-00-00',
			),
		));
	}

}
