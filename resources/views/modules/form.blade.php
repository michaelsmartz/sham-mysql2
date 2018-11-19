{!! Form::hidden('redirectsTo', URL::previous()) !!}
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

    <div class="form-group col-xs-12 {{ $errors->has('topics[]') ? 'has-error' : '' }}">
        <label for="topics[]">Topics <i class="fa fa-question-circle" data-wenk="Link existing topic(s) to this module" data-wenk-pos="right"></i></label>
    </div>
    <div class="col-xs-12">
        <div class="flex-wrapper">
            <div class="col-xs-12">
                {!! Form::select('from[]', $topics, null, array('multiple' => 'multiple', 'size' => '7', 'class'=> 'form-control multipleSelect', 'id'=>'multiselect')) !!}
            </div>
        </div>
        <br>
    </div>

    <div class="col-xs-6 col-xs-offset-3">
        <div class="col-xs-6">
                <button type="button" id="multiselect_rightAll" class="btn btn-block" data-wenk="Select All"><i class="fa fa-angle-double-down" style="font-weight:900"></i></button>
                <button type="button" id="multiselect_rightSelected" class="btn btn-block" data-wenk="Add Selected"><i class="fa fa-angle-down" style="font-weight:900"></i></button>
        </div>
        <div class="col-xs-6">
            <button type="button" id="multiselect_leftSelected" class="btn btn-block" data-wenk="Remove Selected"><i class="fa fa-angle-up" style="font-weight:900"></i></button>
            <button type="button" id="multiselect_leftAll" class="btn btn-block" data-wenk="Unselect All"><i class="fa fa-angle-double-up" style="font-weight:900"></i></button>
        </div>
    </div>

    <div class="col-xs-12">
        <br>
        <div class="col-xs-12">
            {!! Form::select('topics[]', isset($moduleTopics)?$moduleTopics:[], null, array('multiple' => 'multiple', 'size' => '7', 'class'=> 'form-control', 'id'=>'multiselect_to')) !!}
        </div>
        {!! $errors->first('topics[]', '<p class="help-block">:message</p>') !!}
    </div>
</div>

