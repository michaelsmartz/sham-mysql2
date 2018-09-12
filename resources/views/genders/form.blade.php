<div class="row">
    
<div class="form-group col-xs-12 {{ $errors->has('description') ? 'has-error' : '' }}">
    <label for="description">Description</label>
        <textarea class="form-control" name="description" cols="50" rows="5" id="description" minlength="1" maxlength="50">{{ old('description', optional($gender)->description) }}</textarea>
        {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
</div>

</div>