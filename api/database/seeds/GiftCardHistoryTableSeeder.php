<?php

use Illuminate\Database\Seeder;

class GiftCardHistoryTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('gift_card_history')->delete();
        
	}

}
