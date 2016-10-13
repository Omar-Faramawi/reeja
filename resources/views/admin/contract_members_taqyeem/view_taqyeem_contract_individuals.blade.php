<div class="row">
    <div class="form-group form-md-checkboxes  margin-top-10">
        <label class="col-md-3 control-label"
               for="form_control_1">{{ trans('contractmembertaqyeem.portal_services')}}</label>
        <div class="col-md-9">
            <div class="md-checkbox-inline">
                <div class="md-checkbox">
                    <input type="checkbox" id="taqawel_services" name="portal_services[]" value="taqawel_services"
                           class="md-md-check">
                    <label for="taqawel_services">
                        <span></span>
                        <span class="check"></span>
                        <span class="box"></span> {{ trans('contractmembertaqyeem.taqawel_services')}} </label>
                </div>
                <div class="md-checkbox">
                    <input type="checkbox" id="hire_labore" name="portal_services[]" class="md-md-check"
                           value="hire_labore">
                    <label for="hire_labore">
                        <span></span>
                        <span class="check"></span>
                        <span class="box"></span> {{ trans('contractmembertaqyeem.hire_labore')}} </label>
                </div>
                <div class="md-checkbox">
                    <input type="checkbox" id="direct_emp" name="portal_services[]" class="md-md-check"
                           value="direct_emp">
                    <label for="direct_emp">
                        <span></span>
                        <span class="check"></span>
                        <span class="box"></span> {{ trans('contractmembertaqyeem.direct_emp')}} </label>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>

</div>
<div class="row" id="taqawel_services_div" style="display: none;">
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
                                   class="md-md-check">
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
                                   class="md-md-check">
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
<div class="row" id="hire_labore_div" style="display: none;">
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
                                   class="md-md-check">
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

                                   class="md-md-check">
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
<div class="row" id="direct_emp_div" style="display: none;">
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

                                   class="md-md-check">
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
                                   class="md-md-check">
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