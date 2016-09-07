<?php

return [
    
    'debug' => true,
    
    'config' => [
        'token' => env('BILLING_TOKEN'),
        
        'host' => env('BILLING_HOST'),
        
        'uris' => [
            'get_account' => '/Billing/api/1.0/get-account',
            'create_bill' => '/Billing/api/1.0/create-bill',
            'get_bills'   => '/Billing/api/1.0/get-bills',
        ],
        
        'allowed_ips' => explode(',', env('BILLING_IPS')),
    ],
];
