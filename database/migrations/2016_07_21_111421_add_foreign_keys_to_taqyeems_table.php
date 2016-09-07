<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTaqyeemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('taqyeems', function(Blueprint $table)
		{
			$table->foreign('contract_id', 'fk_evaluations_Taqawol_contract1')->references('id')->on('contracts')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('taqyeem_template_id', 'fk_evaluations_taqyeem_template1')->references('id')->on('taqyeem_template')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('taqyeem_owner', 'fk_evaluations_users1')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('taqyeems', function(Blueprint $table)
		{
			$table->dropForeign('fk_evaluations_Taqawol_contract1');
			$table->dropForeign('fk_evaluations_taqyeem_template1');
			$table->dropForeign('fk_evaluations_users1');
		});
	}

}
