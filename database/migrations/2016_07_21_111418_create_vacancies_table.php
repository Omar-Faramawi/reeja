<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVacanciesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('vacancies', function(Blueprint $table)
		{
			$table->increments("id");
			$table->integer('benf_id');
			$table->string('benf_type', 1);
			$table->unsignedInteger('job_id')->index('fk_vacancies_jobs1_idx');
			$table->integer('salary')->nullable();
			$table->tinyInteger('hide_salary')->default(0)->comment('0->show salary , 1-> hide salary');
			$table->unsignedInteger('nationality_id')->nullable()->index('fk_vacancies_nationalities1_idx');
			$table->string('gender', 1)->nullable();
			$table->string('religion', 1)->nullable();
			$table->integer('no_of_vacancies');
			$table->unsignedInteger('region_id')->nullable()->index('fk_vacancies_regions1_idx');
			$table->string('job_type', 1)->nullable();
			$table->date('work_start_date');
			$table->date('work_end_date');
			$table->string('status', 1);
			$table->string('rejection_reason', 45)->nullable();
			$table->timestamps();
			$table->unsignedInteger('created_by')->nullable();
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
        Schema::drop('vacancies');
    }

}
