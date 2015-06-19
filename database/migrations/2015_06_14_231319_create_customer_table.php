<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomerTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customer', function(Blueprint $table)
		{
			$table->increments('customer_id');
			$table->integer('store_id')->unsigned();
			$table->string('username', 16)->unique('username_idx');
			$table->string('firstname', 32);
			$table->string('lastname', 32);
			$table->string('email', 96);
			$table->string('telephone', 32);
			$table->string('password', 40);
			$table->string('salt', 9);
			$table->string('reset', 40);
			$table->text('cart', 65535)->nullable();
			$table->text('wishlist', 65535)->nullable();
			$table->boolean('newsletter');
			$table->integer('address_id')->unsigned();
			$table->integer('customer_group_id')->unsigned();
			$table->integer('referral_id')->unsigned()->default(0);
			$table->boolean('is_affiliate')->default(0);
			$table->boolean('affiliate_status');
			$table->string('company', 32);
			$table->string('website');
			$table->string('code', 64);
			$table->decimal('commission', 4)->unsigned()->default(0.00);
			$table->string('tax_id', 64);
			$table->string('payment_method', 6);
			$table->string('cheque', 100);
			$table->string('paypal', 64);
			$table->string('bank_name', 64);
			$table->string('bank_branch_number', 64);
			$table->string('bank_swift_code', 64);
			$table->string('bank_account_name', 64);
			$table->string('bank_account_number', 64);
			$table->string('ip', 40)->default('0');
			$table->boolean('status');
			$table->boolean('approved');
			$table->string('token');
			$table->dateTime('date_added')->default('0000-00-00 00:00:00');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('customer');
	}

}
