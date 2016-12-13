@extends ('admin.layout')
@section('title', trans('professions.headings.list'))
@section('content')
    <div class="m-heading-1 border-green m-bordered">
        <h3> {{ trans('professions.headings.list') }} </h3>
        <p> {{ trans('professions.sub-headings.list') }}
        </p>
        <div class="row">
            <div class="form-body">
                {{ Form::model($data, ['route' => ['admin.settings.professions.search'], 'method' => 'get', 'id'=>'search_form','class'=>'form-horizontal']) }}
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
                        {{ Form::text('q', null, ['id'=>'q', 'class'=>'form-control']) }}
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
    {{ Form::model($data, ['route' => ['admin.settings.professions.update'], 'method' => 'patch', 'id'=>'live_form']) }}
    {{ Form::hidden('page', $data->currentPage()) }}
    <div class="row">
        <div class="col-md-12">
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings"></i>
                        <span class="caption-subject bold uppercase"> {{ trans('professions.headings.list') }}</span>
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
                    <div>
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr class="odd gradeX">
                                <th>{{ trans('professions.attributes.job_name') }}</th>
                                <th width="50%">{{ trans('professions.attributes.nationalities') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $single)
                                <tr class="odd gradeX {{ $single->hashids }}">
                                    <td> {{ $single->job_name }} </td>
                                    <td>
                                        {{ Form::select('nations['.$single->hashids.'][]', $nationalities, $single->nationality_list, ['placeholder' => trans('professions.attributes.select_nationalities'), 'class'=>'form-control bs-select', "data-size"=>"8", "data-width" => "300", "data-live-search" => "true", "data-actions-box" => "true", "data-selected-text-format" => "count", 'multiple']) }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row text-right">
                        <div class="col-md-12">{{ $data->render() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ Form::close() }}
@endsection
