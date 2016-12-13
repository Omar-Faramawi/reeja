<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMarketTaqaualServicesForDataMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('market_taqaual_services', function (Blueprint $table) {
            $table->integer('created_by')->unsigned()->change();
			$table->integer('updated_by')->nullable()->unsigned()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('market_taqaual_services', function(Blueprint $table)
        {
            $table->integer('created_by')->change();
			$table->integer('updated_by')->nullable()->change();
        });
    }
}
