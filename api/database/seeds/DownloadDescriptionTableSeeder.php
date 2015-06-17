<?php

use Illuminate\Database\Seeder;

class DownloadDescriptionTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('download_description')->delete();
        
	}

}
