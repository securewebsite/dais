<?php

use Illuminate\Database\Seeder;

class OrderOptionTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('order_option')->delete();
        
	}

}
