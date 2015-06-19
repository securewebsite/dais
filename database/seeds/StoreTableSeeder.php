<?php

use Illuminate\Database\Seeder;

class StoreTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('store')->delete();
        
	}

}
