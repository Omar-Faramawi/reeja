<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToGoverPermissionActivitiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('gover_permission_activities', function(Blueprint $table)
		{
			$table->foreign('activity_id', 'fk_gover_permission_activities_activities1')->references('id')->on('activities')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('service_users_permission_id', 'fk_gover_permission_activities_service_users_permission1')->references('id')->on('service_users_permission')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('gover_permission_activities', function(Blueprint $table)
		{
			$table->dropForeign('fk_gover_permission_activities_activities1');
			$table->dropForeign('fk_gover_permission_activities_service_users_permission1');
		});
	}

}
