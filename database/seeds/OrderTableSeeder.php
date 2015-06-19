<?php

use Illuminate\Database\Seeder;

class OrderTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('order')->delete();
        
	}

}
