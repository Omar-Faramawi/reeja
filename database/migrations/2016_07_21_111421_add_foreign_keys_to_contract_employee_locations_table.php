<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToContractEmployeeLocationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('contract_employee_locations', function(Blueprint $table)
		{
			$table->foreign('employee_id', 'fk_employee_ishaar_locations_taqawol_contract_employees1')->references('id')->on('contract_employees')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('contract_employee_locations', function(Blueprint $table)
		{
			$table->dropForeign('fk_employee_ishaar_locations_taqawol_contract_employees1');
		});
	}

}
