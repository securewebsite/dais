<?php

use Illuminate\Database\Seeder;

class AttributeTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('attribute')->delete();
        
		\DB::table('attribute')->insert(array (
			0 => 
			array (
				'attribute_id' => 1,
				'attribute_group_id' => 6,
				'sort_order' => 1,
			),
			1 => 
			array (
				'attribute_id' => 2,
				'attribute_group_id' => 6,
				'sort_order' => 5,
			),
			2 => 
			array (
				'attribute_id' => 3,
				'attribute_group_id' => 6,
				'sort_order' => 3,
			),
			3 => 
			array (
				'attribute_id' => 4,
				'attribute_group_id' => 3,
				'sort_order' => 1,
			),
			4 => 
			array (
				'attribute_id' => 5,
				'attribute_group_id' => 3,
				'sort_order' => 2,
			),
			5 => 
			array (
				'attribute_id' => 6,
				'attribute_group_id' => 3,
				'sort_order' => 3,
			),
			6 => 
			array (
				'attribute_id' => 7,
				'attribute_group_id' => 3,
				'sort_order' => 4,
			),
			7 => 
			array (
				'attribute_id' => 8,
				'attribute_group_id' => 3,
				'sort_order' => 5,
			),
			8 => 
			array (
				'attribute_id' => 9,
				'attribute_group_id' => 3,
				'sort_order' => 6,
			),
			9 => 
			array (
				'attribute_id' => 10,
				'attribute_group_id' => 3,
				'sort_order' => 7,
			),
			10 => 
			array (
				'attribute_id' => 11,
				'attribute_group_id' => 3,
				'sort_order' => 8,
			),
		));
	}

}
