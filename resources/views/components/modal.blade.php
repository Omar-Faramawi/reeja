<div class="modal fade" id="{{ $id }}" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">{{ $title }}</h4>
            </div>
            {!! Form::open(['id' => 'form', 'route' => $route, 'data-url' => $dataUrl ]) !!}
            <div class="modal-body form-body">
                @include($content)
            </div>
            <div class="modal-footer">
                <button type="submit" data-loading-text="{{ trans('labels.loading') }}..." class="demo-loading-btn btn blue">
        <i class="fa fa-check"></i> {{ trans('labels.save') }} </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('labels.cancel') }}
                </button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
