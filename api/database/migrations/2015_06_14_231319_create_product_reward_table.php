<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductRewardTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_reward', function(Blueprint $table)
		{
			$table->increments('product_reward_id');
			$table->integer('product_id')->unsigned();
			$table->integer('customer_group_id')->unsigned();
			$table->integer('points')->unsigned();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('product_reward');
	}

}
