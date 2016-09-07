@extends('front.layout')
@section('title', trans('contracts.details_contract'))
@section('content')

    <!-- BEGIN PAGE CONTENT BODY -->
    <div class="page-content">
        <div class="container">
            <!-- BEGIN PAGE CONTENT INNER -->
            <div class="page-content-inner">
                <div class="row">

                    <div class="col-md-12">

                        <div class="portlet light portlet-fit portlet-form ">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class=" icon-layers font-red"></i>
                                    <span class="caption-subject font-red sbold uppercase">{{ trans('contracts.details_contract') }}</span>
                                </div>
                            </div>
                            <div class="portlet-body">


                                <div class="form-body">

                                    @if(!$canCancel)
                                        <div class="alert alert-info">
                                            {{ trans('contracts.can_delete') }}
                                        </div>
                                    @endif
                                    <div class="form-group form-md-line-input">
                                        <p>{{ trans('temp_job.service_provider_name') }}</p>
                                        <p><i>{{ $username  }}</i></p>
                                    </div>

                                    <div class="form-group form-md-line-input">
                                        <p>{{ trans('temp_job.service_provider_number') }}</p>
                                        <p><i>{{ $userId }}</i></p>
                                    </div>

                                    <div class="form-group form-md-line-input">
                                        <p>{{ trans('temp_job.service_benf_name') }}</p>
                                        <p><i>{{ $benfName }}</i></p>
                                    </div>

                                    <div class="form-group form-md-line-input">
                                        <p>{{ trans('temp_job.service_benf_number') }}</p>
                                        <p><i>{{ $contract->benf_id }}</i></p>
                                    </div>

                                    <div class="caption">
                                        <h5>{{ trans('temp_job.application_info') }}</h5><br>
                                    </div>

                                    <div class="form-group form-md-line-input">
                                        <p>{{ trans('temp_job.job_id') }}</p>
                                        <p><i>{{ @$contract->vacancy->job->job_name }}</i></p>
                                    </div>

                                    <div class="form-group form-md-line-input">
                                        <p>{{ trans('temp_job.nationality_id') }}</p>
                                        <p><i>{{ @$contract->vacancy->nationality->name }}</i></p>
                                    </div>

                                    <div class="form-group form-md-line-input">
                                        <p>{{ trans('temp_job.gender.name') }}</p>
                                        <p>
                                            <i>{{ \Tamkeen\Ajeer\Utilities\Constants::GENDER($contract->vacancy->gender) }}</i>
                                        </p>
                                    </div>

                                    <div class="form-group form-md-line-input">
                                        <p>{{ trans('temp_job.religion_id') }}</p>
                                        <p>
                                            <i>{{ \Tamkeen\Ajeer\Utilities\Constants::RELIGIONS($contract->vacancy->religion) }}</i>
                                        </p>
                                    </div>

                                    <div class="form-group form-md-line-input">
                                        <p>{{ trans('temp_job.work_start_date') }}</p>
                                        <p><i>{{ $contract->vacancy->work_start_date }}</i></p>
                                    </div>

                                    <div class="form-group form-md-line-input">
                                        <p>{{ trans('temp_job.work_end_date') }}</p>
                                        <p><i>{{ $contract->vacancy->work_end_date }}</i></p>
                                    </div>

                                    <div class="form-group form-md-line-input">
                                        <p>{{ trans('temp_job.job_type.name') }}</p>
                                        <p>
                                            <i>{{ \Tamkeen\Ajeer\Utilities\Constants::JOBTYPES($contract->vacancy->job_type)  }}</i>
                                        </p>
                                    </div>

                                </div>
                            </div>

                        </div>

                        @if($canCancel)

                            <div class="text-align-left col-md-12">

                                <button type="button" class="btn btn-primary btn-danger btn-lg" data-toggle="modal"
                                        data-target="#myModal">
                                    {{ trans('contracts.reset') }}
                                </button>

                                @include('components.modal', ['id' => 'myModal', 'title' => trans('contracts.cancel_reason'), 'content' => 'front.contracts.partials.cancel', 'route' => 'contracts.update_status', 'dataUrl' => route('contracts.index') ])
                            </div>
                            <br><br>

                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- END PAGE CONTENT BODY -->
    <!-- END CONTENT BODY -->

@endsection