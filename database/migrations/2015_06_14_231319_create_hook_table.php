<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHookTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('hook', function(Blueprint $table)
		{
			$table->increments('hook_id');
			$table->integer('store_id')->unsigned();
			$table->string('hook')->index('hook_idx');
			$table->text('handlers', 65535);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('hook');
	}

}
