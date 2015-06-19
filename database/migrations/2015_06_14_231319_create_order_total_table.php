<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrderTotalTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_total', function(Blueprint $table)
		{
			$table->increments('order_total_id');
			$table->integer('order_id')->unsigned()->index('order_id_idx');
			$table->string('code', 32);
			$table->string('title');
			$table->string('text');
			$table->decimal('value', 15, 4)->unsigned()->default(0.0000);
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
		Schema::drop('order_total');
	}

}
