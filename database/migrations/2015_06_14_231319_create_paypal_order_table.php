<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePaypalOrderTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('paypal_order', function(Blueprint $table)
		{
			$table->increments('paypal_order_id');
			$table->integer('order_id')->unsigned();
			$table->dateTime('date_added');
			$table->dateTime('date_modified');
			$table->enum('capture_status', array('Complete','NotComplete'))->nullable();
			$table->char('currency_code', 3);
			$table->string('authorization_id', 30);
			$table->decimal('total', 10)->unsigned();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('paypal_order');
	}

}
