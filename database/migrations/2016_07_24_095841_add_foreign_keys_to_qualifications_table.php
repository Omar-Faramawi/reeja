<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToQualificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('qualifications', function (Blueprint $table) {
            $table->foreign('created_by',
                'qualifications_ibfk1')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('updated_by',
                'qualifications_ibfk2')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('qualifications', function (Blueprint $table) {
            $table->dropForeign('qualifications_ibfk1');
            $table->dropForeign('qualifications_ibfk2');
        });
    }
}
