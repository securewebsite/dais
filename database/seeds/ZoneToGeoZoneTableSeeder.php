<?php

use Illuminate\Database\Seeder;

class ZoneToGeoZoneTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('zone_to_geo_zone')->delete();
        
		\DB::table('zone_to_geo_zone')->insert(array (
			0 => 
			array (
				'zone_to_geo_zone_id' => 66,
				'country_id' => 223,
				'zone_id' => 3616,
				'geo_zone_id' => 5,
				'date_added' => '2014-06-28 00:35:35',
				'date_modified' => '0000-00-00 00:00:00',
			),
			1 => 
			array (
				'zone_to_geo_zone_id' => 67,
				'country_id' => 223,
				'zone_id' => 3616,
				'geo_zone_id' => 6,
				'date_added' => '2014-06-28 00:36:10',
				'date_modified' => '0000-00-00 00:00:00',
			),
		));
	}

}
