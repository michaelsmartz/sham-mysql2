<div class="row">

    <div class="form-group col-xs-12 {{ $errors->has('description') ? 'has-error' : '' }}">
        <label for="description">Description</label>
            <textarea class="form-control" name="description" cols="50" rows="10" id="description" minlength="5" maxlength="256" required="true">{{ old('description', isset($module->description) ? $module->description : null) }}</textarea>
            {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group col-xs-12 {{ $errors->has('overview') ? 'has-error' : '' }}">
        <label for="overview">Overview</label>
            <textarea class="form-control" name="overview" cols="50" rows="10" id="overview" minlength="1" maxlength="999" placeholder="Enter overview here...">{{ old('overview', isset($module->overview) ? $module->overview : null) }}</textarea>
            {!! $errors->first('overview', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group col-xs-12 {{ $errors->has('objectives') ? 'has-error' : '' }}">
        <label for="objectives">Objectives</label>
            <textarea class="form-control" name="objectives" cols="50" rows="10" id="objectives" minlength="1" placeholder="Enter objectives here...">{{ old('objectives', isset($module->objectives) ? $module->objectives : null) }}</textarea>
            {!! $errors->first('objectives', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group col-xs-12 {{ $errors->has('topics[id]') ? 'has-error' : '' }}">
        <label for="topics[id]">Topics <i class="fa fa-question-circle" data-wenk="Link existing topic(s) to this module"></i></label>
        <div class="flex-wrapper">
            {!! Form::select('topics[id][]', $topics,isset($moduleTopics)?$moduleTopics:null, array('multiple' => 'multiple', 'style' => 'width:100%')) !!}
            {!! $errors->first('topics[id]', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
</div>

@section('post-body')
    <script src="{{url('/')}}/plugins/multiple-select/multiple-select.min.js"></script>
    <link rel="stylesheet" href="{{url('/')}}/plugins/multiple-select/multiple-select.min.css">
    <script>
    $(function () {
        $('select').multipleSelect({
            filter: true
        });
    });
    </script>
@endsection