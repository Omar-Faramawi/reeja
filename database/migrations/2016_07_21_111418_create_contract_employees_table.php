<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContractEmployeesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contract_employees', function(Blueprint $table)
		{
			$table->increments("id");
			$table->unsignedInteger('contract_id')->index('fk_contract_employees_Taqawol_contract1_idx');
			$table->integer('id_number');
			$table->date('start_date')->nullable();
			$table->date('end_date')->nullable();
			$table->string('salary', 45)->nullable();
			$table->enum('status', ['pending', 'rejected', 'pending_ownership','approved', 'cancelled', 'benef_cancel', 'provider_cancel']);
			$table->unsignedInteger('reasons_id')->nullable()->index('fk_contract_employees_reasons1_idx');
			$table->string('rejection_reason')->nullable();
            $table->string('other_reasons')->nullable();
			$table->string('conditions')->nullable();
			$table->string('condition_approval', 1)->nullable();
			$table->string('provider_rules_approval', 1)->nullable();
			$table->string('benf_rules_approval', 1)->nullable();
			$table->unsignedInteger('bundle_id')->nullable()->index('fk_taqawol_contract_employees_contract_bunch1_idx');
			$table->unsignedInteger('ishaar_id')->index('fk_contract_employees_ishaar_setup1_idx');
			$table->integer('ishaar_cancel_ref_no')->nullable();
			$table->string('qualification_upload')->nullable();
			$table->unsignedInteger('invoices_id')->nullable()->index('fk_contract_employees_invoices1_idx');
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
		Schema::drop('contract_employees');
	}

}
