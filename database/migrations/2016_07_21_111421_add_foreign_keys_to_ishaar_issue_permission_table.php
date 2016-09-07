<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToIshaarIssuePermissionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('ishaar_issue_permission', function(Blueprint $table)
		{
			$table->foreign('ishaar_setup_id', 'fk_ishaar_issue_permission_ishaar_setup1')->references('id')->on('ishaar_setup')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('ishaar_issue_permission', function(Blueprint $table)
		{
			$table->dropForeign('fk_ishaar_issue_permission_ishaar_setup1');
		});
	}

}
