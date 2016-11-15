<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyForeignKeysForSaudiPercentagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('saudi_percentages', function (Blueprint $table) {
            $table->dropForeign('fk_taqaual_saudi_pct_est_permission_activities1');
            $table->dropForeign('fk_taqaual_saudi_pct_est_permission_activities2');
            $table->foreign('provider_activity_id', 'fk_taqaual_saudi_pct_est_permission_activities1')->references('id')->on('activities')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('benf_activity_id', 'fk_taqaual_saudi_pct_est_permission_activities2')->references('id')->on('activities')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('saudi_percentages', function (Blueprint $table) {
            $table->dropForeign('fk_taqaual_saudi_pct_est_permission_activities1');
            $table->dropForeign('fk_taqaual_saudi_pct_est_permission_activities2');
            $table->foreign('provider_activity_id', 'fk_taqaual_saudi_pct_est_permission_activities1')->references('id')->on('est_permission_activities')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('benf_activity_id', 'fk_taqaual_saudi_pct_est_permission_activities2')->references('id')->on('est_permission_activities')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }
}
