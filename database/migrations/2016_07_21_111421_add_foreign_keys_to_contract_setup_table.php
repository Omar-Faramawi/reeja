<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToContractSetupTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('contract_setup', function(Blueprint $table)
		{
			$table->foreign('contract_type_id', 'fk_contract_setup_contract_types1')->references('id')->on('contract_types')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('contract_setup', function(Blueprint $table)
		{
			$table->dropForeign('fk_contract_setup_contract_types1');
		});
	}

}
