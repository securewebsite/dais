<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomerInboxTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customer_inbox', function(Blueprint $table)
		{
			$table->integer('notification_id')->unsigned()->primary();
			$table->integer('customer_id')->unsigned()->index('customer_id_idx');
			$table->string('subject', 64);
			$table->text('message', 65535);
			$table->boolean('is_read')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('customer_inbox');
	}

}
