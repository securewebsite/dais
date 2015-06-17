<?php

use Illuminate\Database\Seeder;

class OptionValueTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('option_value')->delete();
        
		\DB::table('option_value')->insert(array (
			0 => 
			array (
				'option_value_id' => 23,
				'option_id' => 2,
				'image' => '',
				'sort_order' => 1,
			),
			1 => 
			array (
				'option_value_id' => 24,
				'option_id' => 2,
				'image' => '',
				'sort_order' => 2,
			),
			2 => 
			array (
				'option_value_id' => 31,
				'option_id' => 1,
				'image' => '',
				'sort_order' => 2,
			),
			3 => 
			array (
				'option_value_id' => 32,
				'option_id' => 1,
				'image' => '',
				'sort_order' => 1,
			),
			4 => 
			array (
				'option_value_id' => 39,
				'option_id' => 5,
				'image' => '',
				'sort_order' => 1,
			),
			5 => 
			array (
				'option_value_id' => 40,
				'option_id' => 5,
				'image' => '',
				'sort_order' => 2,
			),
			6 => 
			array (
				'option_value_id' => 41,
				'option_id' => 5,
				'image' => '',
				'sort_order' => 3,
			),
			7 => 
			array (
				'option_value_id' => 42,
				'option_id' => 5,
				'image' => '',
				'sort_order' => 4,
			),
			8 => 
			array (
				'option_value_id' => 43,
				'option_id' => 1,
				'image' => '',
				'sort_order' => 3,
			),
			9 => 
			array (
				'option_value_id' => 44,
				'option_id' => 2,
				'image' => '',
				'sort_order' => 3,
			),
			10 => 
			array (
				'option_value_id' => 45,
				'option_id' => 2,
				'image' => '',
				'sort_order' => 4,
			),
			11 => 
			array (
				'option_value_id' => 46,
				'option_id' => 11,
				'image' => '',
				'sort_order' => 1,
			),
			12 => 
			array (
				'option_value_id' => 47,
				'option_id' => 11,
				'image' => '',
				'sort_order' => 2,
			),
			13 => 
			array (
				'option_value_id' => 48,
				'option_id' => 11,
				'image' => '',
				'sort_order' => 3,
			),
		));
	}

}
