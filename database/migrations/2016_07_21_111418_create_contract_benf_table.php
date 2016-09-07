<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContractBenfTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contract_benf', function(Blueprint $table)
		{
			$table->increments("id");
			$table->unsignedInteger('contract_provider_id')->index('fk_contract_benf_contract_providers1_idx');
			$table->unsignedInteger('service_prvdr_benf_id')->index('fk_contract_benf_service_prvdr_benf1_idx');
			$table->timestamps();
			$table->integer('created_by');
			$table->integer('updated_by')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('contract_benf');
	}

}
