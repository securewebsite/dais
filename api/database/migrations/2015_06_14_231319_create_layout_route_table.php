<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLayoutRouteTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('layout_route', function(Blueprint $table)
		{
			$table->increments('layout_route_id');
			$table->integer('layout_id')->unsigned();
			$table->integer('store_id')->unsigned();
			$table->string('route');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('layout_route');
	}

}
