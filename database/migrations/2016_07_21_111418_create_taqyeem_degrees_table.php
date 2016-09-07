<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTaqyeemDegreesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('taqyeem_degrees', function(Blueprint $table)
		{
			$table->increments("id");
			$table->string('name', 45);
			$table->unsignedInteger('taqyeem_item_id')->index('fk_taqyeem_degrees_taqyeem_items1_idx');
			$table->string('active', 1)->default('0');
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
		Schema::drop('taqyeem_degrees');
	}

}
