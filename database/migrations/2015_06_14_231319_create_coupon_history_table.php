<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCouponHistoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('coupon_history', function(Blueprint $table)
		{
			$table->increments('coupon_history_id');
			$table->integer('coupon_id')->unsigned();
			$table->integer('order_id')->unsigned();
			$table->integer('customer_id')->unsigned();
			$table->decimal('amount', 15, 4)->unsigned();
			$table->dateTime('date_added');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('coupon_history');
	}

}
