<?php

use Illuminate\Database\Seeder;

class CustomerTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('customer')->delete();
        
		\DB::table('customer')->insert(array (
			0 => 
			array (
				'customer_id' => 1,
				'store_id' => 0,
				'username' => 'vendetta',
				'firstname' => 'Vince',
				'lastname' => 'Kronlein',
				'email' => 'vkronlein@icloud.com',
				'telephone' => '4803383661',
				'password' => 'bead750346ca6ed21717c6e6fd03f14c961e1dd4',
				'salt' => '46ae1db3c',
				'reset' => '',
				'cart' => 'a:0:{}',
				'wishlist' => 'a:1:{i:0;s:2:"50";}',
				'newsletter' => 0,
				'address_id' => 1,
				'customer_group_id' => 2,
				'referral_id' => 0,
				'is_affiliate' => 1,
				'affiliate_status' => 1,
				'company' => '',
				'website' => 'http://so.lution.io',
				'code' => '55387738a0b07',
				'commission' => '10.00',
				'tax_id' => '555443232',
				'payment_method' => 'paypal',
				'cheque' => '',
				'paypal' => 'vkronlein@icloud.com',
				'bank_name' => '',
				'bank_branch_number' => '',
				'bank_swift_code' => '',
				'bank_account_name' => '',
				'bank_account_number' => '',
				'ip' => '127.0.0.1',
				'status' => 1,
				'approved' => 1,
				'token' => '',
				'date_added' => '2015-04-22 21:38:16',
			),
		));
	}

}
