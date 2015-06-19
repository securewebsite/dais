<?php

use Illuminate\Database\Seeder;

class AffiliateRouteTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('affiliate_route')->delete();
        
		\DB::table('affiliate_route')->insert(array (
			0 => 
			array (
				'route_id' => 1,
				'route' => 'content/home',
				'query' => 'affiliate_id:1',
				'slug' => 'vendetta',
			),
		));
	}

}
