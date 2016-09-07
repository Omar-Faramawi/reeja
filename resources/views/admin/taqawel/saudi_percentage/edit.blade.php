<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title"><i class="fa fa-edit"></i> {{ trans('saudi_percentage.headings.list') }}</h4>
</div>
@if(isset($data))
    {{ Form::model($data, ['route' => ['admin.saudi_percentage.update', $data->hashids], 'method' => 'patch', 'id'=>'form']) }}
@else
    {{ Form::open(['route' => 'admin.saudi_percentage.store', "files"=>"true", 'id'=>'form']) }}
@endif
<div class="modal-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="form-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group form-md-line-input form-md-floating-label">
                            <label {{ isset($data) ? 'style=top:0;' : "" }} for="provider_activity_id">{{ trans('saudi_percentage.attributes.provider_activity') }}
                            </label>
                            {{ Form::select("provider_activity_id", $activities, null, ["class" => "form-control", "required" => "","placeholder" => trans('labels.default')]) }}
                            <span class="help-block">{{ trans('saudi_percentage.attributes.provider_activity') }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group form-md-line-input form-md-floating-label">
                            <label {{ isset($data) ? 'style=top:0;' : "" }} for="benf_activity_id">{{ trans('saudi_percentage.attributes.benf_activity') }}
                            </label>
                            {{ Form::select("benf_activity_id", $activities, null, ["class" => "form-control", "required" => "","placeholder" => trans('labels.default')]) }}
                            <span class="help-block">{{ trans('saudi_percentage.attributes.benf_activity') }}</span>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group form-md-line-input form-md-floating-label">
                            <label {{ isset($data) ? 'style=top:0;' : "" }} for="provider_size_id">{{ trans('saudi_percentage.attributes.provider_size') }}
                            </label>
                            {{ Form::select("provider_size_id", $sizes, null, ["class" => "form-control", "required" => "","placeholder" => trans('labels.default')]) }}
                            <span class="help-block">{{ trans('saudi_percentage.attributes.provider_size') }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group form-md-line-input form-md-floating-label">
                            <label {{ isset($data) ? 'style=top:0;' : "" }} for="benf_size_id">{{ trans('saudi_percentage.attributes.benf_size') }}
                            </label>
                            {{ Form::select("benf_size_id", $sizes, null, ["class" => "form-control", "required" => "","placeholder" => trans('labels.default')]) }}
                            <span class="help-block">{{ trans('saudi_percentage.attributes.benf_size') }}</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group form-md-line-input form-md-floating-label">
                            <label {{ isset($data) ? 'style=top:0;' : "" }} for="saudi_pct">{{ trans('saudi_percentage.attributes.percentage_value') }}
                                <span class="required">*</span></label>
                            {{ Form::number("saudi_pct", null, ["id" => "saudi_pct", "class" => "form-control", "required" => "" ]) }}
                            <span class="help-block">{{ trans('saudi_percentage.attributes.percentage_value') }}</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="submit" data-loading-text="{{ trans('labels.loading') }}..."
            class="demo-loading-btn btn blue"><i class="fa fa-check"></i> {{ trans('labels.save') }} </button>
    <button type="button" data-dismiss="modal" class="btn default">{{ trans('labels.cancel') }}</button>
</div>
{{ Form::close() }}