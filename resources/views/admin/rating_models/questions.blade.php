@if(Session::get('full'))
    @foreach (Session::get('full') as $key => $value)
        @if (isset($value))
            <div class="submitform">
                <div class="row">
                    <div class="col-sm-3">
                        {{trans("ratingmodels.question")}}
                    </div>
                    <div class="col-sm-9">
                        {{$value['q']}}</div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        {{trans("ratingmodels.answer")}}
                    </div>
                    <div class="col-sm-9">
                        <ul>
                            @foreach($value['a'] as $answer)
                                <li>{{$answer}} </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <button type="button" class="close sessionClose" data-dismiss="alert"
                        data-action="{{ url('admin/ratingmodels/removeFromSession/' .  $key )}}"
                        data-token="{{ csrf_token() }}"
                        data-status="{{ $value['status'] }}"></button>

            </div>
        @endif
    @endforeach
@endif
