<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductOptionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_option', function(Blueprint $table)
		{
			$table->increments('product_option_id');
			$table->integer('product_id')->unsigned();
			$table->integer('option_id')->unsigned();
			$table->text('option_value', 65535);
			$table->boolean('required');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('product_option');
	}

}
