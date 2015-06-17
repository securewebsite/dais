<?php

use Illuminate\Database\Seeder;

class MenuTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('menu')->delete();
        
		\DB::table('menu')->insert(array (
			0 => 
			array (
				'menu_id' => 3,
				'name' => 'Blog Header Menu',
				'type' => 'content_category',
				'items' => 'a:2:{i:0;s:1:"1";i:1;s:1:"2";}',
				'status' => 1,
			),
			1 => 
			array (
				'menu_id' => 4,
				'name' => 'Blog Header Pages',
				'type' => 'page',
				'items' => 'a:6:{i:0;s:1:"4";i:1;s:1:"8";i:2;s:1:"6";i:3;s:1:"3";i:4;s:1:"7";i:5;s:1:"5";}',
				'status' => 1,
			),
			2 => 
			array (
				'menu_id' => 5,
				'name' => 'Info',
				'type' => 'page',
				'items' => 'a:4:{i:0;s:1:"4";i:1;s:1:"6";i:2;s:1:"3";i:3;s:1:"5";}',
				'status' => 1,
			),
			3 => 
			array (
				'menu_id' => 7,
				'name' => 'Customer Service',
				'type' => 'custom',
				'items' => 'a:3:{i:0;a:2:{s:4:"href";s:15:"content/contact";s:4:"name";s:10:"Contact Us";}i:1;a:2:{s:4:"href";s:22:"account/returns/insert";s:4:"name";s:7:"Returns";}i:2;a:2:{s:4:"href";s:15:"content/sitemap";s:4:"name";s:7:"Sitemap";}}',
				'status' => 1,
			),
			4 => 
			array (
				'menu_id' => 8,
				'name' => 'Extras',
				'type' => 'custom',
				'items' => 'a:4:{i:0;a:2:{s:4:"href";s:20:"catalog/manufacturer";s:4:"name";s:6:"Brands";}i:1;a:2:{s:4:"href";s:16:"account/giftcard";s:4:"name";s:10:"Gift Cards";}i:2;a:2:{s:4:"href";s:15:"catalog/special";s:4:"name";s:8:"Specials";}i:3;a:2:{s:4:"href";s:8:"calendar";s:4:"name";s:8:"Calendar";}}',
				'status' => 1,
			),
			5 => 
			array (
				'menu_id' => 10,
				'name' => 'Posts',
				'type' => 'post',
				'items' => 'a:1:{i:0;s:1:"1";}',
				'status' => 1,
			),
			6 => 
			array (
				'menu_id' => 13,
				'name' => 'Account',
				'type' => 'custom',
				'items' => 'a:4:{i:0;a:2:{s:4:"href";s:17:"account/dashboard";s:4:"name";s:9:"Dashboard";}i:1;a:2:{s:4:"href";s:13:"account/order";s:4:"name";s:13:"Order History";}i:2;a:2:{s:4:"href";s:16:"account/wishlist";s:4:"name";s:8:"Wishlist";}i:3;a:2:{s:4:"href";s:18:"account/newsletter";s:4:"name";s:10:"Newsletter";}}',
				'status' => 1,
			),
			7 => 
			array (
				'menu_id' => 14,
				'name' => 'Blog Categories',
				'type' => 'content_category',
				'items' => 'a:2:{i:0;s:1:"1";i:1;s:1:"2";}',
				'status' => 1,
			),
			8 => 
			array (
				'menu_id' => 15,
				'name' => 'Product Categories',
				'type' => 'product_category',
				'items' => 'a:37:{i:0;s:2:"33";i:1;s:2:"25";i:2;s:2:"29";i:3;s:2:"28";i:4;s:2:"35";i:5;s:2:"36";i:6;s:2:"30";i:7;s:2:"31";i:8;s:2:"32";i:9;s:2:"20";i:10;s:2:"27";i:11;s:2:"26";i:12;s:2:"18";i:13;s:2:"46";i:14;s:2:"45";i:15;s:2:"34";i:16;s:2:"43";i:17;s:2:"44";i:18;s:2:"47";i:19;s:2:"48";i:20;s:2:"49";i:21;s:2:"50";i:22;s:2:"51";i:23;s:2:"52";i:24;s:2:"58";i:25;s:2:"53";i:26;s:2:"54";i:27;s:2:"55";i:28;s:2:"56";i:29;s:2:"38";i:30;s:2:"37";i:31;s:2:"39";i:32;s:2:"40";i:33;s:2:"41";i:34;s:2:"42";i:35;s:2:"24";i:36;s:2:"57";}',
				'status' => 1,
			),
			9 => 
			array (
				'menu_id' => 16,
				'name' => 'Our Friends',
				'type' => 'custom',
				'items' => 'a:4:{i:0;a:2:{s:4:"href";s:21:"http://www.google.com";s:4:"name";s:6:"Google";}i:1;a:2:{s:4:"href";s:23:"http://www.facebook.com";s:4:"name";s:8:"Facebook";}i:2;a:2:{s:4:"href";s:18:"http://twitter.com";s:4:"name";s:7:"Twitter";}i:3;a:2:{s:4:"href";s:20:"http://instagram.com";s:4:"name";s:9:"Instagram";}}',
				'status' => 1,
			),
			10 => 
			array (
				'menu_id' => 17,
				'name' => 'Shop Header',
				'type' => 'product_category',
				'items' => 'a:37:{i:0;s:2:"33";i:1;s:2:"25";i:2;s:2:"29";i:3;s:2:"28";i:4;s:2:"35";i:5;s:2:"36";i:6;s:2:"30";i:7;s:2:"31";i:8;s:2:"32";i:9;s:2:"20";i:10;s:2:"27";i:11;s:2:"26";i:12;s:2:"18";i:13;s:2:"46";i:14;s:2:"45";i:15;s:2:"34";i:16;s:2:"43";i:17;s:2:"44";i:18;s:2:"47";i:19;s:2:"48";i:20;s:2:"49";i:21;s:2:"50";i:22;s:2:"51";i:23;s:2:"52";i:24;s:2:"58";i:25;s:2:"53";i:26;s:2:"54";i:27;s:2:"55";i:28;s:2:"56";i:29;s:2:"38";i:30;s:2:"37";i:31;s:2:"39";i:32;s:2:"40";i:33;s:2:"41";i:34;s:2:"42";i:35;s:2:"24";i:36;s:2:"57";}',
				'status' => 1,
			),
		));
	}

}
