<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToContractsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('contracts', function(Blueprint $table)
		{
			$table->foreign('contract_nature_id', 'fk_Taqawol_contract_contract_nature1')->references('id')->on('contract_nature')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('reason_id', 'fk_Taqawol_contract_reasons1')->references('id')->on('reasons')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('ishaar_id', 'fk_contract_ishaar_setup')->references('id')->on('ishaar_setup')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('contract_type_id', 'fk_contracts_contract_types1')->references('id')->on('contract_types')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('job_request_id', 'fk_contracts_job_seeker_requests1')->references('id')->on('job_requests')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('market_taqaual_services_id', 'fk_contracts_raised_taqaual_services1')->references('id')->on('market_taqaual_services')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('contracts', function(Blueprint $table)
		{
			$table->dropForeign('fk_Taqawol_contract_contract_nature1');
			$table->dropForeign('fk_Taqawol_contract_reasons1');
			$table->dropForeign('fk_contract_ishaar_setup');
			$table->dropForeign('fk_contracts_contract_types1');
			$table->dropForeign('fk_contracts_job_seeker_requests1');
			$table->dropForeign('fk_contracts_raised_taqaual_services1');
		});
	}

}
