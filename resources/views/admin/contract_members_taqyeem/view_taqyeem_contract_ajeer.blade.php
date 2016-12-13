<div class="row residents_type">
    <div class="form-group form-md-checkboxes  margin-top-10">
        <label class="col-md-3 control-label"
               for="form_control_1">{{ trans('contractmembertaqyeem.mokayemeen')}}</label>
        <div class="col-md-9">
            <div class="md-radio-inline">
                <div class="md-radio">
                    <input type="radio" id="checkbox1_11" name="residents" value="1"
                           class="md-radiobtn" {{ @$permisionToCompact->taqyeemTemplatePermission->residents || empty($permisionToCompact->taqyeemTemplatePermission->residents) == 1 ? "checked" : "" }} >
                    <label for="checkbox1_11">
                        <span></span>
                        <span class="check"></span>
                        <span class="box"></span> {{ trans('contractmembertaqyeem.all_users')}}
                    </label>
                </div>
                <div class="md-radio">
                    <input type="radio" id="checkbox1_12" name="residents"
                           data-url="{{ route('view.resident.details') }}" value="2"
                           class="md-radiobtn" {{ @$permisionToCompact->taqyeemTemplatePermission->residents == 2 ? "checked" : "" }}>
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
<div class="row"
     id="userTypeResidents"
     @if(@$permisionToCompact->taqyeemTemplatePermission->residents ==2)
     style='display: none;'

        @endif
>

    <div class="form-group form-md-checkboxes  margin-top-10">
        <label class="col-md-3 control-label"
               for="form_control_1"></label>
        <div class="col-md-9">
            <div class="md-checkbox-inline">
                @foreach(array_except(Constants::userTypes(), [1, 4, 5]) +[5 => trans('contractmembertaqyeem.individual')] as $userTypeKey=> $userTypeValue)
                    <div class="md-checkbox">
                        <input type="checkbox" id="userTypeResidents-{{$userTypeKey}}"
                               name="userTypeResidents[{{$userTypeKey}}]"
                               value="{{$userTypeKey}}" class="md-radiobtn"
                               @if($userTypeKey == 5 && @$permisionToCompact->taqyeemTemplatePermission->ind )
                               checked
                               @endif
                               @if($userTypeKey == 3 && @$permisionToCompact->taqyeemTemplatePermission->est )
                               checked
                               @endif
                               @if($userTypeKey == 2 && @$permisionToCompact->taqyeemTemplatePermission->gov )
                               checked
                                @endif
                               @if(!isset($permisionToCompact))
                               checked
                                @endif
                        >
                        <label for="userTypeResidents-{{$userTypeKey}}">
                            <span></span>
                            <span class="check"></span>
                            <span class="box"></span> {{$userTypeValue}}
                        </label>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
    <div class="clearfix"></div>

</div>
