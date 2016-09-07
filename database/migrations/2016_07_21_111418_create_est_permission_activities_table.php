<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEstPermissionActivitiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('est_permission_activities', function(Blueprint $table)
		{
			$table->increments("id");
			$table->unsignedInteger('service_users_permission_id')->index('fk_est_permission_activities_service_users_permission1_idx');
			$table->unsignedInteger('activity_id')->index('fk_permission_activities_activities1_idx');
			$table->string('provider', 1)->nullable();
			$table->string('benf', 1)->nullable();
			$table->string('benf_activity', 1)->nullable();
			$table->integer('borrow_pct');
			$table->integer('loan_pct');
			$table->timestamps();
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
		Schema::drop('est_permission_activities');
	}

}
