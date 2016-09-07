<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToGoverIshaarIssuePermissionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('gover_ishaar_issue_permission', function(Blueprint $table)
		{
			$table->foreign('activity_id', 'fk_gover_ishaar_issue_permission_activities1')->references('id')->on('activities')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('ishaar_issue_permission_id', 'fk_gover_ishaar_issue_permission_ishaar_issue_permission1')->references('id')->on('ishaar_issue_permission')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('gover_ishaar_issue_permission', function(Blueprint $table)
		{
			$table->dropForeign('fk_gover_ishaar_issue_permission_activities1');
			$table->dropForeign('fk_gover_ishaar_issue_permission_ishaar_issue_permission1');
		});
	}

}
