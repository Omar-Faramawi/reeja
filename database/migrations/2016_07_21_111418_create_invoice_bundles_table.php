<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInvoiceBundlesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('invoice_bundles', function(Blueprint $table)
		{
			$table->increments("id");
            $table->string('provider_type', 1)->nullable();
            $table->unsignedInteger('provider_id')->nullable();
            $table->unsignedInteger('invoice_id')->nullable();
			$table->unsignedInteger('bundle_id')->index('fk_contract_bunch_bunches1_idx');
            $table->unsignedInteger('num_of_notices');
            $table->unsignedInteger('num_remaining_notices');
			$table->string('status', 1)->nullable();
            $table->date('expire_date');
			$table->timestamps();
			$table->unsignedInteger('created_by');
			$table->unsignedInteger('updated_by')->nullable();
                        $table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('invoice_bundles');
	}

}
