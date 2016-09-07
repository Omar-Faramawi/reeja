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
                <small>{{ trans('taqawoul.headings.Add') }}</small>
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
                                <span class="caption-subject font-dark sbold uppercase">{{ trans('taqawoul.headings.Add') }}</span>
                            </div>

                        </div>
                        <div class="portlet-body">
                            <section>
                                {{ Form::model($service,['route' => ['taqawel.taqawelService.update', $service->id],'method'=>'PUT','id'=>'form', 'class'=>'form-horizontal ','data-url' => url('/taqawel/taqawelService')]) }}
                                <div class="form-body row">

                                    {{-- start of taqawoul form --}}
                                    <div class="col-md-12">
                                        <div class="form-group form-md-line-input">
                                            <label class="control-label text-right col-md-3">
                                                {{trans('taqawoul.form_attributes.service_type')}}
                                                <span class="required"> * </span>
                                            </label>
                                            <div class="col-md-8">
                                                <select class="form-control select2me bs-select" name="service_type" id="taqawel_service_type">
                                                    @if(!count($service_types))
                                                    <option>{{ trans('labels.no_data') }}</option>
                                                    @else
                                                    <option value="">{{ trans('labels.default') }}</option>
                                                    @foreach($service_types as $serv)
                                                    @if ($serv->id == $service->contract_nature_id)
                                                    <option value="{{$serv->id}}" selected>{{$serv->name}}</option>
                                                    @else
                                                    <option value="{{$serv->id}}">{{$serv->name}}</option>
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
                                                <textarea class="form-control" rows="5" id="description" name="description">{{$service->description or ''}}</textarea>
                                                <div class="form-control-focus"></div>
                                                <span class="help-block">{{ trans('taqawoul.form_attributes.service_description') }}
                                                    ...</span>
                                            </div>
                                        </div>
                                        <div class="form-actions row">
                                            <div class="row">
                                                <div class="col-md-offset-1 col-md-9">

                                                    <button type="submit" class="btn btn-primary" name="status"
                                                            value="0"
                                                            id="save_draft">{{trans('taqawoul.buttons.update_draft')}}</button>

                                                    <button type="submit" class="btn green" name="status" value="1"
                                                            data-loading-text="{{ trans('labels.loading') }}..."
                                                            id="save_and_publish">{{trans('taqawoul.buttons.update_and_publish')}}</button>

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