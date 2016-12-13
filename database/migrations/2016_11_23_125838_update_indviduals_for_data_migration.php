<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateIndvidualsForDataMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('indviduals', function(Blueprint $table)
        {
			$table->integer('ownership_id')->nullable()->unsigned()->change();
			$table->string('name', 255)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('indviduals', function(Blueprint $table)
        {
			$table->integer('ownership_id')->nullable()->change();
			$table->string('name', 45)->change();
        });
    }
}
