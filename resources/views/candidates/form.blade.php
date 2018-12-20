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
                <label for="title">Select title</label>
                <select v-model="selectedTitle" class='form-control'>
                    <option disabled value="">Please select one</option>
                    <option v-for="title in titles" :value="title">@{{title}}</option>
                </select>
            </div>

            <div class="form-group col-xs-3">
                <label for="gender">Select gender</label>
                <select v-model="selectedGender" class='form-control'>
                    <option disabled value="">Please select one</option>
                    <option v-for="gender in genders" :value="gender">@{{gender}}</option>
                </select>
            </div>

            <div class="form-group col-xs-3">
                <label for="gender">Select marital status</label>
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

            <div class="form-group col-xs-4">
                <label for="disability">Select disability</label>
                <select v-model="selectedDisability" class='form-control' @change="selectedDisabilityFunc()">
                    <option disabled value="">Please select one</option>
                    <option v-for="disability in disabilities" :value="disability">@{{disability}}</option>
                </select>
            </div>

            <div class="form-group col-xs-4">
                <label for="skill">Select skills</label>
                <select v-model="selectedSkill" class='form-control' @change="selectedSkillFunc()">
                    <option disabled value="">Please select one</option>
                    <option v-for="skill in skills" :value="skill">@{{skill}}</option>
                </select>
            </div>

            <div class="form-group col-xs-4">
                <label for="qualification">Highest qualifications</label>
                <select v-model="selectedQualification" class='form-control select-multiple multiple' @change="selectedQualificationFunc()">
                    <option v-for="qualification in qualifications" :value="qualification">@{{qualification}}</option>
                </select>
            </div>

            <div class="form-group col-xs-12">
                <div class="fileUploader" id="one"></div>
            </div>
        </div>
    </div>
    <div id="date-picker"> </div>
</div>

@section('post-body')
    <link href="{{URL::to('/')}}/css/candidates.min.css" rel="stylesheet">
    <script src="{{URL::to('/')}}/js/candidates.min.js"></script>

    <link href="{{URL::to('/')}}/plugins/fileUploader/fileUploader.css" rel="stylesheet">
    <script src="{{URL::to('/')}}/plugins/fileUploader/fileUploader.js"></script>
    <script>
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
                        intro_msg: "{{ 'Attach CV' }}",
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