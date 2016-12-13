<div class="fileinput fileinput-{{ isset($value) ? 'exists' : 'new' }}" data-provides="fileinput">
    <div class="input-group input-small">
        <div class="form-control input-fixed input-small" data-trigger="fileinput">
            <i class="fa fa-file fileinput-exists"></i>&nbsp;
            <span class="fileinput-filename">{{ isset($value) ? basename($value) : null }}</span>
        </div>
        <span class="input-group-addon btn default btn-file">
            <span class="fileinput-new"> {{ trans('labels.select_file') }} </span>
            <span class="fileinput-exists"> {{ trans('labels.change') }} </span>
            <input type="file" name="{{ isset($name) ? $name : 'file' }}"> 
        </span>
        <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput">
            {{ trans('labels.remove') }} </a>
        @if(isset($value))
        <a href="{{ url('uploads/' . $value) }}" class="input-group-addon btn blue fileinput-exists">{{ trans('temp_job.download') }}</a>
        @endif
    </div>
</div>
