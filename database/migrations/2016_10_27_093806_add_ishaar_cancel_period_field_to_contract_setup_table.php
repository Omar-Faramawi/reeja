<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIshaarCancelPeriodFieldToContractSetupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contract_setup', function (Blueprint $table) {
            $table->unsignedInteger('ishaar_cancel_period')
                ->after('offer_accept_period_type')
                ->nullable();

            $table->unsignedInteger('ishaar_cancel_period_type')
                  ->after('ishaar_cancel_period')
                  ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contract_setup', function (Blueprint $table) {
            $table->dropColumn('ishaar_cancel_period');
            $table->dropColumn('ishaar_cancel_period_type');
        });
    }
}
