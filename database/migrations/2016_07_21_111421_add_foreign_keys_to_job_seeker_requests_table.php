<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToJobSeekerRequestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('job_requests', function(Blueprint $table)
		{
			$table->foreign('hr_pool_id_number', 'fk_job_seeker_requests_hr_pool1')->references('id')->on('hr_pool')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('reasons_id', 'fk_job_seeker_requests_reasons1')->references('id')->on('reasons')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('vacancies_id', 'fk_job_seeker_requests_vacancies1')->references('id')->on('vacancies')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('job_requests', function(Blueprint $table)
		{
			$table->dropForeign('fk_job_seeker_requests_hr_pool1');
			$table->dropForeign('fk_job_seeker_requests_reasons1');
			$table->dropForeign('fk_job_seeker_requests_vacancies1');
		});
	}

}
