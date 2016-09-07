<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSaudiPercentageTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('saudi_percentages', function(Blueprint $table)
		{
			$table->increments("id");
			$table->unsignedInteger('contract_type_id')->index('fk_taqaual_saudi_pct_contract_types1_idx');
			$table->unsignedInteger('provider_activity_id')->index('fk_taqaual_saudi_pct_est_permission_activities1_idx');
			$table->unsignedInteger('provider_size_id')->index('fk_taqaual_saudi_pct_est_sizes1_idx');
			$table->unsignedInteger('benf_activity_id')->index('fk_taqaual_saudi_pct_est_permission_activities2_idx');
			$table->unsignedInteger('benf_size_id')->index('fk_taqaual_saudi_pct_est_sizes2_idx');
			$table->integer('saudi_pct');
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
		Schema::drop('saudi_percentages');
	}

}
