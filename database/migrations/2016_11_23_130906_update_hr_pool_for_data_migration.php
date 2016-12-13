<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateHrPoolForDataMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hr_pool', function(Blueprint $table)
        {
            $table->integer('provider_id')->nullable()->unsigned()->change();
			$table->string('name', 255)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hr_pool', function(Blueprint $table)
        {
            $table->integer('provider_id')->nullable()->change();
			$table->string('name', 45)->nullable()->change();
        });
    }
}
