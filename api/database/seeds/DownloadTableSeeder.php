<?php

use Illuminate\Database\Seeder;

class DownloadTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('download')->delete();
        
	}

}
