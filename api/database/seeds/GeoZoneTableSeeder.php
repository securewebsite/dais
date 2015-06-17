<?php

use Illuminate\Database\Seeder;

class GeoZoneTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('geo_zone')->delete();
        
	}

}
