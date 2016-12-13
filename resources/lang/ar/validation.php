<?php

return [
    "accepted" => "يجب قبول الحقل :attribute",
    "active_url" => "الحقل :attribute لا يُمثّل رابطًا صحيحًا",
    "after" => "يجب على الحقل :attribute أن يكون تاريخًا لاحقًا للتاريخ :date.",
    "alpha" => "يجب أن لا يحتوي الحقل :attribute سوى على حروف",
    "alpha_dash" => "يجب أن لا يحتوي الحقل :attribute على حروف، أرقام ومطّات.",
    "alpha_num" => "يجب أن يحتوي :attribute على حروفٍ وأرقامٍ فقط",
    "array" => "يجب أن يكون الحقل :attribute ًمصفوفة",
    "attributes" => [
        "address" => "العنوان",
        "age" => "العمر",
        "available" => "مُتاح",
        "city" => "المدينة",
        "content" => "المُحتوى",
        "country" => "الدولة",
        "date" => "التاريخ",
        "day" => "اليوم",
        "description" => "الوصف",
        "email" => "البريد الالكتروني",
        "excerpt" => "المُلخص",
        "first_name" => "الاسم",
        "gender" => "الجنس",
        "hour" => "ساعة",
        "last_name" => "اسم العائلة",
        "minute" => "دقيقة",
        "mobile" => "الجوال",
        "month" => "الشهر",
        "name" => "الاسم",
        "password" => "كلمة المرور",
        "password_confirmation" => "تأكيد كلمة المرور",
        "phone" => "الهاتف",
        "second" => "ثانية",
        "sex" => "الجنس",
        "size" => "الحجم",
        "time" => "الوقت",
        "title" => "اللقب",
        "username" => "اسم المُستخدم",
        "year" => "السنة"
    ],
    "before" => "يجب على الحقل :attribute أن يكون تاريخًا سابقًا للتاريخ :date.",
    "between" => [
        "array" => "يجب أن يحتوي :attribute على عدد من العناصر محصورًا ما بين :min و :max",
        "file" => "يجب أن يكون حجم الملف :attribute محصورًا ما بين :min و :max كيلوبايت.",
        "numeric" => "يجب أن تكون قيمة :attribute محصورة ما بين :min و :max.",
        "string" => "يجب أن يكون عدد حروف النّص :attribute محصورًا ما بين :min و :max"
    ],
    "boolean" => "يجب أن تكون قيمة الحقل :attribute إما true أو false ",
    "confirmed" => "حقل التأكيد غير مُطابق للحقل :attribute",
    "contract_field_cannot_edit_if_approved" => "لا يمكن تعديل حقل :attribute لانه قد تم الموافقة على العقد من قبل المستفيد",
    "custom" => [
        "attribute-name" => [
            "rule-name" => "custom-message"
        ],
        "parent_id" => [
            "required_if" => "الحقل :attribute مطلوب في حال ما إذا كان البنك فرعي"
        ]
    ],
    "date" => "الحقل :attribute ليس تاريخًا صحيحًا",
    "date_format" => "لا يتوافق الحقل :attribute مع الشكل :format.",
    "different" => "يجب أن يكون الحقلان :attribute و :other مُختلفان",
    "digits" => "يجب أن يحتوي الحقل :attribute على :digits رقمًا/أرقام",
    "digits_between" => "يجب أن يحتوي الحقل :attribute ما بين :min و :max رقمًا/أرقام ",
    "email" => "يجب أن يكون :attribute عنوان بريد إلكتروني صحيح البُنية",
    "exists" => "القيمة المحددة للحقل :attribute غير موجودة",
    "filled" => "الحقل :attribute إجباري",
    "image" => "يجب أن يكون الحقل :attribute صورةً",
    "in" => "الحقل :attribute لاغٍ",
    "integer" => "يجب أن يكون الحقل :attribute عددًا صحيحًا",
    "ip" => "يجب أن يكون الحقل :attribute عنوان IP ذي بُنية صحيحة",
    "json" => "يجب أن يكون الحقل :attribute نصآ من نوع JSON.",
    "max" => [
        "array" => "يجب أن لا يحتوي الحقل :attribute على أكثر من :max عناصر/عنصر.",
        "file" => "يجب أن يكون حجم الملف :attribute أقل من أو يساوي :max كيلوبايت",
        "numeric" => "يجب أن تكون قيمة الحقل :attribute أقل من أو تساوي :max.",
        "string" => "يجب أن لا يتجاوز طول النّص :attribute :max حروفٍ/حرفًا"
    ],
    "mimes" => "يجب أن يكون الحقل :attribute ملفًا من نوع :values.",
    "min" => [
        "array" => "يجب أن يحتوي الحقل :attribute على الأقل على :min عُنصرًا/عناصر",
        "file" => "يجب أن يكون حجم الملف :attribute أكبر من :min كيلوبايت",
        "numeric" => "يجب أن تكون قيمة الحقل :attribute أكبر من أو تساوي :min.",
        "string" => "يجب أن يكون قيمة الحقل :attribute أكبر :min حروف/حرفًا"
    ],
    "not_in" => "الحقل :attribute لاغٍ",
    "numeric" => "يجب على الحقل :attribute أن يكون رقمًا",
    "regex" => "صيغة الحقل :attribute .غير صحيحة",
    "required" => "الحقل :attribute مطلوب.",
    "required_if" => "الحقل :attribute مطلوب في حال ما إذا كان :other يساوي :value.",
    "required_unless" => "الحقل :attribute مطلوب في حال ما لم يكن :other يساوي :values.",
    "required_with" => "الحقل :attribute إذا توفّر :values.",
    "required_with_all" => "الحقل :attribute إذا توفّر :values.",
    "required_without" => "الحقل :attribute إذا لم يتوفّر :values.",
    "required_without_all" => "الحقل :attribute إذا لم يتوفّر :values.",
    "same" => "يجب أن يتطابق الحقل :attribute مع :other",
    "saudi_percentage_unique" => "تم إدخال نسبة السعودة بهذه المعايير سابقا",
    "size" => [
        "array" => "يجب أن يحتوي الحقل :attribute عن ما لا يقل عن:min عنصرٍ/عناصر",
        "file" => "يجب أن يكون حجم الملف :attribute أكبر من :size كيلو بايت.",
        "numeric" => "يجب أن تكون قيمة :attribute أكبر من :size.",
        "string" => "يجب أن يحتوي النص :attribute عن ما لا يقل عن  :size حرفٍ/أحرف."
    ],
    "string" => "يجب أن يكون الحقل :attribute نصآ.",
    "timezone" => "يجب أن يكون :attribute نطاقًا زمنيًا صحيحًا",
    "unique" => "قيمة الحقل :attribute مُستخدمة من قبل",
    "url" => "صيغة الرابط :attribute غير صحيحة"
];
