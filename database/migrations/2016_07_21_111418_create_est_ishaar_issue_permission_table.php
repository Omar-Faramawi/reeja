<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEstIshaarIssuePermissionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('est_ishaar_issue_permission', function(Blueprint $table)
		{
			$table->increments("id");
			$table->unsignedInteger('ishaar_issue_permission_id')->index('fk_est_ishaar_issue_permission_ishaar_issue_permission1_idx');
			$table->unsignedInteger('activity_id')->index('fk_est_ishaar_issue_permission_activities1_idx');
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
		Schema::drop('est_ishaar_issue_permission');
	}

}
