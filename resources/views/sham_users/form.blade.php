<div class="row">
    
<div class="form-group col-xs-12 {{ $errors->has('username') ? 'has-error' : '' }}">
    <label for="username">Username</label>
        <input class="form-control" name="username" type="text" id="username" value="{{ old('username', optional($shamUser)->username) }}" minlength="1" maxlength="100" required="true" placeholder="Enter username">
        {!! $errors->first('username', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('password') ? 'has-error' : '' }}">
    <label for="password">Password</label>
        <input class="form-control" name="password" type="password" id="password" value="{{ old('password', optional($shamUser)->password) }}" placeholder="Enter password">
        {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('email_address') ? 'has-error' : '' }}">
    <label for="email_address">Email Address</label>
        <input class="form-control" name="email_address" type="email" id="email_address" value="{{ old('email_address', optional($shamUser)->email_address) }}" placeholder="Enter email address">
        {!! $errors->first('email_address', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('cell_number') ? 'has-error' : '' }}">
    <label for="cell_number">Cell Number</label>
        <input class="form-control" name="cell_number" type="number" id="cell_number" value="{{ old('cell_number', optional($shamUser)->cell_number) }}" placeholder="Enter cell number">
        {!! $errors->first('cell_number', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('ShamUserProfileId') ? 'has-error' : '' }}">
    <label for="ShamUserProfileId">Sham User Profile</label>
        <select class="form-control" id="ShamUserProfileId" name="ShamUserProfileId" required="true">
        	    <option value="" style="display: none;" {{ old('ShamUserProfileId', optional($shamUser)->ShamUserProfileId ?: '') == '' ? 'selected' : '' }} disabled selected>Select Sham User Profile</option>
        	@foreach ($ShamUserProfileIds as $key => $ShamUserProfileId)
			    <option value="{{ $key }}" {{ old('ShamUserProfileId', optional($shamUser)->ShamUserProfileId) == $key ? 'selected' : '' }}>
			    	{{ $ShamUserProfileId }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('ShamUserProfileId', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('employee_id') ? 'has-error' : '' }}">
    <label for="employee_id">Employee</label>
        <select class="form-control" id="employee_id" name="employee_id">
        	    <option value="" style="display: none;" {{ old('employee_id', optional($shamUser)->employee_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select Employee</option>
        	@foreach ($employee_ids as $key => $employee_id)
			    <option value="{{ $key }}" {{ old('employee_id', optional($shamUser)->employee_id) == $key ? 'selected' : '' }}>
			    	{{ $employee_id }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('employee_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('silence_start') ? 'has-error' : '' }}">
    <label for="silence_start">Silence Start</label>
        <input class="form-control datepicker" name="silence_start" type="text" id="silence_start" value="{{ old('silence_start', optional($shamUser)->silence_start) }}" minlength="1" placeholder="Enter silence start" data-enable-time="true" data-no-calendar="true">
        {!! $errors->first('silence_start', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('silence_end') ? 'has-error' : '' }}">
    <label for="silence_end">Silence End</label>
        <input class="form-control datepicker" name="silence_end" type="text" id="silence_end" value="{{ old('silence_end', optional($shamUser)->silence_end) }}" minlength="1" placeholder="Enter silence end">
        {!! $errors->first('silence_end', '<p class="help-block">:message</p>') !!}
</div>

</div>