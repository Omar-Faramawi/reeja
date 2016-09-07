<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTaqyeemTemplateItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('taqyeem_template_items', function(Blueprint $table)
		{
			$table->increments("id");
			$table->unsignedInteger('taqyeem_template_id')->index('fk_taqyeem_template_items_taqyeem_template1_idx');
			$table->unsignedInteger('taqyeem_item_id')->index('fk_taqyeem_template_items_taqyeem_items1_idx');
			$table->timestamps();
			$table->unsignedInteger('created_by');
			$table->unsignedInteger('updated_by')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('taqyeem_template_items');
	}

}
