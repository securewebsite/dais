<?php

use Illuminate\Database\Seeder;

class LengthClassTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('length_class')->delete();
        
		\DB::table('length_class')->insert(array (
			0 => 
			array (
				'length_class_id' => 1,
				'value' => '1.00000000',
			),
			1 => 
			array (
				'length_class_id' => 2,
				'value' => '10.00000000',
			),
			2 => 
			array (
				'length_class_id' => 3,
				'value' => '0.39370000',
			),
		));
	}

}
