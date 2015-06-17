<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrderRecurringTransactionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_recurring_transaction', function(Blueprint $table)
		{
			$table->increments('order_recurring_transaction_id');
			$table->integer('order_recurring_id')->unsigned();
			$table->dateTime('created');
			$table->decimal('amount', 10, 4)->unsigned();
			$table->string('type');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('order_recurring_transaction');
	}

}
