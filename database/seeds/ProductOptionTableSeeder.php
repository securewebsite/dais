<?php

use Illuminate\Database\Seeder;

class ProductOptionTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('product_option')->delete();
        
		\DB::table('product_option')->insert(array (
			0 => 
			array (
				'product_option_id' => 208,
				'product_id' => 42,
				'option_id' => 4,
				'option_value' => 'test',
				'required' => 1,
			),
			1 => 
			array (
				'product_option_id' => 209,
				'product_id' => 42,
				'option_id' => 6,
				'option_value' => '',
				'required' => 1,
			),
			2 => 
			array (
				'product_option_id' => 217,
				'product_id' => 42,
				'option_id' => 5,
				'option_value' => '',
				'required' => 1,
			),
			3 => 
			array (
				'product_option_id' => 218,
				'product_id' => 42,
				'option_id' => 1,
				'option_value' => '',
				'required' => 1,
			),
			4 => 
			array (
				'product_option_id' => 219,
				'product_id' => 42,
				'option_id' => 8,
				'option_value' => '2011-02-20',
				'required' => 1,
			),
			5 => 
			array (
				'product_option_id' => 220,
				'product_id' => 42,
				'option_id' => 10,
				'option_value' => '2011-02-20 22:25',
				'required' => 1,
			),
			6 => 
			array (
				'product_option_id' => 221,
				'product_id' => 42,
				'option_id' => 9,
				'option_value' => '22:25',
				'required' => 1,
			),
			7 => 
			array (
				'product_option_id' => 222,
				'product_id' => 42,
				'option_id' => 7,
				'option_value' => '',
				'required' => 1,
			),
			8 => 
			array (
				'product_option_id' => 223,
				'product_id' => 42,
				'option_id' => 2,
				'option_value' => '',
				'required' => 1,
			),
			9 => 
			array (
				'product_option_id' => 225,
				'product_id' => 47,
				'option_id' => 12,
				'option_value' => '2011-04-22',
				'required' => 1,
			),
			10 => 
			array (
				'product_option_id' => 226,
				'product_id' => 30,
				'option_id' => 5,
				'option_value' => '',
				'required' => 1,
			),
		));
	}

}
