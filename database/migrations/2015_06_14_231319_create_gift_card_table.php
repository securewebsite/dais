<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGiftCardTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('gift_card', function(Blueprint $table)
		{
			$table->increments('gift_card_id');
			$table->integer('order_id')->unsigned();
			$table->string('code', 10);
			$table->string('from_name', 64);
			$table->string('from_email', 96);
			$table->string('to_name', 64);
			$table->string('to_email', 96);
			$table->integer('gift_card_theme_id')->unsigned();
			$table->text('message', 65535);
			$table->decimal('amount', 15, 4)->unsigned();
			$table->boolean('status');
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
		Schema::drop('gift_card');
	}

}
