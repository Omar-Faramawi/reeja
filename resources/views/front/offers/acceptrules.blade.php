<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">{{trans("offers.modal.accept.title")}}</h4>
</div>
<div class="modal-body">

    <div class="row">
        <div class="col-md-12">
            <h2>{{trans("offers.modal.accept.rules")}}</h2>
            <p>
                {{trans("offers.modal.accept.rulesDetails")}}
            </p>
        </div>
    </div>

</div>
<div class="modal-footer">
    <div class="form-actions">
        <button type="button" class="btn default"
                data-dismiss="modal">{{trans("offers.modal.accept.cancel")}}</button>
        <a href="{{url("offers/accept/approve/" . $id)}}"
           data-target="#ajax"
           data-toggle="modal"
           class="btn green uppercase">{{trans("offers.modal.accept.approve")}}</a>
    </div>
</div>
