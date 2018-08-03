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

</div>