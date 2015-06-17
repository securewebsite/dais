<?php

use Illuminate\Database\Seeder;

class EmailTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('email')->delete();
        
		\DB::table('email')->insert(array (
			0 => 
			array (
				'email_id' => 1,
				'email_slug' => 'admin_forgotten_email',
				'configurable' => 0,
				'priority' => 1,
				'config_description' => '',
				'recipient' => 2,
				'is_system' => 1,
			),
			1 => 
			array (
				'email_id' => 2,
				'email_slug' => 'admin_people_contact',
				'configurable' => 1,
				'priority' => 2,
				'config_description' => 'Customer Newsletter',
				'recipient' => 1,
				'is_system' => 1,
			),
			2 => 
			array (
				'email_id' => 3,
				'email_slug' => 'admin_event_add',
				'configurable' => 1,
				'priority' => 2,
				'config_description' => 'Administrator Adds You to an Event',
				'recipient' => 1,
				'is_system' => 1,
			),
			3 => 
			array (
				'email_id' => 4,
				'email_slug' => 'admin_event_waitlist',
				'configurable' => 1,
				'priority' => 2,
				'config_description' => 'Administrator Adds You to an Event Waitlist ',
				'recipient' => 1,
				'is_system' => 1,
			),
			4 => 
			array (
				'email_id' => 5,
				'email_slug' => 'admin_affiliate_add_commission',
				'configurable' => 1,
				'priority' => 2,
				'config_description' => 'Administrator Adds a Commission to Your Affiliate Account',
				'recipient' => 1,
				'is_system' => 1,
			),
			5 => 
			array (
				'email_id' => 7,
				'email_slug' => 'admin_customer_approve',
				'configurable' => 0,
				'priority' => 2,
				'config_description' => '',
				'recipient' => 1,
				'is_system' => 1,
			),
			6 => 
			array (
				'email_id' => 8,
				'email_slug' => 'admin_customer_add_credit',
				'configurable' => 1,
				'priority' => 2,
				'config_description' => 'Administrator Adds a Store Credit to Your Customer Account',
				'recipient' => 1,
				'is_system' => 1,
			),
			7 => 
			array (
				'email_id' => 9,
				'email_slug' => 'admin_customer_add_reward',
				'configurable' => 1,
				'priority' => 2,
				'config_description' => 'Administrator Adds Reward Points to Your Customer Account',
				'recipient' => 1,
				'is_system' => 1,
			),
			8 => 
			array (
				'email_id' => 10,
				'email_slug' => 'admin_order_add_history',
				'configurable' => 1,
				'priority' => 2,
				'config_description' => 'Administrator Updates Your Active Orders',
				'recipient' => 1,
				'is_system' => 1,
			),
			9 => 
			array (
				'email_id' => 11,
				'email_slug' => 'admin_return_add_history',
				'configurable' => 1,
				'priority' => 2,
				'config_description' => 'Administrator Updates Your Active Returns',
				'recipient' => 1,
				'is_system' => 1,
			),
			10 => 
			array (
				'email_id' => 12,
				'email_slug' => 'admin_giftcard_send',
				'configurable' => 0,
				'priority' => 1,
				'config_description' => '',
				'recipient' => 1,
				'is_system' => 1,
			),
			11 => 
			array (
				'email_id' => 14,
				'email_slug' => 'public_waitlist_join',
				'configurable' => 1,
				'priority' => 2,
				'config_description' => 'You Join an Event Waitlist',
				'recipient' => 1,
				'is_system' => 1,
			),
			12 => 
			array (
				'email_id' => 15,
				'email_slug' => 'public_customer_order_confirm',
				'configurable' => 1,
				'priority' => 2,
				'config_description' => 'You Place an Order',
				'recipient' => 1,
				'is_system' => 1,
			),
			13 => 
			array (
				'email_id' => 16,
				'email_slug' => 'public_admin_order_confirm',
				'configurable' => 0,
				'priority' => 2,
				'config_description' => '',
				'recipient' => 2,
				'is_system' => 1,
			),
			14 => 
			array (
				'email_id' => 18,
				'email_slug' => 'public_customer_forgotten',
				'configurable' => 0,
				'priority' => 1,
				'config_description' => '',
				'recipient' => 1,
				'is_system' => 1,
			),
			15 => 
			array (
				'email_id' => 20,
				'email_slug' => 'public_contact_admin',
				'configurable' => 0,
				'priority' => 2,
				'config_description' => '',
				'recipient' => 2,
				'is_system' => 1,
			),
			16 => 
			array (
				'email_id' => 21,
				'email_slug' => 'public_contact_customer',
				'configurable' => 0,
				'priority' => 1,
				'config_description' => '',
				'recipient' => 1,
				'is_system' => 1,
			),
			17 => 
			array (
				'email_id' => 22,
				'email_slug' => 'public_register_customer',
				'configurable' => 0,
				'priority' => 2,
				'config_description' => '',
				'recipient' => 1,
				'is_system' => 1,
			),
			18 => 
			array (
				'email_id' => 23,
				'email_slug' => 'public_register_admin',
				'configurable' => 0,
				'priority' => 2,
				'config_description' => '',
				'recipient' => 2,
				'is_system' => 1,
			),
			19 => 
			array (
				'email_id' => 26,
				'email_slug' => 'public_giftcard_confirm',
				'configurable' => 0,
				'priority' => 1,
				'config_description' => '',
				'recipient' => 1,
				'is_system' => 1,
			),
			20 => 
			array (
				'email_id' => 27,
				'email_slug' => 'email_wrapper',
				'configurable' => 0,
				'priority' => 2,
				'config_description' => '',
				'recipient' => 1,
				'is_system' => 1,
			),
			21 => 
			array (
				'email_id' => 28,
				'email_slug' => 'email_wrapper',
				'configurable' => 0,
				'priority' => 1,
				'config_description' => '',
				'recipient' => 1,
				'is_system' => 1,
			),
		));
	}

}
