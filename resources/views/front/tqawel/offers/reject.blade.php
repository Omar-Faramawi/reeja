{{ Form::open(['url' => url('/taqawel/offers/reject/' . $id), 'data-url'=>url('/taqawel/offers/'), 'id'=>'form',"method"=>"PUT","role"=>"form"]) }}
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">{{trans("offers.modal.reject.title")}}</h4>
</div>
<div class="modal-body">

    <div class="row">
        <div class="col-md-12">
            <div class="form-body">
                @if (count($errors))
                    <div class="alert alert-danger">
                        <button class="close" data-close="alert"></button>
                        @foreach($errors->all() as $error)
                            <span>{{$error}}</span><br/>
                        @endforeach
                    </div>
                @endif
                <div class="form-group form-md-line-input form-md-floating-label has-info">
                    {{Form::select("reason_id",$reasons,null,["class"=>"form-control edited",'required'=>'required'])}}
                    <label for="reason_id">{{trans("offers.modal.reject.reason")}}<span
                                class="required">*</span></label>
                    <span class="help-block">{{ trans('offers.modal.reject.reasonRequired') }} ...</span>
                </div>
                <div class="form-group form-md-line-input form-md-floating-label has-info" id="other_reason" style="display:none">
                    {{Form::text("other_reason",null,["class"=>"form-control edited",'required'=>'required', 'id' => 'other'])}}
                    <label for="other_reason">{{trans("offers.modal.reject.other")}}<span
                                class="required">*</span></label>
                    <span class="help-block">{{ trans('offers.modal.reject.reasonRequired') }} ...</span>
                </div>
                <div class="form-group form-md-line-input form-md-floating-label">
                    <textarea id="extraDetails" name="extraDetails" class="form-control" rows="3"></textarea>
                    <label for="extraDetails">{{trans("offers.modal.reject.extraDetails")}}</label>
                </div>

            </div>
        </div>
    </div>

</div>
<div class="modal-footer">
    <div class="form-actions">
        <button type="button" class="btn default"
                data-dismiss="modal">{{trans("offers.modal.close")}}</button>
        <button type="submit" data-loading-text="{{ trans('labels.loading') }}..."
                class="btn green uppercase">{{trans("offers.modal.reject.send")}}</button>
    </div>
</div>
{{Form::close()}}
@if(app()->getLocale() == "ar")
    <script src="{{ asset('assets/js/front-rtl.js') }}"></script>
@else
    <script src="{{ asset('assets/js/front.js') }}"></script>
@endif
