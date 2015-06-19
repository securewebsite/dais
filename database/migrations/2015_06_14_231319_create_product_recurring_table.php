<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductRecurringTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_recurring', function(Blueprint $table)
		{
			$table->integer('product_id')->unsigned()->index('product_id_idx');
			$table->integer('recurring_id')->unsigned()->index('recurring_id_idx');
			$table->integer('customer_group_id')->unsigned()->index('customer_group_id_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('product_recurring');
	}

}
