<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToIndividualLaborsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('individual_labors', function(Blueprint $table)
		{
			$table->foreign('indviduals_id_number', 'fk_individual_labors_indviduals1')->references('id')->on('indviduals')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('individual_labors', function(Blueprint $table)
		{
			$table->dropForeign('fk_individual_labors_indviduals1');
		});
	}

}
