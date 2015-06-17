<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrderProductTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_product', function(Blueprint $table)
		{
			$table->increments('order_product_id');
			$table->integer('order_id')->unsigned();
			$table->integer('product_id')->unsigned();
			$table->string('name');
			$table->string('model', 64);
			$table->integer('quantity')->unsigned();
			$table->decimal('price', 15, 4)->unsigned()->default(0.0000);
			$table->decimal('total', 15, 4)->unsigned()->default(0.0000);
			$table->decimal('tax', 15, 4)->unsigned()->default(0.0000);
			$table->integer('reward')->unsigned();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('order_product');
	}

}
