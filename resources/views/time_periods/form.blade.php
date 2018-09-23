<div class="row">
    
<div class="form-group col-xs-12 {{ $errors->has('description') ? 'has-error' : '' }}">
    <label for="description">Description</label>
        <input class="form-control" name="description" type="text" id="description" value="{{ old('description', optional($timePeriod)->description) }}" minlength="1" maxlength="50" required="true" placeholder="Enter description">
        {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('start_time') ? 'has-error' : '' }}">
    <label for="start_time">Start Time</label>
        <input class="form-control timepicker" name="start_time" type="text" id="start_time" value="{{ old('start_time', optional($timePeriod)->start_time) }}" minlength="1" required="true" placeholder="Enter start time">
        {!! $errors->first('start_time', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('end_time') ? 'has-error' : '' }}">
    <label for="end_time">End Time</label>
        <input class="form-control timepicker" name="end_time" type="text" id="end_time" value="{{ old('end_time', optional($timePeriod)->end_time) }}" minlength="1" required="true" placeholder="Enter end time">
        {!! $errors->first('end_time', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('time_period_type') ? 'has-error' : '' }}">
    <label for="time_period_type">Time Period Type</label>
        <select class="form-control" id="time_period_type" name="time_period_type">
        	    <option value="" style="display: none;" {{ old('time_period_type', optional($timePeriod)->time_period_type ?: '') == '' ? 'selected' : '' }} disabled selected>Select time period type</option>
        	@foreach (['Shift' => 'Shift',
'Break' => 'Break'] as $key => $text)
			    <option value="{{ $key }}" {{ old('time_period_type', optional($timePeriod)->time_period_type) == $key ? 'selected' : '' }}>
			    	{{ $text }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('time_period_type', '<p class="help-block">:message</p>') !!}
</div>

</div>