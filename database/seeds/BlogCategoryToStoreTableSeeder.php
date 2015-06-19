<?php

use Illuminate\Database\Seeder;

class BlogCategoryToStoreTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('blog_category_to_store')->delete();
        
		\DB::table('blog_category_to_store')->insert(array (
			0 => 
			array (
				'category_id' => 1,
				'store_id' => 0,
			),
			1 => 
			array (
				'category_id' => 2,
				'store_id' => 0,
			),
		));
	}

}
