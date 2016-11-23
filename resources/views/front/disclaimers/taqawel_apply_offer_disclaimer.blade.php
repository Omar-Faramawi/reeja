<p>{{ trans('taqawel_disclaimer.heading') }}</p>

<ol>
    @foreach(trans('taqawel_disclaimer.points') as $point)
        <li>{{ $point }}</li><br>
    @endforeach

</ol>
