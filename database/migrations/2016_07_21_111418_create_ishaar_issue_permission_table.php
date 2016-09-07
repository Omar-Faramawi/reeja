<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIshaarIssuePermissionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ishaar_issue_permission', function(Blueprint $table)
		{
			$table->increments("id");
			$table->unsignedInteger('ishaar_setup_id')->index('fk_ishaar_issue_permission_ishaar_setup1_idx');
			$table->unsignedInteger('labor_borrow_count')->nullable();
            $table->string('ishaar_issue_est', 1);
			$table->string('ishaar_issue_indv', 1)->nullable();
			$table->string('ishaar_issue_gover', 1)->nullable();
			$table->string('ishaar_benf_est', 1)->nullable();
			$table->string('ishaar_benf_indv', 1)->nullable();
			$table->string('ishaar_benf_gover', 1)->nullable();
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
		Schema::drop('ishaar_issue_permission');
	}

}
