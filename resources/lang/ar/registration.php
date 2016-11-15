<?php

return [
    'title' 				    => 'تسجيل الافراد',
    'register'				    => 'تسجيل',
    'validation'                => [

        'nicerror'              => ' !!! رقم الهوية/الاقامة/الحدود غير صحيح',
        'required_if'           => 'الحقل :attribute مطلوب في حال ما إذا كان :other',   
        'nic_not_active'        => ' عفوا ، الحساب غير نشط لدى وزارة الداخلية',
    ],
    'attributes'                => [

        'id_number'             => 'رقم الهوية/الاقامة/الحدود',
        'saudi'                 => 'سعودي',
        'birth_date'            => 'تاريخ الميلاد',
        'religion'              => 'الديانة',       
        'id_numbers'            => 'رقم الهوية الوطنية / رقم الاقامة / رقم الحدود',
        'id_numbers_saudi'      => 'رقم الهوية الوطنية',
        'id_numbers_non_saudi'  => 'رقم الاقامة / رقم الحدود',
        'first_name'            => 'الاسم الاول',
        'last_name'             => 'اسم العائلة',
        'password'              => 'كلمة المرور',
        'confirm_password'      => 'تاكيد كلمة المرور',
        'phone'                 => 'رقم الجوال',
        'email'                 => 'البريد الالكتروني',
        'gender'                => 'النوع',
        'birth_date'            => 'تاريخ الميلاد',    
        
    ],
    'male'                      => 'ذكر',
    'female'                    => 'انثى',
    'religions'                 => [

        'non_muslim'            => 'غير مسلم',
        'muslim'                => 'مسلم',
        'na'                    => 'غير محدد',

    ],
    'choose'                    => 'اختر الديانة',
    'success'                   => 'تم التسجيل بنجاح'
];
