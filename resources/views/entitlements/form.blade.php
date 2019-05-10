<div class="row">

<div class="form-group col-xs-12 {{ $errors->has('leave_policy') ? 'has-error' : '' }}">
    <label for="duration_unit">Leave Policy</label>
    <select class="form-control" id="leave_policy" name="leave_policy" required="true" {!! ($mode =='edit')?'disabled':'' !!}>
        <option value="" style="display: none;" {{ old('leave_policy', optional($entitlement)->absence_type_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select Leave Policy</option>
        @foreach ($leave_policies as $key => $leave_policy)
            <option value="{{ $key }}" {{ old('leave_policy', optional($entitlement)->absence_type_id) == $key ? 'selected' : '' }}>
                {{ $leave_policy }}
            </option>
        @endforeach
    </select>
    {!! $errors->first('leave_policy', '<p class="help-block">:message</p>') !!}
</div>
    
<div class="form-group col-xs-6 {{ $errors->has('start_date') ? 'has-error' : '' }}">
    <label for="start_date">Start Date</label>
        <input class="form-control datepicker" name="start_date" type="text" id="start_date" {!! ($mode =='edit')?'disabled':'' !!} value="{{ old('start_date', optional($entitlement)->start_date) }}" placeholder="Enter start date here..." required="true">
        {!! $errors->first('start_date', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-6 {{ $errors->has('end_date') ? 'has-error' : '' }}">
    <label for="end_date">End Date</label>
        <input class="form-control datepicker" name="end_date" type="text" id="end_date" {!! ($mode =='edit')?'disabled':'' !!} value="{{ old('end_date', optional($entitlement)->end_date) }}" placeholder="Enter end date here..." required="true">
        {!! $errors->first('end_date', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-6 {{ $errors->has('total') ? 'has-error' : '' }}">
    <label for="total">Total</label>
        <input class="form-control" name="total" type="number" id="total" {!! (!is_null($employee_id) && $employee_id == optional($data)->employee_id) ?'disabled':'' !!} value="{{ old('total', optional($entitlement)->total) }}" placeholder="Enter total here..." required="true">
        {!! $errors->first('total', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-6 {{ $errors->has('taken') ? 'has-error' : '' }}">
    <label for="taken">Taken</label>
        <input class="form-control" name="taken" type="number" id="taken"  {!! (!is_null($employee_id) && $employee_id == optional($data)->employee_id) ?'disabled':'' !!} value="{{ old('taken', optional($entitlement)->taken) }}" minlength="1" placeholder="Enter taken here...">
        {!! $errors->first('taken', '<p class="help-block">:message</p>') !!}
</div>

<div id="date-picker"> </div>

</div>