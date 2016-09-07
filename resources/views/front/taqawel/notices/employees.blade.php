<div class="portlet box red">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-globe"></i>{{trans('ishaar_setup.form_attributes.employee_choose')}}</div>
        <div class="tools"> </div>
    </div>
    <div class="portlet-body">
        <table class="table table-striped table-bordered table-hover table-checkable myemployees"
               id="datatable_ajax">
            <thead>
                <tr role="row" class="heading">
                    <th id="id"># </th>
                    <th id="check" class="no-sort"></th>
                    <th id="id_number">{{trans('ishaar_setup.form_attributes.id_number')}} </th>
                    <th id="name"> {{trans('ishaar_setup.form_attributes.name')}} </th>
                    <th id="nationality.name"> {{trans('ishaar_setup.form_attributes.nationality')}} </th>
                    <th id="job.job_name"> {{trans('ishaar_setup.form_attributes.job')}} </th>
                    <th id="gender_name"> {{trans('ishaar_setup.form_attributes.gender')}} </th>
                    <th id="age"> {{trans('ishaar_setup.form_attributes.age')}} </th>
                    <th id="religion_name"> {{trans('ishaar_setup.form_attributes.religion')}} </th>
                    <th id="region.name"> {{trans('ishaar_setup.form_attributes.approved_areas')}} </th>
                    <th id="details" class="no-sort" width="10%"> {{trans('ishaar_setup.attributes.details')}}</th>
                </tr>
                <tr role="row" class="filter">
                    <td>
                        <input type="text" class="form-control form-filter input-sm" name="id">
                    </td>
                    
                    <td></td>
                    
                    <td>
                        <input type="text" class="form-control form-filter input-sm" name="id_number">
                    </td>
                    <td>
                        <input type="text" class="form-control form-filter input-sm" name="name">
                    </td>
                    <td>
                        {{ Form::select('nationality_id', $nationalities, null, ['class' => 'form-control bs-select form-filter input-sm', 'placeholder' => trans('labels.default')]) }}

                    </td>
                    <td>
                        {{ Form::select('job_id', $jobs, null, ['class' => 'form-control bs-select form-filter input-sm', 'placeholder' => trans('labels.default')]) }}

                    </td>
                    <td>
                        <input type="text" class="form-control form-filter input-sm"
                               name="gender">
                    </td>
                    <td>
                        
                    </td>

                    <td>
                        <input type="text" class="form-control form-filter input-sm"
                               name="religion">
                    </td>
                    <td>
                        <input type="text" class="form-control form-filter input-sm"
                               name="region_id">
                    </td>
                    <td>
                        <button class="btn btn-sm green btn-outline filter-submit margin-bottom">
                            <i class="fa fa-search"></i> {{ trans('add_laborer.search') }}
                        </button>
                    </td>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

</div>
@if(count($accountType))
<div class="row" >
    <div class="col-md-offset-3 col-md-12">
        <button type="button" class="btn btn-circle green left" id="add_employees" >{{trans('ishaar_setup.actions.add_employee')}}</button>
    </div>
</div>
@endif
<div class="row" id="only_one_employee_msg"></div>


<!-- END EXAMPLE TABLE PORTLET-->
