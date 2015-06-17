<?php

use Illuminate\Database\Seeder;

class PageToLayoutTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('page_to_layout')->delete();
        
	}

}
