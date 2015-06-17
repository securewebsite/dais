<?php

use Illuminate\Database\Seeder;

class TaxRateToCustomerGroupTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('tax_rate_to_customer_group')->delete();
        
		\DB::table('tax_rate_to_customer_group')->insert(array (
			0 => 
			array (
				'tax_rate_id' => 88,
				'customer_group_id' => 1,
			),
			1 => 
			array (
				'tax_rate_id' => 88,
				'customer_group_id' => 2,
			),
			2 => 
			array (
				'tax_rate_id' => 88,
				'customer_group_id' => 3,
			),
			3 => 
			array (
				'tax_rate_id' => 88,
				'customer_group_id' => 4,
			),
		));
	}

}
