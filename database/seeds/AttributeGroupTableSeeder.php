<?php

use Illuminate\Database\Seeder;

class AttributeGroupTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('attribute_group')->delete();
        
		\DB::table('attribute_group')->insert(array (
			0 => 
			array (
				'attribute_group_id' => 3,
				'sort_order' => 2,
			),
			1 => 
			array (
				'attribute_group_id' => 4,
				'sort_order' => 1,
			),
			2 => 
			array (
				'attribute_group_id' => 5,
				'sort_order' => 3,
			),
			3 => 
			array (
				'attribute_group_id' => 6,
				'sort_order' => 4,
			),
		));
	}

}
