<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePermissionServiceEnvironmentForDataMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permission_service_environment', function (Blueprint $table) {
            $table->integer('created_by')->nullable()->unsigned()->change();
			$table->integer('updated_by')->nullable()->unsigned()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permission_service_environment', function(Blueprint $table)
        {
            $table->integer('created_by')->nullable()->change();
			$table->integer('updated_by')->nullable()->change();
        });
    }
}
