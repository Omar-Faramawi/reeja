<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToEstPermissionActivitiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('est_permission_activities', function(Blueprint $table)
		{
			$table->foreign('service_users_permission_id', 'fk_est_permission_activities_service_users_permission1')->references('id')->on('service_users_permission')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('activity_id', 'fk_permission_activities_activities1')->references('id')->on('activities')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('est_permission_activities', function(Blueprint $table)
		{
			$table->dropForeign('fk_est_permission_activities_service_users_permission1');
			$table->dropForeign('fk_permission_activities_activities1');
		});
	}

}
