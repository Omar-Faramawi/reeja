<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToContractProvidersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('contract_providers', function(Blueprint $table)
		{
			$table->foreign('contract_type_id', 'fk_contract_providers_contract_types1')->references('id')->on('contract_types')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('service_prvdr_benf_id', 'fk_contract_providers_service_prvdr_benf1')->references('id')->on('service_prvdr_benf')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('contract_providers', function(Blueprint $table)
		{
			$table->dropForeign('fk_contract_providers_contract_types1');
			$table->dropForeign('fk_contract_providers_service_prvdr_benf1');
		});
	}

}
