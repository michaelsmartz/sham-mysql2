<div class="row">

<div class="form-group col-xs-12 {{ $errors->has('description') ? 'has-error' : '' }}">
    <label for="description">description</label>
    <input class="form-control" name="description" type="text" id="description" value="{{ old('description', optional($language)->description) }}" maxlength="50" required="true" placeholder="Enter description">
    {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('is_preferred') ? 'has-error' : '' }}">
    <label for="is_preferred">Preferred</label>
        <div class="checkbox">
            <label for="is_preferred_1">
                <input id="is_preferred_1" class="" name="is_preferred" type="hidden" value="0" />
            	<input id="is_preferred_1" class="" name="is_preferred" type="checkbox" value="1" {{ old('is_preferred', optional($language)->is_preferred) == '1' ? 'checked' : '' }}>
                Yes
            </label>
        </div>

        {!! $errors->first('is_preferred', '<p class="help-block">:message</p>') !!}
</div>

</div>