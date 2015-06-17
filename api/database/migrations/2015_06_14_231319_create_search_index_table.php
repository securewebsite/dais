<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSearchIndexTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('search_index', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('language_id')->unsigned()->index('language_id_idx');
			$table->string('type', 24);
			$table->integer('object_id')->unsigned();
			$table->text('text', 65535);
		});

		DB::statement('ALTER TABLE dais_search_index ADD FULLTEXT text_idx(text)');
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('search_index');
	}

}
