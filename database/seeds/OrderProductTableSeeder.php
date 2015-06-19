<?php

use Illuminate\Database\Seeder;

class OrderProductTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('order_product')->delete();
        
	}

}
