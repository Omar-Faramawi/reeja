<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveEmployerAndJobSeekerFromPermissionServiceEnvironmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permission_service_environment', function (Blueprint $table) {
	        $table->dropColumn('employer');
	        $table->dropColumn('job_seeker');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permission_service_environment', function (Blueprint $table) {
	        $table->string('employer', 1)->nullable();
	        $table->string('job_seeker', 1)->nullable();
        });
    }
}
