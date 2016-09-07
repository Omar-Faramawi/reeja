<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVacancyLocationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('vacancy_locations', function(Blueprint $table)
		{
			$table->increments("id");
			$table->string('location', 45);
			$table->unsignedInteger('vacancies_id')->index('fk_vacancy_locations_vacancies1_idx');
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
		Schema::drop('vacancy_locations');
	}

}
