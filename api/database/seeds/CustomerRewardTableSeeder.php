<?php

use Illuminate\Database\Seeder;

class CustomerRewardTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('customer_reward')->delete();
        
	}

}
