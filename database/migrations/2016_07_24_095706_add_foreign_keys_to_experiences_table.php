<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToExperiencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('experiences', function (Blueprint $table) {
            $table->foreign('created_by',
                'experiences_ibfk1')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('updated_by',
                'experiences_ibfk2')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('experiences', function (Blueprint $table) {
            $table->dropForeign('experiences_ibfk1');
            $table->dropForeign('experiences_ibfk2');
        });
    }
}
