<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHrPoolTable extends Migration
{
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_pool', function (Blueprint $table) {
            $table->increments('id');
			$table->unsignedInteger('id_number');
			$table->string('provider_type', 1)->nullable();
			$table->integer('provider_id')->nullable();
			$table->string('name', 45)->nullable();
			$table->integer('age')->nullable();
			$table->string('gender', 1)->nullable();
			$table->unsignedInteger('job_id')->nullable()->index('fk_employees_jobs1_idx');
			$table->unsignedInteger('experience_id')->nullable()->index('fk_employees_experiences1_idx');
			$table->unsignedInteger('nationality_id')->nullable()->index('fk_employees_nationalities1_idx');
			$table->unsignedInteger('qualification_id')->nullable()->index('fk_employees_qualifications1_idx');
			$table->string('email', 45)->nullable();
			$table->string('phone', 15)->nullable();
			$table->date('birth_date')->nullable();
			$table->string('religion', 1)->nullable();
			$table->date('work_start_date')->nullable();
			$table->date('work_end_date')->nullable();
			$table->string('status', 1)->nullable();
			$table->unsignedInteger('region_id')->nullable()->index('fk_employees_regions1_idx');
			$table->string('chk', 1)->nullable();
			$table->string('job_type', 1)->nullable();
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
        Schema::drop('hr_pool');
    }
    
}
