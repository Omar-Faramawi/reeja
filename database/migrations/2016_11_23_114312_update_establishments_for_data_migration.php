<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEstablishmentsForDataMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('establishments', function(Blueprint $table)
        {
            $table->integer('created_by')->unsigned()->change();
			$table->integer('updated_by')->nullable()->unsigned()->change();
			$table->string('name', 255)->change();
			$table->string('wasel_address', 255)->nullable()->change();
			$table->string('rejection_reason', 255)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('establishments', function(Blueprint $table)
        {
            $table->integer('created_by')->change();
			$table->integer('updated_by')->nullable()->change();
			$table->string('name', 45)->change();
			$table->string('wasel_address', 45)->nullable()->change();
			$table->string('rejection_reason', 45)->nullable()->change();
        });
    }
}
