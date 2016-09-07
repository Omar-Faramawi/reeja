<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToInvoicesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('invoices', function(Blueprint $table)
		{
			$table->foreign('banks_id', 'fk_invoices_banks1')->references('id')->on('banks')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('contracts_id', 'fk_invoices_contracts1')->references('id')->on('contracts')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('invoices', function(Blueprint $table)
		{
			$table->dropForeign('fk_invoices_banks1');
			$table->dropForeign('fk_invoices_contracts1');
		});
	}

}
