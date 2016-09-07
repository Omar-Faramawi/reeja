<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">{{ trans('taqawoul.headings.Add') }}</h4>
</div>
@if(isset($service))
    {{ Form::model($service, ['route' => ['taqawel.publishservice.update', $service->id], 'method' => 'patch', 'id'=>'formTest']) }}
@else
    {{ Form::open(['route' => 'taqawel.publishservice.store', 'id'=>'formTest']) }}
@endif
<div class="modal-body">
    <div class="form-body row">

        {{-- start of taqawoul form --}}
        <div class="col-md-12">
            <div class="form-group form-md-line-input">
                <label class="control-label text-right col-md-3">
                    {{trans('taqawoul.form_attributes.service_type')}}
                    <span class="required"> * </span>
                </label>
                <div class="col-md-8">
                    {{Form::select("contract_nature_id",$service_types,null,["class"=>"form-control edited",'required'=>'required'])}}
                </div>
            </div>
            <div class="form-group form-md-line-input">
                <label for="description"
                       class="control-label text-right col-md-3">{{trans('taqawoul.form_attributes.service_description')}}</label>
                <div class="col-sm-8">
                    {{ Form::textarea('description', null, ['class' => 'form-control','id'=>'description']) }}
                    <div class="form-control-focus"></div>
                                                <span class="help-block">{{ trans('taqawoul.form_attributes.service_description') }}
                                                    ...</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal-footer">
    <button type="submit" class="btn green" name="status" value="1"
            data-loading-text="{{ trans('labels.loading') }}..."
            id="save_and_publish">{{trans('taqawoul.buttons.save_and_publish')}}</button>

    <button type="button" class="btn default"
            name="cancel" data-dismiss="modal">{{trans('taqawoul.buttons.cancel')}}</button>

</div>
{{Form::close()}}
