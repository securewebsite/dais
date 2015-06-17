<?php

use Illuminate\Database\Seeder;

class CategoryDescriptionTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('category_description')->delete();
        
		\DB::table('category_description')->insert(array (
			0 => 
			array (
				'category_id' => 17,
				'language_id' => 1,
				'name' => 'Software',
				'description' => '&lt;p&gt;&lt;br&gt;&lt;/p&gt;',
				'meta_description' => '',
				'meta_keyword' => '',
			),
			1 => 
			array (
				'category_id' => 18,
				'language_id' => 1,
				'name' => 'Laptops &amp; Notebooks',
				'description' => '&lt;p&gt;
Shop Laptop feature only the best laptop deals on the market. By comparing laptop deals from the likes of PC World, Comet, Dixons, The Link and Carphone Warehouse, Shop Laptop has the most comprehensive selection of laptops on the internet. At Shop Laptop, we pride ourselves on offering customers the very best laptop deals. From refurbished laptops to netbooks, Shop Laptop ensures that every laptop - in every colour, style, size and technical spec - is featured on the site at the lowest possible price.
&lt;/p&gt;
',
				'meta_description' => 'Shop Laptop feature only the best laptop deals on the market. By comparing laptop deals from the likes of PC World, Comet, Dixons, The Link and Carphone Warehouse,.',
				'meta_keyword' => 'laptop, deals, laptop deals',
			),
			2 => 
			array (
				'category_id' => 20,
				'language_id' => 1,
				'name' => 'Desktops',
				'description' => '&lt;p&gt;Example of category description text&lt;/p&gt;
',
				'meta_description' => 'Example of category description',
				'meta_keyword' => '',
			),
			3 => 
			array (
				'category_id' => 24,
				'language_id' => 1,
				'name' => 'Phones &amp; PDAs',
				'description' => '&lt;p&gt;&lt;br&gt;&lt;/p&gt;',
				'meta_description' => '',
				'meta_keyword' => '',
			),
			4 => 
			array (
				'category_id' => 25,
				'language_id' => 1,
				'name' => 'Components',
				'description' => '&lt;p&gt;&lt;br&gt;&lt;/p&gt;',
				'meta_description' => '',
				'meta_keyword' => '',
			),
			5 => 
			array (
				'category_id' => 26,
				'language_id' => 1,
				'name' => 'PC',
				'description' => '&lt;p&gt;&lt;br&gt;&lt;/p&gt;',
				'meta_description' => '',
				'meta_keyword' => '',
			),
			6 => 
			array (
				'category_id' => 27,
				'language_id' => 1,
				'name' => 'Mac',
				'description' => '&lt;p&gt;&lt;br&gt;&lt;/p&gt;',
				'meta_description' => '',
				'meta_keyword' => '',
			),
			7 => 
			array (
				'category_id' => 28,
				'language_id' => 1,
				'name' => 'Monitors',
				'description' => '&lt;p&gt;&lt;br&gt;&lt;/p&gt;',
				'meta_description' => '',
				'meta_keyword' => '',
			),
			8 => 
			array (
				'category_id' => 29,
				'language_id' => 1,
				'name' => 'Mice and Trackballs',
				'description' => '&lt;p&gt;&lt;br&gt;&lt;/p&gt;',
				'meta_description' => '',
				'meta_keyword' => '',
			),
			9 => 
			array (
				'category_id' => 30,
				'language_id' => 1,
				'name' => 'Printers',
				'description' => '&lt;p&gt;&lt;br&gt;&lt;/p&gt;',
				'meta_description' => '',
				'meta_keyword' => '',
			),
			10 => 
			array (
				'category_id' => 31,
				'language_id' => 1,
				'name' => 'Scanners',
				'description' => '&lt;p&gt;&lt;br&gt;&lt;/p&gt;',
				'meta_description' => '',
				'meta_keyword' => '',
			),
			11 => 
			array (
				'category_id' => 32,
				'language_id' => 1,
				'name' => 'Web Cameras',
				'description' => '&lt;p&gt;&lt;br&gt;&lt;/p&gt;',
				'meta_description' => '',
				'meta_keyword' => '',
			),
			12 => 
			array (
				'category_id' => 33,
				'language_id' => 1,
				'name' => 'Cameras',
				'description' => '&lt;p&gt;&lt;br&gt;&lt;/p&gt;',
				'meta_description' => '',
				'meta_keyword' => '',
			),
			13 => 
			array (
				'category_id' => 34,
				'language_id' => 1,
				'name' => 'MP3 Players',
				'description' => '&lt;p&gt;Shop Laptop feature only the best laptop deals on the market. By comparing laptop deals from the likes of PC World, Comet, Dixons, The Link and Carphone Warehouse, Shop Laptop has the most comprehensive selection of laptops on the internet. At Shop Laptop, we pride ourselves on offering customers the very best laptop deals. From refurbished laptops to netbooks, Shop Laptop ensures that every laptop - in every colour, style, size and technical spec - is featured on the site at the lowest possible price.&lt;/p&gt;
',
				'meta_description' => '',
				'meta_keyword' => '',
			),
			14 => 
			array (
				'category_id' => 35,
				'language_id' => 1,
				'name' => 'test 1',
				'description' => '&lt;p&gt;&lt;br&gt;&lt;/p&gt;',
				'meta_description' => '',
				'meta_keyword' => '',
			),
			15 => 
			array (
				'category_id' => 36,
				'language_id' => 1,
				'name' => 'test 2',
				'description' => '&lt;p&gt;&lt;br&gt;&lt;/p&gt;',
				'meta_description' => '',
				'meta_keyword' => '',
			),
			16 => 
			array (
				'category_id' => 37,
				'language_id' => 1,
				'name' => 'test 5',
				'description' => '&lt;p&gt;&lt;br&gt;&lt;/p&gt;',
				'meta_description' => '',
				'meta_keyword' => '',
			),
			17 => 
			array (
				'category_id' => 38,
				'language_id' => 1,
				'name' => 'test 4',
				'description' => '&lt;p&gt;&lt;br&gt;&lt;/p&gt;',
				'meta_description' => '',
				'meta_keyword' => '',
			),
			18 => 
			array (
				'category_id' => 39,
				'language_id' => 1,
				'name' => 'test 6',
				'description' => '&lt;p&gt;&lt;br&gt;&lt;/p&gt;',
				'meta_description' => '',
				'meta_keyword' => '',
			),
			19 => 
			array (
				'category_id' => 40,
				'language_id' => 1,
				'name' => 'test 7',
				'description' => '&lt;p&gt;&lt;br&gt;&lt;/p&gt;',
				'meta_description' => '',
				'meta_keyword' => '',
			),
			20 => 
			array (
				'category_id' => 41,
				'language_id' => 1,
				'name' => 'test 8',
				'description' => '&lt;p&gt;&lt;br&gt;&lt;/p&gt;',
				'meta_description' => '',
				'meta_keyword' => '',
			),
			21 => 
			array (
				'category_id' => 42,
				'language_id' => 1,
				'name' => 'test 9',
				'description' => '&lt;p&gt;&lt;br&gt;&lt;/p&gt;',
				'meta_description' => '',
				'meta_keyword' => '',
			),
			22 => 
			array (
				'category_id' => 43,
				'language_id' => 1,
				'name' => 'test 11',
				'description' => '&lt;p&gt;&lt;br&gt;&lt;/p&gt;',
				'meta_description' => '',
				'meta_keyword' => '',
			),
			23 => 
			array (
				'category_id' => 44,
				'language_id' => 1,
				'name' => 'test 12',
				'description' => '&lt;p&gt;&lt;br&gt;&lt;/p&gt;',
				'meta_description' => '',
				'meta_keyword' => '',
			),
			24 => 
			array (
				'category_id' => 45,
				'language_id' => 1,
				'name' => 'Windows',
				'description' => '&lt;p&gt;&lt;br&gt;&lt;/p&gt;',
				'meta_description' => '',
				'meta_keyword' => '',
			),
			25 => 
			array (
				'category_id' => 46,
				'language_id' => 1,
				'name' => 'Macs',
			'description' => '&lt;p&gt;&lt;span style=&quot;color: rgb(33, 36, 37);&quot;&gt;Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. &lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;color: rgb(33, 36, 37);&quot;&gt;It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.&lt;/span&gt;&lt;br&gt;&lt;/p&gt;',
				'meta_description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an.',
				'meta_keyword' => 'industry, dummy, ipsum, lorem, dummy text, lorem ipsum',
			),
			26 => 
			array (
				'category_id' => 47,
				'language_id' => 1,
				'name' => 'test 15',
				'description' => '&lt;p&gt;&lt;br&gt;&lt;/p&gt;',
				'meta_description' => '',
				'meta_keyword' => '',
			),
			27 => 
			array (
				'category_id' => 48,
				'language_id' => 1,
				'name' => 'test 16',
				'description' => '&lt;p&gt;&lt;br&gt;&lt;/p&gt;',
				'meta_description' => '',
				'meta_keyword' => '',
			),
			28 => 
			array (
				'category_id' => 49,
				'language_id' => 1,
				'name' => 'test 17',
				'description' => '&lt;p&gt;&lt;br&gt;&lt;/p&gt;',
				'meta_description' => '',
				'meta_keyword' => '',
			),
			29 => 
			array (
				'category_id' => 50,
				'language_id' => 1,
				'name' => 'test 18',
				'description' => '&lt;p&gt;&lt;br&gt;&lt;/p&gt;',
				'meta_description' => '',
				'meta_keyword' => '',
			),
			30 => 
			array (
				'category_id' => 51,
				'language_id' => 1,
				'name' => 'test 19',
				'description' => '&lt;p&gt;&lt;br&gt;&lt;/p&gt;',
				'meta_description' => '',
				'meta_keyword' => '',
			),
			31 => 
			array (
				'category_id' => 52,
				'language_id' => 1,
				'name' => 'test 20',
				'description' => '&lt;p&gt;&lt;br&gt;&lt;/p&gt;',
				'meta_description' => '',
				'meta_keyword' => '',
			),
			32 => 
			array (
				'category_id' => 53,
				'language_id' => 1,
				'name' => 'test 21',
				'description' => '&lt;p&gt;&lt;br&gt;&lt;/p&gt;',
				'meta_description' => '',
				'meta_keyword' => '',
			),
			33 => 
			array (
				'category_id' => 54,
				'language_id' => 1,
				'name' => 'test 22',
				'description' => '&lt;p&gt;&lt;br&gt;&lt;/p&gt;',
				'meta_description' => '',
				'meta_keyword' => '',
			),
			34 => 
			array (
				'category_id' => 55,
				'language_id' => 1,
				'name' => 'test 23',
				'description' => '&lt;p&gt;&lt;br&gt;&lt;/p&gt;',
				'meta_description' => '',
				'meta_keyword' => '',
			),
			35 => 
			array (
				'category_id' => 56,
				'language_id' => 1,
				'name' => 'test 24',
				'description' => '&lt;p&gt;&lt;br&gt;&lt;/p&gt;',
				'meta_description' => '',
				'meta_keyword' => '',
			),
			36 => 
			array (
				'category_id' => 57,
				'language_id' => 1,
				'name' => 'Tablets',
				'description' => '&lt;p&gt;&lt;br&gt;&lt;/p&gt;',
				'meta_description' => '',
				'meta_keyword' => '',
			),
			37 => 
			array (
				'category_id' => 58,
				'language_id' => 1,
				'name' => 'test 25',
				'description' => '&lt;p&gt;&lt;br&gt;&lt;/p&gt;',
				'meta_description' => '',
				'meta_keyword' => '',
			),
			38 => 
			array (
				'category_id' => 59,
				'language_id' => 1,
				'name' => 'Live Events',
				'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus feugiat dui a odio facilisis porta commodo ut ligula. Nullam ligula urna, blandit vel justo eu, tristique tempor nisl. Nam ornare auctor enim vel venenatis. &lt;div&gt;&lt;br&gt;&lt;/div&gt;&lt;div&gt;Duis et elit augue. Nulla auctor nunc et ultrices lobortis. Donec ultricies, metus quis convallis tincidunt, nisl nibh molestie tortor, et accumsan turpis nulla rhoncus libero. Donec hendrerit enim ut lectus condimentum malesuada.&lt;/div&gt;',
				'meta_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus feugiat dui a odio facilisis porta commodo ut ligula. Nullam ligula urna, blandit vel justo eu,.',
				'meta_keyword' => 'ligula',
			),
		));
	}

}
