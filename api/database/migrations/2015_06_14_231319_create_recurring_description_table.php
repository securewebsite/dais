<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRecurringDescriptionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('recurring_description', function(Blueprint $table)
		{
			$table->integer('recurring_id')->unsigned()->primary();
			$table->integer('language_id')->unsigned()->index('language_id_idx');
			$table->string('name');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('recurring_description');
	}

}
