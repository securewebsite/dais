<?php

use Illuminate\Database\Seeder;

class AddressTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('address')->delete();
        
		\DB::table('address')->insert(array (
			0 => 
			array (
				'address_id' => 1,
				'customer_id' => 1,
				'firstname' => 'Vince',
				'lastname' => 'Kronlein',
				'company' => '',
				'company_id' => '',
				'tax_id' => '',
				'address_1' => '603 E. Taylor St.',
				'address_2' => '',
				'city' => 'Tempe',
				'postcode' => '85281',
				'country_id' => 223,
				'zone_id' => 3616,
			),
		));
	}

}
