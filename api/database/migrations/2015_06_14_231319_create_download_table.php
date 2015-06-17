<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDownloadTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('download', function(Blueprint $table)
		{
			$table->increments('download_id');
			$table->string('filename', 128);
			$table->string('mask', 128);
			$table->integer('remaining')->unsigned();
			$table->dateTime('date_added')->default('0000-00-00 00:00:00');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('download');
	}

}
