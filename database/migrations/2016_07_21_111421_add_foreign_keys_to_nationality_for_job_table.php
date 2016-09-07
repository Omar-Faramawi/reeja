<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToNationalityForJobTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('nationality_for_job', function(Blueprint $table)
		{
			$table->foreign('ishaar_job_id', 'fk_nationality_for_job_ishaar_jobs1')->references('id')->on('ishaar_jobs')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('nationality_id', 'fk_nationality_for_job_nationalities1')->references('id')->on('nationalities')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('nationality_for_job', function(Blueprint $table)
		{
			$table->dropForeign('fk_nationality_for_job_ishaar_jobs1');
			$table->dropForeign('fk_nationality_for_job_nationalities1');
		});
	}

}
