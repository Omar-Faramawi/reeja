<?php

return [
    'dummy'  => env('DUMMY_NIC', true),

    'username' => env('MOL_NIC_USERNAME'),

    'password' => env('MOL_NIC_PASSWORD'),

    'operatorId' => 1008143230,   // Eng. Waleed's NID

    'data' => [
        'citizens'   => [
            [
                'identity' => [
                    'number'      => 1010101010,
                    'expiry_date' => [
                        'h' => '1440-01-01',
                        'g' => '2016-01-01',
                    ],
                ],
                'name'     => [
                    'first'  => 'first',
                    'second' => '',
                    'third'  => '',
                    'last'   => 'last',
                ],
                'birth_place' => 'birth place',
                'birth_date'  => [
                    'h' => '1400-01-01',
                    'g' => '2000-01-01',
                ],
                'gender'         => 1,
                'occupation'     => 'معلم',
                'status'         => 1,
                'martial_status' => [
                    'code' => 1,
                    'name' => '',
                ],
            ],
            [
                'identity' => [
                    'number'      => 1020101000,
                    'expiry_date' => [
                        'h' => '1440-01-01',
                        'g' => '2016-01-01',
                    ],
                ],
                'name'     => [
                    'first'  => 'first1',
                    'second' => '',
                    'third'  => '',
                    'last'   => 'last1',
                ],
                'birth_place' => 'birth place',
                'birth_date'  => [
                    'h' => '1400-01-01',
                    'g' => '2000-01-01',
                ],
                'gender'         => 1,
                'occupation'     => 'occupation',
                'status'         => 1,
                'martial_status' => [
                    'code' => 1,
                    'name' => '',
                ],
            ],
            [
                'identity' => [
                    'number'      => 1000011021,
                    'expiry_date' => [
                        'h' => '1440-01-01',
                        'g' => '2016-01-01',
                    ],
                ],
                'name'     => [
                    'first'  => 'first2',
                    'second' => '',
                    'third'  => '',
                    'last'   => 'last2',
                ],
                'birth_place' => 'birth place',
                'birth_date'  => [
                    'h' => '1400-02-02',
                    'g' => '2000-02-02',
                ],
                'gender'         => 1,
                'occupation'     => 'occupation',
                'status'         => 1,
                'martial_status' => [
                    'code' => 1,
                    'name' => '',
                ],
            ],
            [
                'identity' => [
                    'number'      => 1010102000,
                    'expiry_date' => [
                        'h' => '1440-01-01',
                        'g' => '2016-01-01',
                    ],
                ],
                'name'     => [
                    'first'  => 'first3',
                    'second' => '',
                    'third'  => '',
                    'last'   => 'last3',
                ],
                'birth_place' => 'birth place',
                'birth_date'  => [
                    'h' => '1400-03-03',
                    'g' => '2000-03-03',
                ],
                'gender'         => 1,
                'occupation'     => 'occupation',
                'status'         => 1,
                'martial_status' => [
                    'code' => 1,
                    'name' => '',
                ],
            ],
            [
                'identity' => [
                    'number'      => 1010100020,
                    'expiry_date' => [
                        'h' => '1440-01-01',
                        'g' => '2016-01-01',
                    ],
                ],
                'name'     => [
                    'first'  => 'first4',
                    'second' => '',
                    'third'  => '',
                    'last'   => 'last4',
                ],
                'birth_place' => 'birth place',
                'birth_date'  => [
                    'h' => '1400-04-04',
                    'g' => '2000-04-04',
                ],
                'gender'         => 1,
                'occupation'     => 'occupation',
                'status'         => 1,
                'martial_status' => [
                    'code' => 1,
                    'name' => '',
                ],
            ],
            [
                'identity' => [
                    'number'      => 1020200000,
                    'expiry_date' => [
                        'h' => '1440-01-01',
                        'g' => '2016-01-01',
                    ],
                ],
                'name'     => [
                    'first'  => 'first',
                    'second' => '',
                    'third'  => '',
                    'last'   => 'last',
                ],
                'birth_place' => 'birth place',
                'birth_date'  => [
                    'h' => '1400-01-01',
                    'g' => '2000-04-04',
                ],
                'gender'         => 1,
                'occupation'     => 'occupation',
                'status'         => 1,
                'martial_status' => [
                    'code' => 1,
                    'name' => '',
                ],
            ],
        ],
        'foreigners' => [
            [
                'residency' => [
                    'number'      => 2012160202,
                    'expiry_date' => [
                        'h' => '14400101',
                        'g' => '2016-01-01',
                    ],
                    'id_type'     => 'رب أسرة',
                    'issue_place' => 'الرياض',
                    'issue_date'  => [
                        'h' => '14400101',
                        'g' => '2016-01-01',
                    ],
                ],
                'marital_status' => [
                    'code' => 1,
                    'name' => '',
                ],
                'nationality' => [
                    'code' => 111,
                    'name' => 'مصري',
                ],
                'relationship' => [
                    'code' => 111,
                    'name' => '',
                ],
                'name'     => [
                    'first'  => 'Omar',
                    'second' => '',
                    'third'  => '',
                    'last'   => 'ahmed',
                ],
                'birth_place' => 'birth place',
                'birth_date'  => [
                    'h' => '14000101',
                    'g' => '2000-01-01',
                ],
                'gender'         => [
                    'code' => 1,
                ],
                'occupation'     => 'معلم',
                'status'         => 1,
                'travel'         => [
                    'travel_status' => 'داخل المملكة',
                    'entry_date'    => [
                        'h' => '14000101',
                        'g' => '2000-01-01',
                    ],
                    'last_entry_date'  => [
                        'h' => '14000101',
                        'g' => '2000-01-01',
                    ],
                    'last_exit_date'  => [
                        'h' => '14000101',
                        'g' => '2000-01-01',
                    ],
                    'passport_expiry_date'  => [
                        'h' => '14400101',
                        'g' => '2020-01-01',
                    ],
                ],
                'sponsor' => [
                    'name'       => 'name',
                    'id_number'  => '4294967295',
                    'occupation' => 'name',
                    'status'     => 0,
                    'type'       => [
                        'code' => 1,
                        'name' => '',
                    ],
                ],
                'visa' => [
                    'type'              => 'name',
                    'final_exit_issued' => 'name',
                    'expiry_date'       => [
                        'h' => '14400101',
                        'g' => '2020-01-01',
                    ],
                ],
            ],
        ],
        'code'       => 123123,
    ],
];
