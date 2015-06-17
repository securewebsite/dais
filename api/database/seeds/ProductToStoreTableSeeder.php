<?php

use Illuminate\Database\Seeder;

class ProductToStoreTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('product_to_store')->delete();
        
		\DB::table('product_to_store')->insert(array (
			0 => 
			array (
				'product_id' => 28,
				'store_id' => 0,
			),
			1 => 
			array (
				'product_id' => 29,
				'store_id' => 0,
			),
			2 => 
			array (
				'product_id' => 30,
				'store_id' => 0,
			),
			3 => 
			array (
				'product_id' => 31,
				'store_id' => 0,
			),
			4 => 
			array (
				'product_id' => 32,
				'store_id' => 0,
			),
			5 => 
			array (
				'product_id' => 33,
				'store_id' => 0,
			),
			6 => 
			array (
				'product_id' => 34,
				'store_id' => 0,
			),
			7 => 
			array (
				'product_id' => 36,
				'store_id' => 0,
			),
			8 => 
			array (
				'product_id' => 40,
				'store_id' => 0,
			),
			9 => 
			array (
				'product_id' => 41,
				'store_id' => 0,
			),
			10 => 
			array (
				'product_id' => 42,
				'store_id' => 0,
			),
			11 => 
			array (
				'product_id' => 43,
				'store_id' => 0,
			),
			12 => 
			array (
				'product_id' => 44,
				'store_id' => 0,
			),
			13 => 
			array (
				'product_id' => 45,
				'store_id' => 0,
			),
			14 => 
			array (
				'product_id' => 46,
				'store_id' => 0,
			),
			15 => 
			array (
				'product_id' => 47,
				'store_id' => 0,
			),
			16 => 
			array (
				'product_id' => 48,
				'store_id' => 0,
			),
			17 => 
			array (
				'product_id' => 49,
				'store_id' => 0,
			),
			18 => 
			array (
				'product_id' => 50,
				'store_id' => 0,
			),
		));
	}

}
