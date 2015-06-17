<?php

use Illuminate\Database\Seeder;

class OptionValueDescriptionTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('option_value_description')->delete();
        
		\DB::table('option_value_description')->insert(array (
			0 => 
			array (
				'option_value_id' => 23,
				'language_id' => 1,
				'option_id' => 2,
				'name' => 'Checkbox 1',
			),
			1 => 
			array (
				'option_value_id' => 24,
				'language_id' => 1,
				'option_id' => 2,
				'name' => 'Checkbox 2',
			),
			2 => 
			array (
				'option_value_id' => 31,
				'language_id' => 1,
				'option_id' => 1,
				'name' => 'Medium',
			),
			3 => 
			array (
				'option_value_id' => 32,
				'language_id' => 1,
				'option_id' => 1,
				'name' => 'Small',
			),
			4 => 
			array (
				'option_value_id' => 39,
				'language_id' => 1,
				'option_id' => 5,
				'name' => 'Red',
			),
			5 => 
			array (
				'option_value_id' => 40,
				'language_id' => 1,
				'option_id' => 5,
				'name' => 'Blue',
			),
			6 => 
			array (
				'option_value_id' => 41,
				'language_id' => 1,
				'option_id' => 5,
				'name' => 'Green',
			),
			7 => 
			array (
				'option_value_id' => 42,
				'language_id' => 1,
				'option_id' => 5,
				'name' => 'Yellow',
			),
			8 => 
			array (
				'option_value_id' => 43,
				'language_id' => 1,
				'option_id' => 1,
				'name' => 'Large',
			),
			9 => 
			array (
				'option_value_id' => 44,
				'language_id' => 1,
				'option_id' => 2,
				'name' => 'Checkbox 3',
			),
			10 => 
			array (
				'option_value_id' => 45,
				'language_id' => 1,
				'option_id' => 2,
				'name' => 'Checkbox 4',
			),
			11 => 
			array (
				'option_value_id' => 46,
				'language_id' => 1,
				'option_id' => 11,
				'name' => 'Small',
			),
			12 => 
			array (
				'option_value_id' => 47,
				'language_id' => 1,
				'option_id' => 11,
				'name' => 'Medium',
			),
			13 => 
			array (
				'option_value_id' => 48,
				'language_id' => 1,
				'option_id' => 11,
				'name' => 'Large',
			),
		));
	}

}
