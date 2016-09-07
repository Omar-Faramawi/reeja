<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEstLaborsTable extends Migration
{
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('est_labors', function (Blueprint $table) {
            $table->increments("id");
            $table->integer('id_number');
            $table->string('name', 45)->nullable();
            $table->string('phone', 15)->nullable();
            $table->string('gender', 1)->nullable();
            $table->integer('job_id')->nullable();
            $table->integer('nationality_id')->nullable();
            $table->string('email', 45)->nullable();
            $table->unsignedInteger('establishment_id')->index('fk_est_employees_establishments1_idx');
            $table->string('chk', 1)->nullable();
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
        Schema::drop('est_labors');
    }
    
}
