<div class="position-center" id="recruitment-requests">
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="form-group col-xs-6">
                <span class="field">
                    <label for="birth_date">Job Title</label>
                    {!! Form::text('job_title', old('job_title', isset($request->job_title) ? $request->job_title : null), ($_mode=='show')?['class'=>'form-control','disabled']:['class'=>'form-control fix-case field-required', 'autocomplete'=>'off', 'placeholder'=>'Job Title', 'required', 'title'=>'Required', 'id'=>'job_title']) !!}
                </span>
                </div>

                <div class="form-group col-sm-2">
                <span class="field">
                <label for="position">Job Status</label>
                    {!! Form::select('employee_status_id', $positions, old('employee_status_id', isset($request->employee_status_id) ? $request->employee_status_id : null), ($_mode=='show')?['class'=>'form-control','disabled']:['class'=>'form-control fix-case field-required', 'autocomplete'=>'off', 'placeholder'=>'Job status..', 'data-field-name'=>'Job Status', 'required', 'title'=>'Required', 'data-parsley-trigger'=>'focusout']) !!}
                </span>
                </div>

                <div class="form-group col-sm-4">
                <span class="field">
                <label for="department">Department</label>
                    {!! Form::select('department_id', $departments, old('department_id', isset($request->department_id) ? $request->department_id : null), ($_mode=='show')?['class'=>'form-control','disabled']:['class'=>'form-control fix-case field-required', 'autocomplete'=>'off', 'placeholder'=>'Department..', 'data-field-name'=>'Department', 'required', 'title'=>'Required', 'data-parsley-trigger'=>'focusout']) !!}
                </span>
                </div>

                <div class="form-group col-xs-4">
                    <label for="skill">Select Skills</label>
                    {!! Form::select('skills[]', $skills,
                        old('skills', isset($recruitmentSkills) ? $recruitmentSkills : null),
                        ($_mode=='show')?['class'=>'form-control','disabled']:['class' => 'form-control select-multiple', 'multiple'=>'multiple']
                    ) !!}
                </div>

                <div class="form-group col-xs-4">
                    <label for="interview_type">Select Interview Types</label>
                    {!! Form::select('interview_types[]', $interviewTypes,
                        old('interview_types', isset($recruitmentInterviewTypes) ? $recruitmentInterviewTypes : null),
                        ($_mode=='show')?['class'=>'form-control','disabled']:['class' => 'form-control select-multiple', 'multiple'=>'multiple']
                    ) !!}
                </div>

                <div class="form-group col-xs-2">
                <span class="field">
                    <label for="quantity">No. of Positions</label>
                    {!! Form::text('quantity', old('quantity', isset($request->quantity) ? $request->quantity : null), ($_mode=='show')?['class'=>'form-control','disabled']:['class'=>'form-control fix-case field-required', 'autocomplete'=>'off', 'placeholder'=>'No. of Positions', 'required', 'title'=>'Required', 'id'=>'quantity',
                      'data-parsley-pattern'=>"^[\d\+\-\.\(\)\/\s]*$",
                      'data-filter'=>"([A-Z]{0,3}|[A-Z]{3}[0-9]*)",
                      'data-parsley-trigger'=>'focusout'])
                    !!}
                </span>
                </div>

                <div class="form-group col-xs-2">
                <span class="field">
                    <label for="yearExperience">Years of Experience</label>
                    {!! Form::text('year_experience', old('year_experience', isset($request->year_experience) ? $request->year_experience : null), ($_mode=='show')?['class'=>'form-control','disabled']:['class'=>'form-control fix-case field-required', 'autocomplete'=>'off', 'placeholder'=>'Year Experience', 'required', 'title'=>'Required', 'id'=>'year_experience',
                      'data-parsley-pattern'=>"^[\d\+\-\.\(\)\/\s]*$",
                      'data-filter'=>"([A-Z]{0,3}|[A-Z]{3}[0-9]*)",
                      'data-parsley-trigger'=>'focusout'])
                    !!}
                </span>
                </div>

                <div class="form-group col-sm-4">
                <span class="field">
                <label for="qualification">Highest Qualifications</label>
                    {!! Form::select('qualification_id', $qualifications, old('qualification_id', isset($request->qualification_id) ? $request->qualification_id : null), ($_mode=='show')?['class'=>'form-control','disabled']:['class'=>'form-control fix-case field-required', 'autocomplete'=>'off', 'placeholder'=>'Qualification..', 'data-field-name'=>'Qualification', 'required', 'title'=>'Required', 'data-parsley-trigger'=>'focusout']) !!}
                </span>
                </div>

                <div class="form-group col-xs-5">
                <span class="field">
                    <label for="field_of_study">Field of Study</label>
                    {!! Form::text('field_of_study', old('field_of_study', isset($request->field_of_study) ? $request->field_of_study : null),($_mode=='show')?['class'=>'form-control','disabled']:['class'=>'form-control fix-case field-required', 'autocomplete'=>'off', 'placeholder'=>'Field of study', 'required', 'title'=>'Required', 'id'=>'field_of_study']) !!}
                </span>
                </div>

                <div class="form-group col-sm-3">
                <span class="field">
                <label for="recruitment_type_id">Recruitment Type</label>
                    {!! Form::select('recruitment_type_id', $recruitmentTypes, old('recruitment_type_id', isset($request->recruitment_type_id) ? $request->recruitment_type_id : null), ($_mode=='show')?['class'=>'form-control','disabled']:['class'=>'form-control fix-case field-required', 'autocomplete'=>'off', 'placeholder'=>'Recruitment Type..', 'data-field-name'=>'Recruitment Type', 'required', 'title'=>'Required', 'data-parsley-trigger'=>'focusout']) !!}
                </span>
                </div>

                <div class="form-group col-xs-3">
                    <span class="field">
                        <label for="start_date">Start Date</label>
                        {!! Form::text('start_date', old('start_date', isset($request->start_date) ? $request->start_date : null), ($_mode=='show')?['class'=>'form-control','disabled']:['class'=>'form-control fix-case field-required datepicker', 'autocomplete'=>'off', 'placeholder'=>'Start Date', 'required', 'title'=>'Required','id'=>'start_date']) !!}
                    </span>
                </div>

                <div class="form-group col-xs-3">
                    <span class="field">
                        <label for="end_date">End Date</label>
                        {!! Form::text('end_date', old('end_date', isset($request->end_date) ? $request->end_date : null), ($_mode=='show')?['class'=>'form-control','disabled']:['class'=>'form-control fix-case field-required datepicker', 'autocomplete'=>'off', 'placeholder'=>'End Date', 'required', 'title'=>'Required','id'=>'end_date']) !!}
                    </span>
                </div>

                <div class="form-group col-xs-3">
                <span class="field">
                    <label for="min_salary">Minimum Salary</label>
                    {!! Form::text('min_salary', old('min_salary', isset($request->min_salary) ? $request->min_salary : null), ($_mode=='show')?['class'=>'form-control','disabled']:['class'=>'form-control fix-case', 'autocomplete'=>'off', 'placeholder'=>'Minimum Salary', '', 'title'=>'Required', 'id'=>'min_salary',
                      'data-parsley-pattern'=>"^[\d\+\-\.\(\)\/\s]*$",
                      'data-filter'=>"([A-Z]{0,3}|[A-Z]{3}[0-9]*)",
                      'data-parsley-trigger'=>'focusout'])
                     !!}
                </span>
                </div>

                <div class="form-group col-xs-3">
                <span class="field">
                    <label for="max_salary">Maximum Salary</label>
                    {!! Form::text('max_salary', old('max_salary', isset($request->max_salary) ? $request->max_salary : null), ($_mode=='show')?['class'=>'form-control','disabled']:['class'=>'form-control fix-case', 'autocomplete'=>'off', 'placeholder'=>'Maximum Salary', '', 'title'=>'Required', 'id'=>'max_salary',
                      'data-parsley-pattern'=>"^[\d\+\-\.\(\)\/\s]*$",
                      'data-filter'=>"([A-Z]{0,3}|[A-Z]{3}[0-9]*)",
                      'data-parsley-trigger'=>'focusout'])
                     !!}
                </span>
                </div>

                <div class="form-group col-xs-12">
                    <span class="field">
                        <label for="cover">Job Description</label>
                         <textarea name="description" id="description"
                                   required
                                   placeholder="description"
                                   maxlength ='10000'
                                   title='Required'
                                   autocomplete='off'
                                   {{ ($_mode=='show')? 'class="form-control"  disabled': 'class="form-control"'}}
                         >{!! isset($request->description) ? $request->description : null !!}</textarea>
                    </span>
                </div>

                @if($_mode == 'show')
                <div class="form-group col-xs-12 {{ $errors->has('is_approved') ? 'has-error' : '' }}">
                    <label for="is_approved">Approved</label>
                    <div class="checkbox">
                        <label for="is_approved_1">
                            <input id="is_approved_1" class="" name="is_approved" type="hidden" value="0" />
                            <input id="is_approved_1" class="" name="is_approved" type="checkbox" value="1" {{ old('processed', $processed) == 1 ? 'disabled' : '' }} {{ old('is_approved', optional($request)->is_approved) == '1' ? 'checked' : '' }}>
                            Yes
                        </label>
                    </div>

                    {!! $errors->first('is_completed', '<p class="help-block">:message</p>') !!}
                </div>

                <div class="form-group col-xs-12 {{ $errors->has('is_completed') ? 'has-error' : '' }}">
                    <label for="is_completed">Completed</label>
                    <div class="checkbox">
                        <label for="is_completed_1">
                            <input id="is_completed_1" class="" name="is_completed" type="hidden" value="0" />
                            <input id="is_completed_1" class="" name="is_completed" type="checkbox" value="1" {{ old('processed', $processed) == 1 ? 'disabled' : '' }} {{ old('is_completed', optional($request)->is_completed) == '1' ? 'checked' : '' }}>
                            Yes
                        </label>
                    </div>

                    {!! $errors->first('is_completed', '<p class="help-block">:message</p>') !!}
                </div>
                @elseif($_mode == 'edit')
                    <div class="form-group col-xs-12 {{ $errors->has('is_approved') ? 'has-error' : '' }}">
                        <label for="is_approved">Approved</label>
                        <div class="checkbox">
                            <label for="is_approved_1">
                                <input id="is_approved_1" class="" name="is_approved" type="hidden" value="0" />
                                <input id="is_approved_1" class="" name="is_approved" type="checkbox" value="1" {{ old('is_approved', optional($request)->is_approved) == '1' ? 'checked' : '' }}>
                                Yes
                            </label>
                        </div>

                        {!! $errors->first('is_completed', '<p class="help-block">:message</p>') !!}
                    </div>

                    <div class="form-group col-xs-12 {{ $errors->has('is_completed') ? 'has-error' : '' }}">
                        <label for="is_completed">Completed</label>
                        <div class="checkbox">
                            <label for="is_completed_1">
                                <input id="is_completed_1" class="" name="is_completed" type="hidden" value="0" />
                                <input id="is_completed_1" class="" name="is_completed" type="checkbox" value="1" {{ old('is_completed', optional($request)->is_completed) == '1' ? 'checked' : '' }}>
                                Yes
                            </label>
                        </div>

                        {!! $errors->first('is_completed', '<p class="help-block">:message</p>') !!}
                    </div>
                @endif
            </div>
        </div>
        <div id="date-picker"> </div>
    </div>
</div>

@section('post-body')
    <link href="{{URL::to('/')}}/plugins/sumoselect/sumoselect.css" rel="stylesheet">
    <script src="{{URL::to('/')}}/js/recruitment-request.min.js"></script>
    <script src="{{URL::to('/')}}/plugins/ckeditor_basic_nightly/ckeditor/ckeditor.js"></script>

    <script>
        CKEDITOR.replace('description');
        CKEDITOR.htmlEncodeOutput = true;
    </script>
@endsection
