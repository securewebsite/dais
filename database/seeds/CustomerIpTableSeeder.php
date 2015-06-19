<?php

use Illuminate\Database\Seeder;

class CustomerIpTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('customer_ip')->delete();
        
		\DB::table('customer_ip')->insert(array (
			0 => 
			array (
				'customer_ip_id' => 1,
				'customer_id' => 1,
				'ip' => '127.0.0.1',
				'date_added' => '2015-04-22 21:38:16',
			),
		));
	}

}
