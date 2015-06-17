<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTagTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tag', function(Blueprint $table)
		{
			$table->increments('tag_id');
			$table->string('section', 55);
			$table->integer('element_id')->unsigned()->index('element_id_idx');
			$table->integer('language_id')->unsigned()->index('language_id_idx');
			$table->string('tag', 128)->index('tag_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tag');
	}

}
