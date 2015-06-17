<?php

use Illuminate\Database\Seeder;

class AttributeDescriptionTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('attribute_description')->delete();
        
		\DB::table('attribute_description')->insert(array (
			0 => 
			array (
				'attribute_id' => 1,
				'language_id' => 1,
				'name' => 'Description',
			),
			1 => 
			array (
				'attribute_id' => 2,
				'language_id' => 1,
				'name' => 'No. of Cores',
			),
			2 => 
			array (
				'attribute_id' => 3,
				'language_id' => 1,
				'name' => 'Clockspeed',
			),
			3 => 
			array (
				'attribute_id' => 4,
				'language_id' => 1,
				'name' => 'test 1',
			),
			4 => 
			array (
				'attribute_id' => 5,
				'language_id' => 1,
				'name' => 'test 2',
			),
			5 => 
			array (
				'attribute_id' => 6,
				'language_id' => 1,
				'name' => 'test 3',
			),
			6 => 
			array (
				'attribute_id' => 7,
				'language_id' => 1,
				'name' => 'test 4',
			),
			7 => 
			array (
				'attribute_id' => 8,
				'language_id' => 1,
				'name' => 'test 5',
			),
			8 => 
			array (
				'attribute_id' => 9,
				'language_id' => 1,
				'name' => 'test 6',
			),
			9 => 
			array (
				'attribute_id' => 10,
				'language_id' => 1,
				'name' => 'test 7',
			),
			10 => 
			array (
				'attribute_id' => 11,
				'language_id' => 1,
				'name' => 'test 8',
			),
		));
	}

}
