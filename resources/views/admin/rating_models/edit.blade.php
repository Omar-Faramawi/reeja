<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title"><i class="fa fa-edit"></i> {{ trans('ratingmodels.widgetName') }}</h4>
</div>
@if(isset($ratingModels))
    {{ Form::model($ratingModels, ["files"=>"true", 'route' => ['admin.ratingmodels.update', $ratingModels->hashids], 'method' => 'patch', 'id'=>'form']) }}
@else
    {{ Form::open(['route' => 'admin.ratingmodels.index', "files"=>"true", 'id'=>'form']) }}
@endif
<div class="modal-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="form-body">
                <div class="form-group form-md-line-input form-md-floating-label">
                    {{ Form::text('name', null, ['id'=>'name', 'class'=>'form-control']) }}
                    <label {{ isset($ratingModels) ? 'style=top:0;' : "" }} for="name">{{ trans('ratingmodels.formTitle') }}
                        <span class="required">*</span></label>
                    <span class="help-block">{{ trans('ratingmodels.formTitle') }}</span>
                </div>


                <br>
                <br>

                <div class="resultdiv">
                    @include("admin.rating_models.questions",$ratingModels)
                </div>
                <br>
                <a href="#" style="margin-bottom:20px; float:right"
                   class="addform">{{ trans('ratingmodels.addNewQuestion') }}</a>
                <div class="submitform submitformcont">
                    <div class="form-group form-md-line-input form-md-floating-label">
                        {{ Form::textarea('question', null, ['class' => 'form-control',"id"=>"question",'size' => '20x3']) }}
                        <label {{ isset($ratingModels) ? 'style=top:0;' : "" }} for="question">{{ trans('ratingmodels.question') }}
                            <span
                                    style="color:red"> *</span> </label>
                        <span class="help-block">{{ trans('ratingmodels.question') }}</span>

                    </div>
                    <div class="form-group divAdd">
                        <label class="control-label col-sm-3" for="answer">{{ trans('ratingmodels.answer') }}</label>
                        <div class="col-sm-9 ">
                            <div class="divCont">
                                <div class="col-lg-9" style=" margin-bottom: 10px">
                                    {{ Form::text('answer[]', null, ['id'=>'answer', 'class'=>'form-control answerClass']) }}
                                </div>
                                <div class="col-lg-3">
                                    <button type="button" class="btn btn-primary btn-add"
                                    >{{ trans('ratingmodels.addAnswer') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="button" data-loading-text="{{ trans('labels.loading') }}..."
                                class="btn btn-primary" id="btn-save"
                                data-action="{{ url('admin/ratingmodels/addSession') }}"
                                data-token="{{ csrf_token() }}"><i
                                    class="fa fa-check"></i>{{ trans('ratingmodels.addQA') }}</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="modal-footer">
    <button type="submit" data-loading-text="{{ trans('labels.loading') }}..." class="demo-loading-btn btn blue">
        <i class="fa fa-check"></i> {{ trans('labels.save') }} </button>
    <button type="button" data-dismiss="modal" class="btn default">{{ trans('labels.cancel') }}</button>
</div>
{{form::close()}}