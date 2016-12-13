@extends ('admin.layout')
@section('title', trans('occupation_managment.headings.list'))
@section('content')
    <div class="m-heading-1 border-green m-bordered">
        <h3> {{ trans('occupation_managment.headings.list') }} </h3>
        <p> {{ trans('occupation_managment.sub-headings.list') }} </p>
        <div class="row">
            <div class="form-body">
                {{ Form::model($data, ['route' => ['admin.settings.occupation_management.search'], 'method' => 'get', 'id'=>'search_form','class'=>'form-horizontal']) }}
                <div class="col-md-1 pull-right">
                    <div class="btn-group pull-right">
                        <a href="{{route('admin.settings.occupation_management.index')}}"
                           data-loading-text="{{ trans('labels.loading') }}..."
                           class="demo-loading-btn btn blue">
                            <i class="fa fa-check"></i> {{ trans('labels.cancel') }}
                        </a>
                    </div>
                </div>
                <div class="col-md-1 pull-right">
                    <div class="btn-group pull-right">
                        <button type="submit" data-loading-text="{{ trans('labels.loading') }}..."
                                class="demo-loading-btn btn blue">
                            <i class="fa fa-check"></i> {{ trans('labels.search') }}
                        </button>
                    </div>
                </div>
                <div class="col-md-2 pull-right">
                    <div class="form-group">
                        {{ Form::text('q', request('q'), ['id'=>'q', 'class'=>'form-control']) }}
                    </div>
                </div>
            </div>
            {{Form::close()}}
        </div>
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
    {{ Form::model($data, ['route' => ['admin.settings.occupation_management.updateforsearch'], 'method' => 'patch', 'id'=>'live_form']) }}
    {{ Form::hidden('page', $data->currentPage()) }}
    <div class="row">
        <div class="col-md-12">
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings"></i>
                        <span class="caption-subject bold uppercase"> {{ trans('occupation_managment.headings.list') }}</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6 pull-right">
                                <div class="btn-group pull-right">
                                    <button type="submit" data-loading-text="{{ trans('labels.loading') }}..."
                                            class="demo-loading-btn btn blue">
                                        <i class="fa fa-check"></i> {{ trans('labels.save') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-scrollable">
                        <table class="table table-striped table-bordered table-hover order-column">
                            <thead>
                            <tr class="odd gradeX">
                                <th>{{ trans('occupation_managment.attributes.job_name') }}</th>
                                <th>{{ trans('occupation_managment.attributes.attachment_mandatory') }}</th>
                                <th>{{ trans('occupation_managment.attributes.attachment_id') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $single)
                                <tr class="odd gradeX {{ $single->hashids }}">
                                    <td> {{ $single->job_name }} </td>
                                    <td>
                                        {{Form::hidden('job_id[]',$single->hashids)}}
                                        <input type="checkbox" name="attachment_mandatory[{{ $single->hashids }}]"
                                               value="1"
                                               {{ ($single->attachment_mandatory) ? "checked" : "" }} class="make-switch switch-large"
                                               data-on-color="success" data-off-color="warning"
                                               id="attachment_mandatory"
                                               data-label-icon="fa fa-fullscreen"
                                               data-on-text="<i class='fa fa-check'></i>"
                                               data-off-text="<i class='fa fa-times'></i>"/>
                                    </td>
                                    <td>
                                        {{ Form::select('attachment_id['.$single->hashids.'][]', isset($attachments) ? $attachments : array(), $single->attachments->lists('id')->toArray(), ['id'=>'attachment_id', 'class'=>'form-control bs-select', "data-size"=>"8", "data-width" => "300", "data-live-search" => "true", "data-actions-box" => "true", 'multiple']) }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            </tfoot>
                        </table>
                    </div>
                    <div class="row text-right">
                        <div class="col-md-12">{{ $data->appends(['q' => request('q')])->render() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ Form::close() }}
@endsection
