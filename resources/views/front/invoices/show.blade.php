@extends('front.layout')
@section('title', trans('invoices.headings.tab_head'))
@section("content")
    <div class="page-content">
        <div class="container">
            <!-- BEGIN PAGE CONTENT INNER -->
            <div class="page-content-inner">
                <div class="row">
                    <div class="col-md-12">
                        <div class="portlet light portlet-fit portlet-datatable">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-info-circle"></i>{{trans("invoices.headings.one_head")}} {{$invoice->id}}
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="portlet grey-cascade box">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-info-circle"></i>{{trans("invoices.headings.basic_information")}}
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="row static-info">
                                            <div class="col-md-5 name">
                                                {{ trans('invoices.list_attributes.number') }}
                                            </div>
                                            <div class="col-md-7 value">
                                                {{$invoice->bill_number}}
                                            </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name">
                                                {{ trans('invoices.list_attributes.amount') }}
                                            </div>
                                            <div class="col-md-7 value">
                                                {{$invoice->amount}}
                                               {{trans("packagesubscribe.reyal")}}
                                            </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name">
                                                {{ trans('invoices.list_attributes.description') }}
                                            </div>
                                            <div class="col-md-7 value">
                                                {{$invoice->description}}
                                            </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name">
                                                {{ trans('invoices.list_attributes.issue_date') }}
                                            </div>
                                            <div class="col-md-7 value">
                                                {{$invoice->issue_date_formatted}}
                                            </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name">
                                                {{ trans('invoices.list_attributes.expiry_date') }}
                                            </div>
                                            <div class="col-md-7 value">
                                                {{$invoice->expiry_date_formatted}}
                                            </div>
                                        </div>
                                        @if($invoice->status == \Tamkeen\Ajeer\Utilities\Constants::INVOICE_STATUS['paid'])
                                        <div class="row static-info">
                                            <div class="col-md-5 name">
                                                {{ trans('invoices.list_attributes.paid_date') }}
                                            </div>
                                            <div class="col-md-7 value">
                                                {{$invoice->paid_date}}
                                            </div>
                                        </div>
                                        @endif
                                        <div class="row static-info">
                                            <div class="col-md-5 name">
                                                {{ trans('invoices.list_attributes.status') }}
                                            </div>
                                            <div class="col-md-7 value">
                                                {{$invoice->status_name}}
                                            </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name">
                                                {{ trans('invoices.list_attributes.invoice_type') }}
                                            </div>
                                            <div class="col-md-7 value">
                                                {{$invoice->trans_invoice_type}}
                                            </div>
                                        </div>
                                        
                                       
                                    </div>
                                </div>
                               
                            </div>
                            @if($invoice->invoice_type != \Tamkeen\Ajeer\Utilities\Constants::INVOICE_TYPES['bundle'])
                            <div class="portlet-body">
                                <div class="portlet grey-cascade box">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-info-circle"></i>{{trans("invoices.headings.contract_information")}}
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                    
                                    <div class="row static-info">
                                            <div class="col-md-5 name">
                                                {{ trans('invoices.list_attributes.account_num') }}
                                            </div>
                                            <div class="col-md-7 value">
                                                @if($invoice->invoice_type == \Tamkeen\Ajeer\Utilities\Constants::INVOICE_TYPES['certificate'])
                                                @foreach($invoice->certificates as $cer)
                                                @if($cer->contract->contract_type_id) == \Tamkeen\Ajeer\Utilities\Constants::CONTRACTTYPES['taqawel'])
                                                <a href="{{url('taqawel/offer-taqawel-contract/'.$cer->contract->id.'/details')}}">{{$cer->contract->id}}</a><br/>
                                                @else
                                                <a href="{{url('contractdetails/'.$cer->contract->id)}}">{{$cer->contract->id}}</a><br/>
                                                @endif
                                                @endforeach
                                                @else
                                                @if($invoice->contract)
                                                @if($invoice->contract->contract_type_id == \Tamkeen\Ajeer\Utilities\Constants::CONTRACTTYPES['taqawel'])
                                                <a href="{{url('taqawel/offer-taqawel-contract/'.$invoice->contract->id.'/details')}}">{{$invoice->contract->id}}</a><br/>
                                                @else
                                                <a href="{{url('contractdetails/'.$invoice->contract->id)}}">{{$invoice->contract->id}}</a><br/>
                                                @endif
                                                @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection