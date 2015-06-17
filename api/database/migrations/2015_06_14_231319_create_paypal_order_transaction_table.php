<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePaypalOrderTransactionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('paypal_order_transaction', function(Blueprint $table)
		{
			$table->increments('paypal_order_transaction_id');
			$table->integer('paypal_order_id')->unsigned();
			$table->char('transaction_id', 20);
			$table->char('parent_transaction_id', 20);
			$table->dateTime('date_added');
			$table->string('note');
			$table->char('msgsubid', 38);
			$table->char('receipt_id', 20);
			$table->enum('payment_type', array('none','echeck','instant','refund','void'))->nullable();
			$table->char('payment_status', 20);
			$table->char('pending_reason', 50);
			$table->char('transaction_entity', 50);
			$table->decimal('amount', 10)->unsigned();
			$table->text('debug_data', 65535);
			$table->text('call_data', 65535);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('paypal_order_transaction');
	}

}
