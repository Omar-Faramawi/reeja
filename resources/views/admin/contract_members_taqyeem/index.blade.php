@if(!isset($hideTaqyeemType))
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title"><i class="fa fa-edit"></i> {{ trans('ratingmodels.widgetName') }}</h4>
</div>

{!! Form::open(['route' => 'nextToTaqyeemPost', 'id' => 'taqyeem_permissions_form', 'data-back-url' => url('/admin/ratingmodels')]) !!}

<div class="modal-body">
    <div class="form-body">
        <div class="row">

            <div class="form-group form-md-line-input">
                <label class="col-md-3 control-label" for="link_period">{{ trans('contractmembertaqyeem.link_period') }}
                    <span class="required">*</span>
                </label>
                <div class="col-md-3">
                    {{ Form::selectRange('link_period', 1,60,null , ['id'=>'link_period', 'class'=>'form-control', 'placeholder' => trans('contractmembertaqyeem.link_period') ]) }}
                </div>
                <div class="col-md-6">
                    {{ trans('contractmembertaqyeem.periodType') }}
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="form-group form-md-line-input  margin-top-10">
                <label class="col-md-3 control-label"
                       for="model">{{ trans('contractmembertaqyeem.taqyeem_template_name') }}
                    <span class="required">*</span>
                </label>
                <div class="col-md-3">
                    {{ Form::text('taqyeem_template_name', $ratingModel->name , ['id'=>'model', 'class'=>'form-control', 'readonly']) }}
                    {{ Form::hidden('taqyeem_template_id', $ratingModel->id , ['id'=>'model', 'class'=>'form-control', 'readonly']) }}
                    <span class="help-block">{{ trans('contractmembertaqyeem.taqyeem_template_name') }}...</span>
                </div>

            </div>

        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="form-group form-md-radios margin-top-10">
                <label class="col-md-3 control-label"
                       for="form_control_1">{{ trans('contractmembertaqyeem.taqyeem_type')}}</label>
                <div class="col-md-9">
                    <div class="md-radio-inline">
                        <div class="md-radio">
                            <input type="radio"
                                   data-url="{{ route('view.taqyeem.individuals', ['id' => $ratingModel->id]) }}"
                                   id="checkbox1_8" value="1" name="taqyeem_type" class="md-radiobtn" checked="">
                            <label for="checkbox1_8">
                                <span></span>
                                <span class="check"></span>
                                <span class="box"></span> {{ trans('contractmembertaqyeem.member_taqyeem')}} </label>
                        </div>
                        <div class="md-radio">
                            <input type="radio" data-url="{{ route('view.taqyeem.ajeer', ['id' => $ratingModel->id]) }}"
                                   id="checkbox1_9" name="taqyeem_type" value="2" class="md-radiobtn">
                            <label for="checkbox1_9">
                                <span></span>
                                <span class="check"></span>
                                <span class="box"></span> {{ trans('contractmembertaqyeem.portal_taqyeem')}} </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="partial-div">
            <div class="page-loader" style="display: none;"></div>
            <div class="partial-page-content">
@endif
                @if(!isset($taqyeemType) || @$taqyeemType == '1')
                    @include('admin.contract_members_taqyeem.view_taqyeem_contract_individuals')
                @endif
@if(!isset($hideTaqyeemType))
            </div>
        </div>

        <div class="resident-div">
            <div class="page-loader" style="display: none;"></div>
            <div class="partial-resident-div">
@endif
            @if(@$taqyeemType == '2')
                @include('admin.contract_members_taqyeem.view_taqyeem_contract_ajeer')
				
                <div class="row">
                    <div class="form-group form-md-radios margin-top-10">
                        <label class="col-md-3 control-label"
                            for="form_control_1">{{ trans('contractmembertaqyeem.nashr_taqyeem')}}</label>
                        <div class="col-md-9">
                            <div class="md-radio-inline">
                                <div class="md-radio">
                                    <input type="radio" id="checkbox1_18" value="1" name="periodic_or_date" class="md-radiobtn" checked>
                                    <label for="checkbox1_18">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span> {{ trans('contractmembertaqyeem.periodic')}}
                                    </label>
                                </div>
                                <div class="md-radio">
                                    <input type="radio" id="checkbox1_19" name="periodic_or_date" value="2" class="md-radiobtn">
                                    <label for="checkbox1_19">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span> {{ trans('contractmembertaqyeem.specific_date')}}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="row" id="taqyeem_period">
                    <div class="form-group form-md-line-input">
                        <label class="col-md-3 control-label"
                            for="form_control_1">{{ trans('contractmembertaqyeem.fatra_nashr_taqyeem')}}</label>
                        <div class="col-md-3">
                            {{ Form::select('periodic_period',[1 => trans('contractmembertaqyeem.1_month'), 3 => trans('contractmembertaqyeem.3_months'), 6 => trans('contractmembertaqyeem.6_months'), 12 => trans('contractmembertaqyeem.12_months')], null, ['class'=>'form-control','placeholder' => trans('labels.default') ]) }}
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="row" id="taqyeem_date_div" style="display:none">
                    <div class="form-group form-md-line-input">
                        <label class="col-md-3 control-label"
                            for="form_control_1">{{ trans('contractmembertaqyeem.tarekh_nashr_taqyeem')}}</label>
                        <div class="col-md-3">
                            {{ Form::text('taqyeem_date', null, ['class'=>'form-control date-picker','placeholder' => trans('labels.default'), 'readonly' => 'readonly' ]) }}
							<div class="form-control-focus"></div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            @endif
@if(!isset($hideTaqyeemType))
            </div>
        </div>


    </div>

<div class="modal-footer">
    <button id="taqyeem_permissions_submit" type="submit" data-loading-text="{{ trans('labels.loading') }}..." class="demo-loading-btn btn blue">
        <i class="fa fa-check"></i> {{ trans('labels.save') }} </button>
    <button type="button" data-dismiss="modal" class="btn default">{{ trans('labels.cancel') }}</button>
</div>

{!! form::close() !!}
@endif