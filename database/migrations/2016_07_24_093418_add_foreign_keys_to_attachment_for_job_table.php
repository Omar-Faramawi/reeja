<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToAttachmentForJobTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attachment_for_job', function(Blueprint $table)
        {
            $table->foreign('attachment_id', 'fk_attachment_for_jobs_attachments1_idx')->references('id')->on('attachments')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('job_id', 'fk_attachment_for_jobs_jobs1_idx')->references('id')->on('ad_jobs')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attachment_for_job', function(Blueprint $table)
        {
            $table->dropForeign('fk_attachment_for_jobs_attachments1_idx');
            $table->dropForeign('fk_attachment_for_jobs_jobs1_idx');
        });
    }

}
