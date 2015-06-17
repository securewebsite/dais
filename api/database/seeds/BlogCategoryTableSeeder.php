<?php

use Illuminate\Database\Seeder;

class BlogCategoryTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('blog_category')->delete();
        
		\DB::table('blog_category')->insert(array (
			0 => 
			array (
				'category_id' => 1,
				'image' => '',
				'parent_id' => 0,
				'top' => 0,
				'columns' => 0,
				'sort_order' => 0,
				'status' => 1,
				'date_added' => '2014-08-20 04:58:59',
				'date_modified' => '2015-06-03 13:18:33',
			),
			1 => 
			array (
				'category_id' => 2,
				'image' => 'data/blog/category/landscape-a.jpg',
				'parent_id' => 1,
				'top' => 0,
				'columns' => 0,
				'sort_order' => 0,
				'status' => 1,
				'date_added' => '2014-08-22 17:04:52',
				'date_modified' => '2015-06-03 13:18:37',
			),
		));
	}

}
