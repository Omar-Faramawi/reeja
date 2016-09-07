<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToGovernmentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('governments', function(Blueprint $table)
		{
			$table->foreign('parent_id', 'fk_governments_governments1')->references('id')->on('governments')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('governments', function(Blueprint $table)
		{
			$table->dropForeign('fk_governments_governments1');
		});
	}

}
