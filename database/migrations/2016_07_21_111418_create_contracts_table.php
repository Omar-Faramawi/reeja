<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContractsTable extends Migration
{
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->increments("id");
            $table->unsignedInteger('contract_type_id')->index('fk_contracts_contract_types1_idx');
            $table->string('provider_type', 1);
            $table->unsignedInteger('provider_id');
            $table->string('benf_type', 1);
            $table->integer('benf_id');
            $table->unsignedInteger('contract_nature_id')->nullable()->index('fk_Taqawol_contract_contract_nature1_idx');
            $table->string('contract_name', 45);
            $table->string('contract_desc');
            $table->string('contract_amount', 45)->nullable();
            $table->string('contract_locations', 255)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('contract_ref_no')->nullable();
            $table->unsignedInteger('ishaar_id')->nullable()->index('fk_contract_ishaar_setup_idx');
            $table->string('more_one_location', 1)->nullable();
            $table->enum('status', [
                'requested',
                'pending',
                'rejected',
                'pending_ownership',
                'approved',
                'cancelled',
                'benef_cancel',
                'provider_cancel',
            ]);
            $table->string('approval_provider', 1)->nullable();
            $table->string('approval_benf', 1)->nullable();
            $table->unsignedInteger('reason_id')->nullable()->index('fk_Taqawol_contract_reasons1_idx');
            $table->string('rejection_reason')->nullable();
            $table->string('other_reasons')->nullable();
            $table->string('contract_file')->nullable();
            $table->integer('cancel_ref_no')->nullable();
            $table->string('rules_approval', 1)->nullable();
            $table->string('conditions_cancel')->nullable();
            $table->string('conditions_reback')->nullable();
            $table->integer('ownership_id')->nullable();
            $table->tinyInteger('job_type')->nullable(); //new
            $table->string('ownership_approval', 1)->nullable();
            $table->unsignedInteger('job_request_id')->nullable()->index('fk_contracts_job_seeker_requests1_idx');
            $table->unsignedInteger('market_taqaual_services_id')->nullable()->index('fk_contracts_raised_taqaual_services1_idx');
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('vacancy_id')->index('fk_vacancy_id_contracts_table');
            $table->softDeletes();
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
        Schema::drop('contracts');
    }
    
    
}
