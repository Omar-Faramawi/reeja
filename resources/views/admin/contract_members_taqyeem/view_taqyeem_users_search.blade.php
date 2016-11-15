<div class="row residents_search">
        <div class="col-md-3 control-label form-group form-md-checkboxes">
            <label class="" for="form_control_1">{{ trans('contractmembertaqyeem.search')}}</label>
        </div>
        <div class="col-md-3">
            <div class="form-group form-md-line-input">
                {!! Form::label('user_type', trans('contractmembertaqyeem.user_type')) !!}
                {!! Form::select('search[user_type]', array_except(Constants::userTypes(), [1, 4, 5]) +[5 => trans('contractmembertaqyeem.individual')] ,[], ['class' => 'form-control col-md-3']) !!}
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group form-md-line-input">
                {!! Form::label('user_name', trans('contractmembertaqyeem.user_name')) !!}
                {!! Form::text('search[user_name]', null, ['class' => 'form-control col-md-3']) !!}
            </div>
        </div>
        <div class="col-md-1">
            <div class="form-group form-md-line-input">
                {!! Form::button(trans('contractmembertaqyeem.search'), [ 'data-url' => route('view.taqyeem.search.users') ,'id' => 'search-users', 'class' => 'btn btn-primary btn-sm']) !!}
            </div>
        </div>


    <div class="clearfix"></div>
    <br><br>
</div>

<div class="row residents_search">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <div class="search-results">
            @if(!empty($results) && isset($isSearch))
                @include('admin.contract_members_taqyeem.view_taqyeem_search_results')
            @endif
        </div> <!-- search results -->
        <br>
        <div class="table-div" @if(empty($results)) style="display:none" @endif>
            <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr class="odd gradeX">
                    <th>{{ trans('contractmembertaqyeem.id') }}</th>
                    <th>{{ trans('contractmembertaqyeem.user_name') }}</th>
                    <th>{{ trans('contractmembertaqyeem.activity') }}</th>
                    <th>{{ trans('contractmembertaqyeem.size') }}</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
					@if(!empty($results) && !isset($isSearch))
						@foreach($results as $result)
							<tr id="taqyeem_row_{{ @$result->userType }}_{{ $result->id }}">
								<td>{{ $result->id }}</td>
								<td>{{ $result->name }}</td>
								<td>{{ $result->est_activity or '' }}</td>
								<td>{{ $result->est_size or '' }}</td>
								<td class="text-center">
									<input type="hidden" name="ids[]" value="{{ $result->id }}">
									<input type="hidden" name="userType[]" value="{{ @$result->userType }}">
									<button class="remove-row btn-small btn-danger error">×</button>
								</td>
							</tr>
						@endforeach
					@endif
                </tbody>
                <tfoot></tfoot>
            </table>
        </div>
    </div>
</div>
