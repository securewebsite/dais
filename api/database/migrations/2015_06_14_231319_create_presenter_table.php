<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePresenterTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('presenter', function(Blueprint $table)
		{
			$table->increments('presenter_id');
			$table->string('presenter_name', 150);
			$table->string('image');
			$table->string('facebook', 128);
			$table->string('twitter', 128);
			$table->text('bio', 16777215);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('presenter');
	}

}
