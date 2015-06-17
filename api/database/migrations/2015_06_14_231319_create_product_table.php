<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product', function(Blueprint $table)
		{
			$table->increments('product_id');
			$table->integer('event_id')->unsigned()->default(0);
			$table->string('model', 64);
			$table->string('sku', 64);
			$table->string('upc', 12);
			$table->string('ean', 14);
			$table->string('jan', 13);
			$table->string('isbn', 13);
			$table->string('mpn', 64);
			$table->string('location', 128);
			$table->integer('visibility')->unsigned()->default(1);
			$table->integer('quantity')->unsigned();
			$table->integer('stock_status_id')->unsigned();
			$table->string('image')->nullable();
			$table->integer('manufacturer_id')->unsigned();
			$table->boolean('shipping')->default(1);
			$table->decimal('price', 15, 4)->unsigned()->default(0.0000);
			$table->integer('points')->unsigned();
			$table->integer('tax_class_id')->unsigned();
			$table->date('date_available');
			$table->dateTime('end_date')->default('0000-00-00 00:00:00');
			$table->decimal('weight', 15, 8)->unsigned()->default(0.00000000);
			$table->integer('weight_class_id')->unsigned();
			$table->decimal('length', 15, 8)->unsigned()->default(0.00000000);
			$table->decimal('width', 15, 8)->unsigned()->default(0.00000000);
			$table->decimal('height', 15, 8)->unsigned()->default(0.00000000);
			$table->integer('length_class_id')->unsigned();
			$table->boolean('subtract')->default(1);
			$table->integer('minimum')->unsigned()->default(1);
			$table->integer('sort_order')->unsigned();
			$table->boolean('status');
			$table->dateTime('date_added')->default('0000-00-00 00:00:00');
			$table->dateTime('date_modified')->default('0000-00-00 00:00:00');
			$table->integer('viewed')->unsigned();
			$table->integer('customer_id')->unsigned()->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('product');
	}

}
