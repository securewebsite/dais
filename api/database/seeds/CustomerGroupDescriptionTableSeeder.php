<?php

use Illuminate\Database\Seeder;

class CustomerGroupDescriptionTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('customer_group_description')->delete();
        
		\DB::table('customer_group_description')->insert(array (
			0 => 
			array (
				'customer_group_id' => 1,
				'language_id' => 1,
				'name' => 'Guest',
				'description' => 'This is the default group for any site visitor that isn\'t logged in.',
			),
			1 => 
			array (
				'customer_group_id' => 2,
				'language_id' => 1,
				'name' => 'Customer',
				'description' => 'This is the default free customer group for any customer that simply has an account.',
			),
			2 => 
			array (
				'customer_group_id' => 3,
				'language_id' => 1,
				'name' => 'Silver',
				'description' => 'This is an example 1st tier paid membership group. Always ensure that the customer_group_id\'s of your memberships are in ascending order otherwise the visibility and content settings will not work correctly.  This can be safely deleted if not needed.',
			),
			3 => 
			array (
				'customer_group_id' => 4,
				'language_id' => 1,
				'name' => 'Gold',
				'description' => 'This is an example 2nd tier paid membership group. Always ensure that the customer_group_id\'s of your memberships are in ascending order otherwise the visibility and content settings will not work correctly.  This can be safely deleted if not needed.',
			),
		));
	}

}
