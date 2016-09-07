<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToPermissionServiceEnvironmentTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('permission_service_environment', function(Blueprint $table)
		{
			$table->foreign('contract_type_id', 'fk_service_environment_contract_types1')->references('id')->on('contract_types')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('template_permission_id', 'fk_service_environment_taqyeem_template_permision1')->references('id')->on('taqyeem_template_permission')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('permission_service_environment', function(Blueprint $table)
		{
			$table->dropForeign('fk_service_environment_contract_types1');
			$table->dropForeign('fk_service_environment_taqyeem_template_permision1');
		});
	}

}
