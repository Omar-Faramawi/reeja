<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserIdAndUserTypeToPermissionSpecificUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permission_specific_users', function (Blueprint $table) {
	        $table->integer('user_id');
	        $table->integer('user_type');
	        $table->dropColumn('establishment_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permission_specific_users', function (Blueprint $table) {
        	$table->dropColumn('user_id');
	        $table->dropColumn('user_type');
	        $table->integer('establishment_id');
        });
    }
}
