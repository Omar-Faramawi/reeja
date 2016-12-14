<div class="portlet box blue">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-globe"></i>{{trans('ishaar_setup.form_attributes.employee_choose')}}</div>
        <div class="tools"></div>
    </div>
    <div class="portlet-body">
        <table class="table table-striped table-bordered table-hover table-checkable myemployees"
               id="datatable_ajax">
            <thead>
            <tr role="row" class="heading">
                <th id="id" class="no-sort">#</th>
                <th id="check" class="no-sort"></th>
                <th id="id_number" class="no-sort">{{trans('ishaar_setup.form_attributes.id_number')}} </th>
                <th id="name" class="no-sort"> {{trans('ishaar_setup.form_attributes.name')}} </th>
                <th class="no-sort" id="nationality"> {{trans('ishaar_setup.form_attributes.nationality')}} </th>
                <th class="no-sort" id="occupation"> {{trans('ishaar_setup.form_attributes.job')}} </th>
                <th class="no-sort" id="buttons" class="no-sort"
                    width="10%"> {{trans('ishaar_setup.attributes.details')}}</th>
            </tr>
            <tr role="row" class="filter">
                <td></td>
                <td></td>
                <td>
                    <input type="text" class="form-control form-filter input-sm" name="id_number">
                </td>
                <td></td>
                <td>
                    <select class="form-control bs-select form-filter input-sm"  name="nationality_id" data-live-search="true">
                        <option selected="selected" value="">{{ trans('labels.noneSelectedTextValueSmall')}}</option>
                        @foreach($nationalities as $value)
                        <option value="{{$value['id']}}">{{$value['name']}}</option>
                        @endforeach
                    </select>

                </td>
                <td>
                    <select class="form-control bs-select form-filter input-sm"  name="job_id" data-live-search="true">
                        <option selected="selected" value="">{{ trans('labels.noneSelectedTextValueSmall')}}</option>
                        @foreach($jobs as $value)
                        <option value="{{$value['id']}}">{{$value['name']}}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <button class="btn btn-sm green btn-outline filter-submit margin-bottom">
                        <i class="fa fa-search"></i> {{ trans('add_laborer.search') }}
                    </button>
                    <button class="btn btn-sm red btn-outline filter-cancel">
                        <i class="fa fa-times"></i> {{ trans('add_laborer.reset') }}
                    </button>
                   
                </td>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>

        @if(count($accountType))
            <button type="button" class="btn btn-circle green pull-right"
                id="add_employees">{{trans('ishaar_setup.actions.add_employee')}}</button>
            <div class="clearfix"></div>
        @endif
    </div>
</div>

<div class="row" id="only_one_employee_msg"></div>