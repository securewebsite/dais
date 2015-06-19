<?php

use Illuminate\Database\Seeder;

class CustomRouteTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('custom_route')->delete();
        
		\DB::table('custom_route')->insert(array (
			0 => 
			array (
				'route_id' => 29,
				'route' => 'account/gift_card',
				'slug' => 'gift-card',
			),
			1 => 
			array (
				'route_id' => 30,
				'route' => 'account/login',
				'slug' => 'login',
			),
			2 => 
			array (
				'route_id' => 31,
				'route' => 'account/logout',
				'slug' => 'logout',
			),
			3 => 
			array (
				'route_id' => 32,
				'route' => 'account/register',
				'slug' => 'register',
			),
			4 => 
			array (
				'route_id' => 33,
				'route' => 'account/returns/insert',
				'slug' => 'returns',
			),
			5 => 
			array (
				'route_id' => 34,
				'route' => 'catalog/manufacturer',
				'slug' => 'brands',
			),
			6 => 
			array (
				'route_id' => 35,
				'route' => 'catalog/special',
				'slug' => 'specials',
			),
			7 => 
			array (
				'route_id' => 36,
				'route' => 'common/queue',
				'slug' => 'queue',
			),
			8 => 
			array (
				'route_id' => 37,
				'route' => 'content/calendar',
				'slug' => 'calendar',
			),
			9 => 
			array (
				'route_id' => 38,
				'route' => 'content/contact',
				'slug' => 'contact',
			),
			10 => 
			array (
				'route_id' => 39,
				'route' => 'content/home',
				'slug' => 'blog',
			),
			11 => 
			array (
				'route_id' => 40,
				'route' => 'content/site_map',
				'slug' => 'site-map',
			),
			12 => 
			array (
				'route_id' => 41,
				'route' => 'search/search',
				'slug' => 'search',
			),
			13 => 
			array (
				'route_id' => 42,
				'route' => 'shop/home',
				'slug' => 'shop',
			),
			14 => 
			array (
				'route_id' => 43,
				'route' => 'account/forgotten',
				'slug' => 'forgotten',
			),
		));
	}

}
