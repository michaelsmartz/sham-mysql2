<div class="row">
    <div class="col-sm-12">
        <div class="row">
            <div v-if="errors.length">
                <b>Please correct the following error(s):</b>
                <ul>
                    <li v-for="error in errors">@{{ error }}</li>
                </ul>
            </div>


            <div class="form-group col-xs-3">
                <label for="dob">Date of Birth</label>
                <input
                        id="dob"
                        class='form-control datepicker'
                        v-model="dob"
                        type="text"
                        name="dob"
                >
            </div>

            <div class="form-group col-xs-3">
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

            <div class="form-group col-xs-6">
                <label for="surname">Surname</label>
                <input
                        id="surname"
                        class='form-control'
                        v-model="surname"
                        type="text"
                        name="surname"
                >
            </div>

            <div class="form-group col-xs-6">
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

            <div class="form-group col-xs-3">
                <label for="phone">Phone Number</label>
                <input
                        id="phone"
                        class='form-control'
                        v-model="phone"
                        type="number"
                        name="phone"
                >
            </div>

            <div class="form-group col-xs-3">
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
        </div>
    </div>
    <div id="date-picker"> </div>
</div>

@section('post-body')
    <link href="{{URL::to('/')}}/css/candidates.min.css" rel="stylesheet">
    <script src="{{URL::to('/')}}/js/candidates.min.js"></script>
@endsection