<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToIshaarSetupTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('ishaar_setup', function(Blueprint $table)
		{
			$table->foreign('ishaar_type_id', 'fk_ishaar_types_idx')->references('id')->on('ishaar_types')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('ishaar_setup', function(Blueprint $table)
		{
			$table->dropForeign('fk_ishaar_types_idx');
		});
	}

}
