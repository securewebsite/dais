<?php

use Illuminate\Database\Seeder;

class CurrencyTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('currency')->delete();
        
		\DB::table('currency')->insert(array (
			0 => 
			array (
				'currency_id' => 1,
				'title' => 'Pound Sterling',
				'code' => 'GBP',
				'symbol_left' => '£',
				'symbol_right' => '',
				'decimal_place' => '2',
				'value' => 0.64289998999999998,
				'status' => 1,
				'date_modified' => '2015-06-12 12:49:21',
			),
			1 => 
			array (
				'currency_id' => 2,
				'title' => 'US Dollar',
				'code' => 'USD',
				'symbol_left' => '$',
				'symbol_right' => '',
				'decimal_place' => '2',
				'value' => 1,
				'status' => 1,
				'date_modified' => '2015-06-12 12:58:21',
			),
			2 => 
			array (
				'currency_id' => 3,
				'title' => 'Euro',
				'code' => 'EUR',
				'symbol_left' => '',
				'symbol_right' => '€',
				'decimal_place' => '2',
				'value' => 0.88859999000000001,
				'status' => 1,
				'date_modified' => '2015-06-12 12:49:21',
			),
		));
	}

}
