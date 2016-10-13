@extends('front.layout')
@section('title', trans('rating.heading'))
@section('content')
<!-- BEGIN CONTENT BODY -->
<!-- BEGIN PAGE HEAD-->
<div class="page-head">
   <div class="container">
      <!-- BEGIN PAGE TITLE -->
      <div class="page-title">
         <h1>{{ trans('rating.heading') }}</h1>
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
            <a href="{{ url('/') }}">{{trans('contracts_cancelation.home')}}</a>
            <i class="fa fa-circle"></i>
         </li>
         <li>
            <span>{{ trans('rating.rating') }}</span>
         </li>
      </ul>
      <!-- END PAGE BREADCRUMBS -->
      <!-- BEGIN PAGE CONTENT INNER -->
      <div class="page-content-inner">
         <div class="row">
            <div class="col-md-12">
               <!-- Begin: life time stats -->
               <div class="portlet light portlet-fit portlet-datatable ">
                  <div class="portlet-title">
                     <div class="caption">
                        <i class="icon-settings font-dark"></i>
                        <span class="caption-subject font-dark sbold uppercase">{{ trans('rating.rating') }}</span>
                     </div>
                  </div>
                  <div class="portlet-body">
                     <div class="row">
                        <div class="col-md-12">
                           <div class="panel panel-primary">
                              <div class="panel-heading">
                                 <h3 class="panel-title">{{ $taqyeem->name }}</h3>
                              </div>
                              <div class="panel-body">
                              @if(isset($block))
                                 <div class="alert alert-danger">{{ trans('rating.block') }}</div> 
                              @elseif(isset($outdated))
                                 <div class="alert alert-danger">{{ trans('rating.outdated') }}</div> 
                              @elseif(isset($taqyeemTaken))
                                 <div class="alert alert-success">{{ trans('rating.taken') }}</div> 
                              @else
                              {{ Form::open(['route' => 'rating.post', 'data-url'=> url('rating/'.$taqyeem->id."/".$type), "files"=>"false", 'id'=>'form']) }}
                              {{ Form::hidden('taqyeemId', $taqyeem->id) }}
                              {{ Form::hidden('contractId', $contractId) }}
                                 <ul>
                                    @foreach($taqyeem->items as $item)
                                       <li>
                                          <div class="form-group">
                                             <label>{{ $item->name }}</label>
                                             <select class="form-control" name='name[]'>
                                                <option value=''>{{ trans('rating.choose') }}</option>
                                                @foreach($item->degrees as $degree)
                                                   <option value="{{$degree->id}}">{{$degree->name}}</option>
                                                @endforeach
                                             </select>
                                          </div>
                                       </li>
                                    @endforeach
                                 </ul>
                                 <button class="btn btn-block green">{{ trans('labels.save') }}</button>
                              {{ Form::close() }}
                              @endif
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- End: life time stats -->
            </div>
         </div>
      </div>
      <!-- END PAGE CONTENT INNER -->
   </div>
</div>
<!-- END PAGE CONTENT BODY -->
<!-- END CONTENT BODY -->
@endsection