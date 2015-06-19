<?php

use Illuminate\Database\Seeder;

class ProductToDownloadTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('product_to_download')->delete();
        
	}

}
