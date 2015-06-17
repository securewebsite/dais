<?php

use Illuminate\Database\Seeder;

class CategoryToLayoutTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('category_to_layout')->delete();
        
	}

}
