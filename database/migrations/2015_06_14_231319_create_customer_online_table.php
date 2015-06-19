<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomerOnlineTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customer_online', function(Blueprint $table)
		{
			$table->string('ip', 40)->primary();
			$table->integer('customer_id')->unsigned();
			$table->text('url', 65535);
			$table->text('referer', 65535);
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
		Schema::drop('customer_online');
	}

}
