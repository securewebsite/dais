<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('user')->delete();
        
		\DB::table('user')->insert(array (
			0 => 
			array (
				'user_id' => 1,
				'user_group_id' => 1,
				'user_name' => 'vkronlein',
				'password' => 'd8ec59e420875dc5aed10dac07bf0df7436c27d6',
				'salt' => 'd79b98308',
				'firstname' => '',
				'lastname' => '',
				'email' => 'vkronlein@icloud.com',
				'code' => '',
				'ip' => '127.0.0.1',
				'status' => 1,
				'date_added' => '2015-04-10 00:20:00',
				'last_access' => '2015-06-12 12:49:20',
			),
		));
	}

}
