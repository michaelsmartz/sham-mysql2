<div class="row">

<div class="form-group col-xs-12 {{ $errors->has('description') ? 'has-error' : '' }}">
    <label for="description">Description</label>
        <input class="form-control" name="description" type="text" id="description" value="{{ old('description', optional($reward)->description) }}" minlength="1" maxlength="50" required="true" placeholder="Enter description">
        {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('rewarded_by') ? 'has-error' : '' }}">
    <label for="rewarded_by">Rewarded By</label>
        <input class="form-control" name="rewarded_by" type="text" id="rewarded_by" value="{{ old('rewarded_by', optional($reward)->rewarded_by) }}" min="1" max="100" required="true" placeholder="Enter rewarded by">
        {!! $errors->first('rewarded_by', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-6 {{ $errors->has('employee_id') ? 'has-error' : '' }}">
    <label for="employee_id">Employee</label>
        <select class="form-control" id="employee_id" name="employee_id">
        	    <option value="" style="display: none;" {{ old('employee_id', optional($reward)->employee_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select employee</option>
        	@foreach ($employees as $key => $employee)
			    <option value="{{ $key }}" {{ old('employee_id', optional($reward)->employee_id) == $key ? 'selected' : '' }}>
			    	{{ $employee }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('employee_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-6 {{ $errors->has('date_received') ? 'has-error' : '' }}">
    <label for="date_received">Date Received</label>
        <input class="form-control datepicker" name="date_received" type="text" id="date_received" value="{{ old('date_received', optional($reward)->date_received) }}" placeholder="Enter date received">
        {!! $errors->first('date_received', '<p class="help-block">:message</p>') !!}
</div>

</div>