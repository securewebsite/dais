<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReturnTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('return', function(Blueprint $table)
		{
			$table->increments('return_id');
			$table->integer('order_id')->unsigned();
			$table->integer('product_id')->unsigned();
			$table->integer('customer_id')->unsigned();
			$table->string('firstname', 32);
			$table->string('lastname', 32);
			$table->string('email', 96);
			$table->string('telephone', 32);
			$table->string('product');
			$table->string('model', 64);
			$table->integer('quantity')->unsigned();
			$table->boolean('opened');
			$table->integer('return_reason_id')->unsigned();
			$table->integer('return_action_id')->unsigned();
			$table->integer('return_status_id')->unsigned();
			$table->text('comment', 65535)->nullable();
			$table->date('date_ordered');
			$table->dateTime('date_added');
			$table->dateTime('date_modified');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('return');
	}

}
