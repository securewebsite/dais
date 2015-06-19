<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrderFraudTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_fraud', function(Blueprint $table)
		{
			$table->integer('order_id')->unsigned()->primary();
			$table->integer('customer_id')->unsigned();
			$table->string('country_match', 3);
			$table->string('country_code', 2);
			$table->string('high_risk_country', 3);
			$table->integer('distance')->unsigned();
			$table->string('ip_region');
			$table->string('ip_city');
			$table->decimal('ip_latitude', 10, 6);
			$table->decimal('ip_longitude', 10, 6);
			$table->string('ip_isp');
			$table->string('ip_org');
			$table->integer('ip_asnum');
			$table->string('ip_user_type');
			$table->string('ip_country_confidence', 3);
			$table->string('ip_region_confidence', 3);
			$table->string('ip_city_confidence', 3);
			$table->string('ip_postal_confidence', 3);
			$table->string('ip_postal_code', 10);
			$table->integer('ip_accuracy_radius');
			$table->string('ip_net_speed_cell');
			$table->integer('ip_metro_code')->unsigned();
			$table->integer('ip_area_code')->unsigned();
			$table->string('ip_time_zone');
			$table->string('ip_region_name');
			$table->string('ip_domain');
			$table->string('ip_country_name');
			$table->string('ip_continent_code', 2);
			$table->string('ip_corporate_proxy', 3);
			$table->string('anonymous_proxy', 3);
			$table->integer('proxy_score')->unsigned();
			$table->string('is_trans_proxy', 3);
			$table->string('free_mail', 3);
			$table->string('carder_email', 3);
			$table->string('high_risk_username', 3);
			$table->string('high_risk_password', 3);
			$table->string('bin_match', 10);
			$table->string('bin_country', 2);
			$table->string('bin_name_match', 3);
			$table->string('bin_name');
			$table->string('bin_phone_match', 3);
			$table->string('bin_phone', 32);
			$table->string('customer_phone_in_billing_location', 8);
			$table->string('ship_forward', 3);
			$table->string('city_postal_match', 3);
			$table->string('ship_city_postal_match', 3);
			$table->decimal('score', 10, 5)->unsigned();
			$table->text('explanation', 65535);
			$table->decimal('risk_score', 10, 5)->unsigned();
			$table->integer('queries_remaining')->unsigned();
			$table->string('maxmind_id', 8);
			$table->text('error', 65535);
			$table->dateTime('date_added')->default('0000-00-00 00:00:00');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('order_fraud');
	}

}
