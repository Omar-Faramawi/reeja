<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTaqyeemDegreesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('taqyeem_degrees', function(Blueprint $table)
		{
			$table->foreign('taqyeem_item_id', 'fk_taqyeem_degrees_taqyeem_items1')->references('id')->on('taqyeem_items')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('taqyeem_degrees', function(Blueprint $table)
		{
			$table->dropForeign('fk_taqyeem_degrees_taqyeem_items1');
		});
	}

}
