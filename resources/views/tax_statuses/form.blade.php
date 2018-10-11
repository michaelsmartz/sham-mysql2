<div class="row">
    
<div class="form-group col-xs-12 {{ $errors->has('description') ? 'has-error' : '' }}">
    <label for="description">description</label>
        <input class="form-control" name="description" type="text" id="description" value="{{ old('description', optional($taxStatus)->description) }}" minlength="5" maxlength="50" required="true" placeholder="Enter description">
        {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
</div>

</div>