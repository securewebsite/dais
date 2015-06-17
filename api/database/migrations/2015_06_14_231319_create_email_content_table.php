<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmailContentTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('email_content', function(Blueprint $table)
		{
			$table->integer('email_id')->unsigned()->primary();
			$table->integer('language_id')->unsigned()->default(1)->index('language_id_idx');
			$table->string('subject', 128);
			$table->text('text', 65535);
			$table->text('html', 65535);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('email_content');
	}

}
