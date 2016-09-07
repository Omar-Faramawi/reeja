<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTaqyeemPermissionServiceTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('taqyeem_permission_service', function(Blueprint $table)
		{
			$table->increments("id");
			$table->string('chk', 1)->nullable();
			$table->unsignedInteger('taqyeem_owner_id')->index('fk_taqyeem_permision_service_service_providers1_idx');
			$table->unsignedInteger('resident_id')->index('fk_taqyeem_permision_service_service_providers2_idx');
			$table->unsignedInteger('template_permission_id')->index('fk_taqyeem_permision_service_taqyeem_template_permision1_idx');
			$table->timestamps();
			$table->unsignedInteger('created_by');
			$table->unsignedInteger('updated_by')->nullable();
			$table->unsignedInteger('contract_type_id')->index('fk_taqyeem_permission_service_contract_types1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('taqyeem_permission_service');
	}

}
