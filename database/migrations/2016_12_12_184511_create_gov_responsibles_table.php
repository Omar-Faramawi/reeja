<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGovResponsiblesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gov_responsibles', function (Blueprint $table) {
            $table->increments("id");
            $table->integer('id_number')->nullable();
            $table->unsignedInteger('government_id')->index('fk_gov_responsibles_governments1_idx');
            $table->string('responsible_name', 45);
            $table->string('responsible_phone', 45);
            $table->string('responsible_email', 45);
            $table->string('job_name', 45);
            $table->timestamps();
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by')->nullable();

            $table->foreign('government_id', 'fk_gov_responsibles_governments1')->references('id')->on('governments')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('gov_responsibles');
    }
}
