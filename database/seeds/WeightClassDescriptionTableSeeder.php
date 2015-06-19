<?php

use Illuminate\Database\Seeder;

class WeightClassDescriptionTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('weight_class_description')->delete();
        
		\DB::table('weight_class_description')->insert(array (
			0 => 
			array (
				'weight_class_id' => 1,
				'language_id' => 1,
				'title' => 'Kilogram',
				'unit' => 'kg',
			),
			1 => 
			array (
				'weight_class_id' => 2,
				'language_id' => 1,
				'title' => 'Gram',
				'unit' => 'g',
			),
			2 => 
			array (
				'weight_class_id' => 5,
				'language_id' => 1,
				'title' => 'Pound ',
				'unit' => 'lb',
			),
			3 => 
			array (
				'weight_class_id' => 6,
				'language_id' => 1,
				'title' => 'Ounce',
				'unit' => 'oz',
			),
		));
	}

}
