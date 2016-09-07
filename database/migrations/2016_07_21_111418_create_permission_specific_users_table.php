<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePermissionSpecificUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('permission_specific_users', function(Blueprint $table)
		{
			$table->increments("id");
			$table->unsignedInteger('template_permission_id')->index('fk_table1_taqyeem_template_permision1_idx');
			$table->integer('establishment_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('permission_specific_users');
	}

}
