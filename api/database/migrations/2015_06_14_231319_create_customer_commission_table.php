<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomerCommissionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customer_commission', function(Blueprint $table)
		{
			$table->increments('customer_commission_id');
			$table->integer('customer_id')->unsigned();
			$table->integer('order_id')->unsigned();
			$table->text('description', 65535);
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
		Schema::drop('customer_commission');
	}

}
