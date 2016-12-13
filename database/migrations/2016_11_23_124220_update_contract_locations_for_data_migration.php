<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateContractLocationsForDataMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contract_locations', function(Blueprint $table)
        {
			$table->string('desc_location', 255)->nullable()->change();
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contract_locations', function(Blueprint $table)
        {
			$table->string('desc_location', 45)->nullable()->change();
        });
    }
}
