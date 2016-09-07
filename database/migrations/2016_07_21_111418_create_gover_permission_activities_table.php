<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGoverPermissionActivitiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('gover_permission_activities', function(Blueprint $table)
		{
			$table->increments("id");
			$table->string('chk', 1)->nullable();
			$table->unsignedInteger('activity_id')->index('fk_gover_permission_activities_activities1_idx');
			$table->timestamps();
			$table->unsignedInteger('created_by');
			$table->unsignedInteger('updated_by')->nullable();
			$table->unsignedInteger('service_users_permission_id')->index('fk_gover_permission_activities_service_users_permission1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('gover_permission_activities');
	}

}
