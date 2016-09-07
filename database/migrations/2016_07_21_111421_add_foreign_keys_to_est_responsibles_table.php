<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToEstResponsiblesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('est_responsibles', function(Blueprint $table)
		{
			$table->foreign('establishments_id', 'fk_est_responsibles_establishments1')->references('id')->on('establishments')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('est_responsibles', function(Blueprint $table)
		{
			$table->dropForeign('fk_est_responsibles_establishments1');
		});
	}

}
