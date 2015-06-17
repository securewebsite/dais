<?php

use Illuminate\Database\Seeder;

class CustomerGroupTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('customer_group')->delete();
        
		\DB::table('customer_group')->insert(array (
			0 => 
			array (
				'customer_group_id' => 1,
				'approval' => 0,
				'company_id_display' => 0,
				'company_id_required' => 0,
				'tax_id_display' => 0,
				'tax_id_required' => 0,
				'sort_order' => 1,
			),
			1 => 
			array (
				'customer_group_id' => 2,
				'approval' => 0,
				'company_id_display' => 0,
				'company_id_required' => 0,
				'tax_id_display' => 0,
				'tax_id_required' => 0,
				'sort_order' => 2,
			),
			2 => 
			array (
				'customer_group_id' => 3,
				'approval' => 0,
				'company_id_display' => 0,
				'company_id_required' => 0,
				'tax_id_display' => 0,
				'tax_id_required' => 0,
				'sort_order' => 3,
			),
			3 => 
			array (
				'customer_group_id' => 4,
				'approval' => 0,
				'company_id_display' => 0,
				'company_id_required' => 0,
				'tax_id_display' => 0,
				'tax_id_required' => 0,
				'sort_order' => 4,
			),
		));
	}

}
