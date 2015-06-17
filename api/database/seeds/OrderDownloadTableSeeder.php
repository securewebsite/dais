<?php

use Illuminate\Database\Seeder;

class OrderDownloadTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('order_download')->delete();
        
	}

}
