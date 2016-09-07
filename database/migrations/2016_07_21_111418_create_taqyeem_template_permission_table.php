<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTaqyeemTemplatePermissionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('taqyeem_template_permission', function(Blueprint $table)
		{
			$table->increments("id");
			$table->integer('link_period')->nullable();
			$table->unsignedInteger('taqyeem_template_id')->index('fk_taqyeem_template_permision_taqyeem_template1_idx');
			$table->string('taqyeem_type', 1)->nullable();
			$table->string('periodic_or_date', 1)->nullable();
			$table->string('periodic_period', 1)->nullable();
			$table->date('taqyeem_date')->nullable();
			$table->string('residents', 1)->nullable();
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
		Schema::drop('taqyeem_template_permission');
	}

}
