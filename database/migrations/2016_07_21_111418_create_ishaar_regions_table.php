<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIshaarRegionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ishaar_regions', function(Blueprint $table)
		{
            $table->increments('id');
			$table->unsignedInteger('regions_id');
			$table->unsignedInteger('ishaar_setup_id');
			$table->unsignedInteger('created_by');
			$table->unsignedInteger('updated_by')->nullable();
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ishaar_regions');
	}

}
