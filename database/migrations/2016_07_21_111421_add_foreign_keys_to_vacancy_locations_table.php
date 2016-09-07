<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToVacancyLocationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('vacancy_locations', function(Blueprint $table)
		{
			$table->foreign('vacancies_id', 'fk_vacancy_locations_vacancies1')->references('id')->on('vacancies')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('vacancy_locations', function(Blueprint $table)
		{
			$table->dropForeign('fk_vacancy_locations_vacancies1');
		});
	}

}
