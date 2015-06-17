<?php

use Illuminate\Database\Seeder;

class VanityRouteTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('vanity_route')->delete();
        
	}

}
