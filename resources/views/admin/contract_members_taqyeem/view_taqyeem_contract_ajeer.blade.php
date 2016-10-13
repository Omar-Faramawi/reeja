<div class="row residents_type">
    <div class="form-group form-md-checkboxes  margin-top-10">
        <label class="col-md-3 control-label"
               for="form_control_1">{{ trans('contractmembertaqyeem.mokayemeen')}}</label>
        <div class="col-md-9">
            <div class="md-radio-inline">
                <div class="md-radio">
                    <input type="radio" id="checkbox1_11" id="checkbox1_11" name="residents" value="1" class="md-radiobtn" {{ @$permisionToCompact->taqyeemTemplatePermission->residents || empty($permisionToCompact->taqyeemTemplatePermission->residents) == 1 ? "checked" : "" }}>
                    <label for="checkbox1_11">
                        <span></span>
                        <span class="check"></span>
                        <span class="box"></span> {{ trans('contractmembertaqyeem.all_users')}}
                    </label>
                </div>
                <div class="md-radio">
                    <input type="radio" id="checkbox1_12" id="checkbox1_12" name="residents" data-url="{{ route('view.resident.details') }}" value="2" class="md-radiobtn" {{ @$permisionToCompact->taqyeemTemplatePermission->residents == 2 ? "checked" : "" }}>
                    <label for="checkbox1_12">
                        <span></span>
                        <span class="check"></span>
                        <span class="box"></span> {{ trans('contractmembertaqyeem.individuals')}} </label>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>

</div>
