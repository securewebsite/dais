<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEventManagerTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('event_manager', function(Blueprint $table)
		{
			$table->increments('event_id');
			$table->string('event_name', 150);
			$table->string('model', 50);
			$table->string('sku', 50);
			$table->integer('visibility')->unsigned()->default(1);
			$table->string('event_length', 40);
			$table->text('event_days', 65535);
			$table->string('event_class', 40)->default('event');
			$table->dateTime('date_time')->default('0000-00-00 00:00:00');
			$table->boolean('online')->default(0);
			$table->string('link', 200);
			$table->string('location', 200);
			$table->string('telephone', 25);
			$table->decimal('cost', 15, 4)->unsigned()->default(0.0000);
			$table->integer('seats')->unsigned()->default(0);
			$table->integer('filled')->unsigned()->default(0);
			$table->string('presenter_tab', 50);
			$table->text('roster', 16777215);
			$table->integer('presenter_id')->unsigned()->default(0);
			$table->text('description', 16777215);
			$table->boolean('refundable')->default(0);
			$table->dateTime('date_end')->default('0000-00-00 00:00:00');
			$table->integer('product_id')->unsigned()->default(0);
			$table->integer('page_id')->unsigned()->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('event_manager');
	}

}
