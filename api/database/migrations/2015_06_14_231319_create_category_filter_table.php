<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoryFilterTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('category_filter', function(Blueprint $table)
		{
			$table->integer('category_id')->unsigned()->index('category_id_idx');
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
		Schema::drop('category_filter');
	}

}
