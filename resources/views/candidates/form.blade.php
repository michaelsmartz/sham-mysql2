<div class="position-center" id="candidates-app">
<div class="row">
    <div class="col-sm-12">
        <div class="row">
            <div class="form-group col-xs-2">
                <div class="avatar-upload">
                    <div class="avatar-edit">
                        <input type='file' name="profile_pic" id="imageUpload" accept=".png, .jpg, .jpeg" />
                        <label for="imageUpload" title="change profile image"></label>
                    </div>
                    <div class="avatar-preview">
                        <div id="imagePreview" style="background-image: url({{$candidate->picture}});">
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group col-sm-3">
                <label for="birth_date">Date of birth</label>
                {!! Form::text('birth_date', old('birth_date', isset($candidate->birth_date) ? $candidate->birth_date : null), ['class'=>'form-control fix-case field-required datepicker', 'minage'=>'18', 'autocomplete'=>'off', 'placeholder'=>'Date Of Birth', 'required', 'title'=>'Required', 'id'=>'birth_date']) !!}
            </div>

            <div class="form-group col-sm-2">
                <label for="gender_id">Gender</label>
                {!! Form::select('gender_id', $genders, old('gender_id', isset($candidate->gender_id) ? $candidate->gender_id : null), ['class'=>'form-control fix-case field-required', 'autocomplete'=>'off', 'placeholder'=>'Gender..', 'required', 'title'=>'Required', 'data-parsley-trigger'=>'focusout']) !!}
            </div>
            <div class="form-group col-sm-2">
                <label for="title_id">Title</label>
                {!! Form::select('title_id', $titles, old('title_id', isset($candidate->title_id) ? $candidate->title_id : null), ['class'=>'form-control fix-case field-required', 'autocomplete'=>'off', 'placeholder'=>'Title..', 'required', 'title'=>'Required', 'data-parsley-trigger'=>'focusout']) !!}
            </div>
            <div class="form-group col-sm-3">
                <label for="marital_status_id">Marital Status</label>
                {!! Form::select('marital_status_id', $maritalstatuses, old('marital_status_id', isset($candidate->marital_status_id) ? $candidate->marital_status_id : null), ['id' =>'marital_status_id', 'name'=>'marital_status_id', 'class'=>'form-control fix-case field-required', 'autocomplete'=>'off', 'placeholder'=>'Marital Status..']) !!}
            </div>


            <div class="form-group col-xs-3">
                <span class="field">
                    <label for="first_name">First Name</label>
                    {!! Form::text('first_name', old('first_name', isset($candidate->first_name) ? $candidate->first_name : null), ['class'=>'form-control fix-case field-required', 'autocomplete'=>'off', 'placeholder'=>'First Name', 'required', 'title'=>'Required','id'=>'first_name', 'data-parsley-pattern' => '^[a-zA-ZÀ-ÖØ-öø-ÿ\-]+( [a-zA-ZÀ-ÖØ-öø-ÿ]+)*$', 'maxlength' => '50', 'data-parsley-trigger'=>'focusout']) !!}
                </span>
            </div>
            <div class="form-group col-xs-3">
                <span class="field">
                    <label for="surname">Surname</label>
                    {!! Form::text('surname', old('surname', isset($candidate->surname) ? $candidate->surname : null), ['class'=>'form-control fix-case field-required', 'autocomplete'=>'off', 'placeholder'=>'Surname', 'required', 'title'=>'Required','id'=>'surname', 'data-parsley-pattern' => '^[a-zA-ZÀ-ÖØ-öø-ÿ\-]+( [a-zA-ZÀ-ÖØ-öø-ÿ]+)*$', 'maxlength' => '50', 'data-parsley-trigger'=>'focusout']) !!}
                </span>
            </div>

            <div class="form-group col-xs-4">
                    <span class="field">
                        <label for="email">Personal Email</label>
                        {!! Form::email('email', old('email', isset($candidate->email) ? $candidate->email : null), ['class'=>'form-control fix-case field-required', 'autocomplete'=>'off', 'placeholder'=>'Personal Email', 'required', 'title'=>'Required','id'=>'personalEmail', 'maxlength' => '50']) !!}
                    </span>
            </div>

            <div class="form-group col-xs-3">
                    <span class="field">
                        <label for="phone">Phone Number</label>
                        {!! Form::text('phone', old('phone', isset($candidate->phone) ? $candidate->phone : null), ['class'=>'form-control fix-case field-required', 'autocomplete'=>'off', 'placeholder'=>'Phone', 'required', 'title'=>'Required','id'=>'phone', 'maxlength' => '50',
                        'data-parsley-pattern'=>"^[\d\+\-\.\(\)\/\s]*$",
                        'data-filter'=>"([A-Z]{0,3}|[A-Z]{3}[0-9]*)",
                        'data-parsley-trigger'=>'focusout'])
                        !!}
                    </span>
            </div>

            <div class="form-group col-xs-3">
                    <span class="field">
                        <label for="id_number">Id Number</label>
                        {!! Form::text('id_number', old('id_number', isset($candidate->id_number) ? $candidate->id_number : null), ['class'=>'form-control fix-case field-required', 'autocomplete'=>'off', 'placeholder'=>'Id Number', 'required', 'title'=>'Required','id'=>'idNumber', 'maxlength' => '50',
                        'data-parsley-trigger' => 'focusout',
                        'data-parsley-remote',
                        'data-parsley-remote-validator'=>'checkId',
                        'data-parsley-remote-message' => 'Id Number is already in use'])
                        !!}
                    </span>
            </div>

            <div class="form-group col-xs-4">
                <span class="field">
                    <label for="passport_country">Passport Country</label>
                    {!! Form::select('passport_country_id', $countries, old('passport_country_id', isset($candidate->passport_country_id) ? $candidate->passport_country_id : null), ['class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>'Passport Country..', 'id'=>'passport_country_id']) !!}
                </span>
            </div>

            <div class="form-group col-xs-3">
                <span class="field">
                    <label for="passport_no">Passport No/Work Permit</label>
                        {!! Form::text('passport_no', old('passport_no', isset($candidate->passport_no) ? $candidate->passport_no : null), ['class'=>'form-control', 'dependsOnFieldNotEmpty'=>'passport_country_id', 'autocomplete'=>'off', 'placeholder'=>'Passport No', 'maxlength' => '50',
                                'data-parsley-validate-if-empty'=>'true',
                                'data-parsley-required-if'=>'#passport_country_id',
                                'data-parsley-trigger'=>'focusout',
                                'data-parsley-remote',
                                'data-parsley-remote-validator'=>'checkPassport',
                                'data-parsley-remote-message'=>'Passport Number is already in use'])
                        !!}
                </span>
            </div>

            <div class="form-group col-xs-3">
                <span class="field">
                    <label for="immigration_status_id">Immigration Status</label>
                    {!! Form::select('immigration_status_id', $immigrationStatuses, old('immigration_status_id', isset($candidate->immigration_status_id) ? $candidate->immigration_status_id : null), ['class'=>'form-control', 'dependsOnFieldNotEmpty'=>'passport_country_id', 'autocomplete'=>'off', 'placeholder'=>'Immigration Status..']) !!}
                </span>
            </div>

            <div class="form-group col-xs-3">
                <span class="field">
                     <label for="nationality">Nationality</label>
                    {!! Form::text('nationality', old('nationality', isset($candidate->nationality) ? $candidate->nationality : null),['class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>'Nationality', 'maxlength' => '50']) !!}
                </span>
            </div>

            <div class="form-group col-sm-3">
                <span class="field">
                    <label for="addr_line_1">Address Line 1</label>
                    {!! Form::text('addr_line_1', old('addr_line_1', isset($candidate->addr_line_1) ? $candidate->addr_line_1 : null), ['class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>'Address Line 1', 'id'=>'addr1', 'maxlength'=>'50']) !!}
                </span>
            </div>
            <div class="form-group col-sm-3">
                <span class="field">
                    <label for="addr_line_2">Address Line 2</label>
                    {!! Form::text('addr_line_2', old('addr_line_2', isset($candidate->addr_line_2) ? $candidate->addr_line_2 : null), ['class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>'Address Line 2', 'id'=>'addr2', 'maxlength'=>'50']) !!}
                </span>
            </div>

            <div class="form-group col-sm-3">
                <span class="field">
                     <label for="addr_line_3">Address Line 3</label>
                    {!! Form::text('addr_line_3', old('addr_line_3', isset($candidate->addr_line_3) ? $candidate->addr_line_3 : null), ['class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>'Address Line 3', 'id'=>'addr3', 'maxlength'=>'50']) !!}
                </span>
            </div>
            <div class="form-group col-sm-3">
                <span class="field">
                    <label for="addr_line_4">Address Line 4</label>
                    {!! Form::text('addr_line_4', old('addr_line_4', isset($candidate->addr_line_4) ? $candidate->addr_line_4 : null), ['class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>'Address Line 4', 'id'=>'addr4', 'maxlength'=>'50']) !!}
                </span>
            </div>

            <div class="form-group col-sm-3">
                <span class="field">
                    <label for="city">City</label>
                    {!! Form::text('city', old('city', isset($candidate->city) ? $candidate->city : null), ['class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>'City', 'id'=>'city', 'maxlength'=>'50']) !!}
                </span>
            </div>
            <div class="form-group col-sm-2">
                <span class="field">
                     <label for="province">Province</label>
                    {!! Form::text('province', old('province', isset($candidate->province) ? $candidate->province : null), ['class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>'Province', 'id'=>'province', 'maxlength'=>'50']) !!}
                </span>
            </div>
            <div class="form-group col-sm-2">
                <span class="field">
                     <label for="zip_code">Zip Code</label>
                    {!! Form::text('zip_code', old('zip_code', isset($candidate->zip_code) ? $candidate->zip_code : null), ['class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>'Zip Code', 'id'=>'zip_code']) !!}
                </span>
            </div>

            <div class="form-group col-xs-4">
                <label for="skill">Select skills</label>
                {!! Form::select('skills[]', $skills,
                    old('skills', isset($candidateSkills) ? $candidateSkills : null),
                    ['class' => 'form-control select-multiple', 'multiple'=>'multiple']
                ) !!}
            </div>

            <div class="form-group col-xs-4">
                <label for="disability">Select disabilities</label>
                {!! Form::groupRelationSelect('disabilities[]', $disabilities, 'disabilities',
            'description', 'description', 'id',
            isset($candidateDisabilities) ? $candidateDisabilities : null, ['class' => 'form-control select-multiple', 'multiple'=>'multiple']
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
                        <input type="hidden" :name="'qualifications[' + index + '][deleted_at]'">
                        <div class="col-xs-1">
                            <button type="button" v-on:click="removeQual(index)" class="btn btn-default" data-wenk-pos="right"
                                    data-wenk="Remove Qualification">
                                <i class="fa fa-minus" style="color:rgb(255,59,48)"></i>
                            </button>
                        </div>
                        <div class="col-md-1">
                            <input v-model="qual.reference" type="text"
                                   :name="'qualifications['+index+'][reference]'" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <input v-model="qual.description" type="text"
                                   :name="'qualifications['+index+'][description]'" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <input v-model="qual.institution" type="text"
                                   :name="'qualifications['+index+'][institution]'" class="form-control">
                        </div>
                        <div class="col-sm-2">
                            <input v-model="qual.student_no" type="text"
                                   :name="'qualifications['+index+'][student_no]'" class="form-control">
                        </div>
                        <div class="col-sm-2">
                            <input v-model="qual.obtained_on" type="text" class="form-control datepicker"
                                   :name="'qualifications['+index+'][obtained_on]'" date-format="yy-mm-dd" change-month="true" change-year="true">
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
                            <label class="col-sm-2">Previous Employer</label>
                            <label class="col-sm-2">Position</label>
                            <label class="col-sm-1">Salary</label>
                            <label class="col-sm-2">Reason for leaving?</label>
                            <label class="col-sm-1">Start Date</label>
                            <label class="col-sm-1">End Date</label>
                            <label class="col-sm-2">Employer's Contact Number</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row" v-for="(employment, index) in employments">
                            <input type="hidden" :name="'previous_employments[' + index + '][deleted_at]'">
                            <div class="col-xs-1">
                                <button type="button" v-on:click="removeEmploy(index)" class="btn btn-default" data-wenk-pos="right"
                                        data-wenk="Remove Employment">
                                    <i class="fa fa-minus" style="color:rgb(255,59,48)"></i>
                                </button>
                            </div>
                            <div class="col-md-2">
                                <input v-model="employment.previous_employer" type="text"
                                       :name="'previous_employments['+index+'][previous_employer]'" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <input v-model="employment.position" type="text"
                                       :name="'previous_employments['+index+'][position]'" class="form-control">
                            </div>
                            <div class="col-md-1">
                                <input v-model="employment.salary" type="text"
                                       :name="'previous_employments['+index+'][salary]'" class="form-control">
                            </div>
                            <div class="col-sm-2">
                                <input v-model="employment.reason_leaving" type="text"
                                       :name="'previous_employments['+index+'][reason_leaving]'" class="form-control">
                            </div>
                            <div class="col-sm-1">
                                <input v-model="employment.start_date" type="text"
                                       :name="'previous_employments['+index+'][start_date]'" class="form-control datepicker">
                            </div>
                            <div class="col-sm-1">
                                <input v-model="employment.end_date" type="text"
                                       :name="'previous_employments['+index+'][end_date]'" class="form-control datepicker">
                            </div>
                            <div class="col-sm-2">
                                <input v-model="employment.contact" type="text"
                                       :name="'previous_employments['+index+'][contact]'" class="form-control">
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>


            <div class="form-group col-xs-2">
                    <span class="field">
                        <label for="date_available">Possible Start Date</label>
                        {!! Form::text('date_available', old('date_available', isset($candidate->date_available) ? $candidate->date_available : null), ['class'=>'form-control fix-case field-required datepicker', 'autocomplete'=>'off', 'placeholder'=>'Possible Start Date', 'required', 'title'=>'Required','id'=>'possible_start_date', 'maxlength' => '50']) !!}
                    </span>
            </div>

            <div class="form-group col-xs-2">
                    <span class="field">
                        <label for="notice_period">Notice Period
                             <span>
                                <i class="fa fa-question-circle" aria-hidden="true"
                                   data-wenk-pos="top" data-wenk="Notice period in month">
                                </i>
                             </span>
                        </label>
                        {!! Form::number('notice_period', old('notice_period', isset($candidate->notice_period) ? $candidate->notice_period : null), ['class'=>'form-control fix-case', 'autocomplete'=>'off', 'placeholder'=>'Notice Period','id'=>'notice_period', 'maxlength' => '50', 'min'=> '0']) !!}
                    </span>
            </div>

            <div class="form-group col-sm-3">
                <span class="field">
                <label for="preferred_notification_id">Preferred notification</label>
                    {!! Form::select('preferred_notification_id', $preferredNotifications, old('preferred_notification_id', isset($candidate->preferred_notification_id) ? $candidate->preferred_notification_id : null), ['class'=>'form-control fix-case field-required', 'autocomplete'=>'off', 'placeholder'=>'Preferred Notification..', 'data-field-name'=>'Preferred Notification', 'required', 'title'=>'Required', 'data-parsley-trigger'=>'focusout']) !!}
                </span>
            </div>

            <div class="form-group col-xs-12">
                    <span class="field">
                        <label for="overview">Overview</label>
                        {!! Form::textarea('overview', old('overview', isset($candidate->overview) ? htmlspecialchars_decode($candidate->overview) : null), ['class'=>'form-control fix-case field-required', 'autocomplete'=>'off', 'placeholder'=>'Overview', 'required', 'title'=>'Required','id'=>'overview', 'maxlength' => '50']) !!}
                    </span>
            </div>

            <div class="form-group col-xs-12">
                    <span class="field">
                        <label for="cover">Cover Letter</label>
                        {!! Form::textarea('cover', old('cover', isset($candidate->cover) ? htmlspecialchars_decode($candidate->cover) : null), ['class'=>'form-control fix-case field-required', 'autocomplete'=>'off', 'placeholder'=>'Cover Letter', 'required', 'title'=>'Required','id'=>'cover', 'maxlength' => '50']) !!}
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
</div>

@section('post-body')
    <link href="{{URL::to('/')}}/css/candidates.min.css" rel="stylesheet">
    <script src="{{URL::to('/')}}/js/candidates.min.js"></script>

    <link href="{{URL::to('/')}}/plugins/fileUploader/fileUploader.css" rel="stylesheet">
    <script src="{{URL::to('/')}}/plugins/fileUploader/fileUploader.js"></script>

    <script src="{{URL::to('/')}}/plugins/ckeditor_basic_nightly/ckeditor/ckeditor.js"></script>

    <script>
        CKEDITOR.replace('overview');
        CKEDITOR.replace('cover');
        var initializeFileUpload = function() {
            $('#one').fileUploader({
                lang: 'en',
                useFileIcons: true,
                fileMaxSize: {!! '1.7' !!},
                totalMaxSize: {!! '5' !!},
                useLoadingBars: true,
                linkButtonContent: '',
                deleteButtonContent: "<i class='text-danger fa fa-times' data-wenk='Remove file'></i>",
                resultPrefix: "attachment",
                duplicatesWarning: true,
                filenameTest: function(fileName, fileExt, $container) {
                    var allowedExts = ["doc", "docx", "xls", "xlsx", "ppt", "pptx", "pdf", "jpg", "jpeg", "png"];

                    var $info = $('<div class="errorLabel center"></div>');
                    var proceed = true;
                    // length check
                    if (fileName.length > 120) {
                        $info.html('Name too long...');
                        proceed = false;
                    }
                    // replace not allowed characters
                    fileName = fileName.replace(" ", "-");
                    // extension check
                    if (allowedExts.indexOf(fileExt) < 0) {
                        $info.html('Extension not allowed...');
                        proceed = false;
                    }
                    // show an error message, but only if there is no other error message already there
                    if (!proceed && $container.children('.errorLabel').length < 1) {
                        $container.append($info);
                        setTimeout(function() {
                            $info.animate({opacity: 0}, 300, function() {
                                $(this).remove();
                            });
                        }, 5000);
                    }
                    if (!proceed) {
                        return false;
                    }
                    return fileName;
                },
                langs: {
                    'en': {
                        intro_msg: "{{ 'Attach supporting documents. (Passport, ID, CV, Certificates, Qualifications, Testimonials,..etc)' }}",
                        dropZone_msg:
                            '<p><strong>Drop</strong>&nbsp;your files here or <strong class="text-primary">click</strong>&nbsp;on this area' +
                            '<br><small class="text-muted">{{ "You can upload any related files" }}.\n' +
                            '   One file can be max 10 MB</small>\n' +
                            '</p>',
                        maxSizeExceeded_msg: 'File too large',
                        totalMaxSizeExceeded_msg: 'Total size exceeded',
                        duplicated_msg: 'File duplicated (skipped)',
                        name_placeHolder: 'name',
                    }
                },
                HTMLTemplate: function() {
                    return [
                        '<p class="introMsg"></p>',
                        '<div>',
                        '    <div class="inputContainer">',
                        '        <input class="fileLoader" type="file" {!! 'multiple' !!} />',
                        '    </div>',
                        '    <div class="dropZone"></div>',
                        '    <div class="filesContainer filesContainerEmpty">',
                        '        <div class="innerFileThumbs"></div>',
                        '        <div style="clear:both;"></div>',
                        '    </div>',
                        '</div>',
                        '<div class="result"></div>'
                    ].join("\n");
                }
            });
        };
        $(function(){
            initializeFileUpload();
        });

    </script>
@endsection
