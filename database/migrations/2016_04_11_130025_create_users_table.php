<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments("id");
            $table->string('name');
            $table->string('email');
            $table->unsignedInteger('user_type_id')->index('user_type_id');
            $table->string('password', 255);
            $table->unsignedInteger('id_no')->nullable()->index('id_no');
            $table->unsignedInteger('national_id')->nullable()->index('national_id');
            $table->string('active', 1);
            $table->string('remember_token')->nullable();
            $table->timestamps();
            $table->unsignedInteger('created_by')->index('created_by')->unsigned();
            $table->unsignedInteger('updated_by')->nullable()->index('updated_by')->unsigned();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('users');
    }
}
