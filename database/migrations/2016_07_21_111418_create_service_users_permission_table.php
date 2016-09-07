<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateServiceUsersPermissionTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_users_permission', function (Blueprint $table) {
            $table->increments("id");
            $table->unsignedInteger('contract_type_id')->index('fk_service_users_permission_contract_types1_idx');
            $table->unsignedInteger('service_prvdr_benf_id')->index('fk_table1_service_prvdr_benf1_idx');
            $table->string('benf_est', 1)->nullable();
            $table->string('benf_indv', 1)->nullable();
            $table->string('benf_gover', 1)->nullable();
            $table->integer('avl_borrow_labor')->nullable();
            $table->softDeletes();
            $table->unsignedInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('service_users_permission');
    }

}
