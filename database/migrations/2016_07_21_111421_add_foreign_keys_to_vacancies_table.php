<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToVacanciesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('vacancies', function(Blueprint $table)
		{
			$table->foreign('job_id', 'fk_vacancies_jobs1')->references('id')->on('ad_jobs')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('nationality_id', 'fk_vacancies_nationalities1')->references('id')->on('nationalities')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('region_id', 'fk_vacancies_regions1')->references('id')->on('regions')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('vacancies', function(Blueprint $table)
		{
			$table->dropForeign('fk_vacancies_jobs1');
			$table->dropForeign('fk_vacancies_nationalities1');
			$table->dropForeign('fk_vacancies_regions1');
		});
	}

}
