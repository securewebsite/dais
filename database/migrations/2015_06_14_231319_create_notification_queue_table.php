<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNotificationQueueTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('notification_queue', function(Blueprint $table)
		{
			$table->increments('queue_id');
			$table->string('email', 96)->index('email_idx');
			$table->string('name', 66);
			$table->string('subject', 128);
			$table->text('text', 65535);
			$table->text('html', 65535);
			$table->boolean('sent')->default(0)->index('sent_idx');
			$table->dateTime('date_added')->default('0000-00-00 00:00:00');
			$table->dateTime('date_sent')->default('0000-00-00 00:00:00');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('notification_queue');
	}

}
