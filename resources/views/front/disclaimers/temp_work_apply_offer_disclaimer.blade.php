<p>{{ trans('temp_work_disclaimer.heading') }}</p>

<ol>
    @foreach(trans('temp_work_disclaimer.points') as $point)
        <li>{{ $point }}</li><br>
    @endforeach

</ol>
