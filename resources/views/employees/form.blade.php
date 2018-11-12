@php
    //if(sizeof($errors) > 0){ dump($errors->bags);}
    $groups = [];
    foreach ($jobTitles as $model) {
        $groups[$model->description][$model->id] = ['name' => $model->full_name, 'manager_id' => $model->employee_id];
    }
    //dump($groups);
@endphp

{!! Form::hidden('redirectsTo', URL::previous()) !!}

<div class="position-center" id="accordion-app">
    <ul data-direction="vertical" data-multiple="true" data-initial-index="[0,1,2]" data-event="click" class="accordion accordion--box accordion--vertical">
        <li class="accordion__panel">
            <span class="accordion__heading">Personal<i class="-icon -icon--right" data-wenk-pos="left" data-wenk="Click to expand/collapse this section"></i></span>
            <div class="accordion__expander">
                <div class="form-group">
                    <div class="col-xs-2">
                        <div class="avatar-upload">
                            <div class="avatar-edit">
                                <input type='file' name="profile_pic" id="imageUpload" accept=".png, .jpg, .jpeg" />
                                <label for="imageUpload" title="change profile image"></label>
                            </div>
                            <div class="avatar-preview">
                                <div id="imagePreview" style="background-image: url({{$employee->picture}});">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                    <span class="field">
                        {!! Form::text('birth_date', old('birth_date', isset($employee->birth_date) ? $employee->birth_date : null), ['class'=>'form-control datepicker field-required', 'minage'=>'18', 'autocomplete'=>'off', 'placeholder'=>'Date Of Birth', 'required', 'title'=>'Required', 'id'=>'birth_date']) !!}
                        <label for="birth_date">Date of birth</label>
                    </span>
                    </div>
                    <div class="col-sm-2">
                        {!! Form::select('gender_id', $genders, old('gender_id', isset($employee->gender_id) ? $employee->gender_id : null), ['class'=>'form-control field-required', 'autocomplete'=>'off', 'placeholder'=>'Gender..', 'required', 'title'=>'Required', 'data-parsley-trigger'=>'focusout']) !!}
                    </div>
                    <div class="col-sm-2">
                        {!! Form::select('title_id', $titles, old('title_id', isset($employee->title_id) ? $employee->title_id : null), ['class'=>'form-control field-required', 'autocomplete'=>'off', 'placeholder'=>'Title..', 'data-field-name'=>'Title', 'required', 'title'=>'Required', 'data-parsley-trigger'=>'focusout']) !!}
                    </div>
                    <div class="col-sm-3">
                        {!! Form::select('marital_status_id', $maritalstatuses, old('marital_status_id', isset($employee->marital_status_id) ? $employee->marital_status_id : null), ['id' =>'marital_status_id', 'name'=>'marital_status_id', 'class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>'Marital Status..']) !!}
                    </div>
                </div>
                <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
                    <label class="col-xs-2 control-label"></label>
                    <div class="col-sm-3">
                        <span class="field">
                            {!! Form::text('first_name', old('first_name', isset($employee->first_name) ? $employee->first_name : null), ['class'=>'form-control fix-case field-required', 'autocomplete'=>'off', 'placeholder'=>'First Name', 'required', 'title'=>'Required','id'=>'first_name', 'data-parsley-pattern' => '^[a-zA-ZÀ-ÖØ-öø-ÿ\-]+( [a-zA-ZÀ-ÖØ-öø-ÿ]+)*$', 'maxlength' => '50', 'data-parsley-trigger'=>'focusout']) !!}
                            <label for="first_name">First Name</label>
                        </span>
                        {!! $errors->first('first_name', '<p class="help-block">:message</p>') !!}
                    </div>
                    <div class="col-sm-3">
                        {!! Form::text('known_as', old('known_as', isset($employee->known_as) ? $employee->known_as : null), ['class'=>'form-control fix-case title-case', 'autocomplete'=>'off', 'placeholder'=>'Second/Other names', 'pattern' => '^[a-zA-ZÀ-ÖØ-öø-ÿ\-]+( [a-zA-ZÀ-ÖØ-öø-ÿ]+)*$', 'maxlength' => '50']) !!}
                    </div>
                    <div class="col-sm-4">
                    <span class="field">
                        {!! Form::text('surname', old('surname', isset($employee->surname) ? $employee->surname : null), ['class'=>'form-control fix-case field-required', 'autocomplete'=>'off', 'placeholder'=>'Surname', 'required', 'title'=>'Required','id'=>'surname', 'pattern' => '^[a-zA-ZÀ-ÖØ-öø-ÿ\-]+( [a-zA-ZÀ-ÖØ-öø-ÿ]+)*$', 'maxlength' => '50']) !!}
                        <label for="surname">Surname</label>
                    </span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-2 control-label"></label>
                    <div class="col-sm-3">
                        {!! Form::select('passport_country_id', $countries, old('passport_country_id', isset($employee->passport_country_id) ? $employee->passport_country_id : null), ['class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>'Passport Country..', 'id'=>'passport_country_id']) !!}
                    </div>
                    <div class="col-sm-3">
                    <span class="field">
                        {!! Form::text('passport_no', old('passport_no', isset($employee->passport_no) ? $employee->passport_no : null), ['class'=>'form-control', 'dependsOnFieldNotEmpty'=>'passport_country_id', 'autocomplete'=>'off', 'placeholder'=>'Passport No', 'maxlength' => '50',
                                'data-parsley-validate-if-empty'=>'true',
                                'data-parsley-required-if'=>'#passport_country_id',
                                'data-parsley-trigger'=>'focusout',
                                'data-parsley-remote',
                                'data-parsley-remote-validator'=>'checkPassport',
                                'data-parsley-remote-message'=>'Passport Number is already in use'])
                        !!}
                        <label for="passport_no">Passport No</label>
                    </span>
                    </div>
                    <div class="col-sm-4">
                        {!! Form::select('immigration_status_id', $immigrationStatuses, old('immigration_status_id', isset($employee->immigration_status_id) ? $employee->immigration_status_id : null), ['class'=>'form-control', 'dependsOnFieldNotEmpty'=>'passport_country_id', 'autocomplete'=>'off', 'placeholder'=>'Immigration Status..']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-2 control-label"></label>
                    <div class="col-sm-3">
                    <span class="field">
                        {!! Form::text('id_number', old('id_number', isset($employee->id_number) ? $employee->id_number : null), ['class'=>'form-control field-required', 'autocomplete'=>'off', 'placeholder'=>'ID Number',
                                'required', 'title' => 'Required', 'id' => 'id_number', 'maxlength' => '50',
                                'data-parsley-trigger' => 'focusout',
                                'data-parsley-remote',
                                'data-parsley-remote-validator'=>'checkId',
                                'data-parsley-remote-message' => 'Id Number is already in use']) !!}
                        <label for="id_number">ID Number</label>
                    </span>
                    </div>
                    <div class="col-sm-3">
                    <span class="field">
                        {!! Form::text('nationality', old('nationality', isset($employee->nationality) ? $employee->nationality : null),['class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>'Nationality', 'maxlength' => '50']) !!}
                        <label for="nationality">Nationality</label>
                    </span>
                    </div>
                    <div class="col-sm-4">
                        {!! Form::select('ethnic_group_id', $ethnicGroups, old('ethnic_group_id', isset($employee->ethnic_group_id) ? $employee->ethnic_group_id : null), ['class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>'Ethnic Group..']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-2 control-label">Phones</label>
                    <input type="hidden" name="homePhone[telephone_number_type_id]" value="1">
                    <input type="hidden" name="mobilePhone[telephone_number_type_id]" value="2">
                    <input type="hidden" name="workPhone[telephone_number_type_id]" value="3">
                    <div class="col-sm-3">
                        <span class="field">
                            {!! Form::text('mobilePhone[tel_number]', old('mobilePhone[tel_number]', isset($employee->mobilePhone->tel_number) ? $employee->mobilePhone->tel_number : null), ['class'=>'form-control field-required', 'autocomplete'=>'off', 'id'=>'cell', 'placeholder'=>'Mobile', 'required', 'title'=>'Required', 'data-parsley-pattern'=>"^[\d\+\-\.\(\)\/\s]*$", 'data-filter'=>"([A-Z]{0,3}|[A-Z]{3}[0-9]*)" ]) !!}
                            <label for="mobilePhone[tel_number]">Mobile Phone</label>
                        </span>
                    </div>
                    <div class="col-sm-3">
                        <span class="field">
                            {!! Form::text('workPhone[tel_number]', old('workPhone[tel_number]', isset($employee->workPhone->tel_number) ? $employee->workPhone->tel_number : null), ['class'=>'form-control field-required', 'autocomplete'=>'off', 'id'=>'emergency', 'placeholder'=>'Emergency Contact', 'required', 'title'=>'Required', 'data-parsley-pattern'=>"^[\d\+\-\.\(\)\/\s]*$", 'data-filter'=>'(\d\+\-\.\(\)\/\s)' ]) !!}
                            <label for="workPhone[tel_number]">Emergency Contact</label>
                        </span>
                    </div>
                    <div class="col-sm-4">
                        <span class="field">
                            {!! Form::text('homePhone[tel_number]', old('homePhone[tel_number]', isset($employee->homePhone->tel_number) ? $employee->homePhone->tel_number : null), ['class'=>'form-control', 'autocomplete'=>'off', 'id'=>'phone', 'placeholder'=>'Home']) !!}
                            <label for="homePhone[tel_number]">Home Phone</label>
                        </span>
                    </div>
                </div>
            </div>
        </li>
        <li class="accordion__panel">
            <span class="accordion__heading">Address/Contact<i class="-icon -icon--right" data-wenk-pos="left" data-wenk="Click to expand/collapse this section"></i></span>
            <div class="accordion__expander">

                <div class="form-group">
                    <label class="col-xs-2 control-label">Email Addresses</label>
                    <div class="col-sm-5">
                        <span class="field">
                            {!! Form::email('privateEmail[email_address]', old('privateEmail[email_address]', isset($employee->privateEmail->email_address) ? $employee->privateEmail->email_address : null), ['class'=>'form-control email', 'autocomplete'=>'off', 'placeholder'=>'Private Email']) !!}
                            <label for="privateEmail[email_address]">Private Email</label>
                        </span>
                    </div>
                    <div class="col-sm-5">
                        <span class="field">
                            {!! Form::email('workEmail[email_address]', old('workEmail[email_address]', isset($employee->workEmail->email_address) ? $employee->workEmail->email_address : null), ['class'=>'form-control email', 'autocomplete'=>'off', 'placeholder'=>'Work Email']) !!}
                            <label for="workEmail[email_address]">Work Email</label>
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-2 control-label">Home Address</label>
                    <div class="col-sm-5">
                    <span class="field">
                        {!! Form::text('homeAddress[addr_line_1]', old('homeAddress[addr_line_1]', isset($employee->homeAddress->addr_line_1) ? $employee->homeAddress->addr_line_1 : null), ['class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>'Address Line 1', 'id'=>'homeaddr1', 'maxlength'=>'50', 'data-mirror'=>'#postaladdr1']) !!}
                        <label for="homeAddress[addr_line_1]">Address Line 1</label>
                    </span>
                    </div>
                    <div class="col-sm-5">
                    <span class="field">
                        {!! Form::text('homeAddress[addr_line_2]', old('homeAddress[addr_line_2]', isset($employee->homeAddress->addr_line_2) ? $employee->homeAddress->addr_line_2 : null), ['class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>'Address Line 2', 'id'=>'homeaddr2', 'maxlength'=>'50', 'data-mirror'=>'#postaladdr2']) !!}
                        <label for="homeAddress[addr_line_2]">Address Line 2</label>
                    </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-2 control-label"></label>
                    <div class="col-sm-5">
                        <span class="field">
                            {!! Form::text('homeAddress[addr_line_3]', old('homeAddress[addr_line_3]', isset($employee->homeAddress->addr_line_3) ? $employee->homeAddress->addr_line_3 : null), ['class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>'Address Line 3', 'id'=>'homeaddr3', 'maxlength'=>'50', 'data-mirror'=>'#postaladdr3']) !!}
                            <label for="homeAddress[addr_line_3]">Address Line 3</label>
                        </span>
                    </div>
                    <div class="col-sm-5">
                        <span class="field">
                            {!! Form::text('homeAddress[addr_line_4]', old('homeAddress[addr_line_4]', isset($employee->homeAddress->addr_line_4) ? $employee->homeAddress->addr_line_4 : null), ['class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>'Address Line 4', 'id'=>'homeaddr4', 'maxlength'=>'50', 'data-mirror'=>'#postaladdr4']) !!}
                            <label for="homeAddress[addr_line_4]">Address Line 4</label>
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-2 control-label"></label>
                    <div class="col-sm-3">
                        <span class="field">
                            {!! Form::text('homeAddress[city]', old('homeAddress[city]', isset($employee->homeAddress->city) ? $employee->homeAddress->city : null), ['class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>'City', 'id'=>'homecity', 'maxlength'=>'50', 'data-mirror'=>'#postalcity']) !!}
                            <label for="homeAddress[city]">City</label>
                        </span>
                    </div>
                    <div class="col-sm-2">
                        <span class="field">
                            {!! Form::text('homeAddress[province]', old('homeAddress[province]', isset($employee->homeAddress->province) ? $employee->homeAddress->province : null), ['class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>'Province', 'id'=>'homeprovince', 'maxlength'=>'50', 'data-mirror'=>'#postalprovince']) !!}
                            <label for="homeAddress[province]">Province</label>
                        </span>
                    </div>
                    <div class="col-sm-2">
                        <span class="field">
                            {!! Form::text('homeAddress[zip_code]', old('homeAddress[zip_code]', isset($employee->homeAddress->zip_code) ? $employee->homeAddress->zip_code : null), ['class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>'Zip', 'id'=>'homezip', 'data-mirror'=>'#postalzip']) !!}
                            <label for="homeAddress[zip_code]">Zip Code</label>
                        </span>
                    </div>
                    <div class="col-sm-3">
                        {!! Form::select('homeAddress[country_id]', $countries, old('homeAddress[country_id]', isset($employee->homeAddress->country_id) ? $employee->homeAddress->country_id : null), ['class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>'Country..', 'id'=>'homecountry', 'data-mirror'=>'#postalcountry']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-2 control-label">Postal Address</label>
                    <div class="col-sm-5">
                        <span class="field">
                            {!! Form::text('postalAddress[addr_line_1]', old('postalAddress[addr_line_1]', isset($employee->postalAddress->addr_line_1) ? $employee->postalAddress->addr_line_1 : null), ['class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>'Address Line 1', 'maxlength'=>'50', 'id'=>'postaladdr1']) !!}
                            <label for="postalAddress[addr_line_1]">Address Line 1</label>
                        </span>
                    </div>
                    <div class="col-sm-5">
                        <span class="field">
                            {!! Form::text('postalAddress[addr_line_2]', old('postalAddress[addr_line_2]', isset($employee->postalAddress->addr_line_2) ? $employee->postalAddress->addr_line_2 : null), ['class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>'Address Line 2', 'maxlength'=>'50', 'id'=>'postaladdr2']) !!}
                            <label for="postalAddress[addr_line_2]">Address Line 2</label>
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-2 control-label"></label>
                    <div class="col-sm-5">
                        <span class="field">
                            {!! Form::text('postalAddress[addr_line_3]', old('postalAddress[addr_line_3]', isset($employee->postalAddress->addr_line_3) ? $employee->postalAddress->addr_line_3 : null), ['class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>'Address Line 3', 'maxlength'=>'50', 'id'=>'postaladdr3']) !!}
                            <label for="postalAddress[addr_line_3]">Address Line 1</label>
                        </span>
                    </div>
                    <div class="col-sm-5">
                        <span class="field">
                            {!! Form::text('postalAddress[addr_line_4]', old('postalAddress[addr_line_4]', isset($employee->postalAddress->addr_line_4) ? $employee->postalAddress->addr_line_4 : null), ['class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>'Address Line 4', 'maxlength'=>'50', 'id'=>'postaladdr4']) !!}
                            <label for="postalAddress[addr_line_4]">Address Line 4</label>
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-2 control-label"></label>
                    <div class="col-sm-3">
                        <span class="field">
                            {!! Form::text('postalAddress[city]', old('postalAddress[city]', isset($employee->postalAddress->city) ? $employee->postalAddress->city : null), ['class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>'City', 'id'=>'postalcity', 'maxlength'=>'50']) !!}
                            <label for="postalAddress[city]">City</label>
                        </span>
                    </div>
                    <div class="col-sm-2">
                        <span class="field">
                            {!! Form::text('postalAddress[province]', old('postalAddress[province]', isset($employee->postalAddress->province) ? $employee->postalAddress->province : null), ['class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>'Province', 'id'=>'postalprovince', 'maxlength'=>'50']) !!}
                            <label for="postalAddress[province]">Province</label>
                        </span>
                    </div>
                    <div class="col-sm-2">
                        <span class="field">
                            {!! Form::text('postalAddress[zip_code]', old('postalAddress[zip_code]', isset($employee->postalAddress->zip_code) ? $employee->postalAddress->zip_code : null), ['class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>'Zip', 'id'=>'postalzip']) !!}
                            <label for="postalAddress[zip_code]">Zip Code</label>
                        </span>
                    </div>
                    <div class="col-sm-3">
                        {!! Form::select('postalAddress[country_id]', $countries, old('postalAddress[country_id]', isset($employee->postalAddress->country_id) ? $employee->postalAddress->country_id : null), ['class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>'Country..', 'id'=>'postalcountry']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-2 control-label">Next Of Kin</label>
                    <div class="col-sm-5">
                        {!! Form::text('spouse_full_name', old('spouse_full_name', isset($employee->spouse_full_name) ? $employee->spouse_full_name : null), ['class'=>'form-control fix-case', 'autocomplete'=>'off', 'placeholder'=>'Full Name', 'maxlength' => '50']) !!}
                    </div>
                </div>
            </div>
        </li>
        <li class="accordion__panel">
            <span class="accordion__heading">Employment<i class="-icon -icon--right" data-wenk-pos="left" data-wenk="Click to expand/collapse this section"></i></span>
            <div class="accordion__expander">
                <div class="form-group">
                    <label class="col-xs-2 control-label">Company</label>
                    <div class="col-sm-2">
                        {!! Form::select('division_id', $divisions, old('division_id', isset($employee->division_id) ? $employee->division_id : null), ['placeholder' => 'Division..','class' => 'form-control']) !!}
                    </div>
                    <div class="col-sm-2">
                        {!! Form::select('branch_id', $branches, old('branch_id', isset($employee->branch_id) ? $employee->branch_id : null), ['placeholder' => 'Branch..','class' => 'form-control']) !!}
                    </div>
                    <div class="col-sm-3">
                        {!! Form::select('department_id', $departments, old('department_id', isset($employee->department_id) ? $employee->department_id : null), ['placeholder' => 'Department..','class' => 'form-control field-required', 'required', 'title'=>'Required']) !!}
                    </div>
                    <div class="col-sm-3">
                        {!! Form::select('team_id',$teams, old('team_id', isset($employee->team_id) ? $employee->team_id : null), ['placeholder' => 'Team..','class' => 'form-control field-required', 'required', 'title'=>'Required']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-2 control-label">Identification</label>
                    <div class="col-sm-4">
                        <span class="field">
                            {!! Form::text('employee_no', old('employee_no', isset($employee->employee_no) ? $employee->employee_no : null), ['class'=>'form-control field-required', 'autocomplete'=>'off', 'placeholder'=>'Employee No', 'required', 'title'=>'Required',
                               'data-parsley-trigger'=>'focusout',
                               'data-parsley-remote',
                               'data-parsley-remote-validator'=>'checkEmployeeNo',
                               'data-parsley-remote-message'=>'Employee Number is already in use']) !!}
                            <label for="employee_no">Employee Number</label>
                        </span>
                        {!! $errors->first('employee_no', '<p class="help-block">:message</p>') !!}
                    </div>
                    <div class="col-sm-2">
                        <span class="field">
                            {!! Form::text('physical_file_no', old('physical_file_no', isset($employee->physical_file_no) ? $employee->physical_file_no : null), ['class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>'Physical File Number']) !!}
                            <label for="physical_file_no">Physical File Number</label>
                        </span>
                    </div>
                    <div class="col-sm-4">
                        <span class="field">
                            <input type="hidden" value="{{$employee->employee_code}}" name="employee_code">
                            {!! Form::text('employee_code', old('employee_code', isset($employee->employee_code) ? $employee->employee_code : null), ['class'=>'form-control','disabled', 'autocomplete'=>'off', 'placeholder'=>'Employee Code']) !!}
                            <label for="employee_code">Employee Code</label>
                        </span>
                        {!! $errors->first('employee_code', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Reporting Line</label>
                    {!! Form::hidden('line_manager_id', old('line_manager_id', isset($employee->line_manager_id) ? $employee->line_manager_id : null), ['id'=>'line_manager_id']) !!}
                    <div class="col-sm-10">
                        <select name="job_title_id" id="job_title_id" class="bootstrap-select" title="Job Title..." data-show-subtext="true" data-size="10" data-width="100%" data-dropup="true">
                            @foreach ( $groups as $key => $attr )
                                <optgroup label="{{$key}}">
                                    @foreach ( $attr as $id => $attrs )
                                        <option value="{{$id}}" data-employee-id="{{$attrs['manager_id']}}" data-subtext="{{$attrs['name']}}" {{ old('job_title_id', isset($employee->job_title_id) ? $employee->job_title_id : null) == $id ? 'selected' : '' }}>{{$key}}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>

                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-2 control-label">Join/Termination Dates</label>
                    <div class="col-sm-3">
                        <span class="field">
                            {!! Form::text('date_joined', old('date_joined', isset($employee->date_joined) ? $employee->date_joined : null), ['class'=>'form-control datepicker', 'placeholder'=>'Joined Date', 'id'=>'JoinedDate', 'data-pair-elemeent-id'=>'TerminationDate' ]) !!}
                            <label for="date_joined">Date Joined</label>
                        </span>
                    </div>
                    <div class="col-sm-3">
                        <span class="field">
                            {!! Form::text('date_terminated', old('date_terminated', isset($employee->date_terminated) ? $employee->date_terminated : null), ($_mode=='view' || $_mode=='create')?['class'=>'form-control','disabled', 'placeholder'=>'Termination Date']:['class'=>'form-control datepicker', 'placeholder'=>'Termination Date', 'id'=>'TerminationDate']) !!}
                            <label for="date_terminated">Termination Date</label>
                        </span>
                    </div>
                    <div class="col-sm-4">
                        {!! Form::select('employee_status_id', $employeeStatuses, old('employee_status_id', isset($employee->employee_status_id) ? $employee->employee_status_id : null), ($_mode=='view')?['placeholder' => '','class'=>'form-control','disabled']:['class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>'Employee Status..']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-2 control-label">Tax Details</label>
                    <div class="col-sm-4">
                        {!! Form::select('tax_status_id', $taxstatuses, old('tax_status_id', isset($employee->tax_status_id) ? $employee->tax_status_id : null), ['class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>'Tax Status..']) !!}
                    </div>
                    <div class="col-sm-6">
                        <span class="field">
                            {!! Form::text('tax_number', old('tax_number', isset($employee->tax_number) ? $employee->tax_number : null), ['class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>'Tax Number']) !!}
                            <label for="tax_number">Tax Number</label>
                        </span>
                        {!! $errors->first('tax_number', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-2 control-label">Skills</label>
                    <div class="col-sm-10">
                        {!! Form::select('skills[]', $skills, old('skills', isset($employeeSkills) ? $employeeSkills : null), ['class' => 'form-control select-multiple', 'multiple'=>'multiple']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-2 control-label">Disabilities</label>
                    <div class="col-sm-10">
                        {!! Form::groupRelationSelect('disabilities[]', $disabilities, 'disabilities', 
                            'description', 'description', 'id', 
                            isset($employeeDisabilities) ? $employeeDisabilities : null, ['class' => 'form-control select-multiple', 'multiple'=>'multiple']
                            ) !!}
                    </div>
                </div>
            </div>
        </li>
        <li class="accordion__panel">
            <span class="accordion__heading">Qualifications<i class="-icon -icon--right" data-wenk-pos="left" data-wenk="Click to expand/collapse this section"></i></span>
            <div class="accordion__expander">
                <div class="form-group">
                    <div class="row">
                        <div class="col-xs-1">
                            <button class="btn btn-default" v-on:click="addNewQual" type="button" data-wenk-pos="right"
                                    data-wenk="Add New Qualification">
                                <i class="fa fa-plus text-success"></i>
                            </button>
                        </div>
                        <label class="col-sm-1">Ref</label>
                        <label class="col-sm-3">Description</label>
                        <label class="col-sm-3">Institution</label>
                        <label class="col-sm-2">Student Number</label>
                        <label class="col-sm-2">Date Obtained</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row" v-for="(qual, index) in quals">
                        <div class="col-xs-1">
                            <button type="button" v-on:click="removeQual(index)" class="btn btn-default" data-wenk-pos="right"
                                    data-wenk="Remove Qualification">
                                <i class="fa fa-minus" style="color:rgb(255,59,48)"></i>
                            </button>
                        </div>
                        <div class="col-md-1">
                            <input v-model="qual.reference" type="text"
                                   name="qualifications[][reference]" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <input v-model="qual.description" type="text"
                                   name="qualifications[][description]" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <input v-model="qual.institution" type="text"
                                   name="qualifications[][institution]" class="form-control">
                        </div>
                        <div class="col-sm-2">
                            <input v-model="qual.student_no" type="text"
                                   name="qualifications[][student_no]" class="form-control">
                        </div>
                        <div class="col-sm-2">
                            <DatePicker v-model="qual.obtained_on" class="form-control"
                                    name="qualifications[][obtained_on]" date-format="yy-mm-dd" change-month="true" change-year="true"></DatePicker>
                        </div>
                    </div>
                </div>
            </div>
        </li>
        <li class="accordion__panel">
            <span class="accordion__heading">Attachments<i class="-icon -icon--right" data-wenk-pos="left" data-wenk="Click to expand/collapse this section"></i></span>
            <div class="accordion__expander">

                <div class="form-group">
                    <div class="col-xs-2"></div>
                    <div class="col-xs-10 fileUploader" id="one">
                    </div>
                </div>
                <div class="form-group"></div>
            </div>
        </li>
    </ul>
</div>