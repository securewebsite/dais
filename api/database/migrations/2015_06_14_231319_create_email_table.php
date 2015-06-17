<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmailTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('email', function(Blueprint $table)
		{
			$table->increments('email_id');
			$table->string('email_slug', 55);
			$table->boolean('configurable')->default(0);
			$table->boolean('priority')->default(2);
			$table->text('config_description', 65535);
			$table->boolean('recipient')->default(1);
			$table->boolean('is_system')->default(1);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('email');
	}

}
