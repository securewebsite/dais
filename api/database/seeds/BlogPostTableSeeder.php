<?php

use Illuminate\Database\Seeder;

class BlogPostTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('blog_post')->delete();
        
		\DB::table('blog_post')->insert(array (
			0 => 
			array (
				'post_id' => 1,
				'image' => 'data/blog/post/landscape-b.jpg',
				'author_id' => 1,
				'date_available' => '2014-08-19',
				'sort_order' => 1,
				'status' => 1,
				'visibility' => 1,
				'date_added' => '2014-08-20 06:34:50',
				'date_modified' => '2015-06-03 13:21:28',
				'viewed' => 302,
			),
		));
	}

}
