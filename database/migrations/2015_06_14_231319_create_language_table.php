<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLanguageTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('language', function(Blueprint $table)
		{
			$table->increments('language_id');
			$table->string('name', 32)->index('name_idx');
			$table->string('code', 5);
			$table->string('locale');
			$table->string('image', 64);
			$table->string('directory', 32);
			$table->string('filename', 64);
			$table->integer('sort_order')->unsigned();
			$table->boolean('status');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('language');
	}

}
