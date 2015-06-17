<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLengthClassDescriptionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('length_class_description', function(Blueprint $table)
		{
			$table->increments('length_class_id');
			$table->integer('language_id')->unsigned()->index('language_id_idx');
			$table->string('title', 32);
			$table->string('unit', 4);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('length_class_description');
	}

}
