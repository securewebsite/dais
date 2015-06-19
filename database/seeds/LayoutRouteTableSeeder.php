<?php

use Illuminate\Database\Seeder;

class LayoutRouteTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('layout_route')->delete();
        
		\DB::table('layout_route')->insert(array (
			0 => 
			array (
				'layout_route_id' => 1,
				'layout_id' => 2,
				'store_id' => 0,
				'route' => 'shop/home',
			),
			1 => 
			array (
				'layout_route_id' => 2,
				'layout_id' => 13,
				'store_id' => 0,
				'route' => 'error/notfound',
			),
			2 => 
			array (
				'layout_route_id' => 3,
				'layout_id' => 6,
				'store_id' => 0,
				'route' => 'account/',
			),
			3 => 
			array (
				'layout_route_id' => 5,
				'layout_id' => 7,
				'store_id' => 0,
				'route' => 'checkout/',
			),
			4 => 
			array (
				'layout_route_id' => 6,
				'layout_id' => 8,
				'store_id' => 0,
				'route' => 'content/contact',
			),
			5 => 
			array (
				'layout_route_id' => 7,
				'layout_id' => 15,
				'store_id' => 0,
				'route' => 'content/category',
			),
			6 => 
			array (
				'layout_route_id' => 8,
				'layout_id' => 14,
				'store_id' => 0,
				'route' => 'content/home',
			),
			7 => 
			array (
				'layout_route_id' => 9,
				'layout_id' => 11,
				'store_id' => 0,
				'route' => 'content/page',
			),
			8 => 
			array (
				'layout_route_id' => 10,
				'layout_id' => 16,
				'store_id' => 0,
				'route' => 'content/post',
			),
			9 => 
			array (
				'layout_route_id' => 12,
				'layout_id' => 4,
				'store_id' => 0,
				'route' => 'catalog/category',
			),
			10 => 
			array (
				'layout_route_id' => 13,
				'layout_id' => 5,
				'store_id' => 0,
				'route' => 'catalog/manufacturer',
			),
			11 => 
			array (
				'layout_route_id' => 14,
				'layout_id' => 3,
				'store_id' => 0,
				'route' => 'catalog/product',
			),
			12 => 
			array (
				'layout_route_id' => 16,
				'layout_id' => 9,
				'store_id' => 0,
				'route' => 'content/sitemap',
			),
			13 => 
			array (
				'layout_route_id' => 17,
				'layout_id' => 18,
				'store_id' => 0,
				'route' => 'account/register',
			),
			14 => 
			array (
				'layout_route_id' => 18,
				'layout_id' => 19,
				'store_id' => 0,
				'route' => 'content/calendar',
			),
			15 => 
			array (
				'layout_route_id' => 19,
				'layout_id' => 20,
				'store_id' => 0,
				'route' => 'catalog/compare',
			),
			16 => 
			array (
				'layout_route_id' => 20,
				'layout_id' => 21,
				'store_id' => 0,
				'route' => 'event/page',
			),
			17 => 
			array (
				'layout_route_id' => 21,
				'layout_id' => 22,
				'store_id' => 0,
				'route' => 'error/permission',
			),
			18 => 
			array (
				'layout_route_id' => 23,
				'layout_id' => 17,
				'store_id' => 0,
				'route' => 'search/search',
			),
		));
	}

}
