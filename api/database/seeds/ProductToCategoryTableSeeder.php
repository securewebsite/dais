<?php

use Illuminate\Database\Seeder;

class ProductToCategoryTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('product_to_category')->delete();
        
		\DB::table('product_to_category')->insert(array (
			0 => 
			array (
				'product_id' => 28,
				'category_id' => 24,
			),
			1 => 
			array (
				'product_id' => 29,
				'category_id' => 24,
			),
			2 => 
			array (
				'product_id' => 30,
				'category_id' => 33,
			),
			3 => 
			array (
				'product_id' => 31,
				'category_id' => 33,
			),
			4 => 
			array (
				'product_id' => 32,
				'category_id' => 34,
			),
			5 => 
			array (
				'product_id' => 32,
				'category_id' => 38,
			),
			6 => 
			array (
				'product_id' => 33,
				'category_id' => 25,
			),
			7 => 
			array (
				'product_id' => 33,
				'category_id' => 28,
			),
			8 => 
			array (
				'product_id' => 34,
				'category_id' => 34,
			),
			9 => 
			array (
				'product_id' => 34,
				'category_id' => 49,
			),
			10 => 
			array (
				'product_id' => 36,
				'category_id' => 34,
			),
			11 => 
			array (
				'product_id' => 36,
				'category_id' => 43,
			),
			12 => 
			array (
				'product_id' => 40,
				'category_id' => 24,
			),
			13 => 
			array (
				'product_id' => 41,
				'category_id' => 20,
			),
			14 => 
			array (
				'product_id' => 41,
				'category_id' => 27,
			),
			15 => 
			array (
				'product_id' => 42,
				'category_id' => 25,
			),
			16 => 
			array (
				'product_id' => 42,
				'category_id' => 28,
			),
			17 => 
			array (
				'product_id' => 43,
				'category_id' => 18,
			),
			18 => 
			array (
				'product_id' => 43,
				'category_id' => 46,
			),
			19 => 
			array (
				'product_id' => 44,
				'category_id' => 18,
			),
			20 => 
			array (
				'product_id' => 44,
				'category_id' => 46,
			),
			21 => 
			array (
				'product_id' => 45,
				'category_id' => 18,
			),
			22 => 
			array (
				'product_id' => 45,
				'category_id' => 46,
			),
			23 => 
			array (
				'product_id' => 46,
				'category_id' => 18,
			),
			24 => 
			array (
				'product_id' => 46,
				'category_id' => 45,
			),
			25 => 
			array (
				'product_id' => 47,
				'category_id' => 18,
			),
			26 => 
			array (
				'product_id' => 47,
				'category_id' => 45,
			),
			27 => 
			array (
				'product_id' => 48,
				'category_id' => 34,
			),
			28 => 
			array (
				'product_id' => 48,
				'category_id' => 52,
			),
			29 => 
			array (
				'product_id' => 48,
				'category_id' => 58,
			),
			30 => 
			array (
				'product_id' => 49,
				'category_id' => 57,
			),
			31 => 
			array (
				'product_id' => 50,
				'category_id' => 59,
			),
		));
	}

}
