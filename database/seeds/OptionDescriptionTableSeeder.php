<?php

use Illuminate\Database\Seeder;

class OptionDescriptionTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('option_description')->delete();
        
		\DB::table('option_description')->insert(array (
			0 => 
			array (
				'option_id' => 1,
				'language_id' => 1,
				'name' => 'Radio',
			),
			1 => 
			array (
				'option_id' => 2,
				'language_id' => 1,
				'name' => 'Checkbox',
			),
			2 => 
			array (
				'option_id' => 4,
				'language_id' => 1,
				'name' => 'Text',
			),
			3 => 
			array (
				'option_id' => 5,
				'language_id' => 1,
				'name' => 'Select',
			),
			4 => 
			array (
				'option_id' => 6,
				'language_id' => 1,
				'name' => 'Textarea',
			),
			5 => 
			array (
				'option_id' => 7,
				'language_id' => 1,
				'name' => 'File',
			),
			6 => 
			array (
				'option_id' => 8,
				'language_id' => 1,
				'name' => 'Date',
			),
			7 => 
			array (
				'option_id' => 9,
				'language_id' => 1,
				'name' => 'Time',
			),
			8 => 
			array (
				'option_id' => 10,
				'language_id' => 1,
				'name' => 'Date &amp; Time',
			),
			9 => 
			array (
				'option_id' => 11,
				'language_id' => 1,
				'name' => 'Size',
			),
			10 => 
			array (
				'option_id' => 12,
				'language_id' => 1,
				'name' => 'Delivery Date',
			),
		));
	}

}
