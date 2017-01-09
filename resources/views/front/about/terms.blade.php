@extends('front.layout')
@section('title', trans('front.menu.terms'))
@section('content')
        <!-- BEGIN PAGE HEAD-->
<div class="page-head">
    <div class="container">
        <!-- BEGIN PAGE TITLE -->
        <div class="page-title">
            <h1> {{ trans('labels.system_name') }}
                <small>{{trans('front.menu.terms')}}</small>
            </h1>
        </div>
    </div>
    <!-- END PAGE TOOLBAR -->
</div>
<!-- END PAGE HEAD-->
<!-- BEGIN PAGE CONTENT BODY -->
<div class="page-content">
    <div class="container">
        <!-- BEGIN PAGE BREADCRUMBS -->
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a href="{{ url('/') }}">{{ trans('labels.home') }}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>{{trans('front.menu.terms')}}</span>
            </li>
        </ul>
        <!-- END PAGE BREADCRUMBS -->
        <!-- BEGIN PAGE CONTENT INNER -->
        <div class="page-content-inner">

            <div class="panel-group" id="rules">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">
                            <a data-toggle="collapse" data-parent="#rules" href="#collapseTemp">خدمة إشعارات التقاول</a>
                        </h2>
                    </div>
                    <div id="collapseTemp" class="panel-collapse collapse">
                        <div class="panel-body">
                            <p>إشعار التقاول هو وثيقة قانونية مبنية على وجود عقد عمل يتم من خلالها تحديد الأشخاص الذين سيقومون بتنفيذ العمل. ويحمل العامل إشعار التقاول لإثبات قانونية تواجده في جهة غير التي يتبع لها، وذلك لتقديمها للجهات المختصة (لجان التفتيش) عند طلبها.
                            </p>
                            <hr>
                            <p><strong>المنشآت المسموح لها إصدار إشعارات تقاول، وهي مقدمة الخدمة، يُشترط أن تندرج تحت أحد الأنشطة التالية:
                                </strong></p>
                            <ul>
                                <li>التشييد والبناء </li>
                                <li>مقاولات الصيانة والتشغيل</li>
                                <li>مقاولات النظافة والإعاشة</li>
                                <li>الخدمات الاستشارية والأعمال </li>
                                <li>المعاهد </li>
                                <li>الكليات</li>
                            </ul>
                            <hr>
                            <p><strong>الجهات المستفيدة من إشعارات التقاول:</strong></p>

                            <ul>
                                <li>جميع المنشآت</li>
                                <li>الجهات الحكومية</li>
                                <li>الأفراد</li>
                            </ul>

                            <p><strong>شروط خاصة بنظام نطاقات:</strong></p>

                            <ul>
                                <li>لايمكن للمنشآت التي في النطاق الأحمر والأصفر بالإستفادة من خدمات أجير كمنشأة مستفيدة ولا كمنشأة مقدمة للخدمة.</li>
                                <li>لايوجد إنعكاس نطاقات للعمالة المصدر لهم إشعار تقاول</li>
                            </ul>
                            <div class="alert alert-warning no-margin">تنويه: يجب مراعاة شروط وضوابط النظام المتوافقة مع قوانين أنظمة
                                العمل.
                            </div>
                            <h4>الباقات المتاحة في إشعارات التقاول:</h4>
                            <ul>
                                <li>الباقة الممتازة </li>
                                <li>الباقة المجانية</li>
                            </ul>
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th class="text-center">الخصائص</th>
                                    <th class="text-center" nowrap>الحساب المجاني</th>
                                    <th class="text-center" nowrap>الحساب الممتاز</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="text-center"><strong>إصدار الإشعارات</strong></td>
                                    <td class="text-center"><i class="fa fa-check"></i></td>
                                    <td class="text-center"><i class="fa fa-check"></i></td>
                                </tr>
                                <tr>
                                    <td class="text-center"><strong>عدد الإشعارات التي يمكن إصدارها</strong></td>
                                    <td class="text-center">10 إشعارات كل شهر</td>
                                    <td class="text-center">حسبب عدد الإشعارات التي تم شراءها</td>
                                </tr>
                                <tr>
                                    <td class="text-center"><strong>إصدار أكثر من إشعار في نفس الوقت</strong></td>
                                    <td class="text-center"> </td>
                                    <td class="text-center"><i class="fa fa-check"></i></td>
                                </tr>
                                <tr>
                                    <td class="text-center"><strong>عدد الإشعارات المصدرة لنفس العامل في نفس الفترة</strong></td>
                                    <td class="text-center"> </td>
                                    <td class="text-center"><i class="fa fa-check"></i></td>
                                </tr>
                                <tr>
                                    <td class="text-center"><strong>تعدد مواقع العمل في الإشعار الواحد</strong></td>
                                    <td class="text-center"> </td>
                                    <td class="text-center"><i class="fa fa-check"></i></td>
                                </tr>
                                <tr>
                                    <td class="text-center"><strong>إختيار العمالة المراد إصدار إشعارات عمل مؤقتة لهم من قائمة العمالة التابعين للمنشأة أو المعارين لها</strong></td>
                                    <td class="text-center"> </td>
                                    <td class="text-center"><i class="fa fa-check"></i></td>
                                </tr>
                                <tr>
                                    <td class="text-center"><strong>طرح/طلب خدمات التقاول أو خدمات العمل المؤقت في سوق العمل</strong></td>
                                    <td class="text-center"> </td>
                                    <td class="text-center"><i class="fa fa-check"></i></td>
                                </tr>
                                <tr>
                                    <td class="text-center"><strong>تنبيهات على الجوال والبريد الإلكتروني</strong></td>
                                    <td class="text-center"> </td>
                                    <td class="text-center"><i class="fa fa-check"></i></td>
                                </tr>
                                <tr>
                                    <td class="text-center"><strong>مدة الإشعار</strong></td>
                                    <td class="text-center">شهر واحد</td>
                                    <td class="text-center">1-6 أشهر</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">
                            <a data-toggle="collapse" data-parent="#rules" href="#collapseRental">خدمة إشعارات العمل المؤقت</a>
                        </h2>
                    </div>
                    <div id="collapseRental" class="panel-collapse collapse">
                        <div class="panel-body">
                            <p>إشعار العمل المؤقت هو وثيقة مبنية على وجود عقد تقديم خدمات يتم من خلاله تحديد الأشخاص الذين تمت إعارة خدماتهم لفترة زمنية محددة. يحمل العامل إشعار العمل المؤقت لإثبات قانونية تواجده في جهة غير التي يتبع لها، وذلك لتقديمها للجهات المختصة (لجان التفتيش) عند طلبها.
                            </p>
                            <hr>
                            <p><strong>المنشآت المسموح لها إعارة عمالتها وإصدار إشعار إعارة، يُشترط أن تندرج تحت النشاط
                                    التالي:</strong></p>

                            <ul>
                                <li>التشييد والبناء</li>
                                <li>الصيدليات</li>
                            </ul>
                            <div class="alert alert-info">
                                <strong>بالنسبة للصيدليات:</strong>
                                <ol>
                                    <li>يجب الحصول على موافقة على الإعارة من الشؤون الصحية.</li>
                                    <li>يتم السماح فقط للعمالة المسجلة بمهنة صيدلي (رمز المهنة 2322011).</li>
                                    <li>حد أعلى لكل كيان أن يعير 20% فقط من الصيادلة.</li>
                                    <li>حد أعلى لتجديد الإعارة 4 مرات للتجديد، وفي حالة انه يحتاج أكثر من 12 شهر فيمكنه نقل خدمات العامل
                                        بدلاً من الاستمرار بالإعارة.
                                    </li>
                                </ol>
                            </div>
                            <div class="alert alert-warning no-margin">تنويه: يشترط أن تندرج المنشآت التي تعير عمالتها والمنشآت
                                المستفيدة من العمالة المُعارة تحت نفس النشاط.
                            </div>
                            <hr>
                            <h4>الاستثناءات</h4>

                            <p><strong>جميع المنشآت بأنشطتها المختلفة يمكن أن تُعير عمالتها إلى (يرمز الرقم الى رقم النشاط في
                                    نطاقات):</strong></p>

                            <ul>
                                <li>جمعيات تحفيظ القرآن الكريم</li>
                                <li>المعاهد </li>
                                <li>الكليات</li>
                            </ul>
                            <hr>

                            <h4>شروط خاصة بنظام نطاقات:</h4>
                            <ul>
                                <li>لايمكن للمنشآت التي في النطاق الأحمر والأصفر بالإستفادة من خدمات أجير كمنشأة مستفيدة ولا كمنشأة مقدمة للخدمة.</li>
                                <li>يتم إنعكاس نطاقات للعمالة المصدر لهم إشعار عمل مؤقت</li>
                            </ul>
                            <hr>
                            <h4>تكلفة ومدة إشعار العمل المؤقت:</h4>
                            <ul>
                                <li>•	تكلفة إشعار العمل المؤقت هي 60 ريال لمدة ثلاثة أشهر</li>
                            </ul>
                            <div class="alert alert-warning no-margin">تنويه: يجب مراعاة شروط وضوابط النظام المتوافقة مع قوانين أنظمة
                                العمل.
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <!-- END PAGE CONTENT INNER -->
    </div>
</div>
<!-- END PAGE CONTENT BODY -->
@endsection