<?php

use Illuminate\Database\Seeder;

class TaxRateTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('tax_rate')->delete();
        
		\DB::table('tax_rate')->insert(array (
			0 => 
			array (
				'tax_rate_id' => 88,
				'geo_zone_id' => 6,
				'name' => 'AZ Sales Tax',
				'rate' => '8.1000',
				'type' => 'P',
				'date_added' => '2014-06-28 00:36:45',
				'date_modified' => '2015-03-25 17:47:59',
			),
		));
	}

}
