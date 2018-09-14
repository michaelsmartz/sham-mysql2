<div class="row">
    
<div class="form-group col-xs-12 {{ $errors->has('description') ? 'has-error' : '' }}">
    <label for="description">Description</label>
        <input class="form-control" name="description" type="text" id="description" value="{{ old('description', optional($team)->description) }}" minlength="1" maxlength="50" required="true" placeholder="Enter description">
        {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('time_group_id') ? 'has-error' : '' }}">
    <label for="time_group_id">Time Group</label>
        <select class="form-control" id="time_group_id" name="time_group_id">
        	    <option value="" style="display: none;" {{ old('time_group_id', optional($team)->time_group_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select time group</option>
        	@foreach ($time_groups as $key => $time_group)
			    <option value="{{ $key }}" {{ old('time_group_id', optional($team)->time_group_id) == $key ? 'selected' : '' }}>
			    	{{ $time_group }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('time_group_id', '<p class="help-block">:message</p>') !!}
</div>

</div>