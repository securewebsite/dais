<?php

use Illuminate\Database\Seeder;

class BlogCategoryDescriptionTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('blog_category_description')->delete();
        
		\DB::table('blog_category_description')->insert(array (
			0 => 
			array (
				'category_id' => 1,
				'language_id' => 1,
				'name' => 'General',
				'description' => '&lt;p&gt;This is the general category for all things general.&lt;/p&gt;',
				'meta_description' => 'This is the general category for all things general.',
				'meta_keyword' => 'general',
			),
			1 => 
			array (
				'category_id' => 2,
				'language_id' => 1,
				'name' => 'Latest Product News',
				'description' => '&lt;p&gt;
Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
&lt;/p&gt;',
				'meta_description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an.',
				'meta_keyword' => 'industry, dummy, ipsum, lorem, dummy text, lorem ipsum',
			),
		));
	}

}
