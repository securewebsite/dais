<?php

use Illuminate\Database\Seeder;

class ProductOptionValueTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('product_option_value')->delete();
        
		\DB::table('product_option_value')->insert(array (
			0 => 
			array (
				'product_option_value_id' => 1,
				'product_option_id' => 217,
				'product_id' => 42,
				'option_id' => 5,
				'option_value_id' => 41,
				'quantity' => 100,
				'subtract' => 0,
				'price' => '1.0000',
				'price_prefix' => '+',
				'points' => 0,
				'points_prefix' => '+',
				'weight' => '1.00000000',
				'weight_prefix' => '+',
			),
			1 => 
			array (
				'product_option_value_id' => 2,
				'product_option_id' => 217,
				'product_id' => 42,
				'option_id' => 5,
				'option_value_id' => 42,
				'quantity' => 200,
				'subtract' => 1,
				'price' => '2.0000',
				'price_prefix' => '+',
				'points' => 0,
				'points_prefix' => '+',
				'weight' => '2.00000000',
				'weight_prefix' => '+',
			),
			2 => 
			array (
				'product_option_value_id' => 3,
				'product_option_id' => 217,
				'product_id' => 42,
				'option_id' => 5,
				'option_value_id' => 40,
				'quantity' => 300,
				'subtract' => 0,
				'price' => '3.0000',
				'price_prefix' => '+',
				'points' => 0,
				'points_prefix' => '+',
				'weight' => '3.00000000',
				'weight_prefix' => '+',
			),
			3 => 
			array (
				'product_option_value_id' => 4,
				'product_option_id' => 217,
				'product_id' => 42,
				'option_id' => 5,
				'option_value_id' => 39,
				'quantity' => 92,
				'subtract' => 1,
				'price' => '4.0000',
				'price_prefix' => '+',
				'points' => 0,
				'points_prefix' => '+',
				'weight' => '4.00000000',
				'weight_prefix' => '+',
			),
			4 => 
			array (
				'product_option_value_id' => 5,
				'product_option_id' => 218,
				'product_id' => 42,
				'option_id' => 1,
				'option_value_id' => 32,
				'quantity' => 96,
				'subtract' => 1,
				'price' => '10.0000',
				'price_prefix' => '+',
				'points' => 1,
				'points_prefix' => '+',
				'weight' => '10.00000000',
				'weight_prefix' => '+',
			),
			5 => 
			array (
				'product_option_value_id' => 6,
				'product_option_id' => 218,
				'product_id' => 42,
				'option_id' => 1,
				'option_value_id' => 31,
				'quantity' => 146,
				'subtract' => 1,
				'price' => '20.0000',
				'price_prefix' => '+',
				'points' => 2,
				'points_prefix' => '-',
				'weight' => '20.00000000',
				'weight_prefix' => '+',
			),
			6 => 
			array (
				'product_option_value_id' => 7,
				'product_option_id' => 218,
				'product_id' => 42,
				'option_id' => 1,
				'option_value_id' => 43,
				'quantity' => 300,
				'subtract' => 1,
				'price' => '30.0000',
				'price_prefix' => '+',
				'points' => 3,
				'points_prefix' => '+',
				'weight' => '30.00000000',
				'weight_prefix' => '+',
			),
			7 => 
			array (
				'product_option_value_id' => 8,
				'product_option_id' => 223,
				'product_id' => 42,
				'option_id' => 2,
				'option_value_id' => 23,
				'quantity' => 48,
				'subtract' => 1,
				'price' => '10.0000',
				'price_prefix' => '+',
				'points' => 0,
				'points_prefix' => '+',
				'weight' => '10.00000000',
				'weight_prefix' => '+',
			),
			8 => 
			array (
				'product_option_value_id' => 9,
				'product_option_id' => 223,
				'product_id' => 42,
				'option_id' => 2,
				'option_value_id' => 24,
				'quantity' => 194,
				'subtract' => 1,
				'price' => '20.0000',
				'price_prefix' => '+',
				'points' => 0,
				'points_prefix' => '+',
				'weight' => '20.00000000',
				'weight_prefix' => '+',
			),
			9 => 
			array (
				'product_option_value_id' => 10,
				'product_option_id' => 223,
				'product_id' => 42,
				'option_id' => 2,
				'option_value_id' => 44,
				'quantity' => 2696,
				'subtract' => 1,
				'price' => '30.0000',
				'price_prefix' => '+',
				'points' => 0,
				'points_prefix' => '+',
				'weight' => '30.00000000',
				'weight_prefix' => '+',
			),
			10 => 
			array (
				'product_option_value_id' => 11,
				'product_option_id' => 223,
				'product_id' => 42,
				'option_id' => 2,
				'option_value_id' => 45,
				'quantity' => 3998,
				'subtract' => 1,
				'price' => '40.0000',
				'price_prefix' => '+',
				'points' => 0,
				'points_prefix' => '+',
				'weight' => '40.00000000',
				'weight_prefix' => '+',
			),
			11 => 
			array (
				'product_option_value_id' => 15,
				'product_option_id' => 226,
				'product_id' => 30,
				'option_id' => 5,
				'option_value_id' => 39,
				'quantity' => 2,
				'subtract' => 1,
				'price' => '0.0000',
				'price_prefix' => '+',
				'points' => 0,
				'points_prefix' => '+',
				'weight' => '0.00000000',
				'weight_prefix' => '+',
			),
			12 => 
			array (
				'product_option_value_id' => 16,
				'product_option_id' => 226,
				'product_id' => 30,
				'option_id' => 5,
				'option_value_id' => 40,
				'quantity' => 5,
				'subtract' => 1,
				'price' => '0.0000',
				'price_prefix' => '+',
				'points' => 0,
				'points_prefix' => '+',
				'weight' => '0.00000000',
				'weight_prefix' => '+',
			),
		));
	}

}
