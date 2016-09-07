<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIshaarSetupTable extends Migration
{
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ishaar_setup', function (Blueprint $table) {
            $table->increments("id");
            $table->unsignedInteger('ishaar_type_id');
            $table->string('name');
            $table->integer('max_ishaar_period')->nullable();
            $table->integer('min_no_of_ishaars')->nullable();                          //new
            $table->integer('max_no_of_ishaars')->nullable();                          //new
            $table->integer('max_ishaar_period_type')->nullable();                     //new For taqawel & temp_work
            $table->integer('min_ishaar_period')->nullable();                          //new For taqawel & temp_work
            $table->integer('min_ishaar_period_type')->nullable();                     //new For taqawel & temp_work
            $table->string('labor_gender_male', 1)->nullable();                        //new
            $table->string('labor_gender_female', 1)->nullable();                      //new
            $table->string('ishaar_cancel_free', 1)->nullable();                       //new
            $table->string('ishaar_cancel_paid', 1)->nullable();                       //new
            $table->tinyInteger('trial_ishaar_num')->nullable();                       //new paid
            $table->unsignedInteger('paid_ishaar_payment_expiry_period')->nullable();  //new paid
            $table->tinyInteger('paid_ishaar_payment_expiry_period_type')->nullable(); //new paid
            $table->unsignedInteger('paid_ishaar_valid_expiry_period')->nullable();    //new paid
            $table->tinyInteger('paid_ishaar_valid_expiry_period_type')->nullable();   //new paid
            $table->tinyInteger('labor_follow_provider_perm')->nullable();             //new paid
            $table->tinyInteger('labor_follow_benef_perm')->nullable();                //new paid
            $table->tinyInteger('labor_follow_all_perm')->nullable();                  //new paid
            $table->tinyInteger('labor_multi_regions_perm')->nullable();               //new paid
            $table->unsignedInteger('labor_multi_regions_perm_num')->nullable();       //new paid
            $table->integer('labor_same_benef_max_num_of_ishaar')->nullable();         //new paid
            $table->integer('labor_same_benef_max_period_of_ishaar')->nullable();           //new paid
            $table->tinyInteger('labor_same_benef_max_period_of_ishaar_type')->nullable();  //new paid
            $table->integer('max_of_notice_renew_time')->nullable();
            $table->integer('max_no_of_ishaar_labor')->nullable();
            $table->integer('ishaar_lobor_times')->nullable();
            $table->integer('total_period_labor')->nullable();
            $table->tinyInteger('labor_status_employed')->nullable();
            $table->tinyInteger('labor_status_companion')->nullable();
            $table->tinyInteger('labor_status_visitor')->nullable();
            $table->string('ishaar_cancel_provider', 1)->nullable();
            $table->string('ishaar_cancel_benf', 1)->nullable();
            $table->string('labor_permission_provider', 1)->nullable();
            $table->string('labor_permission_all', 1)->nullable();
            $table->string('labor_permission_benf', 1)->nullable();
            $table->string('nitaq_active', 1)->nullable();
            $table->string('nitaq_haj', 1)->nullable();
            $table->string('nitaq_gover', 1)->nullable();
            $table->integer('amount')->nullable();
            $table->integer('payment_period')->nullable();
            $table->string('issued_season', 1)->nullable();
            $table->date('period_start_date')->nullable();
            $table->date('period_end_date')->nullable();
            $table->integer('max_labor_from_haj')->nullable();
            $table->integer('no_of_borrow_labor')->nullable();
            $table->integer('ishaar_cancel_period')->nullable();
            $table->integer('frequency');
            $table->timestamps();
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by')->nullable();
            $table->softDeletes();
        });
    }
    
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ishaar_setup');
    }
    
}
