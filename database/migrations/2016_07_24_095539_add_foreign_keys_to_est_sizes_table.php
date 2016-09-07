<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToEstSizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('est_sizes', function (Blueprint $table) {
            $table->foreign('updated_by',
                'est_sizes_ibfk_2')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('created_by',
                'est_sizes_ibfk_1')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('est_sizes', function (Blueprint $table) {
            $table->dropForeign('est_sizes_ibfk_2');
            $table->dropForeign('est_sizes_ibfk_1');
        });
    }
}
