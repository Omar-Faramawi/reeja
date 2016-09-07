<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContractLocationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contract_locations', function(Blueprint $table)
		{
			$table->increments("id");
			$table->unsignedInteger('contract_id')->index('fk_contract_locations_Taqawol_contract_idx');
			$table->unsignedInteger('branch_id')->index('fk_contract_locations_establishments1_idx');
			$table->integer('region_id')->nullable();
			$table->string('desc_location', 45)->nullable();
			$table->timestamps();
			$table->unsignedInteger('created_by');
			$table->unsignedInteger('updated_by')->nullable();
		    $table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('contract_locations');
	}

}
