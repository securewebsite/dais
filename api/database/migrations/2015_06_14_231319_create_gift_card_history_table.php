<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGiftCardHistoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('gift_card_history', function(Blueprint $table)
		{
			$table->increments('gift_card_history_id');
			$table->integer('gift_card_id')->unsigned();
			$table->integer('order_id')->unsigned();
			$table->decimal('amount', 15, 4)->unsigned();
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
		Schema::drop('gift_card_history');
	}

}
