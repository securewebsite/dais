<?php

use Illuminate\Database\Seeder;

class ProductRecurringTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('product_recurring')->delete();
        
		\DB::table('product_recurring')->insert(array (
			0 => 
			array (
				'product_id' => 41,
				'recurring_id' => 1,
				'customer_group_id' => 1,
			),
			1 => 
			array (
				'product_id' => 41,
				'recurring_id' => 1,
				'customer_group_id' => 2,
			),
			2 => 
			array (
				'product_id' => 41,
				'recurring_id' => 1,
				'customer_group_id' => 3,
			),
			3 => 
			array (
				'product_id' => 41,
				'recurring_id' => 1,
				'customer_group_id' => 4,
			),
		));
	}

}
