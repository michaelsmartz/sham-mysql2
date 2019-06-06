<div class="row">

<div class="form-group col-xs-12 {{ $errors->has('description') ? 'has-error' : '' }}">
    <label for="description">Description</label>
        <input class="form-control" name="description" type="text" id="description" value="{{ old('description', optional($leaveType)->description) }}" minlength="1" maxlength="191">
        {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('default_balance') ? 'has-error' : '' }}">
    <label for="default_balance">Default Balance</label>
        <input class="form-control" name="default_balance" type="number" id="default_balance" value="{{ old('default_balance', optional($leaveType)->default_balance) }}" min="1" max="2147483647" placeholder="Enter default balance here...">
        {!! $errors->first('default_balance', '<p class="help-block">:message</p>') !!}
</div>

</div>