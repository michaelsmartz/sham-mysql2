<div class="row">
    <div class="form-group col-xs-12 {{ $errors->has('description') ? 'has-error' : '' }}">
        <label for="description">Description</label>
            <input class="form-control" name="description" type="text" id="description" value="{{ old('description', isset($course->description) ? $course->description : null) }}" minlength="5" maxlength="100" required="required">
            {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group col-xs-6 {{ $errors->has('is_public') ? 'has-error' : '' }}">
        <label for="is_public">Public <i class="fa fa-question-circle" data-wenk="Any employee can enrol on a Public course" data-wenk-pos="right"></i></label></label>
        <div class="checkbox">
            <label for="is_public_1">
            	<input id="is_public_1" class="" name="is_public" type="checkbox" value="1" {{ old('is_public', isset($course->is_public) ? $course->is_public : null) == '1' ? 'checked' : '' }}>
                <span class="badge badge-info">Yes</span>
            </label>
        </div>
        {!! $errors->first('is_public', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group col-xs-6 {{ $errors->has('passmark_percentage') ? 'has-error' : '' }}">
        <label for="passmark_percentage">Passmark Percentage</label>
        <input class="form-control" name="passmark_percentage" type="number" id="passmark_percentage" value="{{ old('passmark_percentage', isset($course->passmark_percentage) ? $course->passmark_percentage : null) }}" placeholder="Enter passmark percentage...">
        {!! $errors->first('passmark_percentage', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group col-xs-12 {{ $errors->has('overview') ? 'has-error' : '' }}">
        <label for="overview">Overview</label>
            <textarea class="form-control" name="overview" cols="50" rows="4" id="overview" minlength="1" placeholder="Enter overview...">{{ old('overview', isset($course->overview) ? $course->overview : null) }}</textarea>
            {!! $errors->first('overview', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group col-xs-12 {{ $errors->has('objectives') ? 'has-error' : '' }}">
        <label for="objectives">Objectives</label>
            <textarea class="form-control" name="objectives" cols="50" rows="4" id="objectives" minlength="1" placeholder="Enter objectives...">{{ old('objectives', isset($course->objectives) ? $course->objectives : null) }}</textarea>
            {!! $errors->first('objectives', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group col-xs-12 {{ $errors->has('modules[]') ? 'has-error' : '' }}">
        <label for="from[]">Modules <i class="fa fa-question-circle" data-wenk="Link existing module(s) to this course" data-wenk-pos="right"></i></label>
    </div>
    <div class="col-xs-12">
        <div class="flex-wrapper">
            <div class="col-xs-5">
                {!! Form::select('from[]', $modules, null, array('multiple' => 'multiple', 'size' => '7', 'class'=> 'form-control multipleSelect', 'id'=>'multiselect')) !!}
            </div>
            <div class="col-xs-2">
                <button type="button" id="multiselect_rightAll" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>
                <button type="button" id="multiselect_rightSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
                <button type="button" id="multiselect_leftSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
                <button type="button" id="multiselect_leftAll" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>
            </div>
            <div class="col-xs-5">
                {!! Form::select('modules[]', isset($courseModules)?$courseModules:[],null, array('multiple' => 'multiple', 'size' => '7', 'class'=> 'form-control', 'id'=>'multiselect_to')) !!}
            </div>
            {!! $errors->first('modules[]', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
</div>