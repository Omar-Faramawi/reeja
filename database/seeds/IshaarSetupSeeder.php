<?php

use Illuminate\Database\Seeder;
use Tamkeen\Ajeer\Models\IshaarJob;
use Tamkeen\Ajeer\Models\IshaarSetup;
use Tamkeen\Ajeer\Models\NationalityForJob;
use Tamkeen\Ajeer\Utilities\Constants;

class IshaarSetupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ishaarsArray = [
            [
                'id'                     => 1,
                'ishaar_type_id'         => Constants::CONTRACTTYPES['taqawel_free'],
                'max_ishaar_period'      => 100,
                'min_no_of_ishaars'      => 0,
                'max_no_of_ishaars'      => PHP_INT_MAX,
                'max_ishaar_period_type' => 1,
                'min_ishaar_period'      => 3,
                'min_ishaar_period_type' => 1,
                'labor_gender_male'      => 1,
                'labor_gender_female'    => 1,
                'ishaar_cancel_free'     => 0,
                'ishaar_cancel_paid'     => 0,
                'ishaar_cancel_provider' => 0,
                'ishaar_cancel_benf'     => 0,
                'nitaq_active'           => 0,
                'total_period_labor'     => 10000,
                'ishaar_lobor_times'     => 100,
                'labor_status_employed'  => 1,
                'labor_status_companion' => 1,
                'labor_status_visitor'   => 1,
            ],
            [
                'id'                                         => 2,
                'ishaar_type_id'                             => Constants::CONTRACTTYPES['taqawel_paid'],
                'max_ishaar_period'                          => 100,
                'min_no_of_ishaars'                          => 0,
                'max_no_of_ishaars'                          => PHP_INT_MAX,
                'max_ishaar_period_type'                     => 1,
                'min_ishaar_period'                          => 3,
                'min_ishaar_period_type'                     => 1,
                'labor_gender_male'                          => 1,
                'labor_gender_female'                        => 1,
                'ishaar_cancel_free'                         => 0,
                'ishaar_cancel_paid'                         => 0,
                'ishaar_cancel_provider'                     => 0,
                'ishaar_cancel_benf'                         => 0,
                'nitaq_active'                               => 0,
                'total_period_labor'                         => 10000,
                'ishaar_lobor_times'                         => 100,
                'labor_status_employed'                      => 1,
                'labor_status_companion'                     => 1,
                'labor_status_visitor'                       => 1,
                'trial_ishaar_num'                           => 1,
                'paid_ishaar_payment_expiry_period'          => 1,
                'paid_ishaar_payment_expiry_period_type'     => 2,
                'paid_ishaar_valid_expiry_period'            => 2,
                'paid_ishaar_valid_expiry_period_type'       => 2,
                'labor_multi_regions_perm'                   => 1,
                'labor_multi_regions_perm_num'               => 5,
                'labor_same_benef_max_num_of_ishaar'         => 3,
                'labor_same_benef_max_period_of_ishaar'      => 3,
                'labor_same_benef_max_period_of_ishaar_type' => 2,
            ],
            [
                'id'                       => 3,
                'ishaar_type_id'           => Constants::CONTRACTTYPES['temp_work'],
                'name'                     => 'إشعار عمل مؤقت في موسم الحج',
                'min_ishaar_period'        => 1,
                'max_ishaar_period'        => 43,
                'labor_status_employed'    => 1,
                'labor_status_companion'   => 1,
                'labor_status_visitor'     => 1,
                'labor_permission_benf'    => 1,
                'nitaq_active'             => 0,
                'nitaq_haj'                => 1,
                'nitaq_gover'              => 1,
                'amount'                   => 10,
                'payment_period'           => 3,
                'issued_season'            => 1,
                'period_start_date'        => '2016-08-01',
                'period_end_date'          => '2017-08-01',
                'max_labor_from_haj'       => 11,
                'max_of_notice_renew_time' => 11,
                'labor_gender_male'        => 1,
                'labor_gender_female'      => 1,
            ],
            [
                'id'                       => 4,
                'ishaar_type_id'           => Constants::CONTRACTTYPES['temp_work'],
                'name'                     => 'إشعار عمل مؤقت علي مدار العام',
                'min_ishaar_period'        => 1,
                'max_ishaar_period'        => 43,
                'labor_status_employed'    => 1,
                'labor_status_companion'   => 1,
                'labor_status_visitor'     => 1,
                'labor_permission_benf'    => 1,
                'nitaq_active'             => 0,
                'nitaq_haj'                => 1,
                'nitaq_gover'              => 1,
                'amount'                   => 10,
                'payment_period'           => 3,
                'issued_season'            => 1,
                'period_start_date'        => '2016-08-01',
                'period_end_date'          => '2017-08-01',
                'max_labor_from_haj'       => 11,
                'max_of_notice_renew_time' => 11,
                'labor_gender_male'        => 1,
                'labor_gender_female'      => 1,
            ],
        ];
        
        foreach ($ishaarsArray as $notice) {
            $ishaar = IshaarSetup::create($notice);
            if ($notice['id'] > 2) {
                $ishaar->regions()->sync([1]);
            }
        }
        IshaarJob::create(['id' => 1, 'ishaar_setup_id' => $ishaar->id, 'job_id' => 1]);
        NationalityForJob::create(['id' => 1, 'nationality_id' => 1, 'ishaar_job_id' => 1]);
    }
}
