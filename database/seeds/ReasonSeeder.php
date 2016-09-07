<?php

use Illuminate\Database\Seeder;
use Tamkeen\Ajeer\Models\Reason;

class ReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Reason::create([
            'reason'    => 'أسباب رفض عقود تأجير العماله',
            'parent_id' => null,
        ]);
        Reason::create([
            'reason'    => 'أسباب رفض عقود التقاول',
            'parent_id' => null,
        ]);
        Reason::create([
            'reason'    => 'أسباب طلب إلغاء عقد تأجير عماله',
            'parent_id' => null,
        ]);
        Reason::create([
            'reason'    => 'أسباب طلب إلغاء عقد تقاول',
            'parent_id' => null,
        ]);
        Reason::create([
            'reason'    => 'أسباب طلب إلغاء إشعار تقاول',
            'parent_id' => null,
        ]);
        Reason::create([
            'reason'    => 'أسباب طلب إلغاء إشعار عمل مؤقت',
            'parent_id' => null,
        ]);
        Reason::create([
            'reason'    => 'أسباب رفض اعتماد طلب الغاء عقد عمل مؤقت',
            'parent_id' => null,
        ]);
        Reason::create([
            'reason'    => 'أسباب رفض اعتماد طلب الغاء اشعار عمل مؤقت',
            'parent_id' => null,
        ]);
        Reason::create([
            'reason'    => 'أسباب رفض اعتماد طلب الغاء عقد تقاول',
            'parent_id' => null,
        ]);
        Reason::create([
            'reason'    => 'أسباب رفض اعتماد طلب الغاء اشعار تقاول',
            'parent_id' => null,
        ]);
        Reason::create([
            'reason'    => 'القيمة المالية للعقد لا تتناسب مع إمكانيات الشركة',
            'parent_id' => 1,
        ]);
        Reason::create([
            'reason'    => 'عدم مناسبة العقد مع متطلبات الشركة',
            'parent_id' => 1,
        ]);
        Reason::create([
            'reason'    => 'العقد غير مكتمل',
            'parent_id' => 1,
        ]);
        Reason::create([
            'reason'    => 'أخري',
            'parent_id' => 1,
        ]);

        Reason::create([
            'reason'    => 'القيمة المالية للعقد لا تتناسب مع إمكانيات الشركة',
            'parent_id' => 2,
        ]);
        Reason::create([
            'reason'    => 'عدم مناسبة العقد مع متطلبات الشركة',
            'parent_id' => 2,
        ]);
        Reason::create([
            'reason'    => 'العقد غير مكتمل',
            'parent_id' => 2,
        ]);
        Reason::create([
            'reason'    => 'أخري',
            'parent_id' => 2,
        ]);

        Reason::create([
            'reason'    => 'عدم حاجة المنشأة المستفيدة من الخدمة للخدمات',
            'parent_id' => 3,
        ]);
        Reason::create([
            'reason'    => 'وجود بدائل أرخص',
            'parent_id' => 3,
        ]);
        Reason::create([
            'reason'    => 'المنشأة المقدمة للخدمة لا تملك الطاقة العمالية الكافية لتقديم الخدمات',
            'parent_id' => 3,
        ]);
        Reason::create([
            'reason'    => 'تم الإخلال بأحد شروط العقد',
            'parent_id' => 3,
        ]);
        Reason::create([
            'reason'    => 'جودة الخدمة غير مقبولة',
            'parent_id' => 3,
        ]);
        Reason::create([
            'reason'    => 'بسبب ظروف قاهرة',
            'parent_id' => 3,
        ]);
        Reason::create([
            'reason'    => 'أخري',
            'parent_id' => 3,
        ]);

        Reason::create([
            'reason'    => 'عدم حاجة المنشأة المستفيدة من الخدمة للخدمات',
            'parent_id' => 4,
        ]);
        Reason::create([
            'reason'    => 'وجود بدائل أرخص',
            'parent_id' => 4,
        ]);
        Reason::create([
            'reason'    => 'المنشأة المقدمة للخدمة لا تملك الطاقة العمالية الكافية لتقديم الخدمات',
            'parent_id' => 4,
        ]);
        Reason::create([
            'reason'    => 'تم الإخلال بأحد شروط العقد',
            'parent_id' => 4,
        ]);
        Reason::create([
            'reason'    => 'جودة الخدمة غير مقبولة',
            'parent_id' => 4,
        ]);
        Reason::create([
            'reason'    => 'بسبب ظروف قاهرة',
            'parent_id' => 4,
        ]);
        Reason::create([
            'reason'    => 'أخري',
            'parent_id' => 4,
        ]);
        Reason::create([
            'reason'    => 'وجود بدائل أرخص',
            'parent_id' => 5,
        ]);
        Reason::create([
            'reason'    => 'أخري',
            'parent_id' => 5,
        ]);
        Reason::create([
            'reason'    => 'وجود بدائل أرخص',
            'parent_id' => 6,
        ]);
        Reason::create([
            'reason'    => 'أخري',
            'parent_id' => 6,
        ]);
        Reason::create([
            'reason'    => 'وجود بدائل أرخص',
            'parent_id' => 7,
        ]);
        Reason::create([
            'reason'    => 'بسبب ظروف قاهرة',
            'parent_id' => 8,
        ]);
        Reason::create([
            'reason'    => 'تم الإخلال بأحد شروط العقد',
            'parent_id' => 9,
        ]);
        Reason::create([
            'reason'    => 'العقد غير مكتمل',
            'parent_id' => 10,
        ]);

    }
}
