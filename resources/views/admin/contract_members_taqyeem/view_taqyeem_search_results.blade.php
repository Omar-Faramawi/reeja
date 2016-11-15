<table class="table table-striped table-bordered table-hover">
    <thead>
    <tr class="odd gradeX">
        <th></th>
        <th>{{ trans('contractmembertaqyeem.id') }}</th>
        <th>{{ trans('contractmembertaqyeem.user_name') }}</th>
        <th>{{ trans('contractmembertaqyeem.activity') }}</th>
        <th>{{ trans('contractmembertaqyeem.size') }}</th>
    </tr>
    </thead>
    <tbody>
        @foreach($results as $result)
            <tr data-id="{{ $result->id }}">
                <td><input type="checkbox" class="input-id" name="id[]" data-userType="{{ $result->user_type_id or $userType }}" value="{{ $result->id }}"></td>
                <td>{{ $result->id }}</td>
                <td>{{ $result->name }}</td>
                <td>{{ @$result->est_activity }}</td>
                <td>{{ @$result->est_size }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
    </tfoot>
</table>
@if(!is_array($results))
    {{ $results->links() }}
@endif
