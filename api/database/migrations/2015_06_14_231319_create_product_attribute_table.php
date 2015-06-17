<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductAttributeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_attribute', function(Blueprint $table)
		{
			$table->integer('product_id')->unsigned()->index('product_id_idx');
			$table->integer('attribute_id')->unsigned()->index('attribute_id_idx');
			$table->integer('language_id')->unsigned()->index('language_id_idx');
			$table->text('text', 65535);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('product_attribute');
	}

}
