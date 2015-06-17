<?php

use Illuminate\Database\Seeder;

class LengthClassDescriptionTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('length_class_description')->delete();
        
		\DB::table('length_class_description')->insert(array (
			0 => 
			array (
				'length_class_id' => 1,
				'language_id' => 1,
				'title' => 'Centimeter',
				'unit' => 'cm',
			),
			1 => 
			array (
				'length_class_id' => 2,
				'language_id' => 1,
				'title' => 'Millimeter',
				'unit' => 'mm',
			),
			2 => 
			array (
				'length_class_id' => 3,
				'language_id' => 1,
				'title' => 'Inch',
				'unit' => 'in',
			),
		));
	}

}
