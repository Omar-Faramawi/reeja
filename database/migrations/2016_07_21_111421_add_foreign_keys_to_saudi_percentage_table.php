<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToSaudiPercentageTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('saudi_percentages', function(Blueprint $table)
		{
			$table->foreign('contract_type_id', 'fk_taqaual_saudi_pct_contract_types1')->references('id')->on('contract_types')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('provider_activity_id', 'fk_taqaual_saudi_pct_est_permission_activities1')->references('id')->on('est_permission_activities')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('benf_activity_id', 'fk_taqaual_saudi_pct_est_permission_activities2')->references('id')->on('est_permission_activities')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('provider_size_id', 'fk_taqaual_saudi_pct_est_sizes1')->references('id')->on('est_sizes')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('benf_size_id', 'fk_taqaual_saudi_pct_est_sizes2')->references('id')->on('est_sizes')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('saudi_percentages', function(Blueprint $table)
		{
			$table->dropForeign('fk_taqaual_saudi_pct_contract_types1');
			$table->dropForeign('fk_taqaual_saudi_pct_est_permission_activities1');
			$table->dropForeign('fk_taqaual_saudi_pct_est_permission_activities2');
			$table->dropForeign('fk_taqaual_saudi_pct_est_sizes1');
			$table->dropForeign('fk_taqaual_saudi_pct_est_sizes2');
		});
	}

}
