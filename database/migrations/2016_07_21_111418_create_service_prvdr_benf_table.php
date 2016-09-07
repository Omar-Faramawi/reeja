<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateServicePrvdrBenfTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_prvdr_benf', function (Blueprint $table) {
            $table->increments("id");
            $table->string('name', 45);
            $table->timestamps();
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by')->nullable();
        });

        foreach (\Tamkeen\Ajeer\Utilities\Constants::userTypes() as $userType ) {
            DB::table('service_prvdr_benf')->insert([
                'name'       => $userType,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
                'created_by' => 1,
                'updated_by' => 1,
            ]);
        }

    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('service_prvdr_benf');
    }

}
