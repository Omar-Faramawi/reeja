<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToBanksTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('banks', function(Blueprint $table)
        {
            $table->foreign('parent_bank_id', 'fk_banks_banks1')->references('id')->on('banks')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('created_by', 'banks_ibfk_1')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('updated_by', 'banks_ibfk_2')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('banks', function(Blueprint $table)
        {
            $table->dropForeign('fk_banks_banks1');
            $table->dropForeign('banks_ibfk_1');
            $table->dropForeign('banks_ibfk_2');
        });
    }

}
