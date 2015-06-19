<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoryPathTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('category_path', function(Blueprint $table)
		{
			$table->integer('category_id')->unsigned()->index('category_id_idx');
			$table->integer('path_id')->unsigned()->index('path_id_idx');
			$table->integer('level')->unsigned();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('category_path');
	}

}
