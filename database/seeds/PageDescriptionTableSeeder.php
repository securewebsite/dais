<?php

use Illuminate\Database\Seeder;

class PageDescriptionTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('page_description')->delete();
        
		\DB::table('page_description')->insert(array (
			0 => 
			array (
				'page_id' => 3,
				'language_id' => 1,
				'title' => 'Privacy Policy',
				'description' => '&lt;p&gt;Privacy Policy&lt;/p&gt;
',
				'meta_description' => '',
				'meta_keywords' => '',
			),
			1 => 
			array (
				'page_id' => 4,
				'language_id' => 1,
				'title' => 'About Us',
				'description' => '&lt;p&gt;

About Us

&lt;/p&gt;',
				'meta_description' => 'About Us',
				'meta_keywords' => 'about us',
			),
			2 => 
			array (
				'page_id' => 5,
				'language_id' => 1,
				'title' => 'Terms &amp; Conditions',
				'description' => '&lt;p&gt;Terms &amp; Conditions&lt;/p&gt;
',
				'meta_description' => '',
				'meta_keywords' => '',
			),
			3 => 
			array (
				'page_id' => 6,
				'language_id' => 1,
				'title' => 'Delivery Information',
				'description' => '&lt;p&gt;Delivery Information&lt;/p&gt;
',
				'meta_description' => '',
				'meta_keywords' => '',
			),
			4 => 
			array (
				'page_id' => 7,
				'language_id' => 1,
				'title' => 'Return Policy',
				'description' => '&lt;p&gt;Your return policy here.&lt;/p&gt;
',
				'meta_description' => '',
				'meta_keywords' => '',
			),
			5 => 
			array (
				'page_id' => 8,
				'language_id' => 1,
				'title' => 'Affiliate Terms',
				'description' => '&lt;p&gt;Affiliate terms go here.&lt;/p&gt;
',
				'meta_description' => '',
				'meta_keywords' => '',
			),
			6 => 
			array (
				'page_id' => 11,
				'language_id' => 1,
				'title' => 'Online Webinar',
				'description' => 'Once the event is created, you cannot switch from a product to a page or vice-versa. If you want to switch, you must delete the entire event and start over. &lt;div&gt;&lt;br&gt;&lt;/div&gt;&lt;div&gt;Keep in mind that this will delete all data for the event including anyone who is already registered.&lt;/div&gt;&lt;div&gt;&lt;br&gt;&lt;/div&gt;&lt;div&gt;And here\'s another line of text.&lt;/div&gt;&lt;div&gt;&lt;br&gt;&lt;/div&gt;&lt;div&gt;More text.&lt;/div&gt;',
				'meta_description' => '',
				'meta_keywords' => '',
			),
		));
	}

}
