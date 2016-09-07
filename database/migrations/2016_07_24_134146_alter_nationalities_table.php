<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterNationalitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nationalities', function (Blueprint $table) {
            $table->foreign('created_by',
                'nationalities_ibfk1')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('updated_by',
                'nationalities_ibfk2')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nationalities', function (Blueprint $table) {
            $table->dropForeign('nationalities_ibfk1');
            $table->dropForeign('nationalities_ibfk2');
        });
    }
}
