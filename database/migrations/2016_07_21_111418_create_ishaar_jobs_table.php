<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIshaarJobsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ishaar_jobs', function(Blueprint $table)
		{
			$table->increments("id");
			$table->unsignedInteger('ishaar_setup_id')->index('fk_ishaar_jobs_ishaar_setup1_idx');
			$table->unsignedInteger('job_id')->index('fk_ishaar_jobs_jobs1_idx');
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
		Schema::drop('ishaar_jobs');
	}

}
