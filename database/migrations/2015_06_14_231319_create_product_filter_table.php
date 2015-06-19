<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductFilterTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_filter', function(Blueprint $table)
		{
			$table->integer('product_id')->unsigned()->index('product_id_idx');
			$table->integer('filter_id')->unsigned()->index('filter_id_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('product_filter');
	}

}
