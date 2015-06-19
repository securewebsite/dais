<?php

use Illuminate\Database\Seeder;

class GiftCardTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('gift_card')->delete();
        
	}

}
