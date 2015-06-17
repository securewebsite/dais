<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductToCategoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_to_category', function(Blueprint $table)
		{
			$table->integer('product_id')->unsigned()->index('product_id_idx');
			$table->integer('category_id')->unsigned()->index('category_id_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('product_to_category');
	}

}
