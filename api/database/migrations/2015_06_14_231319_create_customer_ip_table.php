<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomerIpTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customer_ip', function(Blueprint $table)
		{
			$table->increments('customer_ip_id');
			$table->integer('customer_id')->unsigned();
			$table->string('ip', 40)->index('ip_idx');
			$table->dateTime('date_added');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('customer_ip');
	}

}
