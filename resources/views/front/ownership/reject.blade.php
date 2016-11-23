{{ Form::open(['url' => url('/offersdirect/ownership/reject/' . $id . "/" . $hashedid), 'data-url'=>url(''), 'id'=>'form',"method"=>"PUT","role"=>"form"]) }}

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">{{trans("ownership.modal.reject.rejectTitle")}}</h4>
</div>

<div class="modal-body">

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-info-circle"></i>{{trans("ownership.modal.reject.requestApprove")}}
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="form-body">
                        @if (count($errors))
                            <div class="alert alert-danger">
                                <button class="close" data-close="alert"></button>
                                @foreach($errors->all() as $error)
                                    <span>{{$error}}</span><br/>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="form-actions">
                        <button type="submit" data-loading-text="{{ trans('labels.loading') }}..."
                                class="btn green uppercase">{{trans("offers.modal.accept.approve")}}</button>
                        <button type="button" class="btn default"
                                data-dismiss="modal">{{trans("offers.modal.accept.cancel")}}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



{{Form::close()}}
@if(app()->getLocale() == "ar")
    <script src="{{ asset('assets/js/front-rtl.js') }}"></script>
@else
    <script src="{{ asset('assets/js/front.js') }}"></script>
@endif
