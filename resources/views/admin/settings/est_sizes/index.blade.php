@extends ('admin.layout')
@section('title', trans('est_sizes.headings'))
@section('content')
<!-- BEGIN BREADCRUMBS -->
<div class="breadcrumbs">
   <h1>{{ trans('user.settings') }}</h1>
   <ol class="breadcrumb">
      <li>
         <a href="/admin">{{trans('user.home')}}</a>
      </li>
      <li class="active">{{ trans('est_sizes.headings') }}</li>
   </ol>
</div>
<!-- END BREADCRUMBS -->
<!-- BEGIN PAGE BASE CONTENT -->
<div class="m-heading-1 border-green m-bordered">
   <h3> {{ trans('est_sizes.headings') }} </h3>
   <p> {{ trans('est_sizes.sub-headings') }} </p>
</div>
<div class="row">
   <div class="col-md-12">
      <!-- BEGIN EXAMPLE TABLE PORTLET-->
      <div class="portlet box green">
         <div class="portlet-title">
            <div class="caption">
               <i class="icon-settings"></i>
               <span class="caption-subject bold uppercase"> {{ trans('est_sizes.headings') }}</span>
            </div>
         </div>
         <div class="portlet-body">
            <div class="table-toolbar">
               <div class="row">
                  <div class="col-md-6 pull-right">
                     <div class="btn-group pull-right">
                        <button data-toggle="modal" data-target="#main" data-href="{{ route('admin.settings.estsizes.create') }}"
                           class="btn sbold green"> {{ trans('labels.add') }}
                        <i class="fa fa-plus"></i>
                        </button>
                     </div>
                  </div>
               </div>
            </div>
            <div class="table-scrollable">
               <table class="table table-striped table-bordered table-hover table-checkable order-column">
                  <thead>
                     <tr class="odd gradeX">
                        <th>{{ trans('est_sizes.attributes.ar-name') }}</th>
                        <th width="20%">{{ trans('labels.options') }}</th>
                     </tr>
                  </thead>
                  <tbody>
                    @foreach($est_sizes as $est_size)
                     <tr class="odd gradeX {{ $est_size->hashids }}">
                        <td>{{ $est_size->name }}</td>
                        <td>
                           <div class="btn-group btn-group-lg btn-group-solid margin-bottom-10">
								@if($est_size->id > 5)
                              <button data-toggle="modal" data-target="#main"
                                 data-href="{{ route('admin.settings.estsizes.edit', $est_size->hashids) }}" class="btn blue"><i
                                 class="fa fa-edit"></i> {{ trans('labels.edit') }}</button>
                              <button data-popout="true" data-token="{{ csrf_token() }}"
                                 data-id="{{ $est_size->hashids }}"
                                 data-hreff="{{ route('admin.settings.estsizes.destroy', $est_size->hashids) }}"
                                 class="btn red-mint delete-ajax" data-toggle="confirmation"
                                 data-original-title="{{ trans('labels.delete_confirmation_message') }}"
                                 data-placement="top" data-btn-ok-label="{{ trans('labels.delete') }}"
                                 data-btn-cancel-label="{{ trans('labels.cancel') }}">
                              <i class="fa fa-trash-o"></i> {{ trans('labels.delete') }}</button>
								@endif
                           </div>
                        </td>
                     </tr>
                     @endforeach
                  </tbody>
                  <tfoot>
                  </tfoot>
               </table>
            </div>
            <div class="row text-right">
               <div class="col-md-12">{{ $est_sizes->render() }}</div>
            </div>
         </div>
      </div>
      <!-- END EXAMPLE TABLE PORTLET-->
   </div>
</div>
<div class="clearfix"></div>
<!-- END DASHBOARD STATS 1-->
<!-- END PAGE BASE CONTENT -->

@endsection