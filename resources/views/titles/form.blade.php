<div class="row">
    
<div class="form-group col-xs-12 {{ $errors->has('description') ? 'has-error' : '' }}">
    <label for="description">Description</label>
        <textarea class="form-control" name="description" cols="50" rows="5" id="description" minlength="1" maxlength="50" required="true">{{ old('description', optional($title)->description) }}</textarea>
        {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12">
    <input type="hidden" name="is_system_predefined" value="0">
</div>

</div>