<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReturnReasonTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('return_reason', function(Blueprint $table)
		{
			$table->increments('return_reason_id');
			$table->integer('language_id')->unsigned()->index('language_id_idx');
			$table->string('name', 128);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('return_reason');
	}

}
