<?php

use Illuminate\Database\Seeder;

class OptionTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('option')->delete();
        
		\DB::table('option')->insert(array (
			0 => 
			array (
				'option_id' => 1,
				'type' => 'radio',
				'sort_order' => 2,
			),
			1 => 
			array (
				'option_id' => 2,
				'type' => 'checkbox',
				'sort_order' => 3,
			),
			2 => 
			array (
				'option_id' => 4,
				'type' => 'text',
				'sort_order' => 4,
			),
			3 => 
			array (
				'option_id' => 5,
				'type' => 'select',
				'sort_order' => 1,
			),
			4 => 
			array (
				'option_id' => 6,
				'type' => 'textarea',
				'sort_order' => 5,
			),
			5 => 
			array (
				'option_id' => 7,
				'type' => 'file',
				'sort_order' => 6,
			),
			6 => 
			array (
				'option_id' => 8,
				'type' => 'date',
				'sort_order' => 7,
			),
			7 => 
			array (
				'option_id' => 9,
				'type' => 'time',
				'sort_order' => 8,
			),
			8 => 
			array (
				'option_id' => 10,
				'type' => 'datetime',
				'sort_order' => 9,
			),
			9 => 
			array (
				'option_id' => 11,
				'type' => 'select',
				'sort_order' => 1,
			),
			10 => 
			array (
				'option_id' => 12,
				'type' => 'date',
				'sort_order' => 1,
			),
		));
	}

}
