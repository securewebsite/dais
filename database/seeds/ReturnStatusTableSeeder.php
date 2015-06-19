<?php

use Illuminate\Database\Seeder;

class ReturnStatusTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('return_status')->delete();
        
		\DB::table('return_status')->insert(array (
			0 => 
			array (
				'return_status_id' => 1,
				'language_id' => 1,
				'name' => 'Pending',
			),
			1 => 
			array (
				'return_status_id' => 2,
				'language_id' => 1,
				'name' => 'Awaiting Products',
			),
			2 => 
			array (
				'return_status_id' => 3,
				'language_id' => 1,
				'name' => 'Complete',
			),
		));
	}

}
