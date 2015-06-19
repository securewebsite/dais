<?php

use Illuminate\Database\Seeder;

class RouteTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('route')->delete();
        
		\DB::table('route')->insert(array (
			0 => 
			array (
				'route_id' => 1020,
				'route' => 'catalog/category',
				'query' => 'category_id:33',
				'slug' => 'cameras',
			),
			1 => 
			array (
				'route_id' => 1021,
				'route' => 'catalog/category',
				'query' => 'category_id:25',
				'slug' => 'components',
			),
			2 => 
			array (
				'route_id' => 1022,
				'route' => 'catalog/category',
				'query' => 'category_id:29',
				'slug' => 'mice-and-trackballs',
			),
			3 => 
			array (
				'route_id' => 1023,
				'route' => 'catalog/category',
				'query' => 'category_id:28',
				'slug' => 'monitors',
			),
			4 => 
			array (
				'route_id' => 1024,
				'route' => 'catalog/category',
				'query' => 'category_id:35',
				'slug' => 'test-1',
			),
			5 => 
			array (
				'route_id' => 1025,
				'route' => 'catalog/category',
				'query' => 'category_id:36',
				'slug' => 'test-2',
			),
			6 => 
			array (
				'route_id' => 1026,
				'route' => 'catalog/category',
				'query' => 'category_id:30',
				'slug' => 'printers',
			),
			7 => 
			array (
				'route_id' => 1027,
				'route' => 'catalog/category',
				'query' => 'category_id:31',
				'slug' => 'scanners',
			),
			8 => 
			array (
				'route_id' => 1028,
				'route' => 'catalog/category',
				'query' => 'category_id:32',
				'slug' => 'web-cameras',
			),
			9 => 
			array (
				'route_id' => 1029,
				'route' => 'catalog/category',
				'query' => 'category_id:20',
				'slug' => 'desktops',
			),
			10 => 
			array (
				'route_id' => 1030,
				'route' => 'catalog/category',
				'query' => 'category_id:27',
				'slug' => 'mac',
			),
			11 => 
			array (
				'route_id' => 1031,
				'route' => 'catalog/category',
				'query' => 'category_id:26',
				'slug' => 'pc',
			),
			12 => 
			array (
				'route_id' => 1032,
				'route' => 'catalog/category',
				'query' => 'category_id:18',
				'slug' => 'laptops-and-notebooks',
			),
			13 => 
			array (
				'route_id' => 1033,
				'route' => 'catalog/category',
				'query' => 'category_id:46',
				'slug' => 'macs',
			),
			14 => 
			array (
				'route_id' => 1034,
				'route' => 'catalog/category',
				'query' => 'category_id:45',
				'slug' => 'windows',
			),
			15 => 
			array (
				'route_id' => 1035,
				'route' => 'catalog/category',
				'query' => 'category_id:59',
				'slug' => 'live-events',
			),
			16 => 
			array (
				'route_id' => 1037,
				'route' => 'catalog/category',
				'query' => 'category_id:34',
				'slug' => 'mp3-players',
			),
			17 => 
			array (
				'route_id' => 1038,
				'route' => 'catalog/category',
				'query' => 'category_id:43',
				'slug' => 'test-11',
			),
			18 => 
			array (
				'route_id' => 1039,
				'route' => 'catalog/category',
				'query' => 'category_id:44',
				'slug' => 'test-12',
			),
			19 => 
			array (
				'route_id' => 1040,
				'route' => 'catalog/category',
				'query' => 'category_id:47',
				'slug' => 'test-15',
			),
			20 => 
			array (
				'route_id' => 1041,
				'route' => 'catalog/category',
				'query' => 'category_id:48',
				'slug' => 'test-16',
			),
			21 => 
			array (
				'route_id' => 1042,
				'route' => 'catalog/category',
				'query' => 'category_id:49',
				'slug' => 'test-17',
			),
			22 => 
			array (
				'route_id' => 1043,
				'route' => 'catalog/category',
				'query' => 'category_id:50',
				'slug' => 'test-18',
			),
			23 => 
			array (
				'route_id' => 1044,
				'route' => 'catalog/category',
				'query' => 'category_id:51',
				'slug' => 'test-19',
			),
			24 => 
			array (
				'route_id' => 1045,
				'route' => 'catalog/category',
				'query' => 'category_id:52',
				'slug' => 'test-20',
			),
			25 => 
			array (
				'route_id' => 1046,
				'route' => 'catalog/category',
				'query' => 'category_id:58',
				'slug' => 'test-25',
			),
			26 => 
			array (
				'route_id' => 1048,
				'route' => 'catalog/category',
				'query' => 'category_id:53',
				'slug' => 'test-21',
			),
			27 => 
			array (
				'route_id' => 1049,
				'route' => 'catalog/category',
				'query' => 'category_id:54',
				'slug' => 'test-22',
			),
			28 => 
			array (
				'route_id' => 1050,
				'route' => 'catalog/category',
				'query' => 'category_id:55',
				'slug' => 'test-23',
			),
			29 => 
			array (
				'route_id' => 1051,
				'route' => 'catalog/category',
				'query' => 'category_id:56',
				'slug' => 'test-24',
			),
			30 => 
			array (
				'route_id' => 1052,
				'route' => 'catalog/category',
				'query' => 'category_id:38',
				'slug' => 'test-4',
			),
			31 => 
			array (
				'route_id' => 1053,
				'route' => 'catalog/category',
				'query' => 'category_id:37',
				'slug' => 'test-5',
			),
			32 => 
			array (
				'route_id' => 1054,
				'route' => 'catalog/category',
				'query' => 'category_id:39',
				'slug' => 'test-6',
			),
			33 => 
			array (
				'route_id' => 1055,
				'route' => 'catalog/category',
				'query' => 'category_id:40',
				'slug' => 'test-7',
			),
			34 => 
			array (
				'route_id' => 1056,
				'route' => 'catalog/category',
				'query' => 'category_id:41',
				'slug' => 'test-8',
			),
			35 => 
			array (
				'route_id' => 1057,
				'route' => 'catalog/category',
				'query' => 'category_id:42',
				'slug' => 'test-9',
			),
			36 => 
			array (
				'route_id' => 1059,
				'route' => 'catalog/category',
				'query' => 'category_id:24',
				'slug' => 'phones-and-pdas',
			),
			37 => 
			array (
				'route_id' => 1060,
				'route' => 'catalog/category',
				'query' => 'category_id:17',
				'slug' => 'software',
			),
			38 => 
			array (
				'route_id' => 1061,
				'route' => 'catalog/category',
				'query' => 'category_id:57',
				'slug' => 'tablets',
			),
			39 => 
			array (
				'route_id' => 1062,
				'route' => 'catalog/manufacturer/info',
				'query' => 'manufacturer_id:8',
				'slug' => 'apple',
			),
			40 => 
			array (
				'route_id' => 1063,
				'route' => 'catalog/manufacturer/info',
				'query' => 'manufacturer_id:9',
				'slug' => 'canon',
			),
			41 => 
			array (
				'route_id' => 1064,
				'route' => 'catalog/manufacturer/info',
				'query' => 'manufacturer_id:7',
				'slug' => 'hewlett-packard',
			),
			42 => 
			array (
				'route_id' => 1066,
				'route' => 'catalog/manufacturer/info',
				'query' => 'manufacturer_id:5',
				'slug' => 'htc',
			),
			43 => 
			array (
				'route_id' => 1067,
				'route' => 'catalog/manufacturer/info',
				'query' => 'manufacturer_id:6',
				'slug' => 'palm',
			),
			44 => 
			array (
				'route_id' => 1068,
				'route' => 'catalog/manufacturer/info',
				'query' => 'manufacturer_id:11',
				'slug' => 'solution-labs',
			),
			45 => 
			array (
				'route_id' => 1069,
				'route' => 'catalog/manufacturer/info',
				'query' => 'manufacturer_id:10',
				'slug' => 'sony',
			),
			46 => 
			array (
				'route_id' => 1091,
				'route' => 'catalog/product',
				'query' => 'product_id:42',
				'slug' => 'apple-cinema-30-inch',
			),
			47 => 
			array (
				'route_id' => 1092,
				'route' => 'catalog/product',
				'query' => 'product_id:30',
				'slug' => 'canon-eos-5d',
			),
			48 => 
			array (
				'route_id' => 1093,
				'route' => 'catalog/product',
				'query' => 'product_id:50',
				'slug' => 'daisio-live-conference-2015',
			),
			49 => 
			array (
				'route_id' => 1094,
				'route' => 'catalog/product',
				'query' => 'product_id:47',
				'slug' => 'hp-lp3065',
			),
			50 => 
			array (
				'route_id' => 1095,
				'route' => 'catalog/product',
				'query' => 'product_id:28',
				'slug' => 'htc-touch-hd',
			),
			51 => 
			array (
				'route_id' => 1096,
				'route' => 'catalog/product',
				'query' => 'product_id:41',
				'slug' => 'imac',
			),
			52 => 
			array (
				'route_id' => 1097,
				'route' => 'catalog/product',
				'query' => 'product_id:40',
				'slug' => 'iphone',
			),
			53 => 
			array (
				'route_id' => 1098,
				'route' => 'catalog/product',
				'query' => 'product_id:48',
				'slug' => 'ipod-classic',
			),
			54 => 
			array (
				'route_id' => 1099,
				'route' => 'catalog/product',
				'query' => 'product_id:36',
				'slug' => 'ipod-nano',
			),
			55 => 
			array (
				'route_id' => 1100,
				'route' => 'catalog/product',
				'query' => 'product_id:34',
				'slug' => 'ipod-shuffle',
			),
			56 => 
			array (
				'route_id' => 1101,
				'route' => 'catalog/product',
				'query' => 'product_id:32',
				'slug' => 'ipod-touch',
			),
			57 => 
			array (
				'route_id' => 1102,
				'route' => 'catalog/product',
				'query' => 'product_id:43',
				'slug' => 'macbook',
			),
			58 => 
			array (
				'route_id' => 1103,
				'route' => 'catalog/product',
				'query' => 'product_id:44',
				'slug' => 'macbook-air',
			),
			59 => 
			array (
				'route_id' => 1104,
				'route' => 'catalog/product',
				'query' => 'product_id:45',
				'slug' => 'macbook-pro',
			),
			60 => 
			array (
				'route_id' => 1105,
				'route' => 'catalog/product',
				'query' => 'product_id:31',
				'slug' => 'nikon-d300',
			),
			61 => 
			array (
				'route_id' => 1106,
				'route' => 'catalog/product',
				'query' => 'product_id:29',
				'slug' => 'palm-treo-pro',
			),
			62 => 
			array (
				'route_id' => 1107,
				'route' => 'catalog/product',
				'query' => 'product_id:49',
				'slug' => 'samsung-galaxy-tab-10-1',
			),
			63 => 
			array (
				'route_id' => 1108,
				'route' => 'catalog/product',
				'query' => 'product_id:33',
				'slug' => 'samsung-syncmaster-941bw',
			),
			64 => 
			array (
				'route_id' => 1109,
				'route' => 'catalog/product',
				'query' => 'product_id:46',
				'slug' => 'sony-vaio',
			),
			65 => 
			array (
				'route_id' => 1110,
				'route' => 'content/page',
				'query' => 'page_id:4',
				'slug' => 'about-us',
			),
			66 => 
			array (
				'route_id' => 1111,
				'route' => 'content/page',
				'query' => 'page_id:8',
				'slug' => 'affiliate-terms',
			),
			67 => 
			array (
				'route_id' => 1112,
				'route' => 'content/page',
				'query' => 'page_id:6',
				'slug' => 'delivery-information',
			),
			68 => 
			array (
				'route_id' => 1113,
				'route' => 'event/page',
				'query' => 'event_page_id:11',
				'slug' => 'online-webinar',
			),
			69 => 
			array (
				'route_id' => 1114,
				'route' => 'content/page',
				'query' => 'page_id:3',
				'slug' => 'privacy-policy',
			),
			70 => 
			array (
				'route_id' => 1115,
				'route' => 'content/page',
				'query' => 'page_id:7',
				'slug' => 'return-policy',
			),
			71 => 
			array (
				'route_id' => 1116,
				'route' => 'content/page',
				'query' => 'page_id:5',
				'slug' => 'terms-and-conditions',
			),
			72 => 
			array (
				'route_id' => 1117,
				'route' => 'content/category',
				'query' => 'blog_category_id:1',
				'slug' => 'general',
			),
			73 => 
			array (
				'route_id' => 1118,
				'route' => 'content/category',
				'query' => 'blog_category_id:2',
				'slug' => 'latest-product-news',
			),
			74 => 
			array (
				'route_id' => 1119,
				'route' => 'content/post',
				'query' => 'post_id:1',
				'slug' => 'lorem-ipsum-test-post',
			),
		));
	}

}
