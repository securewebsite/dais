<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReturnActionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('return_action', function(Blueprint $table)
		{
			$table->increments('return_action_id');
			$table->integer('language_id')->unsigned()->index('language_id_idx');
			$table->string('name', 64);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('return_action');
	}

}
