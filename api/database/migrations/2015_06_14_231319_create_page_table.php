<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePageTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('page', function(Blueprint $table)
		{
			$table->increments('page_id');
			$table->integer('bottom')->unsigned();
			$table->integer('sort_order')->unsigned();
			$table->boolean('status')->default(1);
			$table->boolean('visibility')->default(1);
			$table->integer('event_id')->unsigned()->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('page');
	}

}
