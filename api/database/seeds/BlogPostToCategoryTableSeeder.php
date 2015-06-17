<?php

use Illuminate\Database\Seeder;

class BlogPostToCategoryTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('blog_post_to_category')->delete();
        
		\DB::table('blog_post_to_category')->insert(array (
			0 => 
			array (
				'post_id' => 1,
				'category_id' => 1,
			),
			1 => 
			array (
				'post_id' => 1,
				'category_id' => 2,
			),
		));
	}

}
