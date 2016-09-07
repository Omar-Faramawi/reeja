<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">{{trans("packagesubscribe.buyDone")}}</h4>
</div>
<div class="modal-body">

    <div class="row">
        <div class="col-md-12">
            <h2>{{trans("packagesubscribe.buyDone")}}</h2>
            <p>
                {{trans("packagesubscribe.buyAlert")}}
            </p>
            <p>
                {{trans("packagesubscribe.invoiceDetails",["ishaarNu"=>$invoice->num_of_notices,"billingAmount"=>$invoice->invoice->amount,"account_no"=>$invoice->invoice->bill_number])}}
            </p>
        </div>
    </div>

</div>
<div class="modal-footer">
    <div class="form-actions">
        <a href="{{url("/")}}" class="btn default"
        >{{trans("packagesubscribe.close")}}</a>
    </div>
</div>