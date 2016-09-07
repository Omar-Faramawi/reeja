<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEstResponsiblesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('est_responsibles', function(Blueprint $table)
		{
			$table->increments("id");
			$table->integer('id_number')->nullable();
			$table->unsignedInteger('establishments_id')->index('fk_est_responsibles_establishments1_idx');
			$table->string('responsible_name', 45);
			$table->string('responsible_phone', 45);
			$table->string('responsible_email', 45);
			$table->string('job_name', 45);
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
		Schema::drop('est_responsibles');
	}

}
