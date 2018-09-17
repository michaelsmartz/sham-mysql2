<div class="row">
    
<div class="form-group col-xs-12 {{ $errors->has('Description') ? 'has-error' : '' }}">
    <label for="Description">Description</label>
        <input class="form-control" name="Description" type="text" id="Description" value="{{ old('Description', optional($immigrationStatus)->Description) }}" minlength="1" maxlength="50" required="true" placeholder="Enter description">
        {!! $errors->first('Description', '<p class="help-block">:message</p>') !!}
</div>

</div>