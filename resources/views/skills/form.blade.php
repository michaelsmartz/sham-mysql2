<div class="row">
    
<div class="form-group col-xs-12 {{ $errors->has('description') ? 'has-error' : '' }}">
    <label for="description">Description</label>
        <input class="form-control" name="description" type="text" id="description" value="{{ old('description', optional($skill)->description) }}" minlength="1" maxlength="50" required="true" placeholder="Enter description">
        {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('Level') ? 'has-error' : '' }}">
    <label for="Level">Level</label>
        <input class="form-control" name="Level" type="text" id="Level" value="{{ old('Level', optional($skill)->Level) }}" min="-32768" max="32767" placeholder="Enter level">
        {!! $errors->first('Level', '<p class="help-block">:message</p>') !!}
</div>

</div>