<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyTaqyeemTemplatePermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('taqyeem_template_permission', function (Blueprint $table) {
            $table->integer('periodic_period')->nullable()->change();
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
            $table->string('periodic_period', 1)->nullable()->change();
        });
    }
}
