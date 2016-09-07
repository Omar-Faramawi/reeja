<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTaqyeemDtlTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('taqyeem_dtl', function(Blueprint $table)
		{
			$table->foreign('degrees_id', 'fk_taqyeem_dtl_degrees1')->references('id')->on('taqyeem_degrees')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('taqyeem_template_items_id', 'fk_taqyeem_dtl_taqyeem_template_items1')->references('id')->on('taqyeem_template_items')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('taqyeems_id', 'fk_taqyeem_dtl_taqyeems1')->references('id')->on('taqyeems')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('taqyeem_dtl', function(Blueprint $table)
		{
			$table->dropForeign('fk_taqyeem_dtl_degrees1');
			$table->dropForeign('fk_taqyeem_dtl_taqyeem_template_items1');
			$table->dropForeign('fk_taqyeem_dtl_taqyeems1');
		});
	}

}
