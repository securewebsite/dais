<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomerRewardTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customer_reward', function(Blueprint $table)
		{
			$table->increments('customer_reward_id');
			$table->integer('customer_id')->unsigned();
			$table->integer('order_id')->unsigned();
			$table->text('description', 65535);
			$table->integer('points')->unsigned();
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
		Schema::drop('customer_reward');
	}

}
