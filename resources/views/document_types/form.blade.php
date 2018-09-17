<div class="row">
    
<div class="form-group col-xs-12 {{ $errors->has('extension') ? 'has-error' : '' }}">
    <label for="extension">Extension</label>
        <input class="form-control" name="extension" type="text" id="extension" value="{{ old('extension', optional($documentType)->extension) }}" minlength="1" placeholder="Enter extension">
        {!! $errors->first('extension', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('description') ? 'has-error' : '' }}">
    <label for="description">Description</label>
        <input class="form-control" name="description" type="text" id="description" value="{{ old('description', optional($documentType)->description) }}" minlength="1" maxlength="50" placeholder="Enter description">
        {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
</div>

</div>