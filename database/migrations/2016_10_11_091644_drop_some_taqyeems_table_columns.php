<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropSomeTaqyeemsTableColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('taqyeems', function (Blueprint $table) {
            $table->dropColumn('taqyeem_owner');
            $table->dropIndex('fk_evaluations_Taqawol_contract1_idx');
            $table->dropColumn('benf_establishment_id');
            $table->dropColumn('benf_government_id');
            $table->dropColumn('benf_individual_id');
            $table->string('owner_type', 1);
            $table->unsignedInteger('owner_id');
            $table->string('benf_type', 1);
            $table->unsignedInteger('benf_id');
            $table->unsignedInteger('contract_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('taqyeems', function (Blueprint $table) {
            $table->unsignedInteger('taqyeem_owner')->index('fk_evaluations_users1_idx');
            $table->unsignedInteger('benf_establishment_id')->nullable();
            $table->unsignedInteger('benf_government_id')->nullable();
            $table->unsignedInteger('benf_individual_id')->nullable();
            $table->dropColumn('owner_type');
            $table->dropColumn('owner_id');
            $table->dropColumn('benf_type');
            $table->dropColumn('benf_id');
            $table->unsignedInteger('contract_id')->index('fk_evaluations_Taqawol_contract1_idx')->change();
        });
    }
}
