<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTaxRuleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tax_rule', function(Blueprint $table)
		{
			$table->increments('tax_rule_id');
			$table->integer('tax_class_id')->unsigned();
			$table->integer('tax_rate_id')->unsigned();
			$table->string('based', 10);
			$table->integer('priority')->unsigned()->default(1);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tax_rule');
	}

}
