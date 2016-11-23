<?php


return [
    'service_users_permissions'           => 'صلاحيات مستخدمي الخدمة',
    'service_providers'                   => 'مقدمي الخدمة',
    'service_beneficials'                 => 'المستفيدين من الخدمة',
    'est_service_beneficials'             => 'المستفيدين من المنشآت',
    'indv_service_beneficials'            => 'المستفيدين من الأفراد',
    'est'                                 => 'منشأة',
    'gov'                                 => 'جهة حكومية',
    'indv'                                => 'فرد',
    'attributes'                          => [
        'benf_indv'             => 'فرد',
        'contract_type_id'      => 'نوع العقد',
        'benf_est'              => 'منشأة',
        'service_prvdr_benf_id' => 'مقدم الخدمة',
        'benf_gover'            => 'جهة حكومية',
        'avl_borrow_labor'      => 'عدد العمالة المسموح للفرد إستعارته',
        'borrow_labor_pct'      => 'الحقل نسبة الاستعارة مطلوب للنشاط :activity_name لأنه تم منح صلاحية للمستفيد من الخدمة او المستفيد من نفس النشاط',
        'loan_labor_pct'        => 'الحقل نسبة الإعارة مطلوب للنشاط :activity_name لأنه تم منح صلاحية لمقدم الخدمة ',
        'choose_provider'       => 'يجب اعطاء صلاحية لمقدم الخدمة فى النشاط  :activity_name  لأنه تم ادخال نسبة إعارة',
        'choose_benf'       => 'يجب إعطاء صلاحية للمستفيد من الخدمة او المستفيد من نفس النشاط فى النشاط :activity_name لأنه تم ادخال نسبة استعارة',
    ],
    'indv2indv'                           => 'الأفراد يستطيعون تقديم الخدمة للأفراد فقط',
    'service_users_permissions_saved'     => 'تم تعديل صلاحيات مستخدمي الخدمة بنجاح',
    'service_users_permissions_not_saved' => 'لم يتم تعديل صلاحيات مستخدمي الخدمة',
    'at_least_one_gover_activities' => 'يجب أن تختار خدمة واحدة على الأقل مسموح بها للجهات الحكومية',
    'at_least_one_privillage' => 'يجب  اختيار صلاحية واحدة على الأقل لكل نشاط مسموح للمنشآت',
];