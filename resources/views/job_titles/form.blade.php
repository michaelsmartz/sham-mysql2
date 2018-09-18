<div class="row">
    
<div class="form-group col-xs-12 {{ $errors->has('description') ? 'has-error' : '' }}">
    <label for="description">Description</label>
        <input class="form-control" name="description" type="text" id="description" value="{{ old('description', optional($jobTitle)->description) }}" minlength="1" maxlength="50" required="true" placeholder="Enter description">
        {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('is_manager') ? 'has-error' : '' }}">
    <label for="is_manager">Manager</label>
        <div class="checkbox">
            <label for="is_manager_1">
                <input id="is_manager_1" class="" name="is_manager" type="hidden" value="0" />
            	<input id="is_manager_1" class="" name="is_manager" type="checkbox" value="1" {{ old('is_manager', optional($jobTitle)->is_manager) == '1' ? 'checked' : '' }}>
                Yes
            </label>
        </div>

        {!! $errors->first('is_manager', '<p class="help-block">:message</p>') !!}
</div>

</div>