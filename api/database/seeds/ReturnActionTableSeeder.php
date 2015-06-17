<?php

use Illuminate\Database\Seeder;

class ReturnActionTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('return_action')->delete();
        
		\DB::table('return_action')->insert(array (
			0 => 
			array (
				'return_action_id' => 1,
				'language_id' => 1,
				'name' => 'Refunded',
			),
			1 => 
			array (
				'return_action_id' => 2,
				'language_id' => 1,
				'name' => 'Credit Issued',
			),
			2 => 
			array (
				'return_action_id' => 3,
				'language_id' => 1,
				'name' => 'Replacement Sent',
			),
		));
	}

}
