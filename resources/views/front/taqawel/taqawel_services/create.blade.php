@extends('front.layout')
@section('title', trans('taqawoul.headings.Add'))
@section('content')
<!-- BEGIN CONTENT BODY -->
<!-- BEGIN PAGE HEAD-->
<div class="page-head">
    <div class="container">
        <!-- BEGIN PAGE TITLE -->
        <div class="page-title">
            <h1>{{ trans('labels.system_name') }}
                <small>{{ isset($service) ? trans('taqawoul.headings.update') : trans('taqawoul.headings.Add') }}</small>
            </h1>
        </div>
        <!-- END PAGE TITLE -->
    </div>
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
                <div class="col-md-12">
                    <div class="portlet light portlet-fit portlet-datatable ">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-settings font-dark"></i>
                                <span class="caption-subject font-dark sbold uppercase">{{ isset($service) ? trans('taqawoul.headings.update') : trans('taqawoul.headings.Add') }}</span>
                            </div>

                        </div>
                        <div class="portlet-body">
                            <section>
                                @if(isset($service))
                                    {{ Form::model($service,['route' => ['taqawel.taqawelService.update', $service->id],'method'=>'PUT','id'=>'form', 'class'=>'form-horizontal ','data-url' => url('/taqawel/taqawelService')]) }}
                                @else
                                    {{ Form::open(['route' => 'taqawel.taqawelService.store','id'=>'form', 'class'=>'form-horizontal ','data-url' => url('/taqawel/taqawelService')]) }}
                                @endif
                                    <div class="form-body row">

                                    {{-- start of taqawoul form --}}
                                    <div class="col-md-12">
                                        <div class="form-group form-md-line-input">
                                            <label class="control-label text-right col-md-3">
                                                {{trans('taqawoul.form_attributes.service_type')}}
                                                <span class="required"> * </span>
                                            </label>
                                            <div class="col-md-8">
                                                <select class="form-control select2me bs-select" name="contract_nature_id" id="taqawel_service_type">
                                                    @if(!count($service_types))
                                                    <option value="">{{ trans('labels.no_data') }}</option>
                                                    @else
                                                    <option value="">{{ trans('labels.default') }}</option>
                                                    @foreach($service_types as $serv)
                                                    @if (old('service_types') == $serv)
                                                    <option value="{{$serv->id}}" selected>{{$serv->name}}</option>
                                                    @else
                                                    <option value="{{$serv->id}}" @if(isset($service)) @if($serv->id == $service->contract_nature_id) selected @endif @endif >{{$serv->name}}</option>
                                                    @endif
                                                    @endforeach
                                                    @endif
                                                    <option value="other" id="choose_other">{{trans('taqawoul.form_attributes.other')}}</option>
                                                </select>
                                                <br/><br/>
                                                <div id="new_service"></div>
                                            </div>
                                        </div>
                                        <div class="form-group form-md-line-input">
                                            <label for="description"
                                                   class="control-label text-right col-md-3">{{trans('taqawoul.form_attributes.service_description')}}</label>
                                            <div class="col-sm-8">
                                                <textarea class="form-control" rows="5" id="description" name="description">@if(isset($service)) {{$service->description or ''}} @endif</textarea>
                                                <div class="form-control-focus"></div>
                                                <span class="help-block">{{ trans('taqawoul.form_attributes.service_description') }}
                                                    ...</span>
                                            </div>
                                        </div>
                                        <div class="form-actions row">
                                            <div class="row">
                                                <div class="col-md-offset-1 col-md-9">
                                                    <button type="submit" class="btn green" 
                                                            data-loading-text="{{ trans('labels.loading') }}..."
                                                            id="save_and_publish">{{trans('taqawoul.buttons.save_and_publish')}}</button>

                                                    <button type="reset" class="btn default"
                                                            name="cancel">{{trans('taqawoul.buttons.cancel')}}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{form::close()}}
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection