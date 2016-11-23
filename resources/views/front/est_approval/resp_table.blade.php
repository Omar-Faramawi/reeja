{!! Form::hidden('estid', $est->id) !!}
<div class="data_box ">

    <div class="data_box">
        <table class="table table-hover table-bordered table-striped">
            <tbody>
            <tr>
                <td>{{trans('est_profile.attributes.name')}}</td>
                <td>{{$est->name}}</td>
            </tr>
            <tr>
                <td>{{trans('est_profile.attributes.FK_establishment_id')}}</td>
                <td>{{$est->FK_establishment_id}}</td>
            </tr>
            <tr>
                <td>{{trans('est_profile.attributes.est_size')}}</td>
                <td>{{$est->est_size}}</td>
            </tr>
            <tr>
                <td>{{trans('est_profile.attributes.est_nitaq')}}</td>
                <td>{{$est->est_nitaq}}</td>
            </tr>
            <tr>
                <td>{{trans('est_profile.attributes.status')}}</td>
                <td>
                    <span class="label label-{{\Tamkeen\Ajeer\Utilities\Constants::EST_STATUS_CLASSES[$est->status]}}">{{$est->status_name}}</span>
                </td>
            </tr>
            </tbody>
        </table>
    </div>

    @foreach($est->responsibles as $resp)
        <div class="data_box">
            <table class="table table-condensed table-hover table-bordered table-striped">
                <tbody>
                <tr>
                    <td>{{trans('est_profile.responsibles_attributes.id_number')}}</td>
                    <td>{{$resp->id_number}}</td>
                </tr>
                <tr>
                    <td>{{trans('est_profile.responsibles_attributes.responsible_name')}}</td>
                    <td>{{$resp->responsible_name}}</td>
                </tr>
                <tr>
                    <td>{{trans('est_profile.responsibles_attributes.job_name')}}</td>
                    <td>{{$resp->job_name}}</td>
                </tr>
                <tr>
                    <td>{{trans('est_profile.responsibles_attributes.responsible_phone')}}</td>
                    <td>{{$resp->responsible_phone}}</td>
                </tr>
                <tr>
                    <td>{{trans('est_profile.responsibles_attributes.responsible_email')}}</td>
                    <td>{{$resp->responsible_email}}</td>
                </tr>
                </tbody>
            </table>
        </div>
    @endforeach

    <div class="form-actions">
        <div class="row">
            <div class="col-md-offset-2 col-md-10">
                {!! Form::hidden('action', '', ['class' => 'hidden_action']) !!}
                {!! Form::button(trans('labels.approve'), ['class' => 'approve_deny btn btn-info btn-lg', 'name' => 'approve', 'data-loading-text'=>trans('labels.loading')]) !!}
                {!! Form::button(trans('labels.deny'), ['class' => 'approve_deny btn btn-danger btn-lg', 'name' => 'deny', 'data-loading-text'=>trans('labels.loading')]) !!}
            </div>
        </div>
    </div>
</div>