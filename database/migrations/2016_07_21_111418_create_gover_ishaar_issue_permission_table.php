<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGoverIshaarIssuePermissionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('gover_ishaar_issue_permission', function(Blueprint $table)
		{
			$table->increments("id");
			$table->unsignedInteger('ishaar_issue_permission_id')->index('fk_gover_ishaar_issue_permission_ishaar_issue_permission1_idx');
			$table->unsignedInteger('activity_id')->index('fk_gover_ishaar_issue_permission_activities1_idx');
			$table->string('chk', 1)->nullable();
			$table->timestamps();
			$table->integer('created_by');
			$table->integer('updated_by')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('gover_ishaar_issue_permission');
	}

}
