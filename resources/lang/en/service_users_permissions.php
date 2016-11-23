<?php


return [
    'service_users_permissions'           => 'Service Users Permissions',
    'service_providers'                   => 'Service Providers',
    'service_beneficials'                 => 'Service Beneficials',
    'est_service_beneficials'             => 'Establishments Services Beneficials',
    'indv_service_beneficials'            => 'Individuals Services Beneficials',
    'est'                                 => 'Establishment',
    'gov'                                 => 'Government',
    'indv'                                => 'Individual',
    'attributes'                          => [
        'benf_indv'             => 'Individual',
        'contract_type_id'      => 'Contract Type',
        'benf_est'              => 'Establishment',
        'service_prvdr_benf_id' => 'Service Provider',
        'benf_gover'            => 'Government',
        'avl_borrow_labor'      => 'Available borrowed labor for individuals',
        'borrow_labor_pct'      => 'Borrow labor Percentage is required for Activity :activity_name Because Of providing Permission for Benf Or Benf Of the same Activity',
        'loan_labor_pct'      => 'Loan labor Percentage is required for Activity :activity_name Because Of providing Permission for Provider',
        'choose_provider'     => 'You Must Give Permission For Provider Of Activity :activity_name Because You Entered Loan Labor Percentage',
        'choose_Benf'           => 'You Must Give Permission For Benf Or Benf Of the same Activity Of Activity :activity_name Because You Entered Borrow Labor Percentage'
    ],
    'indv2indv'                           => 'Individuals can provide services only for individuals',
    'service_users_permissions_saved'     => 'Service permissions updated successfully',
    'service_users_permissions_not_saved' => 'Service permissions not updated',
    'at_least_one_gover_activities'       => 'You Must Choose At Least one Allowed Activity For Government',
    'at_least_one_privillage'             => 'You Must determine At Least one privillage For Any Activity',
];