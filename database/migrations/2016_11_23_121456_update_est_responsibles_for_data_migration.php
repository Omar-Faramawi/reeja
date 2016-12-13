<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEstResponsiblesForDataMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('est_responsibles', function (Blueprint $table) {
            $table->integer('id_number')->nullable()->unsigned()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('est_responsibles', function(Blueprint $table)
        {
            $table->integer('id_number')->nullable()->change();
        });
    }
}
