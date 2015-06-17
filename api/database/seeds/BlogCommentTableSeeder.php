<?php

use Illuminate\Database\Seeder;

class BlogCommentTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('blog_comment')->delete();
        
	}

}
