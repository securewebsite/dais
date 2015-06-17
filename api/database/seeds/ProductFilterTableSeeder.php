<?php

use Illuminate\Database\Seeder;

class ProductFilterTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('product_filter')->delete();
        
		\DB::table('product_filter')->insert(array (
			0 => 
			array (
				'product_id' => 42,
				'filter_id' => 1,
			),
		));
	}

}
