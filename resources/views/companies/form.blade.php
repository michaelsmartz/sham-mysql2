<div class="row">
    
<div class="form-group col-xs-12 {{ $errors->has('name') ? 'has-error' : '' }}">
    <label for="name">name</label>
        <input class="form-control" name="name" type="text" id="name" value="{{ old('name', optional($company)->name) }}" minlength="1" maxlength="50" placeholder="Enter description">
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>

</div>