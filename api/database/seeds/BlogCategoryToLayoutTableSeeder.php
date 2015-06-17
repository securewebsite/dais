<?php

use Illuminate\Database\Seeder;

class BlogCategoryToLayoutTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('blog_category_to_layout')->delete();
        
	}

}
