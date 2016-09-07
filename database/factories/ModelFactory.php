<?php

$faker = Faker\Factory::create('ar_SA');

$factory->define(\Tamkeen\Ajeer\Models\User::class, function () use ($faker) {
    return [
        'name'           => $faker->name,
        'email'          => $faker->safeEmail,
        'active'         => '1',
        'password'       => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
        'user_type_id'   => rand(4, 5),
    ];
});

$factory->define(\Tamkeen\Ajeer\Models\UserTypes::class, function () use ($faker) {
    return [
        'name' => $faker->name,
    ];
});

$factory->define(\Tamkeen\Ajeer\Models\IshaarType::class, function () use ($faker) {
    return [
        'name'       => $faker->word,
        'created_by' => 1,
        'updated_by' => 1,
    ];
});

$factory->define(\Tamkeen\Ajeer\Models\Region::class, function () use ($faker) {
    return [
        'name'       => $faker->country,
        'created_by' => 1,
        'updated_by' => 1,
    ];
});

$factory->define(\Tamkeen\Ajeer\Models\IshaarSetup::class, function () use ($faker) {
    return [
        'max_ishaar_period'      => $faker->numberBetween(1, 11),
        'max_no_of_ishaar_labor' => $faker->numberBetween(1, 11),
    ];
});

$factory->define(\Tamkeen\Ajeer\Models\ContractType::class, function () use ($faker) {
    return [
        'id'         => 1,
        'created_at' => '2016-06-27 08:36:32',
        'updated_at' => '2016-06-27 08:36:32',
        'created_by' => 1,
        'updated_by' => 1,
        'name'       => 'التقاول',
    ];
});

$factory->define(\Tamkeen\Ajeer\Models\ContractSetup::class, function () use ($faker) {
    return [
        'id'                     => '1',
        'contract_type_id'       => '1',
        'min_accept_period'      => '1',
        'min_accept_period_type' => '1',
        'max_accept_period_type' => '1',
        'created_by'             => '1',
    ];
});

$factory->define(\Tamkeen\Ajeer\Models\Activity::class, function () use ($faker) {
    
    return [
        'name' => $faker->name,
    ];
});

$factory->define(\Tamkeen\Ajeer\Models\ServiceProviderBeneficial::class, function () use ($faker) {
    
    return [
        'name'       => '',
        'created_by' => '',
    ];
});

$factory->define(\Tamkeen\Ajeer\Models\ServiceUsersPermission::class, function () use ($faker) {
    
    return [
        'id'                    => '',
        'contract_type_id'      => '',
        'service_prvdr_benf_id' => '',
        'benf_est'              => '',
        'benf_indv'             => '',
        'benf_gover'            => '',
    ];
});

$factory->define(\Tamkeen\Ajeer\Models\EstablishmentPermissionActivity::class, function () use ($faker) {
    return [
        'id'                          => '',
        'service_users_permission_id' => '',
        'activity_id'                 => '',
        'provider'                    => '',
        'benf'                        => '',
        'benf_activity'               => '',
        'borrow_pct'                  => '',
        'loan_pct'                    => '',
        'created_by'                  => '',
    ];
});


$factory->define(\Tamkeen\Ajeer\Models\Reason::class, function () use ($faker) {
    return [
        'reason'    => 'السعر عال',
        'parent_id' => null,
    ];
});


$factory->define(\Tamkeen\Ajeer\Models\GovernmentPermissionActivity::class, function () use ($faker) {
    return [
        'id'          => '3',
        'activity_id' => '3',
    ];
});

$factory->define(\Tamkeen\Ajeer\Models\ContractProvider::class, function () use ($faker) {
    return [
        'contract_type_id'      => '',
        'service_prvdr_benf_id' => '',
        'created_by'            => '',
        'updated_by'            => '',
    ];
});

$factory->define(\Tamkeen\Ajeer\Models\ContractBeneficial::class, function () use ($faker) {
    return [
        'contract_provider_id'  => '1',
        'service_prvdr_benf_id' => '3',
        'created_by'            => 1,
        'updated_by'            => 1,
    ];
});

$factory->define(\Tamkeen\Ajeer\Models\EstablishmentSize::class, function () use ($faker) {
    return [
        'name'       => '',
        'created_by' => '',
    ];
});


$factory->define(\Tamkeen\Ajeer\Models\Job::class, function () use ($faker) {
    return [
        'job_name'   => $faker->unique()->randomElement(['مهندس', 'عامل', 'دكتور']),
        'saudi'      => $saudi = $faker->randomElement(['0', '1']),
        'non_saudi'  => $saudi == 1 ? 0 : 1,
        'created_by' => 1,
        'updated_by' => 1,
    ];
});

$factory->define(\Tamkeen\Ajeer\Models\Nationality::class, function () use ($faker) {
    return [
        'name'       => $nationalityAr = $faker->unique()->randomElement(['مصري', 'سعودي']),
        'eng_name'   => $nationality = $nationalityAr == 'مصري' ? 'egyptian' : 'saudi',
        'abbr'       => $nationality == 'egyptian' ? 'eg' : 'sa',
        'created_by' => 1,
        'updated_by' => 1,
    ];
});

$factory->define(\Tamkeen\Ajeer\Models\Individual::class, function () use ($faker) {
    $gender    = rand(0, 1);
    $genderArr = ['0' => 'female', '1' => 'male'];
    $religion  = rand(0, 1);
    
    return [
        'nid'          => rand(1, 3) . strval(rand(1111, 9999)),
        'name'         => $faker->firstName($genderArr[$gender]) . " " . $faker->lastName(),
        'gender'       => $gender,
        'religion'     => $religion,
        'phone'        => $faker->phoneNumber(),
        'email'        => $faker->freeEmail(),
        'user_type_id' => 4,
        'created_by'   => 1,
    ];
});

$factory->define(\Tamkeen\Ajeer\Models\IndividualLabor::class, function () use ($faker) {
    return [
        'id_number'            => rand(1, 3) . strval(rand(1111, 9999)),
        'created_by'           => 1,
        'indviduals_id_number' => 1,
        'job_id'               => null,
    ];
});

$factory->define(\Tamkeen\Ajeer\Models\User::class, function () use ($faker) {
    return [
        'name'         => $faker->firstName . ' ' . $faker->lastName,
        'email'        => $faker->email,
        'password'     => bcrypt('123456'),
        'id_no'        => null,
        'national_id'  => rand(1, 3) . strval(rand(1111, 9999)),
        'active'       => 1,
        'user_type_id' => rand(2, 5),
    ];
});

$factory->define(\Tamkeen\Ajeer\Models\HRPool::class, function () use ($faker) {
    
    return [
        'id_number'        => $faker->randomNumber(),
        'provider_type'    => $faker->randomElement(array_keys(\Tamkeen\Ajeer\Utilities\Constants::benfTypes())),
        'provider_id'      => $faker->numberBetween(1, 10),
        'name'             => $faker->name,
        'gender'           => $faker->randomElement(array_keys(\Tamkeen\Ajeer\Utilities\Constants::gender())),
        'job_id'           => $faker->randomDigitNotNull(),
        'experience_id'    => $faker->randomDigitNotNull(),
        'nationality_id'   => $faker->randomDigitNotNull(),
        'qualification_id' => $faker->randomDigitNotNull(),
        'email'            => $faker->email,
        'phone'            => $faker->phoneNumber,
        'birth_date'       => $faker->date(),
        'religion'         => $faker->randomElement(array_keys(\Tamkeen\Ajeer\Utilities\Constants::religions())),
        'work_start_date'  => $faker->date(),
        'work_end_date'    => $faker->date(),
        'status'           => $faker->randomElement([0, 1]),
        'region_id'        => 3,
        'chk'              => $faker->boolean(),
        'job_type'         => $faker->randomElement(array_keys(\Tamkeen\Ajeer\Utilities\Constants::jobTypes())),
    ];
    
});


$factory->define(\Tamkeen\Ajeer\Models\Establishment::class, function () use ($faker) {
    
    return [
        'labour_office_no'    => $faker->numberBetween(2, 38),
        'sequence_no'         => $faker->numberBetween(1, 10),
        'id_number'           => $faker->randomDigitNotNull,
        'email'               => $faker->email,
        'name'                => $faker->name,
        'FK_establishment_id' => $faker->numberBetween(1, 10),
        'est_activity'        => $faker->text(),
        'est_size'            => $faker->text(),
        'est_nitaq'           => $faker->text(),
        'district'            => $faker->country,
        'city'                => $faker->city,
        'region'              => 'الرياض',
        'wasel_address'       => $faker->address,
        'local_liecense_no'   => $faker->randomDigitNotNull,
        'parent_id'           => $faker->randomDigitNotNull,
        'status'              => $faker->boolean(),
        'hajj'                => $faker->randomDigitNotNull,
        'catering'            => $faker->randomDigitNotNull,
        'phone'               => $faker->phoneNumber,
        'branch_no'           => $faker->numberBetween(1, 999999),
        'reasons_id'          => $faker->text(),
        'rejection_reason'    => $faker->text(),
    
    ];
    
});

$factory->define(\Tamkeen\Ajeer\Models\Vacancy::class, function () use ($faker) {
    
    return [
        'benf_id'          => $faker->numberBetween(1, 10),
        'benf_type'        => $faker->randomElement(array_keys(\Tamkeen\Ajeer\Utilities\Constants::benfTypes())),
        'job_id'           => $faker->randomDigitNotNull,
        'salary'           => $faker->randomDigit,
        'nationality_id'   => $faker->randomDigitNotNull,
        'gender'           => $faker->randomElement(array_keys(\Tamkeen\Ajeer\Utilities\Constants::gender())),
        'religion'         => $faker->randomElement(array_keys(\Tamkeen\Ajeer\Utilities\Constants::religions())),
        'no_of_vacancies'  => $faker->randomDigitNotNull,
        'region_id'        => 3,
        'job_type'         => $faker->randomElement(array_keys(\Tamkeen\Ajeer\Utilities\Constants::jobTypes())),
        'work_end_date'    => $start = $faker->date(),
        'work_start_date'  => $faker->date('Y-m-d', $start),
        'status'           => $faker->boolean(),
        'rejection_reason' => $faker->text(),
    ];
    
});


$factory->define(\Tamkeen\Ajeer\Models\Contract::class, function () use ($faker) {
    return [
        'contract_type_id'           => $faker->randomNumber(),
        'provider_type'              => $faker->randomElement(array_keys(\Tamkeen\Ajeer\Utilities\Constants::benfTypes())),
        'provider_id'                => $faker->numberBetween(1, 10),
        'benf_id'                    => $faker->numberBetween(1, 10),
        'benf_type'                  => $faker->randomElement(array_keys(\Tamkeen\Ajeer\Utilities\Constants::benfTypes())),
        'contract_nature_id'         => $faker->randomNumber(),
        'reason_id'                  => $faker->randomNumber(),
        'job_request_id'             => $faker->randomNumber(),
        'market_taqaual_services_id' => $faker->randomNumber(),
        'vacancy_id'                 => $faker->randomNumber(),
    ];
});

$factory->define(\Tamkeen\Ajeer\Models\ContractLocation::class, function () use ($faker) {
    return [
        'contract_id'   => factory(\Tamkeen\Ajeer\Models\Contract::class)->create()->id,
        'branch_id'     => factory(\Tamkeen\Ajeer\Models\Establishment::class)->create()->id,
        'desc_location' => $faker->text(),
    ];
});

$factory->define(Tamkeen\Ajeer\Models\Attachment::class, function (Faker\Generator $faker) {
    return [
        'name'       => $faker->name,
        'created_by' => $faker->randomNumber(),
        'updated_by' => $faker->randomNumber(),
    ];
});

$factory->define(Tamkeen\Ajeer\Models\Bank::class, function (Faker\Generator $faker) {
    return [
        'name'           => $faker->name,
        'parent_bank_id' => function () {
            return factory(Tamkeen\Ajeer\Models\Bank::class)->create()->id;
        },
        'created_by'     => $faker->randomNumber(),
        'updated_by'     => $faker->randomNumber(),
    ];
});

$factory->define(Tamkeen\Ajeer\Models\BaseModel::class, function (Faker\Generator $faker) {
    return [
    ];
});

$factory->define(Tamkeen\Ajeer\Models\Bundle::class, function (Faker\Generator $faker) {
    return [
        'name'                  => $faker->name,
        'period'                => $faker->randomNumber(),
        'period_frequency'      => $faker->word,
        'amount'                => $faker->randomNumber(),
        'no_of_ishaar'          => $faker->randomNumber(),
        'bundle_payment_period' => $faker->randomNumber(),
        'payment_frequency'     => $faker->word,
        'created_by'            => $faker->randomNumber(),
        'updated_by'            => $faker->randomNumber(),
    ];
});

$factory->define(Tamkeen\Ajeer\Models\ContractEmployee::class, function (Faker\Generator $faker) {
    return [
        'contract_id'             => function () {
            return factory(Tamkeen\Ajeer\Models\Contract::class)->create()->id;
        },
        'id_number'               => $faker->randomNumber(),
        'start_date'              => $faker->date(),
        'end_date'                => $faker->date(),
        'status'                  => $faker->word,
        'reasons_id'              => $faker->randomNumber(),
        'rejection_reason'        => $faker->word,
        'conditions'              => $faker->word,
        'condition_approval'      => $faker->word,
        'provider_rules_approval' => $faker->word,
        'benf_rules_approval'     => $faker->word,
        'bundle_id'               => $faker->randomNumber(),
        'ishaar_id'               => $faker->randomNumber(),
        'ishaar_cancel_ref_no'    => $faker->randomNumber(),
        'qualification_upload'    => $faker->word,
        'invoices_id'             => $faker->randomNumber(),
        'created_by'              => $faker->randomNumber(),
        'updated_by'              => $faker->randomNumber(),
    ];
});

$factory->define(Tamkeen\Ajeer\Models\ContractNature::class, function (Faker\Generator $faker) {
    return [
        'name'       => $faker->name,
        'status'     => $faker->word,
        'created_by' => function () {
            return factory(Tamkeen\Ajeer\Models\User::class)->create()->id;
        },
        'updated_by' => $faker->randomNumber(),
    ];
});

$factory->define(Tamkeen\Ajeer\Models\Experience::class, function (Faker\Generator $faker) {
    return [
        'name'       => $faker->name,
        'created_by' => $faker->randomNumber(),
        'updated_by' => $faker->randomNumber(),
    ];
});

$factory->define(Tamkeen\Ajeer\Models\Government::class, function (Faker\Generator $faker) {
    return [
        'name'       => $faker->name,
        'parent_id'  => $faker->randomNumber(),
        'email'      => $faker->safeEmail,
        'hajj'       => $faker->word,
        'created_by' => $faker->randomNumber(),
        'updated_by' => $faker->randomNumber(),
    ];
});

$factory->define(Tamkeen\Ajeer\Models\IshaarJob::class, function (Faker\Generator $faker) {
    return [
        'ishaar_setup_id' => function () {
            return factory(Tamkeen\Ajeer\Models\IshaarSetup::class)->create()->id;
        },
        'job_id'          => function () {
            return factory(Tamkeen\Ajeer\Models\Job::class)->create()->id;
        },
        'created_by'      => $faker->randomNumber(),
        'updated_by'      => $faker->randomNumber(),
    ];
});

$factory->define(Tamkeen\Ajeer\Models\JobRequest::class, function (Faker\Generator $faker) {
    return [
        'hr_pool_id_number' => function () {
            return factory(Tamkeen\Ajeer\Models\HRPool::class)->create()->id;
        },
        'vacancies_id'      => function () {
            return factory(Tamkeen\Ajeer\Models\Vacancy::class)->create()->id;
        },
        'status'            => $faker->word,
        'reasons_id'        => $faker->randomNumber(),
        'created_by'        => $faker->randomNumber(),
        'updated_by'        => $faker->randomNumber(),
    ];
});

$factory->define(Tamkeen\Ajeer\Models\MarketTaqawoulServices::class, function (Faker\Generator $faker) {
    return [
        'contract_nature_id' => function () {
            return factory(Tamkeen\Ajeer\Models\ContractNature::class)->create()->id;
        },
    ];
});

$factory->define(Tamkeen\Ajeer\Models\NationalityForJob::class, function (Faker\Generator $faker) {
    return [
        'nationality_id' => function () {
            return factory(Tamkeen\Ajeer\Models\Nationality::class)->create()->id;
        },
        'ishaar_job_id'  => function () {
            return factory(Tamkeen\Ajeer\Models\IshaarJob::class)->create()->id;
        },
        'created_by'     => $faker->randomNumber(),
        'updated_by'     => $faker->randomNumber(),
    ];
});

$factory->define(Tamkeen\Ajeer\Models\Qualification::class, function (Faker\Generator $faker) {
    return [
        'name'       => $faker->name,
        'created_by' => $faker->randomNumber(),
        'updated_by' => $faker->randomNumber(),
    ];
});

$factory->define(Tamkeen\Ajeer\Models\RatingModels::class, function (Faker\Generator $faker) {
    return [
        'name'       => $faker->name,
        'status'     => $faker->word,
        'created_by' => $faker->randomNumber(),
        'updated_by' => $faker->randomNumber(),
    ];
});

$factory->define(Tamkeen\Ajeer\Models\Responsible::class, function (Faker\Generator $faker) {
    return [
        'id_number'         => $faker->randomNumber(),
        'establishments_id' => function () {
            return factory(Tamkeen\Ajeer\Models\Establishment::class)->create()->id;
        },
        'responsible_name'  => $faker->word,
        'responsible_phone' => $faker->word,
        'responsible_email' => $faker->word,
        'job_name'          => $faker->word,
        'created_by'        => $faker->randomNumber(),
        'updated_by'        => $faker->randomNumber(),
    ];
});

$factory->define(Tamkeen\Ajeer\Models\SaudiPercentage::class, function (Faker\Generator $faker) {
    return [
        'contract_type_id'     => function () {
            return factory(Tamkeen\Ajeer\Models\ContractType::class)->create()->id;
        },
        'provider_activity_id' => function () {
            return factory(Tamkeen\Ajeer\Models\EstablishmentPermissionActivity::class)->create()->id;
        },
        'provider_size_id'     => function () {
            return factory(Tamkeen\Ajeer\Models\Size::class)->create()->id;
        },
        'benf_activity_id'     => function () {
            return factory(Tamkeen\Ajeer\Models\EstablishmentPermissionActivity::class)->create()->id;
        },
        'benf_size_id'         => function () {
            return factory(Tamkeen\Ajeer\Models\Size::class)->create()->id;
        },
        'saudi_pct'            => $faker->randomNumber(),
        'created_by'           => $faker->randomNumber(),
        'updated_by'           => $faker->randomNumber(),
    ];
});

$factory->define(Tamkeen\Ajeer\Models\Size::class, function (Faker\Generator $faker) {
    return [
        'name'       => $faker->name,
        'created_by' => $faker->randomNumber(),
        'updated_by' => $faker->randomNumber(),
    ];
});

$factory->define(Tamkeen\Ajeer\Models\TaqyeemDegrees::class, function (Faker\Generator $faker) {
    return [
        'name'            => $faker->name,
        'taqyeem_item_id' => function () {
            return factory(Tamkeen\Ajeer\Models\TaqyeemItems::class)->create()->id;
        },
        'active'          => $faker->word,
        'created_by'      => $faker->randomNumber(),
        'updated_by'      => $faker->randomNumber(),
    ];
});

$factory->define(Tamkeen\Ajeer\Models\TaqyeemDtl::class, function (Faker\Generator $faker) {
    return [
        'taqyeems_id'               => $faker->randomNumber(),
        'degrees_id'                => $faker->randomNumber(),
        'taqyeem_template_items_id' => $faker->randomNumber(),
        'created_by'                => $faker->randomNumber(),
        'updated_by'                => $faker->randomNumber(),
        'taqyeem_template_item_id'  => function () {
            return factory(Tamkeen\Ajeer\Models\RatingModels::class)->create()->id;
        },
    ];
});

$factory->define(Tamkeen\Ajeer\Models\TaqyeemItems::class, function (Faker\Generator $faker) {
    return [
        'name'       => $faker->name,
        'active'     => $faker->word,
        'created_by' => $faker->randomNumber(),
        'updated_by' => $faker->randomNumber(),
    ];
});

$factory->define(Tamkeen\Ajeer\Models\Taqyeems::class, function (Faker\Generator $faker) {
    return [
        'taqyeem_owner'         => $faker->randomNumber(),
        'contract_id'           => $faker->randomNumber(),
        'status'                => $faker->word,
        'taqyeem_template_id'   => function () {
            return factory(Tamkeen\Ajeer\Models\RatingModels::class)->create()->id;
        },
        'benf_establishment_id' => $faker->randomNumber(),
        'benf_government_id'    => $faker->randomNumber(),
        'benf_individual_id'    => $faker->randomNumber(),
        'created_by'            => $faker->randomNumber(),
        'updated_by'            => $faker->randomNumber(),
    ];
});

$factory->define(Tamkeen\Ajeer\Models\TaqyeemTemplateItems::class, function (Faker\Generator $faker) {
    return [
        'taqyeem_template_id' => function () {
            return factory(Tamkeen\Ajeer\Models\RatingModels::class)->create()->id;
        },
        'taqyeem_item_id'     => $faker->randomNumber(),
        'created_by'          => $faker->randomNumber(),
        'updated_by'          => $faker->randomNumber(),
    ];
});

$factory->define(Tamkeen\Ajeer\Models\TaqyeemTemplatePermission::class, function (Faker\Generator $faker) {
    return [
        'link_period'         => $faker->randomNumber(),
        'taqyeem_template_id' => function () {
            return factory(Tamkeen\Ajeer\Models\RatingModels::class)->create()->id;
        },
        'taqyeem_type'        => $faker->word,
        'periodic_or_date'    => $faker->word,
        'periodic_period'     => $faker->word,
        'taqyeem_date'        => $faker->date(),
        'residents'           => $faker->word,
        'created_by'          => $faker->randomNumber(),
        'updated_by'          => $faker->randomNumber(),
    ];
});