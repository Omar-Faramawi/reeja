<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTaqyeemTemplateItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('taqyeem_template_items', function(Blueprint $table)
		{
			$table->foreign('taqyeem_item_id', 'fk_taqyeem_template_items_taqyeem_items1')->references('id')->on('taqyeem_items')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('taqyeem_template_id', 'fk_taqyeem_template_items_taqyeem_template1')->references('id')->on('taqyeem_template')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('taqyeem_template_items', function(Blueprint $table)
		{
			$table->dropForeign('fk_taqyeem_template_items_taqyeem_items1');
			$table->dropForeign('fk_taqyeem_template_items_taqyeem_template1');
		});
	}

}
