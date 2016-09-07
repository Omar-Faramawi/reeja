<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToServiceUsersPermissionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('service_users_permission', function(Blueprint $table)
		{
			$table->foreign('contract_type_id', 'fk_service_users_permission_contract_types1')->references('id')->on('contract_types')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('service_prvdr_benf_id', 'fk_table1_service_prvdr_benf1')->references('id')->on('service_prvdr_benf')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('service_users_permission', function(Blueprint $table)
		{
			$table->dropForeign('fk_service_users_permission_contract_types1');
			$table->dropForeign('fk_table1_service_prvdr_benf1');
		});
	}

}
