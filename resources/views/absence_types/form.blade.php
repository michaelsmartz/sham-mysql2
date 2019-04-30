<div class="row">

<div class="form-group col-xs-12 {{ $errors->has('description') ? 'has-error' : '' }}">
    <label for="description">Description</label>
        <input class="form-control" name="description" type="text" id="description" value="{{ old('description', optional($absenceType)->description) }}" minlength="1" maxlength="100" required="true" placeholder="Enter description">
        {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('duration_unit') ? 'has-error' : '' }}">
    <label for="duration_unit">Duration Unit</label>
        <input class="form-control" name="duration_unit" type="text" id="duration_unit" value="{{ old('duration_unit', optional($absenceType)->duration_unit) }}" placeholder="Enter duration unit">
        {!! $errors->first('duration_unit', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('amount_earns') ? 'has-error' : '' }}">
    <label for="amount_earns">Amount Earns</label>
        <input class="form-control" name="amount_earns" type="text" id="amount_earns" value="{{ old('amount_earns', optional($absenceType)->amount_earns) }}" placeholder="Enter amount earns">
        {!! $errors->first('amount_earns', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('accrue_period') ? 'has-error' : '' }}">
    <label for="accrue_period">Accrue Period</label>
        <input class="form-control" name="accrue_period" type="text" id="accrue_period" value="{{ old('accrue_period', optional($absenceType)->accrue_period) }}" placeholder="Enter accrue period">
        {!! $errors->first('accrue_period', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-6 {{ $errors->has('eligilibity_begins') ? 'has-error' : '' }}">
    <label for="eligilibity_begins">Eligilibity Begins</label>
        <input class="form-control datepicker" name="eligilibity_begins" type="text" id="eligilibity_begins" value="{{ old('eligilibity_begins', optional($absenceType)->eligilibity_begins) }}" placeholder="Enter eligilibity begins">
        {!! $errors->first('eligilibity_begins', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-6 {{ $errors->has('eligibility_ends') ? 'has-error' : '' }}">
    <label for="eligibility_ends">Eligibility Ends</label>
        <input class="form-control datepicker" name="eligibility_ends" type="text" id="eligibility_ends" value="{{ old('eligibility_ends', optional($absenceType)->eligibility_ends) }}" placeholder="Enter eligibility ends">
        {!! $errors->first('eligibility_ends', '<p class="help-block">:message</p>') !!}
</div>

</div>