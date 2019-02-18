<div class="position-center" id="candidates-app">
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="form-group col-xs-6">
                <span class="field">
                    <label for="birth_date">Job Title</label>
                    {!! Form::text('job_title', old('job_title', isset($request->job_title) ? $request->job_title : null), ['class'=>'form-control fix-case field-required', 'autocomplete'=>'off', 'placeholder'=>'Job Title', 'required', 'title'=>'Required', 'id'=>'job_title']) !!}
                </span>
                </div>

                <div class="form-group col-xs-6">
                <span class="field">
                    <label for="birth_date">Position</label>
                    {!! Form::text('position', old('position', isset($request->position) ? $request->position : null), ['class'=>'form-control fix-case field-required', 'autocomplete'=>'off', 'placeholder'=>'Position', 'required', 'title'=>'Required', 'id'=>'position']) !!}
                </span>
                </div>

                <div class="form-group col-xs-12">
                    <span class="field">
                        <label for="cover">Description</label>
                        {!! Form::textarea('description', old('description', isset($request->description) ? $request->description : null), ['class'=>'form-control fix-case field-required', 'autocomplete'=>'off', 'placeholder'=>'Description', 'required', 'title'=>'Required','id'=>'description', 'maxlength' => '50']) !!}
                    </span>
                </div>

                <div class="form-group col-sm-3">
                <span class="field">
                <label for="department">Department</label>
                    {!! Form::select('department', $departments, old('department', isset($request->department) ? $request->department : null), ['class'=>'form-control fix-case field-required', 'autocomplete'=>'off', 'placeholder'=>'Department..', 'data-field-name'=>'Department', 'required', 'title'=>'Required', 'data-parsley-trigger'=>'focusout']) !!}
                </span>
                </div>

                <div class="form-group col-sm-3">
                <span class="field">
                <label for="position">Position</label>
                    {!! Form::select('position', $positions, old('position', isset($request->position) ? $request->position : null), ['class'=>'form-control fix-case field-required', 'autocomplete'=>'off', 'placeholder'=>'Position..', 'data-field-name'=>'Position', 'required', 'title'=>'Required', 'data-parsley-trigger'=>'focusout']) !!}
                </span>
                </div>

                <div class="form-group col-sm-3">
                <span class="field">
                <label for="skill">Skill</label>
                    {!! Form::select('skill', $skills, old('skill', isset($request->skill) ? $request->skill : null), ['class'=>'form-control fix-case field-required', 'autocomplete'=>'off', 'placeholder'=>'Skill..', 'data-field-name'=>'Skill', 'required', 'title'=>'Required', 'data-parsley-trigger'=>'focusout']) !!}
                </span>
                </div>

                <div class="form-group col-xs-3">
                <span class="field">
                    <label for="yearExperience">Position</label>
                    {!! Form::number('year_experience', old('year_experience', isset($request->year_experience) ? $request->year_experience : null), ['class'=>'form-control fix-case field-required', 'autocomplete'=>'off', 'placeholder'=>'Year Experience', 'required', 'title'=>'Required', 'id'=>'year_experience']) !!}
                </span>
                </div>

                <div class="form-group col-xs-5">
                    <label for="interview_type">Select Interview Types</label>
                    {!! Form::select('interview_types[]', $interview_types,
                        old('interview_types', isset($Request_interview_types) ? $Request_interview_types : null),
                        ['class' => 'form-control select-multiple', 'multiple'=>'multiple']
                    ) !!}
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
                                <label class="col-sm-5">Interview Type</label>
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

                                <div class="col-md-5">
                                    <select v-model="selectedInterviewType" class='form-control'>
                                        <option disabled value="">Please select one</option>
                                        <option v-for="interview_type in interview.interview_types" :value="interview_type">@{{interview_type}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>

                <div class="form-group col-sm-5">
                <span class="field">
                <label for="qualification">Highest Qualifications</label>
                    {!! Form::select('qualification', $qualifications, old('qualification', isset($request->qualification) ? $request->qualification : null), ['class'=>'form-control fix-case field-required', 'autocomplete'=>'off', 'placeholder'=>'Qualification..', 'data-field-name'=>'Qualification', 'required', 'title'=>'Required', 'data-parsley-trigger'=>'focusout']) !!}
                </span>
                </div>

                <div class="form-group col-xs-7">
                <span class="field">
                    <label for="field_of_study">Position</label>
                    {!! Form::text('field_of_study', old('field_of_study', isset($request->field_of_study) ? $request->field_of_study : null), ['class'=>'form-control fix-case field-required', 'autocomplete'=>'off', 'placeholder'=>'Field of study', 'required', 'title'=>'Required', 'id'=>'field_of_study']) !!}
                </span>
                </div>

                <div class="form-group col-xs-2">
                    <span class="field">
                        <label for="start_date">Start Date</label>
                        {!! Form::text('start_date', old('start_date', isset($request->start_date) ? $request->start_date : null), ['class'=>'form-control fix-case field-required datepicker', 'autocomplete'=>'off', 'placeholder'=>'Start Date', 'required', 'title'=>'Required','id'=>'start_date', 'maxlength' => '50']) !!}
                    </span>
                </div>

                <div class="form-group col-xs-2">
                    <span class="field">
                        <label for="start_date">End Date</label>
                        {!! Form::text('end_date', old('end_date', isset($request->end_date) ? $request->end_date : null), ['class'=>'form-control fix-case field-required datepicker', 'autocomplete'=>'off', 'placeholder'=>'End Date', 'required', 'title'=>'Required','id'=>'end_date', 'maxlength' => '50']) !!}
                    </span>
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
</div>

@section('post-body')
    <link href="{{URL::to('/')}}/css/recruitment-request.min.css" rel="stylesheet">
    <script src="{{URL::to('/')}}/js/recruitment-request.min.js"></script>
@endsection