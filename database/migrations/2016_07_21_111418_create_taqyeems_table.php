<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTaqyeemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('taqyeems', function(Blueprint $table)
		{
			$table->increments("id");
			$table->unsignedInteger('taqyeem_owner')->index('fk_evaluations_users1_idx');
			$table->unsignedInteger('contract_id')->index('fk_evaluations_Taqawol_contract1_idx');
			$table->string('status', 1);
			$table->unsignedInteger('taqyeem_template_id')->index('fk_evaluations_taqyeem_template1_idx');
			$table->unsignedInteger('benf_establishment_id')->nullable();
			$table->unsignedInteger('benf_government_id')->nullable();
			$table->unsignedInteger('benf_individual_id')->nullable();
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
		Schema::drop('taqyeems');
	}

}
