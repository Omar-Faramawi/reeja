<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToContractLocationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('contract_locations', function(Blueprint $table)
		{
			$table->foreign('contract_id', 'fk_contract_locations_Taqawol_contract')->references('id')->on('contracts')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('branch_id', 'fk_contract_locations_establishments1')->references('id')->on('establishments')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('contract_locations', function(Blueprint $table)
		{
			$table->dropForeign('fk_contract_locations_Taqawol_contract');
			$table->dropForeign('fk_contract_locations_establishments1');
		});
	}

}
