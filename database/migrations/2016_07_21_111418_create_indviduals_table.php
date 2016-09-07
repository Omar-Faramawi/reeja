<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIndvidualsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('indviduals', function(Blueprint $table)
		{
			$table->increments('id');
			$table->unsignedInteger('nid');
			$table->integer('ownership_id')->nullable();
			$table->string('ownership_name', 45)->nullable();
			$table->string('ownership_phone', 15)->nullable();
			$table->string('name', 45);
			$table->string('email', 45);
			$table->string('phone', 45);
			$table->string('gender', 1);
			$table->string('religion', 1);
			$table->unsignedInteger('user_type_id')->index('fk_indviduals_user_types1_idx');
			$table->timestamps();
			$table->softDeletes();
			$table->unsignedInteger('created_by');
			$table->unsignedInteger('updated_by')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('indviduals');
	}

}
