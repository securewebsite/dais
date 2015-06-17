<?php

use Illuminate\Database\Seeder;

class WeightClassTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('weight_class')->delete();
        
		\DB::table('weight_class')->insert(array (
			0 => 
			array (
				'weight_class_id' => 1,
				'value' => '1.00000000',
			),
			1 => 
			array (
				'weight_class_id' => 2,
				'value' => '1000.00000000',
			),
			2 => 
			array (
				'weight_class_id' => 5,
				'value' => '2.20460000',
			),
			3 => 
			array (
				'weight_class_id' => 6,
				'value' => '35.27400000',
			),
		));
	}

}
