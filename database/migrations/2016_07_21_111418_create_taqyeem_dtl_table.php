<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTaqyeemDtlTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('taqyeem_dtl', function(Blueprint $table)
		{
			$table->increments("id");
			$table->unsignedInteger('taqyeems_id')->index('fk_taqyeem_dtl_taqyeems1_idx');
			$table->unsignedInteger('degrees_id')->index('fk_taqyeem_dtl_degrees1_idx');
			$table->unsignedInteger('taqyeem_template_items_id')->index('fk_taqyeem_dtl_taqyeem_template_items1_idx');
			$table->timestamps();
			$table->integer('created_by');
			$table->integer('updated_by')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('taqyeem_dtl');
	}

}
