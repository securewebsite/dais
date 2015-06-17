<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrderDownloadTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_download', function(Blueprint $table)
		{
			$table->increments('order_download_id');
			$table->integer('order_id')->unsigned();
			$table->integer('order_product_id')->unsigned();
			$table->string('name', 64);
			$table->string('filename', 128);
			$table->string('mask', 128);
			$table->integer('remaining')->unsigned();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('order_download');
	}

}
