<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToPermissionSpecificUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('permission_specific_users', function(Blueprint $table)
		{
			$table->foreign('template_permission_id', 'fk_table1_taqyeem_template_permision1')->references('id')->on('taqyeem_template_permission')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('permission_specific_users', function(Blueprint $table)
		{
			$table->dropForeign('fk_table1_taqyeem_template_permision1');
		});
	}

}
