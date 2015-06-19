<?php

use Illuminate\Database\Seeder;

class BlogPostRelatedTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('blog_post_related')->delete();
        
	}

}
