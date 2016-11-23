<p>{{ trans('direct_hiring_disclaimer.heading') }}</p>

<ol>
    @foreach(trans('direct_hiring_disclaimer.points') as $point)
        <li>{{ $point }}</li><br>
    @endforeach

</ol>
