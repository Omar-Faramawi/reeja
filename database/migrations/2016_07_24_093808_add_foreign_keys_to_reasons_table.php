<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToReasonsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reasons', function(Blueprint $table)
        {
            $table->foreign('parent_id', 'fk_reasons_reasons1')->references('id')->on('reasons')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reasons', function(Blueprint $table)
        {
            $table->dropForeign('fk_reasons_reasons1');
        });
    }

}
