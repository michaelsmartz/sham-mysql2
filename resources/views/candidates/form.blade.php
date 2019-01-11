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
                        <input type='file' name="profile_pic" id="imageUpload" accept=".png, .jpg, .jpeg" />
                        <label for="imageUpload" title="change profile image"></label>
                    </div>
                    <div class="avatar-preview">
                        <div id="imagePreview" style="background-image: url('/img/avatar.png');">
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group col-xs-2">
                <label for="dob">Date of Birth</label>
                <input
                        id="dob"
                        class='form-control datepicker'
                        v-model="dob"
                        type="text"
                        name="dob"
                >
            </div>

            <div class="form-group col-xs-2">
                <label for="title">Select Title</label>
                <select v-model="selectedTitle" class='form-control'>
                    <option disabled value="">Please select one</option>
                    <option v-for="title in titles" :value="title">@{{title}}</option>
                </select>
            </div>

            <div class="form-group col-xs-3">
                <label for="gender">Select Gender</label>
                <select v-model="selectedGender" class='form-control'>
                    <option disabled value="">Please select one</option>
                    <option v-for="gender in genders" :value="gender">@{{gender}}</option>
                </select>
            </div>

            <div class="form-group col-xs-3">
                <label for="gender">Select Marital Status</label>
                <select v-model="selectedMaritalStatus" class='form-control'>
                    <option disabled value="">Please select one</option>
                    <option v-for="maritalStatus in maritalStatuses" :value="maritalStatus">@{{maritalStatus}}</option>
                </select>
            </div>

            <div class="form-group col-xs-5">
                <label for="surname">Surname</label>
                <input
                        id="surname"
                        class='form-control'
                        v-model="surname"
                        type="text"
                        name="surname"
                >
            </div>

            <div class="form-group col-xs-5">
                <label for="firstName">FirstName</label>
                <input
                        id="firstName"
                        class='form-control'
                        v-model="firstName"
                        type="text"
                        name="firstName"
                >
            </div>

            <div class="form-group col-xs-3">
                <label for="personalEmail">Personal Email</label>
                <input
                        id="personalEmail"
                        class='form-control'
                        v-model="personalEmail"
                        type="text"
                        name="personalEmail"
                >
            </div>

            <div class="form-group col-xs-3">
                <label for="homeAddress">Home Address</label>
                <input
                        id="homeAddress"
                        class='form-control'
                        v-model="homeAddress"
                        type="text"
                        name="homeAddress"
                >
            </div>

            <div class="form-group col-xs-2">
                <label for="phone">Phone Number</label>
                <input
                        id="phone"
                        class='form-control'
                        v-model="phone"
                        type="number"
                        name="phone"
                >
            </div>

            <div class="form-group col-xs-2">
                <label for="idNumber">Id Number</label>
                <input
                        id="idNumber"
                        class='form-control'
                        v-model="idNumber"
                        type="number"
                        name="idNumber"
                >
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

            <div class="form-group col-xs-4">
                <label for="surname">Previous Employer</label>
                <input
                        id="previous_employer"
                        class='form-control'
                        v-model="previous_employer"
                        type="text"
                        name="previous_employer"
                >
            </div>

            <div class="form-group col-xs-4">
                <label for="surname">Position</label>
                <input
                        id="position"
                        class='form-control'
                        v-model="position"
                        type="text"
                        name="position"
                >
            </div>

            <div class="form-group col-xs-2">
                <label for="surname">Salary</label>
                <input
                        id="salary"
                        class='form-control'
                        v-model="salary"
                        type="number"
                        name="salary"
                >
            </div>

            <div class="form-group col-xs-2">
                <label for="surname">Reason for leaving?</label>
                <textarea
                        id="reason_leaving"
                        class='form-control'
                        v-model="reason_leaving"
                        type="text"
                        name="reason_leaving"
                ></textarea>
            </div>

            <div class="form-group col-xs-4">
                <label for="surname">Position Applying For</label>
                <input
                        id="surname"
                        class='form-control'
                        v-model="position_applied"
                        type="text"
                        name="position_applied"
                >
            </div>

            <div class="form-group col-xs-2">
                <label for="dob">Date You Can Start</label>
                <input
                        id="date_available"
                        class='form-control datepicker'
                        v-model="date_available"
                        type="text"
                        name="date_available"
                >
            </div>

            <div class="form-group col-xs-2">
                <label for="surname">Salary Expectation</label>
                <input
                        id="salary_expectation"
                        class='form-control'
                        v-model="salary_expectation"
                        type="number"
                        name="salary_expectation"
                >
            </div>

            <div class="form-group col-xs-12">
                <label for="skill">Overview</label>
                <textarea class="form-control" name="overview" cols="50" rows="4" id="overview" minlength="1" placeholder="Add Overview"></textarea>
            </div>

            <div class="form-group col-xs-12">
                <label for="skill">Cover Letter</label>
                <textarea class="form-control" name="short-description" cols="50" rows="4" id="short-description" minlength="1" placeholder="Add short description why you should be selected"></textarea>
            </div>

            <div class="form-html col-xs-12">
                <p><b>By clicking the submit button below, I certify that all of the information provided by me on this application is true and complete, and I understand that if any false information, ommissions, or misrepresentations are discovered, my application may be rejected and, if I am employed, my employement may be terminated at any time. &nbsp;</b></p>
                <p><b>I also understand and agree that the terms and conditions of my employment may be changed, with or without cause, and with or without notice, at any time by the company. &nbsp;</b></p>
            </div>
        </div>
    </div>
    <div id="date-picker"> </div>
</div>