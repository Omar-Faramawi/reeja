<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContractEmployeeLocationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contract_employee_locations', function(Blueprint $table)
		{
			$table->increments("id");
			$table->unsignedInteger('employee_id')->index('fk_employee_ishaar_locations_taqawol_contract_employees1_idx');
			$table->string('location', 45)->nullable();
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
		Schema::drop('contract_employee_locations');
	}

}
