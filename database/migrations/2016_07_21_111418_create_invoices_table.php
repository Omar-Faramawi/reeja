<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInvoicesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('invoices', function(Blueprint $table)
		{
			$table->increments("id");
			$table->bigInteger('bill_number')->unsigned()->index();
			$table->unsignedInteger('contracts_id')->index('fk_invoices_contracts1_idx')->nullable();
			$table->unsignedInteger('banks_id')->index('fk_invoices_banks1_idx')->nullable();
			$table->float('amount', 10);
			$table->string('account_no', 25)->nullable();
			$table->string('benf_name', 45);
			$table->string('description', 45)->nullable();
			$table->date('issue_date');
			$table->date('expiry_date');
			$table->string('paid_date', 45)->nullable();
			$table->string('upload_invoice')->nullable();
			$table->string('status', 1);
                        $table->string('provider_type', 1)->nullable();
                        $table->unsignedInteger('provider_id')->nullable();
                        $table->unsignedInteger('invoice_type')->nullable();
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
		Schema::drop('invoices');
	}

}
