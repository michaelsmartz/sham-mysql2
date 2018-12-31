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
                <label for="shortDescription">Short description</label>
                <input
                        id="shortDescription"
                        class='form-control'
                        v-model="shortDescription"
                        type="text"
                        name="shortDescription"
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

            <div class="form-group col-xs-5">
                <label for="department">Select department</label>
                <select v-model="selectedDepartment" class='form-control' @change="selectedDepartmentFunc()">
                    <option disabled value="">Please select one</option>
                    <option v-for="department in departments" :value="department">@{{department}}</option>
                </select>
            </div>

            <div class="form-group col-xs-5">
                <label for="employmentType">Select employment type</label>
                <select v-model="selectedEmploymentType" class='form-control' @change="selectedEmploymentTypeFunc()">
                    <option disabled value="">Please select one</option>
                    <option v-for="employmentType in employmentTypes" :value="employmentType">@{{employmentType}}</option>
                </select>
            </div>

            <div class="form-group col-xs-2">
                <label for="yearExperience">Years of experience</label>
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
</div>

@section('post-body')
    <link href="{{URL::to('/')}}/css/recruitment-request.min.css" rel="stylesheet">
    <script src="{{URL::to('/')}}/js/recruitment-request.min.js"></script>
@endsection