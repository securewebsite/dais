<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEventWaitListTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('event_wait_list', function(Blueprint $table)
		{
			$table->increments('event_wait_list_id');
			$table->integer('event_id')->unsigned();
			$table->integer('customer_id')->unsigned();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('event_wait_list');
	}

}
