@extends ('admin.layout')
@section('title', trans('contract_setup.temp_work_contract_setup'))
@section('content')
    <!-- BEGIN PAGE BASE CONTENT -->


    <div class="m-heading-1 border-green m-bordered">
        <h3> {{ trans('contract_setup.direct_emp') }} </h3>
        <p> {{ trans('contract_setup.temp_work_contract_setup') }} </p>
    </div>

    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings"></i>
                        <span class="caption-subject bold uppercase"> {{ trans('contract_setup.direct_emp_contracts_setup') }}</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6 pull-right">
                                @if(!empty($can_add) && $can_add)
                                    <div class="btn-group pull-right">
                                        <button data-toggle="modal" data-target="#main"
                                                data-href="{{ route('admin.contractSetup.create', ['id'=>$occupation->id]) }}"
                                                class="btn sbold green"> {{ trans('actions.add') }}
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @if(count($errors))
                        <div class="alert alert-danger">
                            <ul class="list-unstyled">
                                @foreach($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (Session::has('msg'))
                        <div class="alert alert-info">{{ Session::pull('msg') }}</div>
                    @endif

                    {!! Form::model($contractSetup, ['route' => ['admin.contractSetup.update', $contractSetup->hashids], 'id' => 'live_form', 'method' => 'PATCH']) !!}
                    {!! Form::hidden('contract_type_id',null, ['id' => 'contract_type_id']) !!}
					<div class="row"><div class="col-lg-10 col-lg-offset-2 form-body"></div></div>
					<div class="row">
						<div class="col-lg-10 col-lg-offset-2">
							<div class="col-lg-6">
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<label for="is_slider">{{trans('contract_setup.attributes.contract_accept_period')}}</label>
											{!! Form::number('contract_accept_period', null, ['min' => 0, 'class' => 'form-control valid']) !!}
										</div>
									</div>
									<div class="col-lg-1">&nbsp;</div>
									<div class="col-lg-5">
										<div class="form-group">
											<label for="featured">&nbsp;</label>
											<div class="select-wrapper select-arrow">
												{!! Form::select('contract_accept_period_type', trans('contract_setup.period_type_array'),null,  ['class' => 'form-control']) !!}

											</div>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<label for="is_slider">{{trans('contract_setup.attributes.ishaar_cancel_period')}}</label>
											{!! Form::number('ishaar_cancel_period', null, ['min' => 0, 'class' => 'form-control valid']) !!}
										</div>
									</div>
									<div class="col-lg-1">&nbsp;</div>
									<div class="col-lg-5">
										<div class="form-group">
											<label for="featured">&nbsp;</label>
											<div class="select-wrapper select-arrow">
												{!! Form::select('ishaar_cancel_period_type', trans('contract_setup.period_type_array'),null,  ['class' => 'form-control']) !!}
											</div>
										</div>
									</div>
								</div>


								<div class="row">
									<div class="col-lg-12">
										<div class="form-group">
											<label for="is_slider">{{trans('contract_setup.ishaar_cancel_acc')}}</label>
											<div class="md-checkbox-inline">
												<div class="md-checkbox">
													{!! Form::checkbox('benf_cancel_ishaar', @$contractSetup->benf_cancel_ishaar, null, ['class' => 'md-check', 'id' => 'benf_cancel_ishaar']) !!}
													<label for="benf_cancel_ishaar" class="text-right">
														<span></span>
														<span class="check"></span>
														<span class="box"></span> {{trans('contract_setup.employer')}}
													</label>
												</div>
												<div class="md-checkbox">
													{!! Form::checkbox('provider_cancel_ishaar', @$contractSetup->provider_cancel_ishaar, null, ['class' => 'md-check', 'id' => 'provider_cancel_ishaar']) !!}
													<label for="provider_cancel_ishaar" class="text-right">
														<span></span>
														<span class="check"></span>
														<span class="box"></span> {{trans('contract_setup.labor')}}
													</label>
												</div>
											</div>
										</div>
									</div>
								</div>



								<div class="row">
									<div class="col-lg-12">
										<div class="form-group">
											<label for="is_slider">{{trans('contract_setup.ownership_att_time')}}</label>
											<div class="md-checkbox-inline">
												<div class="md-checkbox">
													{!! Form::checkbox('ownership_att_time', @$contractSetup->ownership_att_time, null, ['class' => 'md-check', 'id' => 'ownership_att_time']) !!}
													<label for="ownership_att_time" class="text-right">
														<span></span>
														<span class="check"></span>
														<span class="box"></span> {{trans('contract_setup.attributes.ownership_att_time')}}
													</label>
												</div>

												<div class="md-checkbox">
													{!! Form::checkbox('ownership_att_time_offer', @$contractSetup->ownership_att_time_offer, null, ['class' => 'md-check', 'id' => 'ownership_att_time_offer']) !!}
													<label for="ownership_att_time_offer" class="text-right">
														<span></span>
														<span class="check"></span>
														<span class="box"></span> {{trans('contract_setup.attributes.ownership_att_time_offer')}}
													</label>
												</div>
											</div>
										</div>
									</div>

								</div>




								<div class="row">
									<div class="col-lg-9">
										<div class="form-group">
											<label for="is_slider">{{trans('contract_setup.attributes.experience_certificate_amount')}}</label>
											{!! Form::number('experience_certificate_amount', null, ['min' => 0, 'max' => 999999999, 'class' => 'form-control valid']) !!}

										</div>

									</div>
                                    <div class="col-lg-3">
                                        <div class="col-lg-12">&nbsp;</div>
										<div class="col-lg-12 margin-top-10">
											<span>{{ trans('contract_setup.reyal') }}</span>
										</div>
                                    </div>

								</div>

								<div class="row">
									<div class="col col-lg-2">
										<label for="" class="col-md-3 control-label">&nbsp;</label>
									</div>
									<div class="col col-lg-10">
										<button type="submit"
												data-loading-text="{{ trans('contract_setup.saving') }}..."
												class="demo-loading-btn btn blue">{{trans('contract_setup.save')}}</button>

										<button type="submit" class="btn default" name="submitted" value="cancel" data-loading-text="{{ trans('contract_setup.saving') }}...">{{trans('contract_setup.cancel')}}</button>
									</div>
								</div>
							</div>
						</div>
					</div>
                    <!-- /.row (nested) -->
                    {!! Form::close() !!}
                    <div class="clearfix"></div>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>

    <!-- BEGIN DASHBOARD STATS 1-->

    <div class="clearfix"></div>
    <!-- END DASHBOARD STATS 1-->
    <!-- END PAGE BASE CONTENT -->

@endsection