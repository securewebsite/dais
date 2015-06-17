<?php

use Illuminate\Database\Seeder;

class CustomerNotificationTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('customer_notification')->delete();
        
		\DB::table('customer_notification')->insert(array (
			0 => 
			array (
				'customer_id' => 1,
				'settings' => 'a:10:{i:2;a:2:{s:5:"email";i:1;s:8:"internal";i:1;}i:3;a:2:{s:5:"email";i:1;s:8:"internal";i:1;}i:4;a:2:{s:5:"email";i:1;s:8:"internal";i:1;}i:5;a:2:{s:5:"email";i:1;s:8:"internal";i:1;}i:8;a:2:{s:5:"email";i:1;s:8:"internal";i:1;}i:9;a:2:{s:5:"email";i:1;s:8:"internal";i:1;}i:10;a:2:{s:5:"email";i:1;s:8:"internal";i:1;}i:11;a:2:{s:5:"email";i:1;s:8:"internal";i:1;}i:14;a:2:{s:5:"email";i:1;s:8:"internal";i:1;}i:15;a:2:{s:5:"email";i:1;s:8:"internal";i:1;}}',
			),
		));
	}

}
