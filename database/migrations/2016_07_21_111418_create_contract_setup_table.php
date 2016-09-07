<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContractSetupTable extends Migration
{
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_setup', function (Blueprint $table) {
            $table->increments("id");
            $table->unsignedInteger('contract_type_id')->index('contract_type_id');
            $table->integer('offer_accept_period')->nullable();
            $table->integer('offer_accept_period_type')->nullable();
            $table->integer('min_accept_period');
            $table->integer('min_accept_period_type');
            $table->integer('max_accept_period')->nullable();
            $table->integer('max_accept_period_type');
            $table->integer('contract_cancel_period')->nullable();
            $table->integer('contract_cancel_period_type')->nullable();
            $table->string('provider_cancel_contract', 1)->nullable();
            $table->string('benf_cancel_contract', 1)->nullable();
            $table->string('saudi_service_avb', 1)->nullable();
            $table->integer('contract_accept_period')->nullable();
            $table->integer('contract_accept_period_type')->nullable();
            $table->integer('substitute_percintage')->nullable();
            $table->integer('max_labor_avb')->nullable();
            $table->string('ownership_att_time', 1)->nullable();
            $table->string('ownership_att_time_offer', 1)->nullable();
            $table->integer('experience_certificate_amount')->nullable();
            $table->integer('experience_certificate_pay_period')->nullable();
            $table->string('saudis_included', 1)->default(0)->nullable();
            $table->string('provider_cancel_ishaar', 1)->nullable();
            $table->string('benf_cancel_ishaar', 1)->nullable();
            $table->timestamps();
            $table->unsignedInteger('created_by')->index('created_by');
            $table->unsignedInteger('updated_by')->nullable()->index('updated_by');
        });
    }
    
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('contract_setup');
    }
    
}
