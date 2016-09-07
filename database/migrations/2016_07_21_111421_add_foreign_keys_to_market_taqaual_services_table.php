<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToMarketTaqaualServicesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('market_taqaual_services', function(Blueprint $table)
		{
			$table->foreign('contract_nature_id', 'fk_est_services_contract_nature1')->references('id')->on('contract_nature')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('service_prvdr_benf_id', 'fk_raised_taqaual_services_service_prvdr_benf1')->references('id')->on('service_prvdr_benf')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('market_taqaual_services', function(Blueprint $table)
		{
			$table->dropForeign('fk_est_services_contract_nature1');
			$table->dropForeign('fk_raised_taqaual_services_service_prvdr_benf1');
		});
	}

}
