<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePermissionServiceEnvironmentTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('permission_service_environment', function(Blueprint $table)
		{
			$table->increments("id");
			$table->unsignedInteger('contract_type_id')->index('fk_service_environment_contract_types1_idx');
			$table->unsignedInteger('template_permission_id')->index('fk_service_environment_taqyeem_template_permision1_idx');
			$table->string('provider', 1)->nullable();
			$table->string('benf', 1)->nullable();
			$table->string('employer', 1)->nullable();
			$table->string('job_seeker', 1)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('permission_service_environment');
	}

}
