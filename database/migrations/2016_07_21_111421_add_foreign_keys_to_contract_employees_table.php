<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToContractEmployeesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('contract_employees', function(Blueprint $table)
		{
			$table->foreign('contract_id', 'fk_contract_employees_Taqawol_contract1')->references('id')->on('contracts')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('invoices_id', 'fk_contract_employees_invoices1')->references('id')->on('invoices')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('ishaar_id', 'fk_contract_employees_ishaar_setup1')->references('id')->on('ishaar_setup')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('reasons_id', 'fk_contract_employees_reasons1')->references('id')->on('reasons')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('bundle_id', 'fk_taqawol_contract_employees_invoice_bundle1')->references('id')->on('invoice_bundles')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('contract_employees', function(Blueprint $table)
		{
			$table->dropForeign('fk_contract_employees_Taqawol_contract1');
			$table->dropForeign('fk_contract_employees_invoices1');
			$table->dropForeign('fk_contract_employees_ishaar_setup1');
			$table->dropForeign('fk_contract_employees_reasons1');
			$table->dropForeign('fk_taqawol_contract_employees_invoice_bundle1');
		});
	}

}
