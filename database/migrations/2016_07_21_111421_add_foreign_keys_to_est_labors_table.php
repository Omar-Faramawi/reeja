<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToEstLaborsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('est_labors', function(Blueprint $table)
		{
			$table->foreign('establishment_id', 'fk_est_employees_establishments1')->references('id')->on('establishments')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('est_labors', function(Blueprint $table)
		{
			$table->dropForeign('fk_est_employees_establishments1');
		});
	}

}
