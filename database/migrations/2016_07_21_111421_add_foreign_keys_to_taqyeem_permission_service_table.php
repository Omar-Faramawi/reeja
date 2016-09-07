<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTaqyeemPermissionServiceTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('taqyeem_permission_service', function(Blueprint $table)
		{
			$table->foreign('taqyeem_owner_id', 'fk_taqyeem_permision_service_service_providers1')->references('id')->on('service_prvdr_benf')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('resident_id', 'fk_taqyeem_permision_service_service_providers2')->references('id')->on('service_prvdr_benf')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('template_permission_id', 'fk_taqyeem_permision_service_taqyeem_template_permision1')->references('id')->on('taqyeem_template_permission')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('contract_type_id', 'fk_taqyeem_permission_service_contract_types1')->references('id')->on('contract_types')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('taqyeem_permission_service', function(Blueprint $table)
		{
			$table->dropForeign('fk_taqyeem_permision_service_service_providers1');
			$table->dropForeign('fk_taqyeem_permision_service_service_providers2');
			$table->dropForeign('fk_taqyeem_permision_service_taqyeem_template_permision1');
			$table->dropForeign('fk_taqyeem_permission_service_contract_types1');
		});
	}

}
