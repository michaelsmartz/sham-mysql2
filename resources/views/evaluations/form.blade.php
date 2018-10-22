<div class="row">
    
<div class="form-group col-xs-12 {{ $errors->has('assessment_id') ? 'has-error' : '' }}">
    <label for="assessment_id">Assessment</label>
        <select class="form-control" id="assessment_id" name="assessment_id" required="true">
        	    <option value="" style="display: none;" {{ old('assessment_id', optional($evaluation)->assessment_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select assessment</option>
        	@foreach ($assessments as $key => $assessment)
			    <option value="{{ $key }}" {{ old('assessment_id', optional($evaluation)->assessment_id) == $key ? 'selected' : '' }}>
			    	{{ $assessment }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('assessment_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-6 {{ $errors->has('user_employee_id') ? 'has-error' : '' }}">
    <label for="user_employee_id">Employee</label>
        <select class="form-control" id="user_employee_id" name="user_employee_id" required="true">
        	    <option value="" style="display: none;" {{ old('user_employee_id', optional($evaluation)->user_employee_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select user employee</option>
        	@foreach ($employees as $key => $employee)
			    <option value="{{ $key }}" {{ old('user_employee_id', optional($evaluation)->user_employee_id) == $key ? 'selected' : '' }}>
			    	{{ $employee }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('user_employee_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-6 {{ $errors->has('department_id') ? 'has-error' : '' }}">
    <label for="department_id">Department</label>
        <select class="form-control" id="department_id" name="department_id" required="true">
        	    <option value="" style="display: none;" {{ old('department_id', optional($evaluation)->department_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select department</option>
        	@foreach ($departments as $key => $department)
			    <option value="{{ $key }}" {{ old('department_id', optional($evaluation)->department_id) == $key ? 'selected' : '' }}>
			    	{{ $department }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('department_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-6 {{ $errors->has('reference_no') ? 'has-error' : '' }}">
    <label for="reference_no">Reference No</label>
        <input class="form-control" name="reference_no" type="text" id="reference_no" value="{{ old('reference_no', optional($evaluation)->reference_no) }}" maxlength="200" placeholder="Enter reference no">
        {!! $errors->first('reference_no', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-6 {{ $errors->has('reference_source') ? 'has-error' : '' }}">
    <label for="reference_source">Reference Source</label>
        <input class="form-control" name="reference_source" type="text" id="reference_source" value="{{ old('reference_source', optional($evaluation)->reference_source) }}" maxlength="200" placeholder="Enter reference source">
        {!! $errors->first('reference_source', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-6 {{ $errors->has('productcategory_id') ? 'has-error' : '' }}">
    <label for="productcategory_id">Product category</label>
        <select class="form-control" id="productcategory_id" name="productcategory_id" required="true">
        	    <option value="" style="display: none;" {{ old('productcategory_id', optional($evaluation)->productcategory_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select product category</option>
        	@foreach ($productCategories as $key => $productCategory)
			    <option value="{{ $key }}" {{ old('productcategory_id', optional($evaluation)->productcategory_id) == $key ? 'selected' : '' }}>
			    	{{ $productCategory }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('productcategory_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-6 {{ $errors->has('language_id') ? 'has-error' : '' }}">
    <label for="language_id">Language</label>
        <select class="form-control" id="language_id" name="language_id" required="true">
        	    <option value="" style="display: none;" {{ old('language_id', optional($evaluation)->language_id ?: '') == '' ? 'selected' : '' }} disabled selected>Enter language</option>
        	@foreach ($languages as $key => $language)
			    <option value="{{ $key }}" {{ old('language_id', optional($evaluation)->language_id) == $key ? 'selected' : '' }}>
			    	{{ $language }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('language_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-6 {{ $errors->has('feedback_date') ? 'has-error' : '' }}">
    <label for="feedback_date">Feedback Date</label>
        <input class="form-control" name="feedback_date" type="text" id="feedback_date" value="{{ old('feedback_date', optional($evaluation)->feedback_date) }}" minlength="1" required="true" placeholder="Enter feedback date">
        {!! $errors->first('feedback_date', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-6 {{ $errors->has('evaluation_status_id') ? 'has-error' : '' }}">
    <label for="evaluation_status_id">Evaluation Status</label>
    <select class="form-control" id="evaluation_status_id" name="evaluation_status_id" required="true">
        <option value="" style="display: none;" {{ old('evaluation_status_id', optional($evaluation)->evaluation_status_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select evaluation status</option>
        @foreach ($evaluationStatuses as $key => $evaluationStatus)
            <option value="{{ $key }}" {{ old('evaluation_status_id', optional($evaluation)->evaluation_status_id) == $key ? 'selected' : '' }}>
                {{ $evaluationStatus }}
            </option>
        @endforeach
    </select>

    {!! $errors->first('evaluation_status_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12">
    {{ Form::label('QA Sample','QA Sample',array('id'=>'','class'=>'')) }}
    {{ Form::radio('status','savecontent',true,['id'=>'savecontent']) }} Upload Sample File
    {{ Form::radio('status','savepath',false,['id'=>'savepath']) }} Save Path Only
</div>

<div id="contentcontainer">
    <?php if ($mode == 'edit'): ?>
    <div class="form-group col-xs-12">
        {!! Form::label('SameAudio','Replace Audio File:') !!}
        {!! Form::checkbox('SameAudio','true',null,($mode =='view')?['disabled']:['id'=>'SameAudio']) !!}
    </div>
    <?php endif; ?>
    <div class="form-group col-xs-12">
        {!! Form::label('QaSample','Audio File New:') !!}
        {{ Form::file('attachment', ($mode =='view')?['class'=>'form-control','disabled']:['class'=>'form-control bg-whitesmoke','accept'=>'audio/*', 'autocomplete'=>'off', 'placeholder'=>'Audio File', 'id'=>'attachment']) }}
    </div>
</div>
<div class="form-group col-xs-12" id="filecontainer">
    {{ Form::label('QA File Path','QA File Path',array('id'=>'','class'=>'')) }}
    {!! Form::text('UrlPath', null,($mode =='view')?['class'=>'form-control','disabled']:['class'=>'form-control bg-whitesmoke', 'autocomplete'=>'off', 'placeholder'=>'QA File Path', 'id'=>'UrlPath']) !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('comments') ? 'has-error' : '' }}">
    <label for="comments">Comments</label>
        <input class="form-control" name="comments" type="text" id="comments" value="{{ old('comments', optional($evaluation)->comments) }}" maxlength="512" placeholder="Enter comments">
        {!! $errors->first('comments', '<p class="help-block">:message</p>') !!}
</div>

    <div class="form-group col-xs-12" style="padding-top: 20px;">
        <div class="flex-wrapper">
            <div class="col-xs-5" style="padding-left: 0px;">
                {!! Form::select('from[]', $employees, null, array('multiple' => 'multiple', 'size' => '7', 'class'=> 'form-control multipleSelect', 'id'=>'multiselect')) !!}
            </div>
            <div class="col-xs-2">
                <button type="button" id="multiselect_rightAll" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>
                <button type="button" id="multiselect_rightSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
                <button type="button" id="multiselect_leftSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
                <button type="button" id="multiselect_leftAll" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>
            </div>
            <div class="col-xs-5" style="padding-right: 0px;">
                {!! Form::select('selectedassessors[]', isset($assessmentaAssessmentCategories)?$assessmentaAssessmentCategories:[],null, array('multiple' => 'multiple', 'size' => '7', 'class'=> 'form-control', 'id'=>'multiselect_to')) !!}
            </div>
            {!! $errors->first('selectedassessors[]', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

</div>

@section('post-body')
    <script src="{{url('/')}}/plugins/multiselect/multiselect.min.js"></script>
    <script>
        $(function () {
            $('.multipleSelect').each(function(){
                $(this).multiselect({
                    submitAllLeft:false,
                    sort: false,
                    keepRenderingSort: false,
                    search: {
                        left: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
                        right: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
                    },
                    fireSearch: function(value) {
                        return value.length > 3;
                    }
                });
            });
        });
    </script>
    <script>

        $('#savepath').click(function() {
            $('#contentcontainer').hide();
            $('#filecontainer').show(200);
            $('#UrlPath').addClass("required");
            $('#QaSample').removeClass("required");
        });

        $('#savecontent').click(function() {
            $('#contentcontainer').show(200);
            $('#filecontainer').hide();

            mode = '{{$mode}}';
            $('#UrlPath').removeClass("required");

            if(mode == 'create')
            {
                $('#QaSample').addClass("required");
            }
        });

        $(document).ready(function(){
            $( "#savecontent" ).click();
        });
    </script>
@endsection
