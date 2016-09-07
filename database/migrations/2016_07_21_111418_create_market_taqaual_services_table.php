<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMarketTaqaualServicesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('market_taqaual_services', function(Blueprint $table)
		{
			$table->increments("id");
			$table->unsignedInteger('contract_nature_id')->index('fk_est_services_contract_nature1_idx');
			$table->string('description', 45)->nullable();
			$table->string('provider_or_benf', 1);
			$table->unsignedInteger('service_prvdr_benf_id')->index('fk_raised_taqaual_services_service_prvdr_benf1_idx');
			$table->unsignedInteger('service_id');
            $table->tinyInteger('status')->default(1)->comment('1-> published , 0-> saved draft');
			$table->timestamps();
			$table->integer('created_by');
			$table->integer('updated_by')->nullable();
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
		Schema::drop('market_taqaual_services');
	}

}
