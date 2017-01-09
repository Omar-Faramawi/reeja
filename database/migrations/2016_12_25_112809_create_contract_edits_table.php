<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractEditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_edits', function (Blueprint $table) {
            $table->increments("id");
            $table->unsignedInteger('contract_id')->index('fk_contract_edits1_idx');
            $table->string('contract_file')->nullable();
            $table->text('contract_locations')->nullable();
            $table->enum('status', [
                'pending',
                'rejected',
                'approved',
            ]);
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('contract_edits');
    }
}
