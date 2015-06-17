<?php

use Illuminate\Database\Seeder;

class ReturnTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('return')->delete();
        
	}

}
