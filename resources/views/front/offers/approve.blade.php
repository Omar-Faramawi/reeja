{{ Form::open(['url' => url('/offers/accept/approve/' . $id), 'data-url'=>url('/offers'), 'id'=>'form',"method"=>"PUT","role"=>"form"]) }}

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">{{trans("offers.modal.accept.title")}}</h4>
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
                <h2>{{trans("offers.modal.accept.contractTitle")}}</h2>
                <p>
                    {{trans("offers.modal.accept.contractTemplate")}}
                </p>
                <h2>{{trans("offers.modal.accept.rules")}}</h2>
                <p>
                    {{trans("offers.modal.accept.rulesDetails")}}
                </p>
                <div class="row">
                    <div class="col-lg-3">{{trans("offers.offerValideTo")}}</div>
                    <div class="col-lg-9">{{$dateEnded}}</div>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-12 col-lg-6">
                        <div class="input-group">
                            <div class="icheck-inline">
                                <label>

                                    <input type="checkbox" class="icheck"
                                           data-checkbox="icheckbox_flat-grey"
                                           name="acceptRules"
                                           value="1"> {{trans("offers.acceptRules")}}
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="modal-footer">
    <div class="form-actions">
        <button type="button" class="btn default"
                data-dismiss="modal">{{trans("offers.modal.accept.cancel")}}</button>
        <button type="submit" data-loading-text="{{ trans('labels.loading') }}..."
                class="btn green uppercase">{{trans("offers.modal.accept.approve")}}</button>
    </div>
</div>
{{Form::close()}}
@if(app()->getLocale() == "ar")
    <script src="{{ asset('assets/js/front-rtl.js') }}"></script>
@else
    <script src="{{ asset('assets/js/front.js') }}"></script>
@endif
