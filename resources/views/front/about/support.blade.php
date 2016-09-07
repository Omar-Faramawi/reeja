@extends('front.layout')
@section('title', trans('front.menu.help'))
@section('content')
        <!-- BEGIN PAGE HEAD-->
<div class="page-head">
    <div class="container">
        <!-- BEGIN PAGE TITLE -->
        <div class="page-title">
            <h1> {{ trans('labels.system_name') }}
                <small>{{trans('front.menu.help')}}</small>
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
        </ul>
        <!-- END PAGE BREADCRUMBS -->
        <!-- BEGIN PAGE CONTENT INNER -->
        <div class="page-content-inner">
            <div class="row">
                <div class="row margin-bottom-20">
                    <div class="col-lg-4 col-md-6">
                        <div class="portlet light">
                            <div class="card-icon">
                                <i class="icon-user-follow font-red-sunglo theme-font"></i>
                            </div>
                            <div class="card-title">
                                <span> أجير لخدمات الأعمال</span>
                            </div>
                            <div class="card-desc">
                                <span> تهدف لخدمة قطاع الأعمال في المملكة العربية السعودية لتوثيق العلاقات التعاقدية التي تشمل على عقود عمل من الباطن أو عقود عمل مباشرة تتطلب وجود العمالة التابعة لجهة ما للعمل لدى جهة أخرى. ومن خلال بوابة أجير الإلكترونية يُمكن لأصحاب العمل إصدار إشعارات عمل مؤقت الخاصة بالعقود وإشعارات إعارة العمالة للأنشطة الاقتصادية المصرح لها حسب ضوابط وقوانين أنظمة العمل.
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="portlet light">
                            <div class="card-icon">
                                <i class="icon-trophy font-green-haze theme-font"></i>
                            </div>
                            <div class="card-title">
                                <span> أجير لخدمات المرافقين</span>
                            </div>
                            <div class="card-desc">
                                <span> تهدف لتنظيم عمل المرافقين في المملكة العربية السعودية، وذلك بإعطاء تنظيم جديد لعمل المرافقين الراغبين في العمل في الأنشطة الاقتصادية المصرح لها حسب ضوابط وقوانين نظام العمل. يتم ذلك عن طريق بوابة أجير الإلكترونية، والتي تُمكن أصحاب العمل في الأنشطة المصرح لها بإصدار إشعارات تصاريح عمل مؤقتة للمرافقين.
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="portlet light">
                            <div class="card-icon">
                                <i class="icon-layers font-blue theme-font"></i>
                            </div>
                            <div class="card-title">
                                <span> خدمة الزائرين</span>
                            </div>
                            <div class="card-desc">
                                <span> تهدف خدمة أجير الزائرين لإتاحة الفرصة للأشقاء اليمنيين الذين يقيمون في المملكة بصورة غير نظامية قبل تاريخ 20/6/1436 هـ (بعد تصحيح أوضاعهم)،و السوريين المتواجدين في المملكة بطريقة نظامية (بغض النظر عن تاريخ دخولهم) بالعمل بشكل نظامي وفق أنظمة العمل السعودية. حيث توفر خدمة أجير للأشقاء السوريين واليمنيين رخص العمل المؤقتة لستة أشهر قابلة للتجديد.
                                </span>
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