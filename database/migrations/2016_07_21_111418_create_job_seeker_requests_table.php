<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateJobSeekerRequestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('job_requests', function(Blueprint $table)
		{
			$table->increments("id");
			$table->unsignedInteger('hr_pool_id_number')->index('fk_job_seeker_requests_hr_pool1_idx');
			$table->unsignedInteger('vacancies_id')->index('fk_job_seeker_requests_vacancies1_idx');
			$table->string('status', 45)->nullable();
			$table->unsignedInteger('reasons_id')->nullable()->index('fk_job_seeker_requests_reasons1_idx');
			$table->unsignedInteger('created_by');
			$table->unsignedInteger('updated_by')->nullable();
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('job_requests');
	}

}
