<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGiftCardThemeDescriptionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('gift_card_theme_description', function(Blueprint $table)
		{
			$table->integer('gift_card_theme_id')->unsigned()->primary();
			$table->integer('language_id')->unsigned()->index('language_id_idx');
			$table->string('name', 32);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('gift_card_theme_description');
	}

}
