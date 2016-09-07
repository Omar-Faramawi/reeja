<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToHrPoolTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('hr_pool', function(Blueprint $table)
		{
			$table->foreign('experience_id', 'fk_employees_experiences1')->references('id')->on('experiences')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('job_id', 'fk_employees_jobs1')->references('id')->on('ad_jobs')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('nationality_id', 'fk_employees_nationalities1')->references('id')->on('nationalities')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('qualification_id', 'fk_employees_qualifications1')->references('id')->on('qualifications')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('region_id', 'fk_employees_regions1')->references('id')->on('regions')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('hr_pool', function(Blueprint $table)
		{
			$table->dropForeign('fk_employees_experiences1');
			$table->dropForeign('fk_employees_jobs1');
			$table->dropForeign('fk_employees_nationalities1');
			$table->dropForeign('fk_employees_qualifications1');
			$table->dropForeign('fk_employees_regions1');
		});
	}

}
