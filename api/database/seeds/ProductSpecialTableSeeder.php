<?php

use Illuminate\Database\Seeder;

class ProductSpecialTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('product_special')->delete();
        
		\DB::table('product_special')->insert(array (
			0 => 
			array (
				'product_special_id' => 490,
				'product_id' => 42,
				'customer_group_id' => 1,
				'priority' => 1,
				'price' => '90.0000',
				'date_start' => '0000-00-00',
				'date_end' => '0000-00-00',
			),
			1 => 
			array (
				'product_special_id' => 491,
				'product_id' => 30,
				'customer_group_id' => 1,
				'priority' => 1,
				'price' => '80.0000',
				'date_start' => '0000-00-00',
				'date_end' => '0000-00-00',
			),
			2 => 
			array (
				'product_special_id' => 492,
				'product_id' => 30,
				'customer_group_id' => 1,
				'priority' => 2,
				'price' => '90.0000',
				'date_start' => '0000-00-00',
				'date_end' => '0000-00-00',
			),
		));
	}

}
