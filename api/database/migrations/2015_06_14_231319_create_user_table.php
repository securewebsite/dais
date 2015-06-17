<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user', function(Blueprint $table)
		{
			$table->increments('user_id');
			$table->integer('user_group_id')->unsigned();
			$table->string('user_name', 20);
			$table->string('password', 40);
			$table->string('salt', 9);
			$table->string('firstname', 32);
			$table->string('lastname', 32);
			$table->string('email', 96);
			$table->string('code', 40);
			$table->string('ip', 40);
			$table->boolean('status');
			$table->dateTime('date_added')->default('0000-00-00 00:00:00');
			$table->dateTime('last_access')->default('0000-00-00 00:00:00');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user');
	}

}
