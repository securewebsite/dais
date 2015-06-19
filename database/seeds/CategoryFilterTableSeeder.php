<?php

use Illuminate\Database\Seeder;

class CategoryFilterTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('category_filter')->delete();
        
	}

}
