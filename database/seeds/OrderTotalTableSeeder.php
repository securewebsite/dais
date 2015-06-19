<?php

use Illuminate\Database\Seeder;

class OrderTotalTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('order_total')->delete();
        
	}

}
