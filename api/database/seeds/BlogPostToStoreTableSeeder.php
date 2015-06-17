<?php

use Illuminate\Database\Seeder;

class BlogPostToStoreTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('blog_post_to_store')->delete();
        
		\DB::table('blog_post_to_store')->insert(array (
			0 => 
			array (
				'post_id' => 1,
				'store_id' => 0,
			),
		));
	}

}
