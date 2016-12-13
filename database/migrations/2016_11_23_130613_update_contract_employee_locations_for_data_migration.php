<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateContractEmployeeLocationsForDataMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contract_employee_locations', function(Blueprint $table)
        {
			$table->string('location', 255)->nullable()->change();
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contract_employee_locations', function(Blueprint $table)
        {
			$table->string('location', 45)->nullable()->change();
        });
    }
}
