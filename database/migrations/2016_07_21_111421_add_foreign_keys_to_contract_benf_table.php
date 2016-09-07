<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToContractBenfTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('contract_benf', function(Blueprint $table)
		{
			$table->foreign('contract_provider_id', 'fk_contract_benf_contract_providers1')->references('id')->on('contract_providers')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('service_prvdr_benf_id', 'fk_contract_benf_service_prvdr_benf1')->references('id')->on('service_prvdr_benf')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('contract_benf', function(Blueprint $table)
		{
			$table->dropForeign('fk_contract_benf_contract_providers1');
			$table->dropForeign('fk_contract_benf_service_prvdr_benf1');
		});
	}

}
