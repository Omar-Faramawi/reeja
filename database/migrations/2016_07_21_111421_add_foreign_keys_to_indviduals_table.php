<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToIndvidualsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('indviduals', function(Blueprint $table)
		{
			$table->foreign('user_type_id', 'fk_indviduals_user_types1')->references('id')->on('user_types')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('indviduals', function(Blueprint $table)
		{
			$table->dropForeign('fk_indviduals_user_types1');
		});
	}

}
