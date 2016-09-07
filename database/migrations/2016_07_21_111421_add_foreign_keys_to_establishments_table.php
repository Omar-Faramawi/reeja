<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToEstablishmentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('establishments', function(Blueprint $table)
		{
			$table->foreign('parent_id', 'fk_establishments_establishments1')->references('id')->on('establishments')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('reasons_id', 'fk_establishments_reasons1')->references('id')->on('reasons')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('establishments', function(Blueprint $table)
		{
			$table->dropForeign('fk_establishments_establishments1');
			$table->dropForeign('fk_establishments_reasons1');
		});
	}

}
