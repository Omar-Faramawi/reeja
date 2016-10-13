@extends('front.layout')
@section('title', trans('packagesubscribe.mainTitle'))
@section("content")
    <div class="page-content">
        <div class="container">
            <!-- BEGIN PAGE CONTENT INNER -->
            <div class="page-content-inner">
                <div class="row">
                    <div class="col-md-12">
                        <div class="portlet light portlet-fit portlet-datatable">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-info-circle"></i>{{trans("packagesubscribe.mainTitle")}}
                                </div>
                            </div>
                            <div class="portlet-body">
                                @if(session()->has('msg_error'))
                                    <div class="alert alert-block alert-danger fade in">
                                        <button type="button" class="close" data-dismiss="alert"></button>
                                        <p>{!! session()->pull('msg_error') !!} </p>
                                    </div>
                                @endif
                                <div class="portlet grey-cascade box">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-info-circle"></i>{{trans("packagesubscribe.bundleProperties")}}
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="row static-info">
                                            <div class="col-md-5 name">
                                                {{trans("packagesubscribe.canPayTill")}}
                                            </div>
                                            <div class="col-md-7 value">
                                                {{$ishaarSetup->paid_ishaar_payment_expiry_period}}
                                                {{\Tamkeen\Ajeer\Utilities\Constants::periodTypes($ishaarSetup->paid_ishaar_payment_expiry_period_type)}}

                                            </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name">
                                                {{trans("packagesubscribe.ishaarsValidationTime")}}
                                            </div>
                                            <div class="col-md-7 value">
                                                {{$ishaarSetup->paid_ishaar_valid_expiry_period}}
                                                {{ \Tamkeen\Ajeer\Utilities\Constants::periodTypes($ishaarSetup->paid_ishaar_valid_expiry_period_type)}}
                                            </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name">
                                                {{trans("packagesubscribe.max_ishaar_period")}}
                                            </div>
                                            <div class="col-md-7 value">
                                                {{$ishaarSetup->max_ishaar_period}}
                                                {{ \Tamkeen\Ajeer\Utilities\Constants::periodTypes($ishaarSetup->max_ishaar_period_type)}}

                                            </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name">
                                                {{trans("packagesubscribe.max_ishaar_period_type")}}
                                            </div>
                                            <div class="col-md-7 value">
                                                {{$ishaarSetup->min_ishaar_period}}
                                                {{\Tamkeen\Ajeer\Utilities\Constants::periodTypes($ishaarSetup->min_ishaar_period_type)}}
                                            </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name">
                                                {{trans("packagesubscribe.max_places_for_one_employee_for_one_ishaar")}}
                                            </div>
                                            <div class="col-md-7 value">
                                                {{$ishaarSetup->labor_multi_regions_perm_num}}
                                                {{trans("packagesubscribe.places")}}
                                            </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name">
                                                {{trans("packagesubscribe.max_noofishaar_for_one_employee_on_same_time")}}
                                            </div>
                                            <div class="col-md-7 value">
                                                {{$ishaarSetup->total_period_labor}}
                                                {{trans("packagesubscribe.ishaar")}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="portlet grey-cascade box">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-info-circle"></i>{{trans("packagesubscribe.useForSameEmp")}}
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        @if ($ishaarSetup->labor_same_benef_max_num_of_ishaar)
                                            <div class="row static-info">
                                                <div class="col-md-5 name">
                                                    {{trans("packagesubscribe.useForSameEmp")}}
                                                </div>
                                                <div class="col-md-7 value">
                                                    {{$ishaarSetup->labor_same_benef_max_num_of_ishaar}}
                                                    {{trans("packagesubscribe.ishaar")}}

                                                </div>
                                            </div>
                                        @endif
                                        @if ($ishaarSetup->labor_same_benef_max_period_of_ishaar)
                                            <div class="row static-info">
                                                <div class="col-md-5 name">
                                                    {{trans("packagesubscribe.totalTimeOfuseForSameEmp")}}
                                                </div>
                                                <div class="col-md-7 value">
                                                    {{$ishaarSetup->labor_same_benef_max_period_of_ishaar}}
                                                    {{\Tamkeen\Ajeer\Utilities\Constants::periodTypes($ishaarSetup->labor_same_benef_max_period_of_ishaar_type)}}

                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="portlet grey-cascade box">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-info-circle"></i>{{trans("packagesubscribe.ishaarGroups")}}
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="row">
                                            @if (!$hasInvoiceBundles)
                                                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                                    <div class="dashboard-stat2 ">
                                                        <div class="display">
                                                            <div class="number">
                                                                <h4 class="font-blue-sharp">
                                                                    {{trans("packagesubscribe.trailBundle")}}
                                                                </h4>
                                                                <small></small>
                                                            </div>
                                                            <div class="icon">
                                                                <button class="btn blue-madison" type="button"
                                                                        data-token="{{ csrf_token() }}"
                                                                        data-uri="{{ url('taqawel/packagesubsribe')}}"
                                                                        data-hreff="{{ url('taqawel/packagesubsribe/activate') }}"
                                                                        data-loading-text="{{ trans('labels.loading') }}..."
                                                                        id="activateTrail">{{trans("packagesubscribe.activate")}}
                                                                </button>
                                                            </div>
                                                        </div>

                                                        <div class="progress-info">
                                                            <div class="status">
                                                                <div class="status-title">{{trans("packagesubscribe.ishaarsNo")}} </div>
                                                                <div class="status-number">{{$trialBundles->max_of_num_ishaar}}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            @foreach($paidbundles as $bundle)
                                                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                                    <div class="dashboard-stat2 ">
                                                        <div class="display">
                                                            <div class="number">
                                                                <h3 class="font-blue-sharp">
                                                                    <span data-counter="counterup"
                                                                          data-value="{{$bundle->max_of_num_ishaar}}"></span>
                                                                </h3>
                                                                <small>{{trans("packagesubscribe.ishaarsNo")}}</small>
                                                            </div>
                                                            <div class="icon">
                                                                {{$bundle->min_of_num_ishaar}}
                                                                -{{$bundle->max_of_num_ishaar}}
                                                            </div>
                                                        </div>
                                                        <div class="progress-info">
                                                            <div class="status">
                                                                <div class="status-title"> {{trans("packagesubscribe.ishaarPriceForMonth")}}</div>
                                                                <div class="status-number">{{$bundle->monthly_amount}}   {{trans("packagesubscribe.reyal")}}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                {{Form::open(['url' => url('taqawel/packagesubsribe/accept/approve' ),'data-url'=>url('/taqawel/packagesubsribe'), 'id'=>'generateInvoiceForm',"method"=>"PUT","role"=>"form"])}}
                                <div class="row static-info">
                                    <div class="col-lg-3">{{trans("packagesubscribe.noOfRequestedIshaars")}}</div>
                                    <div class="col-lg-5">

                                        <div class="form-group form-md-line-input has-warning">
                                            <div class="input-group">

                                                <div class="input-group-control">
                                                    {{Form::input("number","requestedIshaars",null,["id"=>"requestedIshaars","class"=>"form-control edited"])}}
                                                    {{--Form::text("requestedIshaars",null,["id"=>"requestedIshaars","class"=>"form-control edited"])--}}
                                                </div>
                                                <span class="input-group-btn btn-right">
                                                                <button class="btn blue-madison" type="button"
                                                                        data-token="{{ csrf_token() }}"
                                                                        data-hreff="{{ url('taqawel/packagesubsribe/accept') }}"
                                                                        data-loading-text="{{ trans('labels.loading') }}..."
                                                                        id="calculateButton">{{trans("packagesubscribe.accept")}}
                                                                </button>
                                                            </span>
                                            </div>
                                        </div>
                                        <div class="form-body" id="calculateError">
                                            @if (count($errors))
                                                <div class="alert alert-danger">
                                                    <button class="close" data-close="alert"></button>
                                                    @foreach($errors->all() as $error)
                                                        <span>{{$error}}</span><br/>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>

                                        <div class="col-xs-12" style="display: none;"
                                             id="resultDiv">
                                            <div class="dashboard-stat2 ">
                                                <div class="display">
                                                    <div class="number">
                                                        <h3 class="font-blue-sharp">

                                                        </h3>
                                                        <small>{{trans("packagesubscribe.ishaarPriceForMonth")}}</small>
                                                    </div>
                                                    <div class="icon" id="ishaarsNoRe">
                                                    </div>
                                                </div>
                                                <div class="progress-info">
                                                    <div class="status">
                                                        <div class="status-title"> {{trans("packagesubscribe.totalPrice")}}</div>
                                                        <div class="status-number">
                                                            <div class="label label-warning"
                                                                 id="totalCount"></div> {{trans("packagesubscribe.reyal")}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6"></div>
                                    <div class="col-lg-6">
                                        <div class="form-actions">
                                            <button type="submit" class="btn blue"
                                                    data-loading-text="{{ trans('labels.loading') }}..."
                                            > {{trans("packagesubscribe.approve")}} </button>
                                            <a class="btn yellow btn-outline sbold"
                                               href="{{url("")}}"
                                            > {{trans("packagesubscribe.cancel")}} </a>

                                        </div>
                                    </div>
                                </div>
                                {{Form::close()}}

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Modal -->
    <div id="invoiceModal" class="modal fade" role="basic" aria-hidden="true"
         data-href="{{ url('taqawel/packagesubsribe/invoice') }}">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <img src="{{ asset('assets/img/loading-spinner-grey.gif') }}" alt="" class="loading">
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->
@endsection