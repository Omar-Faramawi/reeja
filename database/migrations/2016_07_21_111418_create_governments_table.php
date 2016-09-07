<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGovernmentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('governments', function(Blueprint $table)
		{
			$table->increments("id");
			$table->string('name', 45);
			$table->unsignedInteger('parent_id')->nullable()->index('fk_governments_governments1_idx');
			$table->string('email', 45);
			$table->string('hajj', 1)->nullable();
			$table->timestamps();
			$table->softDeletes();
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
		Schema::drop('governments');
	}

}
