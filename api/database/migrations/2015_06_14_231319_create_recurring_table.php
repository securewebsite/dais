<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRecurringTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('recurring', function(Blueprint $table)
		{
			$table->increments('recurring_id');
			$table->decimal('price', 10, 4)->unsigned();
			$table->enum('frequency', array('day','week','semi_month','month','year'));
			$table->integer('duration')->unsigned();
			$table->integer('cycle')->unsigned();
			$table->boolean('trial_status');
			$table->decimal('trial_price', 10, 4)->unsigned();
			$table->enum('trial_frequency', array('day','week','semi_month','month','year'));
			$table->integer('trial_duration')->unsigned();
			$table->integer('trial_cycle')->unsigned();
			$table->boolean('status');
			$table->integer('sort_order')->unsigned();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('recurring');
	}

}
