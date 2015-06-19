<?php

use Illuminate\Database\Seeder;

class ModuleTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('module')->delete();
        
		\DB::table('module')->insert(array (
			0 => 
			array (
				'module_id' => 22,
				'type' => 'total',
				'code' => 'shipping',
			),
			1 => 
			array (
				'module_id' => 58,
				'type' => 'total',
				'code' => 'tax',
			),
			2 => 
			array (
				'module_id' => 59,
				'type' => 'total',
				'code' => 'total',
			),
			3 => 
			array (
				'module_id' => 387,
				'type' => 'shipping',
				'code' => 'flat',
			),
			4 => 
			array (
				'module_id' => 390,
				'type' => 'total',
				'code' => 'credit',
			),
			5 => 
			array (
				'module_id' => 393,
				'type' => 'total',
				'code' => 'reward',
			),
			6 => 
			array (
				'module_id' => 408,
				'type' => 'widget',
				'code' => 'account',
			),
			7 => 
			array (
				'module_id' => 410,
				'type' => 'widget',
				'code' => 'banner',
			),
			8 => 
			array (
				'module_id' => 413,
				'type' => 'widget',
				'code' => 'category',
			),
			9 => 
			array (
				'module_id' => 426,
				'type' => 'widget',
				'code' => 'carousel',
			),
			10 => 
			array (
				'module_id' => 427,
				'type' => 'widget',
				'code' => 'featured',
			),
			11 => 
			array (
				'module_id' => 429,
				'type' => 'widget',
				'code' => 'masonry',
			),
			12 => 
			array (
				'module_id' => 430,
				'type' => 'widget',
				'code' => 'page',
			),
			13 => 
			array (
				'module_id' => 438,
				'type' => 'total',
				'code' => 'coupon',
			),
			14 => 
			array (
				'module_id' => 531,
				'type' => 'plugin',
				'code' => 'git',
			),
			15 => 
			array (
				'module_id' => 533,
				'type' => 'total',
				'code' => 'handling',
			),
			16 => 
			array (
				'module_id' => 540,
				'type' => 'widget',
				'code' => 'blog_category',
			),
			17 => 
			array (
				'module_id' => 542,
				'type' => 'widget',
				'code' => 'blog_featured',
			),
			18 => 
			array (
				'module_id' => 543,
				'type' => 'widget',
				'code' => 'blog_hot_topics',
			),
			19 => 
			array (
				'module_id' => 544,
				'type' => 'widget',
				'code' => 'blog_latest',
			),
			20 => 
			array (
				'module_id' => 545,
				'type' => 'widget',
				'code' => 'footer_blocks',
			),
			21 => 
			array (
				'module_id' => 546,
				'type' => 'widget',
				'code' => 'header_menu',
			),
			22 => 
			array (
				'module_id' => 547,
				'type' => 'widget',
				'code' => 'side_bar_menu',
			),
			23 => 
			array (
				'module_id' => 548,
				'type' => 'widget',
				'code' => 'slide_show',
			),
			24 => 
			array (
				'module_id' => 549,
				'type' => 'payment',
				'code' => 'free_checkout',
			),
			25 => 
			array (
				'module_id' => 550,
				'type' => 'total',
				'code' => 'sub_total',
			),
			26 => 
			array (
				'module_id' => 552,
				'type' => 'feed',
				'code' => 'google_site_map',
			),
			27 => 
			array (
				'module_id' => 553,
				'type' => 'feed',
				'code' => 'google_site_map',
			),
			28 => 
			array (
				'module_id' => 554,
				'type' => 'feed',
				'code' => 'google_base',
			),
			29 => 
			array (
				'module_id' => 556,
				'type' => 'plugin',
				'code' => 'example',
			),
		));
	}

}
