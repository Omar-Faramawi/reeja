<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContractProvidersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contract_providers', function(Blueprint $table)
		{
			$table->increments("id");
			$table->unsignedInteger('contract_type_id')->index('fk_contract_providers_contract_types1_idx');
			$table->unsignedInteger('service_prvdr_benf_id')->index('fk_contract_providers_service_prvdr_benf1_idx');
			$table->string('description', 45)->nullable();
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
		Schema::drop('contract_providers');
	}

}
