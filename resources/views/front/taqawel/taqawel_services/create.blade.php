<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">
        @if(isset($service))
            {{ trans('taqawoul.headings.update') }}
        @else
            {{ trans('taqawoul.headings.Add') }}
        @endif
    </h4>
</div>
 @if(isset($service))
    {{ Form::model($service,['route' => ['taqawel.taqawelService.update', $service->id],'method'=>'PUT','id'=>'formTest', 'data-url' => url('/taqawel/taqawelService')]) }}
@else
    {{ Form::open(['route' => 'taqawel.taqawelService.store','id'=>'formTest', 'data-url' => url('/taqawel/taqawelService')]) }}
@endif
<div class="modal-body">
    <div class="form-body row">

        {{-- start of taqawoul form --}}
        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label col-md-4">
                    {{trans('taqawoul.form_attributes.service_type')}}
                    <span class="required"> * </span>
                </label>
                <div class="col-md-8">
                    {{Form::select("contract_nature_id",$service_types,$cached_data['contract_nature_id'],["class"=>"form-control edited",'required'=>'required', 'id'=>'taqawel_service_type', 'placeholder' => trans('labels.default')])}}
                    <br/>
                    <div id="new_service">
                        @if ($cached_data['contract_nature_id'] == 'other')
                            <input id="myInput" class="form-control" name="new_service" type="text" value="{{ $cached_data['new_service'] }}">
                        @endif
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <hr>
            <div class="clearfix"></div>
            <div class="form-group">
                <label for="description"
                       class="control-label col-md-4">
                    {{trans('taqawoul.form_attributes.service_description')}}
                    <span class="required"> * </span>
                </label>
                <div class="col-md-8">
                    <textarea class="form-control" rows="5" id="description" name="description">{{ $cached_data['description'] }}</textarea>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="submit" class="btn btn-primary publish_or_draft" name="status" value="1"
            data-loading-text="{{ trans('labels.loading') }}..."
            id="save_and_publish">{{trans('taqawoul.buttons.save_and_publish')}}</button>
    <input type="hidden" name="save_action" id="save_action" value="publish">
    @if (! isset($service))
    <button type="submit" class="btn btn-primary publish_or_draft" name="status" value="0"
            data-loading-text="{{ trans('labels.loading') }}..."
            id="save_draft">{{trans('taqawoul.buttons.save_draft')}}</button>
    @endif

    <a href="{{route('taqawel.taqawelService.index')}}" class="btn default"
       name="cancel">
        {{trans('taqawoul.buttons.cancel')}}
    </a>
</div>
{{form::close()}}
