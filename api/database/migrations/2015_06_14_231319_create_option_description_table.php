<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOptionDescriptionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('option_description', function(Blueprint $table)
		{
			$table->integer('option_id')->unsigned()->primary();
			$table->integer('language_id')->unsigned()->index('language_id_idx');
			$table->string('name', 128);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('option_description');
	}

}
