<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAttachmentForJobTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('attachment_for_job', function(Blueprint $table)
		{
			$table->increments("id");
			$table->unsignedInteger('job_id')->index('fk_attachment_for_jobs_jobs1_idx');
			$table->unsignedInteger('attachment_id')->index('fk_attachment_for_jobs_attachments1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('attachment_for_job');
	}

}
