<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNationalityForJobTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('nationality_for_job', function(Blueprint $table)
		{
			$table->increments("id");
			$table->unsignedInteger('nationality_id')->index('fk_nationality_for_job_nationalities1_idx');
			$table->unsignedInteger('ishaar_job_id')->index('fk_nationality_for_job_ishaar_jobs1_idx');
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
		Schema::drop('nationality_for_job');
	}

}
