
<div class="form-group {{ $errors->has('employee_id') ? 'has-error' : '' }}">
    <label for="employee_id" class="col-md-2 control-label">Employee</label>
    <div class="col-md-10">
        <select class="form-control" id="employee_id" name="employee_id">
        	    <option value="" style="display: none;" {{ old('employee_id', isset($address->employee_id) ? $address->employee_id : '') == '' ? 'selected' : '' }} disabled selected>Select employee</option>
        	@foreach ($employees as $key => $employee)
			    <option value="{{ $key }}" {{ old('employee_id', isset($address->employee_id) ? $address->employee_id : null) == $key ? 'selected' : '' }}>
			    	{{ $employee }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('employee_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('unit_no') ? 'has-error' : '' }}">
    <label for="unit_no" class="col-md-2 control-label">Unit No</label>
    <div class="col-md-10">
        <input class="form-control" name="unit_no" type="text" id="unit_no" value="{{ old('unit_no', isset($address->unit_no) ? $address->unit_no : null) }}" placeholder="Enter unit no">
        {!! $errors->first('unit_no', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('complex') ? 'has-error' : '' }}">
    <label for="complex" class="col-md-2 control-label">Complex</label>
    <div class="col-md-10">
        <input class="form-control" name="complex" type="text" id="complex" value="{{ old('complex', isset($address->complex) ? $address->complex : null) }}" placeholder="Enter complex">
        {!! $errors->first('complex', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('addr_line_1') ? 'has-error' : '' }}">
    <label for="addr_line_1" class="col-md-2 control-label">Addr Line 1</label>
    <div class="col-md-10">
        <input class="form-control" name="addr_line_1" type="text" id="addr_line_1" value="{{ old('addr_line_1', isset($address->addr_line_1) ? $address->addr_line_1 : null) }}" placeholder="Enter addr line 1">
        {!! $errors->first('addr_line_1', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('addr_line_2') ? 'has-error' : '' }}">
    <label for="addr_line_2" class="col-md-2 control-label">Addr Line 2</label>
    <div class="col-md-10">
        <input class="form-control" name="addr_line_2" type="text" id="addr_line_2" value="{{ old('addr_line_2', isset($address->addr_line_2) ? $address->addr_line_2 : null) }}" placeholder="Enter addr line 2">
        {!! $errors->first('addr_line_2', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('addr_line_3') ? 'has-error' : '' }}">
    <label for="addr_line_3" class="col-md-2 control-label">Addr Line 3</label>
    <div class="col-md-10">
        <input class="form-control" name="addr_line_3" type="text" id="addr_line_3" value="{{ old('addr_line_3', isset($address->addr_line_3) ? $address->addr_line_3 : null) }}" placeholder="Enter addr line 3">
        {!! $errors->first('addr_line_3', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('addr_line_4') ? 'has-error' : '' }}">
    <label for="addr_line_4" class="col-md-2 control-label">Addr Line 4</label>
    <div class="col-md-10">
        <input class="form-control" name="addr_line_4" type="text" id="addr_line_4" value="{{ old('addr_line_4', isset($address->addr_line_4) ? $address->addr_line_4 : null) }}" placeholder="Enter addr line 4">
        {!! $errors->first('addr_line_4', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('city') ? 'has-error' : '' }}">
    <label for="city" class="col-md-2 control-label">City</label>
    <div class="col-md-10">
        <input class="form-control" name="city" type="text" id="city" value="{{ old('city', isset($address->city) ? $address->city : null) }}" minlength="1" placeholder="Enter city">
        {!! $errors->first('city', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('province') ? 'has-error' : '' }}">
    <label for="province" class="col-md-2 control-label">Province</label>
    <div class="col-md-10">
        <input class="form-control" name="province" type="text" id="province" value="{{ old('province', isset($address->province) ? $address->province : null) }}" placeholder="Enter province">
        {!! $errors->first('province', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('zip_code') ? 'has-error' : '' }}">
    <label for="zip_code" class="col-md-2 control-label">Zip Code</label>
    <div class="col-md-10">
        <input class="form-control" name="zip_code" type="text" id="zip_code" value="{{ old('zip_code', isset($address->zip_code) ? $address->zip_code : null) }}" placeholder="Enter zip code">
        {!! $errors->first('zip_code', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('country_id') ? 'has-error' : '' }}">
    <label for="country_id" class="col-md-2 control-label">Country</label>
    <div class="col-md-10">
        <select class="form-control" id="country_id" name="country_id">
        	    <option value="" style="display: none;" {{ old('country_id', isset($address->country_id) ? $address->country_id : '') == '' ? 'selected' : '' }} disabled selected>Enter country</option>
        	@foreach ($countries as $key => $country)
			    <option value="{{ $key }}" {{ old('country_id', isset($address->country_id) ? $address->country_id : null) == $key ? 'selected' : '' }}>
			    	{{ $country }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('country_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('addresstype_id') ? 'has-error' : '' }}">
    <label for="addresstype_id" class="col-md-2 control-label">Addresstype</label>
    <div class="col-md-10">
        <select class="form-control" id="addresstype_id" name="addresstype_id">
        	    <option value="" style="display: none;" {{ old('addresstype_id', isset($address->addresstype_id) ? $address->addresstype_id : '') == '' ? 'selected' : '' }} disabled selected>Select addresstype</option>
        	@foreach ($addresstypes as $key => $addresstype)
			    <option value="{{ $key }}" {{ old('addresstype_id', isset($address->addresstype_id) ? $address->addresstype_id : null) == $key ? 'selected' : '' }}>
			    	{{ $addresstype }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('addresstype_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('is_active') ? 'has-error' : '' }}">
    <label for="is_active" class="col-md-2 control-label">Is Active</label>
    <div class="col-md-10">
        <div class="checkbox">
            <label for="is_active_1">
            	<input id="is_active_1" class="" name="is_active" type="checkbox" value="1" {{ old('is_active', isset($address->is_active) ? $address->is_active : null) == '1' ? 'checked' : '' }}>
                Yes
            </label>
        </div>

        {!! $errors->first('is_active', '<p class="help-block">:message</p>') !!}
    </div>
</div>

