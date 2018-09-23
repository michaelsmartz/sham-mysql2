<div class="row">
    
<div class="form-group col-xs-12 {{ $errors->has('name') ? 'has-error' : '' }}">
    <label for="name">Name</label>
        <input class="form-control" name="name" type="text" id="name" value="{{ old('name', optional($timeGroup)->name) }}" minlength="1" maxlength="50">
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('start') ? 'has-error' : '' }}">
    <label for="start">Start</label>
        <input class="form-control" name="start" type="text" id="start" value="{{ old('start', optional($timeGroup)->start) }}" minlength="1" placeholder="Enter start here...">
        {!! $errors->first('start', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('end') ? 'has-error' : '' }}">
    <label for="end">End</label>
        <input class="form-control" name="end" type="text" id="end" value="{{ old('end', optional($timeGroup)->end) }}" minlength="1" placeholder="Enter end here...">
        {!! $errors->first('end', '<p class="help-block">:message</p>') !!}
</div>

</div>