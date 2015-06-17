<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBlogPostRelatedTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('blog_post_related', function(Blueprint $table)
		{
			$table->integer('post_id')->unsigned()->index('post_id_idx');
			$table->integer('related_id')->unsigned()->index('related_id_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('blog_post_related');
	}

}
