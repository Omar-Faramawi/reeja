<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAdJobsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ad_jobs', function(Blueprint $table)
		{
			$table->increments("id");
			$table->string('job_name', 150);
//			$table->string('saudi', 1)->nullable()->default('0');
//			$table->string('non_saudi', 1)->nullable()->default('0');
			$table->string('attachment_mandatory', 1)->default('0');
			$table->timestamps();
			$table->unsignedInteger('created_by');
			$table->unsignedInteger('updated_by')->nullable();
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ad_jobs');
	}

}
