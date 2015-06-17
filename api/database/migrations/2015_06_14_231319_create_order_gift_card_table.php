<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrderGiftCardTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_gift_card', function(Blueprint $table)
		{
			$table->increments('order_gift_card_id');
			$table->integer('order_id')->unsigned();
			$table->integer('gift_card_id')->unsigned();
			$table->string('description');
			$table->string('code', 10);
			$table->string('from_name', 64);
			$table->string('from_email', 96);
			$table->string('to_name', 64);
			$table->string('to_email', 96);
			$table->integer('gift_card_theme_id')->unsigned();
			$table->text('message', 65535);
			$table->decimal('amount', 15, 4)->unsigned();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('order_gift_card');
	}

}
