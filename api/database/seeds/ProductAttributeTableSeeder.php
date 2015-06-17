<?php

use Illuminate\Database\Seeder;

class ProductAttributeTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('product_attribute')->delete();
        
		\DB::table('product_attribute')->insert(array (
			0 => 
			array (
				'product_id' => 42,
				'attribute_id' => 3,
				'language_id' => 1,
				'text' => '100mhz',
			),
			1 => 
			array (
				'product_id' => 43,
				'attribute_id' => 2,
				'language_id' => 1,
				'text' => '1',
			),
			2 => 
			array (
				'product_id' => 43,
				'attribute_id' => 4,
				'language_id' => 1,
				'text' => '8gb',
			),
			3 => 
			array (
				'product_id' => 47,
				'attribute_id' => 2,
				'language_id' => 1,
				'text' => '4',
			),
			4 => 
			array (
				'product_id' => 47,
				'attribute_id' => 4,
				'language_id' => 1,
				'text' => '16GB',
			),
		));
	}

}
