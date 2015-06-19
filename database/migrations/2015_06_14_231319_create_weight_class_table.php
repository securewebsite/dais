<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWeightClassTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('weight_class', function(Blueprint $table)
		{
			$table->increments('weight_class_id');
			$table->decimal('value', 15, 8)->unsigned()->default(0.00000000);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('weight_class');
	}

}
