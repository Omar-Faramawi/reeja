<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEstablishmentsTable extends Migration
{
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('establishments', function (Blueprint $table) {
            $table->increments("id");
            $table->string('labour_office_no', 45);
            $table->string('sequence_no', 45);
            $table->unsignedInteger('id_number');
            $table->string('email', 45);
            $table->string('name', 45);
            $table->integer('FK_establishment_id');
            $table->string('est_activity', 45)->nullable();
            $table->string('est_size', 45)->nullable();
            $table->string('est_nitaq', 45)->nullable();
            $table->string('district', 45)->nullable();
            $table->string('city', 45)->nullable();
            $table->string('region', 45)->nullable();
            $table->string('wasel_address', 45)->nullable();
            $table->string('local_liecense_no', 45)->nullable();
            $table->unsignedInteger('parent_id')->nullable()->index('fk_establishments_establishments1_idx');
            $table->string('status', 1);
            $table->string('hajj', 1)->nullable();
            $table->string('catering', 1)->nullable();
            $table->string('phone', 15);
            $table->unsignedInteger('branch_no');
            $table->unsignedInteger('reasons_id')->nullable()->index('fk_establishments_reasons1_idx');
            $table->string('rejection_reason', 45)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
        });
    }
    
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('establishments');
    }
    
}
