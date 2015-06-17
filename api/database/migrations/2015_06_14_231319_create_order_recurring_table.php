<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrderRecurringTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_recurring', function(Blueprint $table)
		{
			$table->increments('order_recurring_id');
			$table->integer('order_id')->unsigned();
			$table->dateTime('created');
			$table->boolean('status');
			$table->integer('product_id')->unsigned();
			$table->string('product_name');
			$table->integer('product_quantity')->unsigned();
			$table->integer('recurring_id')->unsigned();
			$table->string('recurring_name');
			$table->string('recurring_description');
			$table->string('recurring_frequency', 25);
			$table->smallInteger('recurring_cycle')->unsigned();
			$table->smallInteger('recurring_duration')->unsigned();
			$table->decimal('recurring_price', 10, 4)->unsigned();
			$table->boolean('trial');
			$table->string('trial_frequency', 25);
			$table->smallInteger('trial_cycle')->unsigned();
			$table->smallInteger('trial_duration')->unsigned();
			$table->decimal('trial_price', 10, 4)->unsigned();
			$table->string('reference');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('order_recurring');
	}

}
