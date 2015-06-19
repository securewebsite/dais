<?php

use Illuminate\Database\Seeder;

class ProductRelatedTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('product_related')->delete();
        
		\DB::table('product_related')->insert(array (
			0 => 
			array (
				'product_id' => 40,
				'related_id' => 42,
			),
			1 => 
			array (
				'product_id' => 41,
				'related_id' => 42,
			),
			2 => 
			array (
				'product_id' => 42,
				'related_id' => 40,
			),
			3 => 
			array (
				'product_id' => 42,
				'related_id' => 41,
			),
		));
	}

}
