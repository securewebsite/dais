<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateZoneToGeoZoneTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('zone_to_geo_zone', function(Blueprint $table)
		{
			$table->increments('zone_to_geo_zone_id');
			$table->integer('country_id')->unsigned();
			$table->integer('zone_id')->unsigned();
			$table->integer('geo_zone_id')->unsigned();
			$table->dateTime('date_added')->default('0000-00-00 00:00:00');
			$table->dateTime('date_modified')->default('0000-00-00 00:00:00');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('zone_to_geo_zone');
	}

}
