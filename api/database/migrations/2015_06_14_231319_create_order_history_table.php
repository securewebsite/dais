<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrderHistoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_history', function(Blueprint $table)
		{
			$table->increments('order_history_id');
			$table->integer('order_id')->unsigned();
			$table->integer('order_status_id')->unsigned();
			$table->boolean('notify');
			$table->text('comment', 65535);
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
		Schema::drop('order_history');
	}

}
