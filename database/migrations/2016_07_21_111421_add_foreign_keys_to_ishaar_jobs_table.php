<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToIshaarJobsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('ishaar_jobs', function(Blueprint $table)
		{
			$table->foreign('ishaar_setup_id', 'fk_ishaar_jobs_ishaar_setup1')->references('id')->on('ishaar_setup')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('job_id', 'fk_ishaar_jobs_jobs1')->references('id')->on('ad_jobs')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('ishaar_jobs', function(Blueprint $table)
		{
			$table->dropForeign('fk_ishaar_jobs_ishaar_setup1');
			$table->dropForeign('fk_ishaar_jobs_jobs1');
		});
	}

}
