<?php

use Illuminate\Database\Seeder;

class ReviewTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('review')->delete();
        
	}

}
