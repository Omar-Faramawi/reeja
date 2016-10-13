<?php

return [
    'headings'        => [
        'tab_head'      => 'My Invoices',
        'list_tab_head' => 'View Invoices list',
        'one_head' => 'View Invoice ',
        'basic_information' => 'Invoice Basic Information ',
        'contract_information' => 'Invoice Contracts Information ',
    ],
    'buttons'         => [
        'details'            => ' More Details',
    ],
    'list_attributes' => [
        'number'                => 'Bill Number',
        'amount'          => 'Invoice Amount ',
        'description'      => 'Description',
        'issue_date'      => ' Issue Date',
        'expiry_date'            => 'Expire Date',
        'paid_date'         => 'Paid Date',
        'status' => 'Invoice Status',
        'invoice_type'    => 'Invoice Type',
        'details'            => ' More Details',
        'account_num'            => ' Account Number ',
    ],
    
    "statuses"          => [
        'pending' => 'Pending',
        'paid' => 'Paid',
        'expired' => 'Expired',
    ],
    "types"        => [
        'bundle' => 'Package Subscription',
        'certificate' => 'Work Completion Certificate',
        'contract_hire_labor' => 'Generate Notices For Hire Labor Contracts',
        'contract_direct_employee' => 'Generate Notices For Direct Employee Contracts',
    ],
];
