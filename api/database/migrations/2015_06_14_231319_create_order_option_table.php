<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrderOptionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_option', function(Blueprint $table)
		{
			$table->increments('order_option_id');
			$table->integer('order_id')->unsigned();
			$table->integer('order_product_id')->unsigned();
			$table->integer('product_option_id')->unsigned();
			$table->integer('product_option_value_id')->unsigned();
			$table->string('name');
			$table->text('value', 65535);
			$table->string('type', 32);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('order_option');
	}

}
