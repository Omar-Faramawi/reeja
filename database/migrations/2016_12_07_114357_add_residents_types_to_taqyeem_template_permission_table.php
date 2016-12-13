<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddResidentsTypesToTaqyeemTemplatePermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('taqyeem_template_permission', function (Blueprint $table) {
            $table->string('ind', 1)->after('residents')->nullable();
            $table->string('est', 1)->after('ind')->nullable();
            $table->string('gov', 1)->after('est')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('taqyeem_template_permission', function (Blueprint $table) {
            $table->dropColumn('ind');
            $table->dropColumn('est');
            $table->dropColumn('gov');
        });
    }
}
