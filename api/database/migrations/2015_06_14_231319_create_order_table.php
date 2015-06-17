<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrderTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order', function(Blueprint $table)
		{
			$table->increments('order_id');
			$table->integer('invoice_no')->unsigned();
			$table->string('invoice_prefix', 26);
			$table->integer('store_id')->unsigned();
			$table->string('store_name', 64);
			$table->string('store_url');
			$table->integer('customer_id')->unsigned();
			$table->integer('customer_group_id')->unsigned();
			$table->string('firstname', 32);
			$table->string('lastname', 32);
			$table->string('email', 96);
			$table->string('telephone', 32);
			$table->string('payment_firstname', 32);
			$table->string('payment_lastname', 32);
			$table->string('payment_company', 32);
			$table->string('payment_company_id', 32);
			$table->string('payment_tax_id', 32);
			$table->string('payment_address_1', 128);
			$table->string('payment_address_2', 128);
			$table->string('payment_city', 128);
			$table->string('payment_postcode', 10);
			$table->string('payment_country', 128);
			$table->integer('payment_country_id')->unsigned();
			$table->string('payment_zone', 128);
			$table->integer('payment_zone_id')->unsigned();
			$table->text('payment_address_format', 65535);
			$table->string('payment_method', 128);
			$table->string('payment_code', 128);
			$table->string('shipping_firstname', 32);
			$table->string('shipping_lastname', 32);
			$table->string('shipping_company', 32);
			$table->string('shipping_address_1', 128);
			$table->string('shipping_address_2', 128);
			$table->string('shipping_city', 128);
			$table->string('shipping_postcode', 10);
			$table->string('shipping_country', 128);
			$table->integer('shipping_country_id')->unsigned();
			$table->string('shipping_zone', 128);
			$table->integer('shipping_zone_id')->unsigned();
			$table->text('shipping_address_format', 65535);
			$table->string('shipping_method', 128);
			$table->string('shipping_code', 128);
			$table->text('comment', 65535);
			$table->decimal('total', 15, 4)->unsigned()->default(0.0000);
			$table->integer('order_status_id')->unsigned();
			$table->integer('affiliate_id')->unsigned();
			$table->decimal('commission', 15, 4)->unsigned();
			$table->integer('language_id')->unsigned();
			$table->integer('currency_id')->unsigned();
			$table->string('currency_code', 3);
			$table->decimal('currency_value', 15, 8)->unsigned()->default(1.00000000);
			$table->string('ip', 40);
			$table->string('forwarded_ip', 40);
			$table->string('user_agent');
			$table->string('accept_language');
			$table->dateTime('date_added');
			$table->dateTime('date_modified');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('order');
	}

}
