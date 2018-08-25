<div class="row">
    
<div class="form-group col-xs-12 {{ $errors->has('title_id') ? 'has-error' : '' }}">
    <label for="title_id">Title</label>
        <select class="form-control" id="title_id" name="title_id">
        	    <option value="" style="display: none;" {{ old('title_id', isset($employee->title_id) ? $employee->title_id : '') == '' ? 'selected' : '' }} disabled selected>Select title</option>
        	@foreach ($titles as $key => $title)
			    <option value="{{ $key }}" {{ old('title_id', isset($employee->title_id) ? $employee->title_id : null) == $key ? 'selected' : '' }}>
			    	{{ $title }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('title_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('initials') ? 'has-error' : '' }}">
    <label for="initials">Initials</label>
        <input class="form-control" name="initials" type="text" id="initials" value="{{ old('initials', isset($employee->initials) ? $employee->initials : null) }}" maxlength="10" placeholder="Enter initials">
        {!! $errors->first('initials', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('first_name') ? 'has-error' : '' }}">
    <label for="first_name">First Name</label>
        <input class="form-control" name="first_name" type="text" id="first_name" value="{{ old('first_name', isset($employee->first_name) ? $employee->first_name : null) }}" maxlength="50" placeholder="Enter first name">
        {!! $errors->first('first_name', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('surname') ? 'has-error' : '' }}">
    <label for="surname">Surname</label>
        <input class="form-control" name="surname" type="text" id="surname" value="{{ old('surname', isset($employee->surname) ? $employee->surname : null) }}" maxlength="50" placeholder="Enter surname">
        {!! $errors->first('surname', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('known_as') ? 'has-error' : '' }}">
    <label for="known_as">Known As</label>
        <input class="form-control" name="known_as" type="text" id="known_as" value="{{ old('known_as', isset($employee->known_as) ? $employee->known_as : null) }}" maxlength="50" placeholder="Enter known as">
        {!! $errors->first('known_as', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('birth_date') ? 'has-error' : '' }}">
    <label for="birth_date">Birth Date</label>
        <input class="form-control" name="birth_date" type="text" id="birth_date" value="{{ old('birth_date', isset($employee->birth_date) ? $employee->birth_date : null) }}" placeholder="Enter birth date">
        {!! $errors->first('birth_date', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('marital_status_id') ? 'has-error' : '' }}">
    <label for="marital_status_id">Marital Status</label>
        <select class="form-control" id="marital_status_id" name="marital_status_id">
        	    <option value="" style="display: none;" {{ old('marital_status_id', isset($employee->marital_status_id) ? $employee->marital_status_id : '') == '' ? 'selected' : '' }} disabled selected>Select marital status</option>
        	@foreach ($maritalstatuses as $key => $maritalstatus)
			    <option value="{{ $key }}" {{ old('marital_status_id', isset($employee->marital_status_id) ? $employee->marital_status_id : null) == $key ? 'selected' : '' }}>
			    	{{ $maritalstatus }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('marital_status_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('id_number') ? 'has-error' : '' }}">
    <label for="id_number">Id Number</label>
        <input class="form-control" name="id_number" type="text" id="id_number" value="{{ old('id_number', isset($employee->id_number) ? $employee->id_number : null) }}" min="1" max="50" required="true" placeholder="Enter id number">
        {!! $errors->first('id_number', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('passport_country_id') ? 'has-error' : '' }}">
    <label for="passport_country_id">Passport Country</label>
        <select class="form-control" id="passport_country_id" name="passport_country_id">
        	    <option value="" style="display: none;" {{ old('passport_country_id', isset($employee->passport_country_id) ? $employee->passport_country_id : '') == '' ? 'selected' : '' }} disabled selected>Enter passport country</option>
        	@foreach ($countries as $key => $country)
			    <option value="{{ $key }}" {{ old('passport_country_id', isset($employee->passport_country_id) ? $employee->passport_country_id : null) == $key ? 'selected' : '' }}>
			    	{{ $country }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('passport_country_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('nationality') ? 'has-error' : '' }}">
    <label for="nationality">Nationality</label>
        <input class="form-control" name="nationality" type="text" id="nationality" value="{{ old('nationality', isset($employee->nationality) ? $employee->nationality : null) }}" maxlength="50" placeholder="Enter nationality">
        {!! $errors->first('nationality', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('language_id') ? 'has-error' : '' }}">
    <label for="language_id">Language</label>
        <select class="form-control" id="language_id" name="language_id">
        	    <option value="" style="display: none;" {{ old('language_id', isset($employee->language_id) ? $employee->language_id : '') == '' ? 'selected' : '' }} disabled selected>Enter language</option>
        	@foreach ($languages as $key => $language)
			    <option value="{{ $key }}" {{ old('language_id', isset($employee->language_id) ? $employee->language_id : null) == $key ? 'selected' : '' }}>
			    	{{ $language }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('language_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('gender_id') ? 'has-error' : '' }}">
    <label for="gender_id">Gender</label>
        <select class="form-control" id="gender_id" name="gender_id">
        	    <option value="" style="display: none;" {{ old('gender_id', isset($employee->gender_id) ? $employee->gender_id : '') == '' ? 'selected' : '' }} disabled selected>Select gender</option>
        	@foreach ($genders as $key => $gender)
			    <option value="{{ $key }}" {{ old('gender_id', isset($employee->gender_id) ? $employee->gender_id : null) == $key ? 'selected' : '' }}>
			    	{{ $gender }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('gender_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('ethnic_group_id') ? 'has-error' : '' }}">
    <label for="ethnic_group_id">Ethnic Group</label>
        <select class="form-control" id="ethnic_group_id" name="ethnic_group_id">
        	    <option value="" style="display: none;" {{ old('ethnic_group_id', isset($employee->ethnic_group_id) ? $employee->ethnic_group_id : '') == '' ? 'selected' : '' }} disabled selected>Select ethnic group</option>
        	@foreach ($ethnicGroups as $key => $ethnicGroup)
			    <option value="{{ $key }}" {{ old('ethnic_group_id', isset($employee->ethnic_group_id) ? $employee->ethnic_group_id : null) == $key ? 'selected' : '' }}>
			    	{{ $ethnicGroup }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('ethnic_group_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('immigration_status_id') ? 'has-error' : '' }}">
    <label for="immigration_status_id">Immigration Status</label>
        <select class="form-control" id="immigration_status_id" name="immigration_status_id">
        	    <option value="" style="display: none;" {{ old('immigration_status_id', isset($employee->immigration_status_id) ? $employee->immigration_status_id : '') == '' ? 'selected' : '' }} disabled selected>Select immigration status</option>
        	@foreach ($immigrationStatuses as $key => $immigrationStatus)
			    <option value="{{ $key }}" {{ old('immigration_status_id', isset($employee->immigration_status_id) ? $employee->immigration_status_id : null) == $key ? 'selected' : '' }}>
			    	{{ $immigrationStatus }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('immigration_status_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('passport_no') ? 'has-error' : '' }}">
    <label for="passport_no">Passport No</label>
        <input class="form-control" name="passport_no" type="text" id="passport_no" value="{{ old('passport_no', isset($employee->passport_no) ? $employee->passport_no : null) }}" maxlength="50" placeholder="Enter passport no">
        {!! $errors->first('passport_no', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('spouse_full_name') ? 'has-error' : '' }}">
    <label for="spouse_full_name">Spouse Full Name</label>
        <input class="form-control" name="spouse_full_name" type="text" id="spouse_full_name" value="{{ old('spouse_full_name', isset($employee->spouse_full_name) ? $employee->spouse_full_name : null) }}" maxlength="50" placeholder="Enter spouse full name">
        {!! $errors->first('spouse_full_name', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('employee_no') ? 'has-error' : '' }}">
    <label for="employee_no">Employee No</label>
        <input class="form-control" name="employee_no" type="text" id="employee_no" value="{{ old('employee_no', isset($employee->employee_no) ? $employee->employee_no : null) }}" minlength="1" maxlength="50" required="true" placeholder="Enter employee no">
        {!! $errors->first('employee_no', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('employee_code') ? 'has-error' : '' }}">
    <label for="employee_code">Employee Code</label>
        <input class="form-control" name="employee_code" type="text" id="employee_code" value="{{ old('employee_code', isset($employee->employee_code) ? $employee->employee_code : null) }}" minlength="1" maxlength="50" required="true" placeholder="Enter employee code">
        {!! $errors->first('employee_code', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('tax_number') ? 'has-error' : '' }}">
    <label for="tax_number">Tax Number</label>
        <input class="form-control" name="tax_number" type="text" id="tax_number" value="{{ old('tax_number', isset($employee->tax_number) ? $employee->tax_number : null) }}" min="0" max="50" placeholder="Enter tax number">
        {!! $errors->first('tax_number', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('tax_status_id') ? 'has-error' : '' }}">
    <label for="tax_status_id">Tax Status</label>
        <select class="form-control" id="tax_status_id" name="tax_status_id">
        	    <option value="" style="display: none;" {{ old('tax_status_id', isset($employee->tax_status_id) ? $employee->tax_status_id : '') == '' ? 'selected' : '' }} disabled selected>Select tax status</option>
        	@foreach ($taxstatuses as $key => $taxstatus)
			    <option value="{{ $key }}" {{ old('tax_status_id', isset($employee->tax_status_id) ? $employee->tax_status_id : null) == $key ? 'selected' : '' }}>
			    	{{ $taxstatus }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('tax_status_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('date_joined') ? 'has-error' : '' }}">
    <label for="date_joined">Date Joined</label>
        <input class="form-control" name="date_joined" type="text" id="date_joined" value="{{ old('date_joined', isset($employee->date_joined) ? $employee->date_joined : null) }}" placeholder="Enter date joined">
        {!! $errors->first('date_joined', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('date_terminated') ? 'has-error' : '' }}">
    <label for="date_terminated">Date Terminated</label>
        <input class="form-control" name="date_terminated" type="text" id="date_terminated" value="{{ old('date_terminated', isset($employee->date_terminated) ? $employee->date_terminated : null) }}" placeholder="Enter date terminated">
        {!! $errors->first('date_terminated', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('department_id') ? 'has-error' : '' }}">
    <label for="department_id">Department</label>
        <select class="form-control" id="department_id" name="department_id">
        	    <option value="" style="display: none;" {{ old('department_id', isset($employee->department_id) ? $employee->department_id : '') == '' ? 'selected' : '' }} disabled selected>Select department</option>
        	@foreach ($departments as $key => $department)
			    <option value="{{ $key }}" {{ old('department_id', isset($employee->department_id) ? $employee->department_id : null) == $key ? 'selected' : '' }}>
			    	{{ $department }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('department_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('team_id') ? 'has-error' : '' }}">
    <label for="team_id">Team</label>
        <select class="form-control" id="team_id" name="team_id">
        	    <option value="" style="display: none;" {{ old('team_id', isset($employee->team_id) ? $employee->team_id : '') == '' ? 'selected' : '' }} disabled selected>Select team</option>
        	@foreach ($teams as $key => $team)
			    <option value="{{ $key }}" {{ old('team_id', isset($employee->team_id) ? $employee->team_id : null) == $key ? 'selected' : '' }}>
			    	{{ $team }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('team_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('employee_status_id') ? 'has-error' : '' }}">
    <label for="employee_status_id">Employee Status</label>
        <select class="form-control" id="employee_status_id" name="employee_status_id">
        	    <option value="" style="display: none;" {{ old('employee_status_id', isset($employee->employee_status_id) ? $employee->employee_status_id : '') == '' ? 'selected' : '' }} disabled selected>Select employee status</option>
        	@foreach ($employeeStatuses as $key => $employeeStatus)
			    <option value="{{ $key }}" {{ old('employee_status_id', isset($employee->employee_status_id) ? $employee->employee_status_id : null) == $key ? 'selected' : '' }}>
			    	{{ $employeeStatus }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('employee_status_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('physical_file_no') ? 'has-error' : '' }}">
    <label for="physical_file_no">Physical File No</label>
        <input class="form-control" name="physical_file_no" type="text" id="physical_file_no" value="{{ old('physical_file_no', isset($employee->physical_file_no) ? $employee->physical_file_no : null) }}" maxlength="50" placeholder="Enter physical file no">
        {!! $errors->first('physical_file_no', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('job_title_id') ? 'has-error' : '' }}">
    <label for="job_title_id">Job Title</label>
        <select class="form-control" id="job_title_id" name="job_title_id">
        	    <option value="" style="display: none;" {{ old('job_title_id', isset($employee->job_title_id) ? $employee->job_title_id : '') == '' ? 'selected' : '' }} disabled selected>Select job title</option>
        	@foreach ($jobTitles as $key => $jobTitle)
			    <option value="{{ $key }}" {{ old('job_title_id', isset($employee->job_title_id) ? $employee->job_title_id : null) == $key ? 'selected' : '' }}>
			    	{{ $jobTitle }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('job_title_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('division_id') ? 'has-error' : '' }}">
    <label for="division_id">Division</label>
        <select class="form-control" id="division_id" name="division_id">
        	    <option value="" style="display: none;" {{ old('division_id', isset($employee->division_id) ? $employee->division_id : '') == '' ? 'selected' : '' }} disabled selected>Select division</option>
        	@foreach ($divisions as $key => $division)
			    <option value="{{ $key }}" {{ old('division_id', isset($employee->division_id) ? $employee->division_id : null) == $key ? 'selected' : '' }}>
			    	{{ $division }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('division_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('branch_id') ? 'has-error' : '' }}">
    <label for="branch_id">Branch</label>
        <select class="form-control" id="branch_id" name="branch_id">
        	    <option value="" style="display: none;" {{ old('branch_id', isset($employee->branch_id) ? $employee->branch_id : '') == '' ? 'selected' : '' }} disabled selected>Select branch</option>
        	@foreach ($branches as $key => $branch)
			    <option value="{{ $key }}" {{ old('branch_id', isset($employee->branch_id) ? $employee->branch_id : null) == $key ? 'selected' : '' }}>
			    	{{ $branch }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('branch_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('picture') ? 'has-error' : '' }}">
    <label for="picture">Picture</label>
        <input class="form-control" name="picture" type="text" id="picture" value="{{ old('picture', isset($employee->picture) ? $employee->picture : null) }}" maxlength="4294967295">
        {!! $errors->first('picture', '<p class="help-block">:message</p>') !!}
</div>

{{-- 
<div class="form-group col-xs-12 {{ $errors->has('line_manager_id') ? 'has-error' : '' }}">
    <label for="line_manager_id">Line Manager</label>
    {!! Form::select("line_manager_id", $lineManagers, isset($employee->line_manager_id) ? $employee->line_manager_id : null, array('class' => 'form-control')) !!}
    {!! $errors->first('line_manager_id', '<p class="help-block">:message</p>') !!}
</div>
--}}
</div>