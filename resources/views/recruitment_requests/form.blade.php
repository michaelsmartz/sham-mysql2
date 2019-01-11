<div class="row">
    <div class="col-sm-12">
        <div class="row">
            <div v-if="errors.length">
                <b>Please correct the following error(s):</b>
                <ul>
                    <li v-for="error in errors">@{{ error }}</li>
                </ul>
            </div>


            <div class="form-group col-xs-6">
                <label for="jobTitle">Job title</label>
                <input
                        id="jobTitle"
                        class='form-control'
                        v-model="jobTitle"
                        type="text"
                        name="jobTitle"
                >
            </div>

            <div class="form-group col-xs-6">
                <label for="position">Position</label>
                <input
                        id="position"
                        class='form-control'
                        v-model="position"
                        type="text"
                        name="position"
                >
            </div>

            <div class="form-group col-xs-12">
                <label for="description">Description</label>
                <textarea
                        id="description"
                        class='form-control'
                        v-model="description"
                        name="description">
                                </textarea>
            </div>

            <div class="form-group col-xs-3">
                <label for="department">Select department</label>
                <select v-model="selectedDepartment" class='form-control' @change="selectedDepartmentFunc()">
                    <option disabled value="">Please select one</option>
                    <option v-for="department in departments" :value="department">@{{department}}</option>
                </select>
            </div>

            <div class="form-group col-xs-3">
                <label for="employmentType">Select type of position</label>
                <select v-model="selectedEmploymentType" class='form-control' @change="selectedEmploymentTypeFunc()">
                    <option disabled value="">Please select one</option>
                    <option v-for="employmentType in employmentTypes" :value="employmentType">@{{employmentType}}</option>
                </select>
            </div>

            <div class="form-group col-xs-3">
                <label for="skills">Select skills</label>
                <select v-model="selectedSkill" class='form-control'>
                    <option disabled value="">Please select one</option>
                    <option v-for="skill in skills" :value="skill">@{{skill}}</option>
                </select>
            </div>

            <div class="form-group col-xs-3">
                <label for="yearExperience">Years of experience required</label>
                <input
                        id="yearExperience"
                        class='form-control'
                        v-model="yearExperience"
                        type="number"
                        min="0"
                        name="yearExperience"
                >
            </div>

            <div class="form-group col-xs-12">
                <fieldset>
                    <legend style="font-size:14px;"><b>Add Interviews</b></legend>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-1">
                                <button class="btn btn-default" v-on:click="addNewInterview" type="button" data-wenk-pos="right"
                                        data-wenk="Add New Interview">
                                    <i class="fa fa-plus text-success"></i>
                                </button>
                            </div>
                            <label class="col-sm-2">Interview Type</label>
                            <label class="col-sm-3">Schedule Comment</label>
                            <label class="col-sm-2">Schedule Date</label>
                            <label class="col-sm-2">Interviewers</label>
                            <label class="col-sm-2">Location</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row" v-for="(interview, index) in interviews">
                            <div class="col-xs-1">
                                <button type="button" v-on:click="removeInterview(index)" class="btn btn-default" data-wenk-pos="right"
                                        data-wenk="Remove Interview">
                                    <i class="fa fa-minus" style="color:rgb(255,59,48)"></i>
                                </button>
                            </div>

                            <div class="col-md-2">
                                <select v-model="selectedInterviewType" class='form-control'>
                                    <option disabled value="">Please select one</option>
                                    <option v-for="interview_type in interview.interview_types" :value="interview_type">@{{interview_type}}</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <textarea
                                        id="schedule_comment"
                                        class="form-control"
                                        v-model="interview.schedule_comment"
                                        type="text"
                                        name="interviews[][schedule_comment]"
                                >

                                </textarea>
                            </div>
                            <div class="col-md-2">
                                <input
                                        id="schedule_date"
                                        class='form-control datepicker'
                                        v-model="interview.schedule_date"
                                        type="text"
                                        name="interviews[][schedule_date]"
                                >
                            </div>
                            <div class="col-md-2">
                                <input
                                        id="interviewers"
                                        class='form-control'
                                        v-model="interview.interviewers"
                                        type="text"
                                        name="interviews[][interviewers]"
                                        multiple
                                >
                            </div>
                            <div class="col-md-2">
                                <input
                                        id="location"
                                        class='form-control'
                                        v-model="interview.location"
                                        type="text"
                                        name="interviews[][location]"
                                >
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>

            <div class="form-group col-xs-3">
                <label for="skills">Select Qualifications</label>
                <select v-model="selectedQualification" class='form-control'>
                    <option disabled value="">Please select one</option>
                    <option v-for="qualification in qualifications" :value="qualification">@{{qualification}}</option>
                </select>
            </div>

            <div class="form-group col-xs-2">
                <label for="date_start">Start Date</label>
                <input
                        id="date_start"
                        class='form-control datepicker'
                        v-model="date_start"
                        type="text"
                        name="date_start"
                >
            </div>

            <div class="form-group col-xs-2" v-if="showEndDate">
                <label for="date_end">End Date</label>
                <input
                        id="date_end"
                        class='form-control datepicker'
                        v-model="date_end"
                        type="text"
                        name="date_end"
                >
            </div>

            <div class="form-group col-xs-12">
                <label for="internalRecruitment">Internal Recruitment</label>
                <input type="checkbox" v-model="internalRecruitment">

                <label for="externalRecruitment">External Recruitment</label>
                <input type="checkbox" v-model="externalRecruitment">
            </div>

            <div class="form-group col-xs-12">
                <label for="showSalary">Show salary</label>
                <input type="checkbox" v-model="showSalary">
            </div>

            <transition name="fade" v-if="showSalary">
                <div class="form-group col-xs-12" >
                    <div class="form-group col-xs-6">
                        <label for="minSalary">Minimum salary</label>
                        <input
                                id="minSalary"
                                class='form-control'
                                v-model="minSalary"
                                name="minSalary"
                                type="number"
                                min="0"
                        >
                    </div>
                    <div class="form-group col-xs-6">
                        <label for="maxSalary">Maximum salary</label>
                        <input
                                id="maxSalary"
                                class='form-control'
                                v-model="maxSalary"
                                name="maxSalary"
                                type="number"
                                min="0"
                        >
                    </div>
                </div>
            </transition>
        </div>
    </div>
    <div id="date-picker"> </div>
</div>

@section('post-body')
    <link href="{{URL::to('/')}}/css/recruitment-request.min.css" rel="stylesheet">
    <script src="{{URL::to('/')}}/js/recruitment-request.min.js"></script>
@endsection