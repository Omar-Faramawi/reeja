<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePermissionSpecificUsersForDataMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permission_specific_users', function(Blueprint $table)
        {
			$table->integer('user_id')->unsigned()->change();
			$table->string('user_type', 1)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permission_specific_users', function(Blueprint $table)
        {
			$table->integer('user_id')->change();
			$table->integer('user_type')->change();
        });
    }
}
