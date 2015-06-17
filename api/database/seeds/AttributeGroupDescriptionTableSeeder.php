<?php

use Illuminate\Database\Seeder;

class AttributeGroupDescriptionTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('attribute_group_description')->delete();
        
		\DB::table('attribute_group_description')->insert(array (
			0 => 
			array (
				'attribute_group_id' => 3,
				'language_id' => 1,
				'name' => 'Memory',
			),
			1 => 
			array (
				'attribute_group_id' => 4,
				'language_id' => 1,
				'name' => 'Technical',
			),
			2 => 
			array (
				'attribute_group_id' => 5,
				'language_id' => 1,
				'name' => 'Motherboard',
			),
			3 => 
			array (
				'attribute_group_id' => 6,
				'language_id' => 1,
				'name' => 'Processor',
			),
		));
	}

}
