<?php

use Illuminate\Database\Seeder;

class EventTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('event')->delete();
        
		\DB::table('event')->insert(array (
			0 => 
			array (
				'event_id' => 3,
				'store_id' => 0,
				'event' => 'admin_edit_product',
				'handlers' => 'a:1:{i:0;s:44:"example/admin/events/admin_event/editProduct";}',
			),
		));
	}

}
