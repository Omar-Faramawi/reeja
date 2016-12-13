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
                            <a data-toggle="collapse" data-parent="#rules" href="#collapseTemp">خدمة إشعارات العمل المؤقتة</a>
                        </h2>
                    </div>
                    <div id="collapseTemp" class="panel-collapse collapse">
                        <div class="panel-body">
                            <p>إشعار العمل المؤقت هو وثيقة قانونية مبنية على وجود عقد خدمات يتم من خلالها تحديد الأشخاص الذين سيقومون
                                بتقديم الخدمة. </p>
                            <hr>
                            <p><strong>المنشآت المسموح لها إصدار إشعارات عمل مؤقت، وهي مقدمة الخدمة، يُشترط أن تندرج تحت أحد الأنشطة
                                    التالية:</strong></p>

                            <div class="row form-group">
                                <div class="col-xs-6">
                                    <div class="panel panel-default text-center">
                                        <div class="panel-body"><span class="fa fa-3x fa-cog"></span></div>
                                        <div class="panel-footer">التشييد والبناء (9)</div>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="panel panel-default text-center">
                                        <div class="panel-body"><span class="fa fa-3x fa-wrench"></span></div>
                                        <div class="panel-footer">مقاولات الصيانة والنظافة والتشغيل والإعاشة (10)</div>
                                    </div>
                                </div>
                                <div class="clearfix form-group"></div>
                                <div class="col-xs-6">
                                    <div class="panel panel-default text-center">
                                        <div class="panel-body"><span class="fa fa-3x fa-line-chart"></span></div>
                                        <div class="panel-footer">الخدمات الاستشارية والأعمال (26)</div>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="panel panel-default text-center">
                                        <div class="panel-body"><span class="fa fa-3x fa-graduation-cap"></span></div>
                                        <div class="panel-footer">المعاهد والكليات (35)</div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <p><strong>الجهات المستفيدة من إشعارات العمل المؤقت:</strong></p>

                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="panel panel-default text-center">
                                        <div class="panel-body"><span class="fa fa-3x fa-building"></span></div>
                                        <div class="panel-footer">جميع المنشآت</div>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="panel panel-default text-center">
                                        <div class="panel-body"><span class="fa fa-3x fa-user"></span></div>
                                        <div class="panel-footer">الأفراد</div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <h4>خطوات إصدار إشعار عمل مؤقت</h4>
                            <h5>الباقة المجانية</h5>
                            <ol>
                                <li>تسجيل دخول المستخدم</li>
                                <li>اختيار المنشأة المقدمة للخدمة</li>
                                <li>اختيار خدمة إصدار إشعار عمل مؤقت (يتم إتاحة هذا الإختيار للنشاطات المتاح لها ذلك فقط).</li>
                                <li>اختيار نوعية التعاقد (عقد مباشر أو عقد من الباطن)</li>
                                <li>يتم إدخال بيانات التعاقد والجهة المستفيدة</li>
                                <li>يتم ارخال رقم اقامة العامل المراد إصدار إشعار عمل مؤقت له</li>
                                <li>الإقرار بالشروط والضوابط القانونية</li>
                                <li>حفظ وطباعة الإشعارات </li>
                                <li>التوقيع على الإشعارات وختمها من قبل المنشأة المقدّمة للخدمة</li>
                                <li>يتم تسليم كل عامل الإشعار الخاص به كي يكون بحوزته أثناء وجوده في مكان تقديم الخدمة</li>
                            </ol>
                            <h5>الباقة الممتازة</h5>
                            <ol>
                                <li>تسجيل دخول المستخدم</li>
                                <li>اختيار المنشأة المقدمة للخدمة</li>
                                <li>اختيار خدمة إصدار إشعار عمل مؤقت (يتم إتاحة هذا الإختيار للنشاطات المتاح لها ذلك فقط)</li>
                                <li>تحديد العدد المطلوب من الإشعارات للإشتراك في الباقة الممتازة ودفع تكلفة الخدمة (20 ريال عن كل شهر) عن طريق إحدى قنوات سداد</li>
                                <li>اختيار نوعية التعاقد (عقد مباشر أو عقد من الباطن)</li>
                                <li>يتم إدخال بيانات التعاقد والخدمة والجهة المستفيدة</li>
                                <li>يتم اختيار العمالة المراد إصدار إشعارات عمل مؤقتة لهم من قائمة العمالة التابعين للمنشأة أو المعارين لها</li>
                                <li>تحديد مدة الإشعارات المصدرة</li>
                                <li>الإقرار بالشروط والضوابط القانونية</li>
                                <li>حفظ وطباعة الإشعارات </li>
                                <li>التوقيع على الإشعارات وختمها من قبل المنشأة المقدّمة للخدمة</li>
                                <li>يتم تسليم كل عامل الإشعار الخاص به كي يكون بحوزته أثناء وجوده في مكان تقديم الخدمة</li>
                            </ol>
                            <div class="alert alert-warning no-margin">تنويه: يجب مراعاة شروط وضوابط النظام المتوافقة مع قوانين أنظمة
                                العمل.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">
                            <a data-toggle="collapse" data-parent="#rules" href="#collapseRental">خدمة إشعارات الإعارة</a>
                        </h2>
                    </div>
                    <div id="collapseRental" class="panel-collapse collapse">
                        <div class="panel-body">
                            <p>إشعار الإعارة هو وثيقة قانونية يتم من خلالها تحديد الأشخاص الذين تمت إعارتهم لفترة زمنية محددة.</p>
                            <hr>
                            <p><strong>المنشآت المسموح لها إعارة عمالتها وإصدار إشعار إعارة، يُشترط أن تندرج تحت النشاط
                                    التالي:</strong></p>

                            <div class="row form-group">
                                <div class="col-xs-6">
                                    <div class="panel panel-default text-center">
                                        <div class="panel-body"><span class="fa fa-3x fa-cogs"></span></div>
                                        <div class="panel-footer">التشييد والبناء (9)</div>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="panel panel-default text-center">
                                        <div class="panel-body"><span class="fa fa-3x fa-medkit"></span></div>
                                        <div class="panel-footer">الصيدليات (13)</div>
                                    </div>
                                </div>
                            </div>
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

                            <div class="row form-group">
                                <div class="col-xs-6">
                                    <div class="panel panel-default text-center">
                                        <div class="panel-body"><span class="fa fa-3x fa-book"></span></div>
                                        <div class="panel-footer">جمعيات تحفيظ القرآن الكريم</div>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="panel panel-default text-center">
                                        <div class="panel-body"><span class="fa fa-3x fa-graduation-cap"></span></div>
                                        <div class="panel-footer">المعاهد والكليات (35)</div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <h4>خطوات إصدار إشعار إعارة</h4>
                            <ol>
                                <li>تسجيل دخول المستخدم</li>
                                <li>اختيار المنشأة المقدمة للخدمة</li>
                                <li>اختيار خدمة إصدار إشعار اعارة</li>
                                <li>يتم إدخال بيانات الجهة المستفيدة</li>
                                <li>يتم اختيار العمالة المراد إعارتهم من قائمة العمالة التابعين للمنشأة وإصدار إشعارات لهم</li>
                                <li>الإقرار بالشروط والضوابط القانونية وبالتكلفة المترتبة على الخدمة (60 ريال لمدة 3 أشهر)</li>
                                <li>سداد قيمة الخدمة عن طريق إحدى قنوات سداد</li>
                                <li>حفظ وطباعة الإشعارات </li>
                                <li>التوقيع على الإشعارات وختمها من قبل المنشأة المقدّمة للخدمة</li>
                                <li>يتم تسليم كل عامل الإشعار الخاص به كي يكون بحوزته أثناء وجوده لدى الجهة المستفيدة</li>
                            </ol>
                            <div class="alert alert-warning no-margin">تنويه: يجب مراعاة شروط وضوابط النظام المتوافقة مع قوانين أنظمة
                                العمل.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">
                            <a data-toggle="collapse" data-parent="#rules" href="#collapseCompanions">خدمة إشعارات المرافقين</a>
                        </h2>
                    </div>
                    <div id="collapseCompanions" class="panel-collapse collapse">
                        <div class="panel-body">
                            <p>إشعار المرافقين هي وثيقة قانونية يتم من خلالها تحديد المرافقين الذين تم السماح لهم بالعمل لدى
                                الجهةالمستفيدة من خدماتهم دون الحاجة لنقل الخدمات، وذلك لفترة زمنية محددة.</p>

                            <p><strong>حالياً، يُسمح للمنشآت الواقعة في قطاع التعليم لإصدار إشعارات للمرافقين، ويُشترط أن تندرج هذه
                                    المنشئات تحت أحد الأنشطة التالية (يرمز الرقم الى رقم النشاط في نطاقات):</strong></p>

                            <div class="row form-group">
                                <div class="col-xs-6">
                                    <div class="panel panel-default text-center">
                                        <div class="panel-body"><span class="fa fa-3x fa-book"></span>
                                            <p>
                                                <b>النشاط الفرعي
                                                </b><br>
                                                9-319
                                            </p>
                                        </div>
                                        <div class="panel-footer">المدارس الأجنبية</div>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="panel panel-default text-center">
                                        <div class="panel-body"><span class="fa fa-3x fa-male"></span>
                                            <p>
                                                <b>النشاط الفرعي
                                                </b><br>9-322 و 9-323 و 9-324
                                            </p>
                                        </div>
                                        <div class="panel-footer">مدارس البنين الأهلية</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-xs-6">
                                    <div class="panel panel-default text-center">
                                        <div class="panel-body"><span class="fa fa-3x fa-female"></span>
                                            <p>
                                                <b>النشاط الفرعي
                                                </b><br>
                                                9-312 و 9-313 و 9-314
                                            </p>
                                        </div>
                                        <div class="panel-footer">مدارس البنات الأهلية</div>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="panel panel-default text-center">
                                        <div class="panel-body"><span class="fa fa-3x fa-child"></span>
                                            <p>
                                                <b>النشاط الفرعي
                                                </b><br>
                                                9-311
                                            </p>
                                        </div>
                                        <div class="panel-footer">رياض الأطفال</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-xs-6">
                                    <div class="panel panel-default text-center">
                                        <div class="panel-body"><span class="fa fa-3x fa-graduation-cap"></span>
                                            <p>
                                                <b>النشاط الفرعي
                                                </b><br>
                                                9-326 و 9-327 و 9-328
                                            </p>
                                        </div>
                                        <div class="panel-footer">مدارس البنين والبنات الأهلية</div>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="panel panel-default text-center">
                                        <div class="panel-body"><span class="fa fa-3x fa-graduation-cap"></span>
                                            <p>
                                                <b>النشاط الفرعي
                                                </b><br>
                                                9-31
                                            </p>
                                        </div>
                                        <div class="panel-footer">معاهد التعليم</div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <h4>خطوات إصدار إشعار مرافق</h4>
                            <ol>
                                <li>تسجيل دخول المستخدم.</li>
                                <li>اختيار المنشأة التي ترغب في توظيف المرافق فيها.</li>
                                <li>النقر على خيار "إشعارات المرافقين" ثم اختيار "إصدار إشعارات جديدة".</li>
                                <li>إدخال بيانات المرافق المراد تسجيله ثم النقر على "التالي"</li>
                                <li>التأكيد على صحة بيانات المرافق بالنقر على "الإقرار بصحة المعلومات".</li>
                                <li>النقر على "إصدار فاتورة" والانتقال لصفحة التسديد عن طريق الصفحة الرئيسية أو اختيار إصدار اشعارات
                                    جديدة لإضافة مرافق آخر.
                                </li>
                                <li>في صفحة إصدار الفاتورة يتم اختيار المرافقين الذين ترغب في اصدار إشعارات لهم ثم النقر على "إصدار
                                    فاتورة".
                                </li>
                                <li>ستظهر فاتورة بها رقم خدمة سداد ليتم تسديد المبلغ المستحق.</li>
                                <li>بعد تسديد المبلغ المستحق، يمكن الدخول الى الصفحة الرئيسية لطباعة الإشعار بالنقر على "الفواتير
                                    والسداد" واختيار إشعارات المرافقين.
                                </li>
                            </ol>
                            <div class="alert alert-warning no-margin">تنويه: يجب مراعاة شروط وضوابط النظام المتوافقة مع قوانين أنظمة
                                العمل.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">
                            <a data-toggle="collapse" data-parent="#rules" href="#collapseVisitors">خدمة الزائرين </a>
                        </h2>
                    </div>
                    <div id="collapseVisitors" class="panel-collapse collapse">
                        <div class="panel-body">
                            <p>إشعار "الزائرين" هو وثيقة قانونية تسمح للزائرين بالعمل لدى الجهة أو الفرد المستفيد من خدماتهم دون
                                الحاجة إلى نقل الخدمات، حسب المدة المحددة في الإشعار. </p>
                            <hr>
                            <p><strong>الجهات المستفيدة من خدمة الزائرين:</strong></p>

                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="panel panel-default text-center">
                                        <div class="panel-body"><span class="fa fa-3x fa-building"></span></div>
                                        <div class="panel-footer">جميع المنشآت</div>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="panel panel-default text-center">
                                        <div class="panel-body"><span class="fa fa-3x fa-user"></span></div>
                                        <div class="panel-footer">الأفراد</div>
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <h4>الجهات ذات العلاقة</h4>
                            <dl class="dl-horizontal">
                                <dt>وزارة الداخلية</dt>
                                <dd>تصدر الرقم الحدودي للزائر كما تقوم بضبط تطبيق الأمر السامي.</dd>

                                <dt>وزارة العمل</dt>
                                <dd>توثق العلاقة التعاقدية بين المنشأة أو الفرد وبين الزائر، كما تفصل في الخلافات العمالية.</dd>

                                <dt>المنشأة أو الفرد</dt>
                                <dd>يوفران الوظيفة التي يحكمها العقد الموقع بين المنشأة أو الفرد وبين الزائر.</dd>

                                <dt>الزائر</dt>
                                <dd>أبناء الجالية السورية اللذين يحملون تأشيرة زيارة وأبناء الجالية اليمنية الذين يحملون وثيقة سفر من الحكومة اليمنية الشرعية</dd>
                            </dl>

                            <hr>
                            <h4>خطوات إصدار إشعار الزائرين للمنشآت</h4>
                            <ol>
                                <li>تسجيل الدخول في نظام أجير (https://www.ajeer.com.sa) باستخدام معلومات المنشأة عند وزارة العمل.</li>
                                <li>اختيار المنشأة التي سيعمل لديها الزائر للمنشآت.</li>
                                <li>اختيار أيقونة إشعارات الزائرين.</li>
                                <li>اختيار "إصدار إشعار جديد"</li>
                                <li>إدخال الرقم الحدودي للزائر وتاريخ ميلاده.</li>
                                <li>التأكد من بيانات الزائر والمنشأة من خلال مركز المعلومات الوطني.</li>
                                <li>الموافقة على الشروط والأحكام المنظمة للخدمة.</li>
                                <li>إصدار الإشعار وطباعته.</li>
                            </ol>
                            <h4>خطوات إصدار إشعار الزائرين للأفراد (للأشقاء اليمنيين) </h4>
                            <ol>
                                <li>تسجيل الدخول في نظام أجير (https://www.ajeer.com.sa) باستخدام معلومات الافراد.</li>
                                <li>اختيار أيقونة إشعارات الزائرين.</li>
                                <li>اختيار "إصدار إشعار جديد"</li>
                                <li>إدخال رقم الحدود للزائر وتاريخ ميلاده.</li>
                                <li>التأكد من بيانات الزائر و الفرد من خلال مركز المعلومات الوطني.</li>
                                <li>الموافقة على الشروط والأحكام المنظمة للخدمة.</li>
                                <li>إصدار الإشعار وطباعته.</li>
                            </ol>
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