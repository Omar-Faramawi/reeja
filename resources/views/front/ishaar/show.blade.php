@extends('front.layout')
@section('title', trans('ishaar_setup.headings.show'))
@section('content')
<!-- BEGIN CONTENT BODY -->
<!-- BEGIN PAGE HEAD-->
<div class="page-head">
    <div class="container">
        <!-- BEGIN PAGE TITLE -->
        <div class="page-title">
            <h1>{{trans('ishaar_setup.headings.show')}}</h1>
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
            <li>
                <a href="{{ url('/') }}">{{trans('ishaar_setup.headings.home')}}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="{{ url(Request::segment(1)) }}">{{trans('ishaar_setup.headings.list')}}</a>
                <i class="fa fa-circle"></i>
            </li>
        </ul>
        <!-- END PAGE BREADCRUMBS -->
        <!-- BEGIN PAGE CONTENT INNER -->
        <div class="page-content-inner">
            <div class="row">
                <div class="col-md-12">

                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_0">
                            <div class="portlet box green">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-gift"></i>{{trans('ishaar_setup.headings.create')}} </div>
                                </div>
                                <div class="portlet-body form">
                                    <!-- BEGIN FORM-->
                                {{ Form::open(['route' => 'ishaar.create','id'=>'form', 'class'=>'form-horizontal ishaars_form','data-url' => url(Request::segment(1))]) }}
                                        <div class="form-body">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">{{trans('ishaar_setup.form_attributes.ishaar_no')}}</label>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control input-circle" value="{{$contract->id or ''}}" disabled="disabled">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-3 control-label">{{trans('ishaar_setup.form_attributes.contract_no')}}</label>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control input-circle" value="{{$contract->contract_id or ''}}" disabled="disabled">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-3 control-label">{{trans('ishaar_setup.form_attributes.benifit_no')}}</label>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control input-circle-left" value="{{$contract->contract->benf_id or ''}}" disabled="disabled">
                                                        <span class="input-group-addon input-circle-right">
                                                            <i class="fa fa-user"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">{{trans('ishaar_setup.form_attributes.benifit_name')}}</label>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control input-circle-left" value="{{$contract->contract->benf_name or ''}}" disabled="disabled">
                                                        <span class="input-group-addon input-circle-right">
                                                            <i class="fa fa-user"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">{{trans('ishaar_setup.form_attributes.benifit_activity')}}</label>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control input-circle-left" value="{{$contract->contract->benef->est_activity or ''}}" disabled="disabled">
                                                        <span class="input-group-addon input-circle-right">
                                                            <i class="fa fa-user"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-3 control-label">{{trans('ishaar_setup.form_attributes.work_start_date')}}</label>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control input-circle-left" value="{{$contract->start_date or ''}}" disabled="disabled">
                                                        <span class="input-group-addon input-circle-right">
                                                           <i class="fa fa-microphone"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-3 control-label">{{trans('ishaar_setup.form_attributes.work_end_date')}}</label>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control input-circle-left" value="{{$contract->end_date or ''}}" disabled="disabled">
                                                        <span class="input-group-addon input-circle-right">
                                                           <i class="fa fa-microphone"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-3 control-label">{{trans('ishaar_setup.form_attributes.work_region')}}</label>
                                                <div class="col-md-4">
                                                    <span class="form-control-static">{{@$contract->contract->contractLocations[0]->region->name}}</span>
                                                </div>
                                            </div>


                                            <div class="form-group last">
                                                <label class="col-md-3 control-label">{{trans('ishaar_setup.form_attributes.work_areas')}}</label>
                                                <div class="col-md-4">
                                                    <span class="form-control-static">@foreach($contract->contract->contractLocations as $cc){{$cc->desc_location}} @endforeach </span>
                                                </div>
                                            </div>


                                        <!-- BEGIN User Details -->
                                    <div class="portlet box yellow">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="fa fa-comments"></i>{{trans('ishaar_setup.headings.user_details')}} </div>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="table-scrollable">
                                                <table class="table table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>{{trans('ishaar_setup.form_attributes.id_number')}} </th>
                                                            <th> {{trans('ishaar_setup.form_attributes.name')}} </th>
                                                            <th> {{trans('ishaar_setup.form_attributes.nationality')}} </th>
                                                            <th> {{trans('ishaar_setup.form_attributes.job')}} </th>
                                                            <th> {{trans('ishaar_setup.form_attributes.gender')}} </th>
                                                            <th> {{trans('ishaar_setup.form_attributes.age')}} </th>
                                                            <th> {{trans('ishaar_setup.form_attributes.religion')}} </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        
                                                        <tr>
                                                            <td class="active"> {{$contract->hrPool->id_number or ''}} </td>
                                                            <td class="success"> {{$contract->hrPool->name or ''}} </td>
                                                            <td class="warning"> {{$contract->hrPool->nationality->name or ''}} </td>
                                                            <td class="danger"> {{$contract->hrPool->job->job_name or ''}} </td>
                                                            <td class="active"> @if($contract->hrPool){{Tamkeen\Ajeer\Utilities\Constants::gender($contract->hrPool->gender)}} @endif</td>
                                                            <td class="success"> {{$contract->hrPool->age or ''}} </td>
                                                            <td class="warning"> @if($contract->hrPool){{ Tamkeen\Ajeer\Utilities\Constants::religions($contract->hrPool->religion)}}@endif </td>
                                                        </tr>
                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END User Details -->
                                    
                                        </div>
                                        <div class="form-actions">
                                            <div class="row">
                                                    <div class="col-md-offset-3 col-md-9">
                                                    <button type="button" class="btn btn-danger" id='refuse_cancel' data-toggle="modal" href="#refuse" data-type="contract">{{ trans('ishaar_setup.actions.ask_cancel') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- END FORM-->
                                </div>
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
<!-- END CONTENT BODY -->
<div class="modal fade" id="refuse" tabindex="-1" aria-hidden="true">
   <div class="modal-dialog">
      {{ Form::open(['url' => url(Request::segment(1)).'/ask_cancel', "files"=>"false",'id'=>'form','data-url' => url(Request::segment(1))]) }}
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h4 class="modal-title">{{ trans('contracts_cancelation.refuse') }}</h4>
         </div>
         <div class="modal-body form-body">
            <input type="hidden" id='modal-type-r' name='type_r' value='contract'>
            <input type="hidden" id='modal-id-r' name='id_r' value='{{ $contract->id }}'>
            <div class="form-group form-md-line-input has-info">
               <select class="form-control" id="select_reason" name='reason'>
                     <option value=""></option>
                     @if(!empty($reasons))
                     @foreach($reasons as $reason)
                        <option value="{{ $reason->id }}">{{ $reason->reason}}</option>
                     @endforeach
                     @endif
               </select>
               <label for="form_control_1">{{ trans('contracts_cancelation.refusereason') }}</label>
            </div>
            <div class="form-group form-md-line-input" style="display:none;" id='other_reason'>
               <input type="text" class="form-control" id="other" name='other'>
               <label for="form_control_1">{{ trans('contracts_cancelation.other') }}</label>
               <span class="help-block">{{ trans('contracts_cancelation.other') }}</span>
            </div>
            <div class="form-group form-md-line-input">
                <textarea class="form-control" rows="5"  name="details"></textarea>
                    <div class="form-control-focus"></div>
                    <span class="help-block">{{ trans('vacancies.list_attributes.details') }}
                        ...</span>
                <label for="details">{{trans('vacancies.list_attributes.details')}}</label>
            </div>
            <div class="form-group form-md-line-input">
                <input type="checkbox" name="report_check" value="1"/>
                {!! trans('ishaar_setup.max_ishaar_period_exceeded',['contract_type'=>$contract->contract_id ,'ishaar_num'=>$contract->id,'generate_date'=>$contract->created_date_formatted,'emp_name'=>$contract->hrPool->name,'id_number'=>$contract->hrPool->id_number,'nationality'=>$contract->hrPool->nationality->name,'period_days'=>getDatesDiff($contract->start_date,$contract->end_date),'ishar_start_date'=>$contract->end_date]) !!}

            </div>
         </div>
         <div class="modal-footer">
            <button type="submit" data-loading-text="{{ trans('labels.loading') }}" class="btn green">{{ trans('contracts_cancelation.confirm') }}</button>
            <button type="button" class="btn btn-danger btn-outline" data-dismiss="modal">{{ trans('labels.cancel') }}</button>

         </div>
      </div>
      <!-- /.modal-content -->
      {{ Form::close() }}
   </div>
   <!-- /.modal-dialog -->
</div>
@endsection