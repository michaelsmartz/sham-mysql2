<div class="row">
    <div class="col-sm-12">
        <div class="row">
            <div v-if="errors.length">
                <b>Please correct the following error(s):</b>
                <ul>
                    <li v-for="error in errors">@{{ error }}</li>
                </ul>
            </div>

            <div class="col-xs-2">
                <div class="avatar-upload">
                    <div class="avatar-edit">
                        <input type='file' name="picture" id="imageUpload" accept=".png, .jpg, .jpeg" />
                        <label for="imageUpload" title="change profile image"></label>
                    </div>
                    <div class="avatar-preview">
                        <div id="imagePreview" style="background-image: url('/img/avatar.png');">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-2">
                <span class="field">
                    <label for="birth_date">Date of birth</label>
                    {!! Form::text('birth_date', old('birth_date', isset($candidate->birth_date) ? $candidate->birth_date : null), ['class'=>'form-control fix-case field-required datepicker', 'minage'=>'18', 'autocomplete'=>'off', 'placeholder'=>'Date Of Birth', 'required', 'title'=>'Required', 'id'=>'birth_date']) !!}
                </span>
            </div>

            <div class="col-sm-2">
                <span class="field">
                <label for="gender_id">Gender</label>
                {!! Form::select('gender_id', $genders, old('gender_id', isset($candidate->gender_id) ? $candidate->gender_id : null), ['class'=>'form-control fix-case field-required', 'autocomplete'=>'off', 'placeholder'=>'Gender..', 'required', 'title'=>'Required', 'data-parsley-trigger'=>'focusout']) !!}
                </span>
            </div>
            <div class="col-sm-3">
                <span class="field">
                <label for="title_id">Title</label>
                {!! Form::select('title_id', $titles, old('title_id', isset($candidate->title_id) ? $candidate->title_id : null), ['class'=>'form-control fix-case field-required', 'autocomplete'=>'off', 'placeholder'=>'Title..', 'data-field-name'=>'Title', 'required', 'title'=>'Required', 'data-parsley-trigger'=>'focusout']) !!}
                </span>
            </div>
            <div class="col-sm-3">
                <span class="field">
                    <label for="marital_status_id">Marital Status</label>
                    {!! Form::select('marital_status_id', $maritalstatuses, old('marital_status_id', isset($candidate->marital_status_id) ? $candidate->marital_status_id : null), ['id' =>'marital_status_id', 'name'=>'marital_status_id', 'class'=>'form-control fix-case field-required', 'autocomplete'=>'off', 'placeholder'=>'Marital Status..']) !!}
                </span>
            </div>


            <div class="form-group col-xs-5">
                    <span class="field">
                        <label for="first_name">First Name</label>
                        {!! Form::text('first_name', old('first_name', isset($candidate->first_name) ? $candidate->first_name : null), ['class'=>'form-control fix-case field-required', 'autocomplete'=>'off', 'placeholder'=>'First Name', 'required', 'title'=>'Required','id'=>'first_name', 'data-parsley-pattern' => '^[a-zA-ZÀ-ÖØ-öø-ÿ\-]+( [a-zA-ZÀ-ÖØ-öø-ÿ]+)*$', 'maxlength' => '50', 'data-parsley-trigger'=>'focusout']) !!}
                    </span>
                {!! $errors->first('first_name', '<p class="help-block">:message</p>') !!}
            </div>
            <div class="form-group col-xs-5">
                    <span class="field">
                        <label for="surname">Surname</label>
                        {!! Form::text('surname', old('surname', isset($candidate->surname) ? $candidate->surname : null), ['class'=>'form-control fix-case field-required', 'autocomplete'=>'off', 'placeholder'=>'Surname', 'required', 'title'=>'Required','id'=>'surname', 'pattern' => '^[a-zA-ZÀ-ÖØ-öø-ÿ\-]+( [a-zA-ZÀ-ÖØ-öø-ÿ]+)*$', 'maxlength' => '50']) !!}
                    </span>
            </div>

            <div class="form-group col-xs-3">
                    <span class="field">
                        <label for="email">Personal Email</label>
                        {!! Form::email('email', old('email', isset($candidate->email) ? $candidate->email : null), ['class'=>'form-control fix-case field-required', 'autocomplete'=>'off', 'placeholder'=>'Personal Email', 'required', 'title'=>'Required','id'=>'personalEmail', 'maxlength' => '50']) !!}
                    </span>
            </div>

            <div class="form-group col-xs-3">
                    <span class="field">
                        <label for="home_address">Home Address</label>
                        {!! Form::text('home_address', old('home_address', isset($candidate->home_address) ? $candidate->home_address : null), ['class'=>'form-control fix-case field-required', 'autocomplete'=>'off', 'placeholder'=>'Home Address', 'required', 'title'=>'Required','id'=>'homeAddress', 'maxlength' => '50']) !!}
                    </span>
            </div>

            <div class="form-group col-xs-2">
                    <span class="field">
                        <label for="phone">Phone Number</label>
                        {!! Form::number('phone', old('phone', isset($candidate->phone) ? $candidate->phone : null), ['class'=>'form-control fix-case field-required', 'autocomplete'=>'off', 'placeholder'=>'Phone', 'required', 'title'=>'Required','id'=>'phone', 'maxlength' => '50']) !!}
                    </span>
            </div>

            <div class="form-group col-xs-2">
                    <span class="field">
                        <label for="id_number">Id Number</label>
                        {!! Form::text('id_number', old('id_number', isset($candidate->id_number) ? $candidate->id_number : null), ['class'=>'form-control fix-case field-required', 'autocomplete'=>'off', 'placeholder'=>'Id Number', 'required', 'title'=>'Required','id'=>'idNumber', 'maxlength' => '50']) !!}
                    </span>
            </div>

            <div class="form-group col-xs-5">
                <label for="disability">Select disability</label>
                {!! Form::groupRelationSelect('disabilities[]', $disabilities, 'disabilities',
                          'description', 'description', 'id',
                          isset($disabilities) ? [] : null, ['class' => 'form-control select-multiple', 'multiple'=>'multiple']
                ) !!}
            </div>

            <div class="form-group col-xs-5">
                <label for="skill">Select skills</label>
                {!! Form::select('skills[]', $skills,
                    old('skills', isset($employeeSkills) ? $employeeSkills : null),
                    ['class' => 'form-control select-multiple', 'multiple'=>'multiple']
                ) !!}
            </div>

            <div class="form-group col-xs-12">
                <fieldset>
                <legend style="font-size:14px;"><b>Add Qualifications</b></legend>
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
                            <input v-model="qual.obtained_on" type="text" class="form-control datepicker"
                                   name="qualifications[][obtained_on]" date-format="yy-mm-dd" change-month="true" change-year="true">
                        </div>
                    </div>
                </div>
                </fieldset>
            </div>

            <div class="form-group col-xs-12">
                <div class="fileUploader" id="one"></div>
            </div>

            <div class="form-group col-xs-12">
                <fieldset>
                    <legend style="font-size:14px;"><b>Add Previous Employments</b></legend>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-1">
                                <button class="btn btn-default" v-on:click="addNewEmploy" type="button" data-wenk-pos="right"
                                        data-wenk="Add New Employment">
                                    <i class="fa fa-plus text-success"></i>
                                </button>
                            </div>
                            <label class="col-sm-3">Previous Employer</label>
                            <label class="col-sm-3">Position</label>
                            <label class="col-sm-2">Salary</label>
                            <label class="col-sm-3">Reason for leaving?</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row" v-for="(employment, index) in employments">
                            <div class="col-xs-1">
                                <button type="button" v-on:click="removeEmploy(index)" class="btn btn-default" data-wenk-pos="right"
                                        data-wenk="Remove Employment">
                                    <i class="fa fa-minus" style="color:rgb(255,59,48)"></i>
                                </button>
                            </div>
                            <div class="col-md-3">
                                <input v-model="employment.previous_employer" type="text"
                                       name="previous_employments[][previous_employer]" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <input v-model="employment.position" type="text"
                                       name="previous_employments[][position]" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <input v-model="employment.salary" type="text"
                                       name="previous_employments[][salary]" class="form-control">
                            </div>
                            <div class="col-sm-3">
                                <input v-model="employment.reason_leaving" type="text"
                                       name="previous_employments[][reason_leaving]" class="form-control">
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>

            <div class="form-group col-xs-4">
                    <span class="field">
                        <label for="position_applying_for">Position Applying For</label>
                        {!! Form::text('position_applying_for', old('position_applying_for', isset($candidate->position_applying_for) ? $candidate->position_applying_for : null), ['class'=>'form-control fix-case field-required', 'autocomplete'=>'off', 'placeholder'=>'Position Applying For', 'required', 'title'=>'Required','id'=>'position_applied', 'maxlength' => '50']) !!}
                    </span>
            </div>

            <div class="form-group col-xs-2">
                    <span class="field">
                        <label for="date_available">Date Available</label>
                        {!! Form::text('date_available', old('date_available', isset($candidate->date_available) ? $candidate->date_available : null), ['class'=>'form-control fix-case field-required datepicker', 'autocomplete'=>'off', 'placeholder'=>'Date Available', 'required', 'title'=>'Required','id'=>'date_available', 'maxlength' => '50']) !!}
                    </span>
            </div>

            <div class="form-group col-xs-2">
                    <span class="field">
                        <label for="salary_expectation">Salary Expectation</label>
                        {!! Form::number('salary_expectation', old('salary_expectation', isset($candidate->salary_expectation) ? $candidate->salary_expectation : null), ['class'=>'form-control fix-case field-required', 'autocomplete'=>'off', 'placeholder'=>'Salary Expectation', 'required', 'title'=>'Required','id'=>'salary_expectation', 'maxlength' => '50']) !!}
                    </span>
            </div>

            <div class="form-group col-xs-4">
                <h5><b>Preferred notification: </b></h5>
                <label for="preferred_notification_id">Mail</label>
                <input type="checkbox" id="preferred_notification_id" value="1">

                <label for="preferred_notification_id">SMS</label>
                <input type="checkbox" id="preferred_notification_id" value="2">
            </div>

            <div class="form-group col-xs-12">
                    <span class="field">
                        <label for="overview">Overview</label>
                        {!! Form::textarea('overview', old('overview', isset($candidate->overview) ? $candidate->overview : null), ['class'=>'form-control fix-case field-required', 'autocomplete'=>'off', 'placeholder'=>'Overview', 'required', 'title'=>'Required','id'=>'overview', 'maxlength' => '50']) !!}
                    </span>
            </div>

            <div class="form-group col-xs-12">
                    <span class="field">
                        <label for="cover">Cover Letter</label>
                        {!! Form::textarea('cover', old('cover', isset($candidate->cover) ? $candidate->cover : null), ['class'=>'form-control fix-case field-required', 'autocomplete'=>'off', 'placeholder'=>'Cover Letter', 'required', 'title'=>'Required','id'=>'cover', 'maxlength' => '50']) !!}
                    </span>
            </div>

            <div class="form-html col-xs-12">
                <p><b>By clicking the submit button below, I certify that all of the information provided by me on this application is true and complete, and I understand that if any false information, ommissions, or misrepresentations are discovered, my application may be rejected and, if I am employed, my employement may be terminated at any time. &nbsp;</b></p>
                <p><b>I also understand and agree that the terms and conditions of my employment may be changed, with or without cause, and with or without notice, at any time by the company. &nbsp;</b></p>
            </div>
        </div>
    </div>
    <div id="date-picker"> </div>
</div>