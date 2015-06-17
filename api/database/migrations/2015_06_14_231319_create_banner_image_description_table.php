<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBannerImageDescriptionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('banner_image_description', function(Blueprint $table)
		{
			$table->integer('banner_image_id')->unsigned()->primary();
			$table->integer('language_id')->unsigned()->index('language_id_idx');
			$table->integer('banner_id')->unsigned();
			$table->string('title', 64);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('banner_image_description');
	}

}
