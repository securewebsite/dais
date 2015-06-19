<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductToLayoutTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_to_layout', function(Blueprint $table)
		{
			$table->integer('product_id')->unsigned()->primary();
			$table->integer('store_id')->unsigned()->index('store_id_idx');
			$table->integer('layout_id')->unsigned();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('product_to_layout');
	}

}
