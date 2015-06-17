<?php

use Illuminate\Database\Seeder;

class BlogPostToLayoutTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('blog_post_to_layout')->delete();
        
	}

}
