@if(!isset($hideTaqyeemType))
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title"><i class="fa fa-edit"></i> {{ trans('ratingmodels.widgetName') }}</h4>
</div>

{!! Form::model($ratingModel->taqyeemTemplatePermission,['route' => 'nextToTaqyeemPost', 'id' => 'taqyeem_permissions_form', 'data-back-url' => url('/admin/ratingmodels')]) !!}

<div class="modal-body">
    <div class="form-body">
        <div class="row">

            <div class="form-group form-md-line-input">
                <label class="col-md-3 control-label" for="link_period">{{ trans('contractmembertaqyeem.link_period') }}
                    <span class="required">*</span>
                </label>
                <div class="col-md-3">
                    {{ Form::selectRange('link_period', 1,60,null , ['id'=>'link_period', 'class'=>'form-control','placeholder' => trans('contractmembertaqyeem.link_period') ]) }}
                    <div class="form-control-focus"></div>
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
                    <div class="form-control-focus"></div>
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
                            {{Form::radio('taqyeem_type',1,null,[ 'data-url'=>route('view.taqyeem.individuals', ['id' => $ratingModel->id]),'id'=>"checkbox1_8",'class'=>"md-radiobtn"])}}
                            <label for="checkbox1_8">
                                <span></span>
                                <span class="check"></span>
                                <span class="box"></span> {{ trans('contractmembertaqyeem.member_taqyeem')}} </label>
                        </div>
                        <div class="md-radio">
                            {{Form::radio('taqyeem_type',2,null,[ 'data-url'=>route('view.taqyeem.ajeer', ['id' => $ratingModel->id]),'id'=>"checkbox1_9",'class'=>"md-radiobtn"])}}

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
@endif
        <div class="partial-div">
            <div class="page-loader" style="display: none;"></div>
            <div class="partial-page-content">
                <div class="row">
                    <div class="form-group form-md-checkboxes  margin-top-10">
                        <label class="col-md-3 control-label"
                               for="form_control_1">{{ trans('contractmembertaqyeem.portal_services')}}</label>
                        <div class="col-md-9">
                            <div class="md-checkbox-inline">
                                <div class="md-checkbox">
                                    <input type="checkbox" id="taqawel_services" name="portal_services[]"
                                           value="taqawel_services"
                                           class="md-md-check"
                                            {{(in_array(Constants::CONTRACTTYPES['taqawel'],$contractsId)) ? 'checked' : ''}}>
                                    <label for="taqawel_services">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span> {{ trans('contractmembertaqyeem.taqawel_services')}}
                                    </label>
                                </div>
                                <div class="md-checkbox">
                                    <input type="checkbox" id="hire_labore" name="portal_services[]" class="md-md-check"
                                           value="hire_labore"
                                            {{(in_array(Constants::CONTRACTTYPES['hire_labor'],$contractsId)) ? 'checked' : ''}}>

                                    <label for="hire_labore">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span> {{ trans('contractmembertaqyeem.hire_labore')}}
                                    </label>
                                </div>
                                <div class="md-checkbox">
                                    <input type="checkbox" id="direct_emp" name="portal_services[]" class="md-md-check"
                                           value="direct_emp"
                                            {{(in_array(Constants::CONTRACTTYPES['direct_emp'],$contractsId)) ? 'checked' : ''}}>

                                    <label for="direct_emp">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span> {{ trans('contractmembertaqyeem.direct_emp')}}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                </div>
                <div class="row"
                     id="taqawel_services_div"
                     @if (!in_array(Constants::CONTRACTTYPES['taqawel'],$contractsId))
                     style="display:none;"
                        @endif>
                    <div class="col-md-12   margin-top-10">
                        {{ trans('contractmembertaqyeem.taqawel_services')}}
                        <div class="clearfix"></div>

                        <div class="table-responsive   margin-top-10">
                            <table class="table table-striped table-bordered table-hover ">
                                <thead>
                                <tr>
                                    <th width="5%"> #</th>
                                    <th> {{ trans('contractmembertaqyeem.taqawel_owner')}}</th>
                                    <th> {{ trans('contractmembertaqyeem.taqawel_rater')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <div class="md-checkbox">
                                            <input type="checkbox" id="taqawel_services_1" name="taqawel_services[]"
                                                   value="{{Constants::SERVICETYPES['benf']}}"
                                                   class="md-md-check"
                                            @if (in_array(Constants::CONTRACTTYPES['taqawel'],$contractsId))

                                                {{($permissions[array_search(Constants::CONTRACTTYPES['taqawel'],
             array_column($permissions, 'contract_type_id'))]['benf'] == 1) ? 'checked' : ''}}
                                                    @endif
                                            >
                                            <label for="taqawel_services_1">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td> {{ trans('contractmembertaqyeem.beneficial')}} </td>
                                    <td> {{ trans('contractmembertaqyeem.provider')}}</td>

                                </tr>
                                <tr>
                                    <td>
                                        <div class="md-checkbox">
                                            <input type="checkbox" id="taqawel_services_2" name="taqawel_services[]"
                                                   value="{{Constants::SERVICETYPES['provider']}}"
                                                   class="md-md-check"
                                            @if (in_array(Constants::CONTRACTTYPES['taqawel'],$contractsId))
                                                {{($permissions[array_search(Constants::CONTRACTTYPES['taqawel'],
                    array_column($permissions, 'contract_type_id'))]['provider'] == 1) ? 'checked' : ''}}
                                                    @endif>
                                            <label for="taqawel_services_2">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td> {{ trans('contractmembertaqyeem.provider')}} </td>
                                    <td> {{ trans('contractmembertaqyeem.beneficial')}} </td>

                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row"
                     id="hire_labore_div"
                     @if (!in_array(Constants::CONTRACTTYPES['hire_labor'],$contractsId))
                     style="display:none;" @endif>
                    <div class="col-md-12   margin-top-10">

                        {{ trans('contractmembertaqyeem.hire_labore')}}
                        <div class="clearfix"></div>

                        <div class="table-responsive  margin-top-10">
                            <table class="table table-striped table-bordered table-hover ">
                                <thead>
                                <tr>
                                    <th width="5%"> #</th>
                                    <th> {{ trans('contractmembertaqyeem.taqawel_owner')}}</th>
                                    <th> {{ trans('contractmembertaqyeem.taqawel_rater')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <div class="md-checkbox">
                                            <input type="checkbox" id="hire_labore_1" name="hire_labore[]"
                                                   value="{{Constants::SERVICETYPES['benf']}}"
                                                   class="md-md-check"
                                            @if (in_array(Constants::CONTRACTTYPES['hire_labor'],$contractsId))
                                                {{($permissions[array_search(Constants::CONTRACTTYPES['hire_labor'],
                            array_column($permissions, 'contract_type_id'))]['benf'] == 1) ? 'checked' : ''}}
                                                    @endif
                                            >
                                            <label for="hire_labore_1">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td> {{ trans('contractmembertaqyeem.beneficial')}} </td>
                                    <td> {{ trans('contractmembertaqyeem.provider')}}</td>

                                </tr>
                                <tr>
                                    <td>
                                        <div class="md-checkbox">
                                            <input type="checkbox" id="hire_labore_2" name="hire_labore[]"
                                                   value="{{Constants::SERVICETYPES['provider']}}"

                                                   class="md-md-check"
                                            @if (in_array(Constants::CONTRACTTYPES['hire_labor'],$contractsId))
                                                {{($permissions[array_search(Constants::CONTRACTTYPES['hire_labor'],
                                    array_column($permissions, 'contract_type_id'))]['provider'] == 1) ? 'checked' : ''}}
                                                    @endif
                                            >
                                            <label for="hire_labore_2">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td> {{ trans('contractmembertaqyeem.provider')}} </td>
                                    <td> {{ trans('contractmembertaqyeem.beneficial')}} </td>

                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row" id="direct_emp_div"
                     @if (!in_array(Constants::CONTRACTTYPES['direct_emp'],$contractsId))
                     style="display:none;" @endif>
                    <div class="col-md-12  margin-top-10">
                        {{ trans('contractmembertaqyeem.direct_emp')}}
                        <div class="clearfix"></div>

                        <div class="table-responsive  margin-top-10">
                            <table class="table table-striped table-bordered table-hover ">
                                <thead>
                                <tr>
                                    <th width="5%"> #</th>
                                    <th> {{ trans('contractmembertaqyeem.taqawel_owner')}}</th>
                                    <th> {{ trans('contractmembertaqyeem.taqawel_rater')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <div class="md-checkbox">
                                            <input type="checkbox" id="direct_emp_1" name="direct_emp[]"
                                                   value="{{Constants::SERVICETYPES['benf']}}"

                                                   class="md-md-check"
                                            @if (in_array(Constants::CONTRACTTYPES['direct_emp'],$contractsId))
                                                {{($permissions[array_search(Constants::CONTRACTTYPES['direct_emp'],
                                    array_column($permissions, 'contract_type_id'))]['benf'] == 1) ? 'checked' : ''}}
                                                    @endif
                                            >
                                            <label for="direct_emp_1">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td> {{ trans('contractmembertaqyeem.job_owner')}} </td>
                                    <td> {{ trans('contractmembertaqyeem.job_seeker')}}</td>

                                </tr>
                                <tr>
                                    <td>
                                        <div class="md-checkbox">
                                            <input type="checkbox" id="direct_emp_2" name="direct_emp[]"
                                                   value="{{Constants::SERVICETYPES['provider']}}"
                                                   class="md-md-check"
                                            @if (in_array(Constants::CONTRACTTYPES['direct_emp'],$contractsId))
                                                {{($permissions[array_search(Constants::CONTRACTTYPES['direct_emp'],
                                    array_column($permissions, 'contract_type_id'))]['provider'] == 1) ? 'checked' : ''}}
                                                    @endif
                                            >
                                            <label for="direct_emp_2">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td> {{ trans('contractmembertaqyeem.job_seeker')}} </td>
                                    <td> {{ trans('contractmembertaqyeem.job_owner')}} </td>

                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="resident-div">
            <div class="page-loader" style="display: none;"></div>
            <div class="partial-resident-div">
            </div>
        </div>
@if(!isset($hideTaqyeemType))
    </div>
</div>

<div class="modal-footer">
    <button id="taqyeem_permissions_submit" type="submit" data-loading-text="{{ trans('labels.loading') }}..." class="demo-loading-btn btn blue">
        <i class="fa fa-check"></i> {{ trans('labels.save') }} </button>
    <button type="button" data-dismiss="modal" class="btn default">{{ trans('labels.cancel') }}</button>
</div>

{!! form::close() !!}
@endif