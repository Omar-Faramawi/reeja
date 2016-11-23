<?php

return [
    'title' 				    => 'Individuals Registration',
    'title_active'              => 'Activate user',
    'activation_number'         => 'Activation number', 
    'activate'                  => 'activate', 
    'register'				    => 'register',
    'validation'                => [

        'nicerror_saudi'        => 'National Id is incorrect',
        'nicerror_non_saudi'    => 'National Id is incorrect',
        'required_if'           => 'This :attribute is required when :other is saudi',   
        'nic_not_active'        => 'The account is not active in NIC',
    ],
    'attributes'                => [

        'id_number_saudi'       => 'National Id',
        'id_number_non_saudi'   => 'National Id',
        'saudi'                 => 'Saudi',
        'birth_date'            => 'Birth date',
        'religion'              => 'Religion',       
        'id_numbers'            => 'National Id',
        'id_numbers_saudi'      => 'National Id',
        'id_numbers_non_saudi'  => 'National Id',
        'first_name'            => 'First name',
        'last_name'             => 'Last name',
        'password'              => 'Password',
        'confirm_password'      => 'Confim password',
        'phone'                 => 'Mobile phone',
        'email'                 => 'Email',
        'gender'                => 'Gender' 
        
    ],
    'male'                      => 'Male',
    'female'                    => 'Female',
    'religions'                 => [

        'non_muslim'            => 'non muslim',
        'muslim'                => 'muslim',
        'na'                    => 'na',

    ],
    'choose'                    => 'choose religion',
    'success'                   => 'Registration successed',
    'wrong_activation'          => 'Wrong activation code',
];
