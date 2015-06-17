<?php

use Illuminate\Database\Seeder;

class BlogPostImageTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('blog_post_image')->delete();
        
	}

}
