<?php
return [
    'menu_name'    => 'Ishaar Setup',
    'headings'     => [
        'list'         => 'Ishaar ',
        'list1'        => 'Types',
        'create'       => 'Create a new ishaar ',
        'edit'         => 'Edit ishaar ',
        'home'         => 'Home ',
        'user_details' => 'User Details',
    ],
    'sub-headings' => [
        'list'   => 'This page allows you to manage ishaar ',
        'create' => 'This page allows you to add new ishaar ',
        'edit'   => 'This page allows you to edit ishaar ',
    ],
    'attributes'   => [
        'ishaar_name'                                => 'Ishaar name',
        'ishaar_type_id'                             => 'Ishaar type',
        'amount'                                     => 'Amount',
        'payment_period'                             => 'Payment period',
        'issued_season'                              => 'Issued season',
        'moaqat_haj'                                 => 'Haj temporary labor',
        'yes'                                        => 'Yes',
        'no'                                         => 'No',
        'add'                                        => 'Add',
        'others'                                     => 'Others',
        'choose'                                     => 'Please choose',
        'period_start_date'                          => 'Start data',
        'period_end_date'                            => 'End date',
        'limited_period'                             => 'Limit period',
        'unlimited_period'                           => 'Unlimted period throught the whole year',
        'job_head'                                   => 'Job head',
        'morafaq'                                    => 'Morfaq',
        'visitor'                                    => 'visitor',
        'regions'                                    => 'Regions',
        'currency'                                   => 'Riyal',
        'ishaar_setup_jobs'                          => 'Job for the employer',
        'job'                                        => 'Job',
        'nationalities'                              => 'Nationalities',
        'day'                                        => 'day',
        'default'                                    => 'Please choose value',
        'region_name'                                => 'Region name',
        'max_labor_from_haj'                         => 'Max labor  from haj',
        'nitaq_active'                               => 'Nitaq active ?',
        'nitaq_haj'                                  => 'Nitaq haj',
        'nitaq_gover'                                => 'Nitaq government',
        'labor_status'                               => 'Labor status',
        'max_ishaar_period'                          => 'Max ishaar period',
        'max_ishaar_period_type'                     => 'Day / Month / Year',
        'min_ishaar_period'                          => 'Min ishaar period',
        'min_ishaar_period_type'                     => 'Day / Month / Year',
        'ishaar_number'                              => 'Notice Number',
        'ishaar_establishment_name'                  => 'Establishment name',
        'name'                                       => 'Name',
        'id_number'                                  => 'National / Iqama ID',
        'ishaar_start_date'                          => 'Notice start date',
        'ishaar_end_date'                            => 'Notice End date',
        'ishaar_status'                              => 'Notice status',
        'details'                                    => 'Details',
        'max_no_of_ishaar_labor'                     => 'Maximum number of Ishaar Labor',
        'contract_type_id'                           => 'Contract Type',
        'ishaar_cancel_benf'                         => 'Service Beneficial',
        'ishaar_cancel_provider'                     => 'Service Provider',
        'labor_gender_male'                          => 'Males',
        'labor_gender_female'                        => 'Females',
        'ishaar_cancel_free'                         => 'Free',
        'ishaar_cancel_paid'                         => 'paid',
        'total_period_labor'                         => 'Maximum allowed number of Ishaars for a Labor in the same period',
        'ishaar_lobor_times'                         => 'Maximum allowed number of Ishaars that an Establishment can provide for the same Labor',
        'min_no_of_ishaars'                          => 'Minimum number of Ishaars',
        'max_no_of_ishaars'                          => 'Maximum number of Ishaars',
        'trial_ishaar_num'                           => 'Number of trial notices',
        'paid_ishaar_payment_expiry_period'          => 'Paid notices payment expiry period',
        'paid_ishaar_valid_expiry_period'            => 'Paid notices validation expiry period',
        'labor_follow_permissions_text'              => 'Labpors follow permissions',
        'labor_follow_permissions'                   => [
            'labor_follow_provider_perm' => 'Service provider',
            'labor_follow_benef_perm'    => 'Beneficiary',
            'labor_follow_all_perm'      => 'All sides permissions',
        ],
        'labor_multi_regions_perm'                   => 'Allow labor to work in multiple regions?',
        'labor_multi_regions_perm_num'               => 'Max regions for one notice',
        'labor_benef_max_num_of_ishaar'              => 'Max notices in the same period',
        'labor_same_benef'                           => 'Benefit from the same labor for the same beneficiary',
        'labor_same_benef_max_num_of_ishaar'         => 'The maximum number of notices',
        'labor_same_benef_max_period_of_ishaar'      => 'The total duration of the benefit from the same labor',
        'labor_same_benef_not_choosen'               => 'You should add a value for The maximum number of notices or for The total duration of the benefit from the same labor',
        'ishaar_payment_expiry_period_type'          => 'Day/Month/Year',
        'paid_ishaar_payment_expiry_period_type'     => 'Day/Month/Year',
        'paid_ishaar_valid_expiry_period_type'       => 'Day/Month/Year',
        'labor_same_benef_max_period_of_ishaar_type' => 'Day/Month/Year',
        'max_of_notice_renew_time'                   => 'Max number of renew notice for same labor & same beneficiary',
    ],
    'actions'      => [
        'cancel'       => 'Cancel Notice',
        'print'        => 'Print',
        'details'      => 'Details',
        'add'          => 'Create Notice',
        'add_invoice'  => 'Add Invoice',
        'ensure_data'  => 'Apply Updates',
        'add_employee' => 'Add Employees ',
        'add_emp'      => 'Add',
        'ask_cancel'   => 'Ask Cancel Notice',
        'sure'         => 'Ensure',
    ],

    'form_attributes'                => [
        'contract_no'              => 'Contract Number',
        'benifit_no'               => 'Beneficiary ID',
        'benifit_name'             => 'Beneficiary Name',
        'benifit_activity'         => 'Beneficiary Activity',
        'work_start_date'          => 'Work start date',
        'work_end_date'            => 'Work end date',
        'work_region'              => 'Work region',
        'work_areas'               => 'Work areas',
        'id_number'                => 'Iqama number',
        'name'                     => 'Name',
        'nationality'              => 'Nationality',
        'job'                      => 'Job',
        'gender'                   => 'Gender',
        'age'                      => 'Age',
        'religion'                 => 'Religion',
        'ishaar_no'                => 'Ishaar number',
        'ishaar_cancel_permission' => 'Ishaar Cancellation requires permission from',
        'labor_gender'             => 'Allowed Labor Gender',
        'ishaar_cancel_type'       => 'Ishaar Cancellation Type',
        'labor_status'             => 'Allowed Labor Status',
        'labor_status_work_head'   => 'Worker',
        'labor_status_visitor'     => 'Visitor',
        'labor_status_companion'   => 'Companion',
        'employee_choose'          => 'Choose Employee',
        'cancel_reason'            => 'Cancel Ishaar Reason',
        'reports'                  => 'Endrosment',
    ],
    'gender'                         => [
        '0' => 'Female',
        '1' => 'Male',
    ],
    'religion'                       => [
        '0' => 'Not muslim',
        '1' => 'Muslim',
        '2' => 'NA',
    ],
    'nationality'                    => [
        '1' => 'Saudi',
    ],
    'added'                          => 'Added successfully',
    'updated'                        => 'Updated successfully',
    'error_updated'                  => 'Sorry! cannot update.',
    'deleted'                        => 'Deleted successfully',
    'error_delete'                   => 'Can\'t delete, This type has regions',
    'ishaars_list'                   => 'Ishaars',
    'no_nationalities_found'         => 'No nationalities for this occupation',
    'error_delete_regions'           => 'Sorry! this Notice includes occupations or nationalities.',
    'cancelIshaar_success'           => 'Cancelled successfully.',
    'cancelIshaar_confirmation'      => 'Are You Sure , You want To Delete This ? ',
    'cancelIshaar_refused'           => 'You Have No Permission To Do This ',
    'before_invoice_notice'          => 'Please Note .. If You Want to Cancel Invouce after Generate It , You Should Stay 3 days Until Its Expiration',
    'after_generate_invoice'         => 'Note .. You should pay Invoice Before 72 Hours.',
    'cant_add_invoice'               => 'sorry , You Couldn\'t Generate Invoise at This Time',
    'add_invoice_success'            => 'You choose Contract Number :contract ,and Should Pay :amount SR for This Contract,Your Invoise Number Is :number',
    'no_contract'                    => 'Please choose Contract To Generate Invoice',
    'provider'                       => 'Service Provider',
    'benf'                           => 'Service Beneficial',
    'free'                           => 'Free',
    'paid'                           => 'Paid',
    'ishaars_bundles_management'     => 'Ishaars & Bundles Management',
    'taqawel_ishaars_management'     => 'Taqawol Ishaars Management',
    'general_ishaars_preferences'    => 'General Ishaars Preferences',
    'free_ishaars_management'        => 'Free Ishaars Management',
    'paid_ishaars_management'        => 'Paid Ishaars management',
    'edit_permission'                => 'Permissions Edit',
    'only_one_employee'              => 'Note : You can\'t add more than one employee on contract Because of Your Free Account ',
    'must_have_employee'             => 'You Must Add Employees First..',
    'add_notice_success'             => 'Successfully , Ishaar Generated',
    'employees_bigger_allowed'       => 'Sorry , Your Contract Employees Greater Than Permitted Number',
    'already_added'                  => 'This Employee Already AddedS..',
    'date_not_in_range'              => 'Sorry , Start & End Date Should Be In Contract Period  ..',
    'ask_cancel_ishaar_success'      => 'Your Request Sent Successfully',
    'no_contractEmployee'            => 'Sorry , You Should Have Employees to Generate Your Invoice ',
    'max_labor_times'                => 'Sorry , You Have Exceeded Tha Max Labor Times For Employee Number :id ',
    'max_total_period_labor'         => 'Sorry , Your Employee Number:id  Has Exceeded Tha Max Total Period Labor ',
    'max_ishaar_for_benf'            => 'Sorry , You Have Exceeded Tha Max Ishaar Number With This Benef Establishment',
    'max_ishaar_for_benf_in_period'  => 'Sorry , You Have Exceeded Tha Max Ishaar Number With This Benef Establishment',
    'max_loan_percentage'            => 'Sorry , You Have Exceeded Tha Max Loan Percentage ',
    'max_borrow_percentage'          => 'Sorry , Your Beneficial Establishment Have Exceeded Tha Max Borrow Percentage ',
    'max_ishaar_period_greater_than' => 'Max Ishaar Period must be greater than Min Ishaar Period',
    'max_no_of_ishaars_greater_than' => 'Max number of Ishaars must be greater than Min number of Ishaars',
    'max_saudian_percentage'       => 'Sorry , Your Have Exceeded Tha Max Saudian Percentage ',
];
